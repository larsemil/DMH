<?php
# Läs mer på http://www.fpdf.org/

global $root, $current_person, $current_larp;
$root = $_SERVER['DOCUMENT_ROOT'];

require $root . '/includes/init.php';
require_once $root . '/pdf/report_pdf.php';

//If the user isnt admin it may not use this page
if (!isset($_SESSION['admin'])) {
    header('Location: ../../../participant/index.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] != "GET") {
    header('Location: ../../../admin/index.php');
    exit;
}

$name = 'Rapporten';
$persons = Person::getAllRegistered($current_larp, false);

$rows = array();
foreach($persons as $person) {
    $rows[] = array($person->Name, $person->Email, $person->PhoneNumber, $person->SocialSecurityNumber);
}


$pdf = new Report_PDF();

$pdf->SetTitle(encode_utf_to_iso($name));
$pdf->SetAuthor(encode_utf_to_iso($current_person->Name));
$pdf->SetCreator('Omnes Mundi');
$pdf->AddFont('Helvetica','');
$pdf->SetSubject(encode_utf_to_iso($name));

$pdf->new_report($current_larp, $name, $rows);

$rows = array();
$rows[] = array('NAMN', 'chk', 'MAIL', 'TELEFONNUMMER', 'Personnummret');
foreach($persons as $person) {
    $rows[] = array($person->Name, '', $person->Email, $person->PhoneNumber, $person->SocialSecurityNumber);
}

$pdf->new_report($current_larp, "Tom kolumn", $rows);
$pdf->Output();
