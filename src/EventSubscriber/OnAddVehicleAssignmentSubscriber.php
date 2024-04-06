<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\VehicleAssignment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class OnAddVehicleAssignmentSubscriber implements EventSubscriberInterface
{
  public function __construct(private readonly EntityManagerInterface $em) { }

  public function onKernelView(ViewEvent $event): void
  {
    $assignment = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();

    if ($assignment instanceof VehicleAssignment && $method === 'POST') {
      $agent = $assignment->getAgent();
      $vehicle = $assignment->getVehicle();

      $vehicle->setAgent($agent);

      $this->em->flush();
    }
  }

  public static function getSubscribedEvents(): array
  {
    return [
      KernelEvents::VIEW => [
        'onKernelView',
        EventPriorities::POST_WRITE
      ],
    ];
  }
}
