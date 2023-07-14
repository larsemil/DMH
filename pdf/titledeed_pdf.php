<?php
# Läs mer på http://www.fpdf.org/

global $root;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
require $root . '/includes/fpdf185/fpdf.php';
require $root . '/includes/init.php';


class TITLEDEED_PDF extends FPDF {
    
    
    function Header()
    {
        global $root;
//         $this->Image($root . '/images/telegram.png',null,null,200);
    }
    
    function SetText(Titledeed $titledeed, Campaign $campaigne) {
        
        $left = 11;
        $y = 0;
        $left2 = $left + 35;
        
        $txt_font = ($titledeed->Tradeable) ? 'SpecialElite' : 'Helvetica';
        
        $y += 11;
        if ($titledeed->Tradeable) {
            $this->SetFont('DancingScript','',45);
        } else {
            $this->SetFont('Helvetica','',40);
        }
        $this->SetXY($left, $y);
        $txt = $titledeed->Tradeable ? 'Ägarbevis' : 'Ägarinformation';
        $this->Cell(0,10,utf8_decode($txt),0,1,'C');
        if (!$titledeed->Tradeable) {
            $this->SetXY($left, $y);
            $y += 10;
            $this->SetXY($left, $y);
            $this->SetFont('Helvetica','',10); 
            $this->Cell(0,10,utf8_decode('(Kan inte säljas)'),0,1,'C');
            $y += 2;
        }
        
        $this->SetFont($txt_font,'',20);    # OK är Times, Arial, Helvetica, SassyFrass, SpecialElite
		# För mer fonter använder du http://www.fpdf.org/makefont/

        $y += 13;
        $this->SetXY($left, $y);
		$this->Cell(80,10,utf8_decode('Namn'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
		$this->SetXY($left2, $y);
		$this->Cell(80,10,utf8_decode($titledeed->Name),0,0); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
		$y += 3;
        
		$this->SetFont($txt_font,'',12); 
		
		if (!empty($titledeed->Location)) {
		    $y += 3;
		    $this->SetXY($left2, $y);
		    $this->Cell(80,10,utf8_decode($titledeed->Location),0,1);
		}
		    
		
		$txt = '';
		if (!empty($titledeed->Type)) $txt .= "$titledeed->Type ";
		if (!empty($titledeed->Size)) $txt .= "($titledeed->Size)";
        if (!empty($titledeed->Size)) {
            $y += 7;
    		$this->SetXY($left, $y);
    		$this->Cell(80,10,utf8_decode('Typ'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
    		$this->SetXY($left2, $y);
    		$this->Cell(80,10,utf8_decode($txt),0,1);
        }
        
        if (!empty($titledeed->PublicNotes)) {
            $y += 7;
            $this->SetXY($left, $y);
            $this->Cell(80,10,utf8_decode('Beskrivning'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
            $this->SetXY($left2, $y);
            $this->Cell(80,10,utf8_decode($titledeed->PublicNotes),0,1);
            
        }
        
        $y += 14;
        $this->SetXY($left, $y);
        $this->Cell(80,10,utf8_decode('Ägare'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
        $owners = array();
        foreach ($titledeed->getGroupOwners() as $owner_group) $owners[] = $owner_group->Name;
        foreach ( $titledeed->getRoleOwners() as $owner_role)  $owners[] = $owner_role->Name;
        if (!empty($owners)) {
            $txt = join(', ', $owners);
        } else {
            $txt = 'Ingen';
        }
        $this->SetXY($left2, $y+1);
        $this->MultiCell(0,8,utf8_decode($txt),0,'L'); # 1- ger ram runt rutan så vi ser hur stor den är

        $y += 14;
        $this->SetXY($left, $y);
        $this->Cell(80,10,utf8_decode('Producerar'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
        $this->SetXY($left2, $y);
        $this->Cell(80,10,utf8_decode($titledeed->ProducesString()),0,1);

        $y += 7;
        $this->SetXY($left, $y);
        $this->Cell(80,10,utf8_decode('Behöver'),0,1); # 0 - No border, 1 -  to the beginning of the next line, C - Centrerad
        $this->SetXY($left2, $y);
        $this->Cell(80,10,utf8_decode($titledeed->RequiresString()),0,1);
    }
    
    function new_titledeed(Titledeed $titledeed, LARP $larp)
    {
        $campaigne = $larp->getCampaign();
        $this->AddFont('DancingScript','');
//         $this->AddPage('L','A5',270);
        $this->AddPage('L','A5',0);
//         $this->AddPage();
        $this->SetText($titledeed, $campaigne);
	}
}

// Money = 0;
// MoneyForUpgrade = 0;
// OrganizerNotes;
// SpecialUpgradeRequirements;