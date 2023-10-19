<?php
# Läs mer på http://www.fpdf.org/

global $root, $current_larp;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";

include_once 'header.php';

require_once $root . '/pdf/receipt_pdf.php';


if ($_SERVER["REQUEST_METHOD"] != "GET") {
    header('Location: index.php');
    exit;
}

if (isset($_GET['bookkeepingId'])) {
    $bookkeepingId = $_GET['bookkeepingId'];
    $bookkeeping = Bookkeeping::loadById($bookkeepingId);
    if (empty($bookkeeping)) {
        header('Location: index.php'); // Posten finns inte
        exit;
    } elseif ($bookkeeping->LarpId != $current_larp->Id) {
        header('Location: index.php'); // Tillhr inte aktuellt lajv
        exit;
    }
    $pdf = new Receipt_PDF();
    $pdf->SetTitle('Kvitto');
    $pdf->SetAuthor(utf8_decode($current_larp->Name));
    $pdf->SetCreator('Omnes Mundi');
    $pdf->AddFont('SpecialElite','');
    $pdf->SetSubject('Kvitto');
    $pdf->nytt_kvitto($bookkeeping);
    
} elseif (isset($_GET['registrationId'])) {
    $registrationId = $_GET['registrationId'];
    $registration = Registration::loadById($registrationId);
    if (empty($registration)) {
        header('Location: index.php'); // Posten finns inte
        exit;
    } elseif ($registration->LARPId != $current_larp->Id) {
        header('Location: index.php'); // Tillhr inte aktuellt lajv
        exit;
    }
    $pdf = new Receipt_PDF();
    $pdf->SetTitle('Kvitto');
    $pdf->SetAuthor(utf8_decode($current_larp->Name));
    $pdf->SetCreator('Omnes Mundi');
    $pdf->AddFont('SpecialElite','');
    $pdf->SetSubject('Kvitto');
    $pdf->nytt_kvitto_avgift($registration);
    
}



$pdf->Output();


