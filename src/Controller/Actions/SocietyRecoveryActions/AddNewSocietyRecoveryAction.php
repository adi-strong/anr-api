<?php

namespace App\Controller\Actions\SocietyRecoveryActions;

use App\Entity\DocObject;
use App\Entity\SocietyRecovery;
use Symfony\Component\HttpFoundation\Request;

class AddNewSocietyRecoveryAction
{
  public function __invoke(SocietyRecovery $societyRecovery, Request $request): SocietyRecovery
  {
    /* ------------------------------------ Handle Uploaded Files ------------------------------------ */

    $uploadCertificateFile = $request->files->get('certificateFile');
    if (null !== $uploadCertificateFile) {
      $certificateObject = new DocObject();
      $certificateObject->file = $uploadCertificateFile;
      $societyRecovery->setCertificate($certificateObject);
    }

    $uploadCallingCardFile = $request->files->get('callingCardFile');
    if (null !== $uploadCallingCardFile) {
      $callingCardObject = new DocObject();
      $callingCardObject->file = $uploadCallingCardFile;
      $societyRecovery->setCallingCard($callingCardObject);
    }

    $uploadPvFile = $request->files->get('pvFile');
    if (null !== $uploadPvFile) {
      $pvObject = new DocObject();
      $pvObject->file = $uploadPvFile;
      $societyRecovery->setPv($pvObject);
    }

    $uploadFormFile = $request->files->get('formFile');
    if (null !== $uploadFormFile) {
      $formObject = new DocObject();
      $formObject->file = $uploadFormFile;
      $societyRecovery->setForm($formObject);
    }

    $uploadExpenseReportFile = $request->files->get('expenseReportFile');
    if (null !== $uploadExpenseReportFile) {
      $expenseReportObject = new DocObject();
      $expenseReportObject->file = $uploadExpenseReportFile;
      $societyRecovery->setExpenseReport($expenseReportObject);
    }

    $uploadProofOfPaymentFile = $request->files->get('proofOfPaymentFile');
    if (null !== $uploadProofOfPaymentFile) {
      $proofOfPaymentObject = new DocObject();
      $proofOfPaymentObject->file = $uploadProofOfPaymentFile;
      $societyRecovery->setProofOfPayment($proofOfPaymentObject);
    }

    /* ------------------------------------ End Handle Uploaded Files -------------------------------- */

    $releasedAt = $societyRecovery->getReleasedAt() ?? new \DateTime();

    $societyRecovery
      ->setReleasedAt($releasedAt)
      ->setProvince($societyRecovery->getAgent()->getProvince());

    return $societyRecovery;
  }
}
