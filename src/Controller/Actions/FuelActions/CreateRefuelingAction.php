<?php

namespace App\Controller\Actions\FuelActions;

use App\Entity\Refueling;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateRefuelingAction extends AbstractController
{
  public function __invoke(Refueling $refueling): Refueling
  {
    $quantity = $refueling->getQuantity();
    $vehicle = $refueling->getVehicle();
    $fuel = $refueling->getFuel();

    if ($quantity <= 0.00) {
      throw new BadRequestHttpException('La Quantité renseignée est invalide.');
    }

    if ($quantity > $fuel->getStock()) {
      throw new BadRequestHttpException('Quantité renseignée excède la quantité existante.');
    }

    if (null === $vehicle->getAgent()) {
      throw new BadRequestHttpException('Ce véhicule n\'est affecté à aucun agent.');
    }

    $newQuantity = $fuel->getStock() - $quantity;
    $fuel->setStock($newQuantity);

    $createdAt = new \DateTime();
    $refueling->setCreatedAt($createdAt);

    return $refueling;
  }
}
