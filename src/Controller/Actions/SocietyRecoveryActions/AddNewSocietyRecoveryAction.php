<?php

namespace App\Controller\Actions\SocietyRecoveryActions;

use App\Entity\DocObject;
use App\Entity\SocietyRecovery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class AddNewSocietyRecoveryAction extends AbstractController
{
  public function __invoke(SocietyRecovery $societyRecovery, Request $request): SocietyRecovery
  {
    /* ------------------------------------ Handle Uploaded Files ------------------------------------ */

    $uploadCertificateFile = $request->files->get('certificateFile');
    if (!$uploadCertificateFile) {
      throw new BadRequestHttpException('L\'Homologation sécuritaire est requis.');
    }
    $certificateObject = new DocObject();
    $certificateObject->file = $uploadCertificateFile;
    $societyRecovery->setCertificate($certificateObject);

    $uploadCallingCardFile = $request->files->get('callingCardFile');
    if (!$uploadCallingCardFile) {
      throw new BadRequestHttpException('L\'Avis de passage est requis.');
    }
    $callingCardObject = new DocObject();
    $callingCardObject->file = $uploadCallingCardFile;
    $societyRecovery->setCallingCard($callingCardObject);

    $uploadPvFile = $request->files->get('pvFile');
    if (!$uploadPvFile) {
      throw new BadRequestHttpException('Le PV est requis.');
    }
    $pvObject = new DocObject();
    $pvObject->file = $uploadPvFile;
    $societyRecovery->setPv($pvObject);

    $uploadFormFile = $request->files->get('formFile');
    if (!$uploadFormFile) {
      throw new BadRequestHttpException('Le Formulaire est requis.');
    }
    $formObject = new DocObject();
    $formObject->file = $uploadFormFile;
    $societyRecovery->setForm($formObject);

    $uploadExpenseReportFile = $request->files->get('expenseReportFile');
    if (!$uploadExpenseReportFile) {
      throw new BadRequestHttpException('La Note de frais est requise.');
    }
    $expenseReportObject = new DocObject();
    $expenseReportObject->file = $uploadExpenseReportFile;
    $societyRecovery->setExpenseReport($expenseReportObject);

    $uploadProofOfPaymentFile = $request->files->get('proofOfPaymentFile');
    if (!$uploadProofOfPaymentFile) {
      throw new BadRequestHttpException('La Preuve de paiement est requise.');
    }
    $proofOfPaymentObject = new DocObject();
    $proofOfPaymentObject->file = $uploadProofOfPaymentFile;
    $societyRecovery->setProofOfPayment($proofOfPaymentObject);

    /* ------------------------------------ End Handle Uploaded Files -------------------------------- */

    $releasedAt = $societyRecovery->getReleasedAt() ?? new \DateTime();
    $type = $societyRecovery->getSociety()->getType();

    $societyRecovery
      ->setType($type)
      ->setReleasedAt($releasedAt)
      ->setProvince($societyRecovery->getAgent()->getProvince());

    return $societyRecovery;
  }
}
