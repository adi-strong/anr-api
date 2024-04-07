<?php

namespace App\Controller\Actions\SalaryActions;

use App\ApiResource\SalaryResource;
use App\Entity\Salary;
use App\Repository\AgentRepository;
use App\Repository\CurrencyRepository;
use App\Repository\YearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateSalaryResourceAction extends AbstractController
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly YearRepository $yearRepository,
    private readonly AgentRepository $agentRepository,
    private readonly CurrencyRepository $currencyRepository
  ) { }

  public function __invoke(SalaryResource$resource): JsonResponse
  {
    $releasedAt = new \DateTime();
    $yearId = $resource->yearId ?? 0;
    $month = $resource->month ?? null;
    $currency = $resource->currency;

    if (null === $currency) {
      throw new BadRequestHttpException('La Devise renseinée est invalide.');
    }

    $lastCurrency = $this->currencyRepository->find(1);
    $rate = $lastCurrency->getRate();

    if (null === $month) {
      throw new BadRequestHttpException('Le Mois renseignée est invalide.');
    }

    $year = $this->yearRepository->find($yearId);
    if (null === $year) {
      throw new BadRequestHttpException('Année invalide.');
    }

    $items = $resource->items;

    if (count($items) > 0) {
      foreach ($items as $item) {
        $agentId = $item['agentId'] ?? null;
        $agent = $this->agentRepository->find($agentId);
        if (null === $agent) {
          throw new BadRequestHttpException('L\'Agent ayant l\'ID "'.$agentId.'" n\'existe pas.');
        }

        $baseAmount = $item['baseAmount'] ?? 0.00;
        if ($baseAmount <= 0.00) {
          throw new BadRequestHttpException(
            'Le Salaire de base renseigné pour l\'agent "'.$agent->getFirstName().'" est invalide.'
          );
        }

        $riskPremiumAmount = $item['riskPremiumAmount'] ?? 0;
        $functionBonusAmount = $item['functionBonusAmount'] ?? 0;

        $total = $baseAmount + $riskPremiumAmount + $functionBonusAmount;

        $salary = (new Salary())
          ->setAgent($agent)
          ->setTotal($total)
          ->setRate($rate)
          ->setYear($year)
          ->setMonth($month)
          ->setReleasedAt($releasedAt)
          ->setBaseAmount($baseAmount)
          ->setCurrency($currency)
          ->setFunctionBonusAmount($functionBonusAmount)
          ->setRiskPremiumAmount($riskPremiumAmount);

        $this->em->persist($salary);
      }
    }
    else throw new BadRequestHttpException('Les Données soumisent sont invalides.');

    $this->em->flush();

    return $this->json($resource);
  }
}
