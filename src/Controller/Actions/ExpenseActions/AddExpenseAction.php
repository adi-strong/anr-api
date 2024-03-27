<?php

namespace App\Controller\Actions\ExpenseActions;

use App\Entity\Expense;
use App\Repository\YearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddExpenseAction extends AbstractController
{
  public function __construct(private readonly YearRepository $yearRepository) { }

  public function __invoke(Expense $expense): Expense
  {
    $lastSession = $this->yearRepository->findLastYear();
    if (null !== $lastSession && $lastSession->isIsActive() === true) {
      $expense->setYear($lastSession);
    }
    else throw new BadRequestHttpException('year: Aucune année en cours.');

    $releasedAt = $expense->getReleasedAt() ?? new \DateTime();
    $expense->setReleasedAt($releasedAt);

    return $expense;
  }
}
