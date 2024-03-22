<?php 
global $root, $current_larp;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";


require_once $root . '/pdf/alchemy_ingredient_pdf.php';
include_once '../header.php';

$type = ALCHEMY_INGREDIENT_PDF::Handwriting;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $type = $_GET['type'];
}

$arrayOfAlcheySuppliers = Alchemy_Supplier::allByCampaign($current_larp, false);
$pdf = new ALCHEMY_INGREDIENT_PDF();
$pdf->SetTitle(utf8_decode('Alla ingredienser för alla lövjerister'));
$pdf->SetAuthor(utf8_decode($current_larp->Name));
$pdf->SetCreator('Omnes Mundi');
$pdf->SetSubject(utf8_decode('Alla ingredienser för alla lövjerister'));
$pdf->all_resources($arrayOfAlcheySuppliers, $type, $current_larp);

$pdf->Output();


