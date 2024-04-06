<?php

namespace App\Controller\Actions\FuelActions;

use App\Entity\FuelStockSupply;
use App\Entity\FuelSupply;
use App\Repository\FuelRepository;
use App\Repository\FuelSiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateFuelSupplyAction extends AbstractController
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly FuelRepository $repository,
    private readonly FuelSiteRepository $siteRepository
  ) { }

  public function __invoke(FuelSupply $supply): FuelSupply
  {
    $createdAt = $supply->getCreatedAt() ?? new \DateTime();
    $items = $supply->items;

    if (isset($items) && count($items) > 0) {
      foreach ($items as $item) {
        $id = $item['id'] ?? null;
        $quantity = $item['quantity'] ?? null;
        $siteId = $item['siteId'] ?? null;

        if (!$id || $id <= 0) throw new BadRequestHttpException('ID incorect.');
        if (!$siteId || $id <= 0) throw new BadRequestHttpException('ID du Site invalide.');
        if (!$quantity || $quantity <= 0.00) throw new BadRequestHttpException('Quantité invalide.');

        $fuel = $this->repository->find($id);
        $site = $this->siteRepository->find($siteId);

        if (!$fuel) {
          throw new BadRequestHttpException('Carburant avec l\'ID "'.$id.'" n\'existe pas.');
        }

        if (!$site) {
          throw new BadRequestHttpException('Site avec l\'ID "'.$siteId.'" n\'existe pas.');
        }

        $oldStock = $fuel->getStock();
        $newStock = $oldStock + $quantity;

        $fuel->setStock($newStock);

        $fuelStock = (new FuelStockSupply())
          ->setFuel($fuel)
          ->setSite($site)
          ->setSupply($supply)
          ->setQuantity($quantity)
          ->setCreatedAt($createdAt);
        $supply->addFuelStockSupply($fuelStock);
      }
    }
    else throw new BadRequestHttpException('Aucun carburant n\'a été renseigné.');

    $supply->setCreatedAt($createdAt);

    $this->em->flush();

    return $supply;
  }
}
