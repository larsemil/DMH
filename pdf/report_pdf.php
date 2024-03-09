<?php
# Läs mer på http://www.fpdf.org/
# Testa orientation med $this->CurOrientation ger 'P' eller 'L'

global $root, $current_user, $current_larp;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";

require_once $root . '/includes/fpdf185/fpdf.php';

require_once $root . '/includes/all_includes.php';


class Report_PDF extends FPDF {
    
    public static $Margin = 1;
    
    public static $x_min = 5;
    public static $y_min = 5;
    
    public static $cell_y = 5;
    
    public static $header_fontsize = 6;
    public static $text_fontsize = 10;
    
    public $x_max;
    public $y_max;
    public $larp;
    public $name;
    public $rows;
    public $num_cols;
    public $lefts = [];
    public $default_cell_width;
    public $cell_widths = [];
    public $current_col = 0;
    public $current_cell_height;
    public $text_max_length;
    
    function Header() {
        global $root, $y;
        $this->SetLineWidth(0.6);
        $this->Line(static::$x_min, static::$y_min, $this->x_max, static::$y_min);
        $this->Line(static::$x_min, static::$y_min, static::$x_min, $this->y_max);
        $this->Line(static::$x_min, $this->y_max, $this->x_max, $this->y_max);
        $this->Line($this->x_max, static::$y_min, $this->x_max, $this->y_max);
        
        $space = 1.2;
        $this->Line(static::$x_min-$space, static::$y_min-$space, $this->x_max+$space, static::$y_min-$space);
        $this->Line(static::$x_min-$space, static::$y_min-$space, static::$x_min-$space, $this->y_max+$space);
        $this->Line(static::$x_min-$space, $this->y_max+$space, $this->x_max+$space, $this->y_max+$space);
        $this->Line($this->x_max+$space, static::$y_min-$space, $this->x_max+$space, $this->y_max+$space);
        
        $mini_header_with = 46;
        $mitten = static::$x_min + ($this->x_max - static::$x_min) / 2 ;
        
        $this->SetXY($mitten-($mini_header_with/2), 3);
        $this->SetFont('Helvetica','',static::$text_fontsize/1.1);
        $this->SetFillColor(255,255,255);
        $txt = $this->larp->Name;
        $this->MultiCell($mini_header_with, 4, utf8_decode($txt), 0, 'C', true);
        
        $y = static::$y_min + static::$Margin;
    }
    
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0, 10, 'Sidan '.$this->PageNo().'/{nb}', 0, 0, 'R');
    }
    
    # Skriv ut Rapportnamnet högst upp.
    # Används på första sidan
    function title($text) {
        global $y;

        # Bra ställe lägga ut debuginfo i början på rapporten
//         $text = $this->GetPageHeight() . " - $text";
        
        $font_size = (600 / strlen(utf8_decode($text)));
        if ($font_size > 90) $font_size = 90;
        $this->SetFont('Helvetica','B', $font_size);    # OK är Times, Arial, Helvetica
        
        $this->SetXY($this->lefts[0], $y-2);
        $this->Cell(0, static::$cell_y*6, utf8_decode($text),0,0,'C');
        
        $y = static::$y_min + (static::$cell_y*6) + (static::$Margin);
        
        $this->bar();
    }

    
    function new_report(LARP $larp, String $name, Array $rows) {
        global $x, $y;
        
        $this->AliasNbPages();
        
        $this->x_max = $this->GetPageWidth()  - static::$x_min;
        $this->y_max = $this->GetPageHeight() - static::$y_min;
        
        $this->lefts = [];
        $this->cell_widths = [];
        
        $this->larp     = $larp;
        $this->name     = $name;
        $this->rows     = $rows;
        $this->num_cols = sizeof($this->rows[0]);
        $this->text_max_length = 94 / $this->num_cols; #  (Empiriskt testat för vad som ser bra ut)
        
        $this->cell_height = static::$cell_y + (2*static::$Margin);
        $this->default_cell_width = ($this->x_max - static::$x_min) / $this->num_cols - (2*static::$Margin);
        
        $current_left = static::$x_min ;
        
        $this->lefts[0] = $current_left; # Vänstraste vänstermarginalen

        # Markera extra breda kolumner
        $max_length = [];
        foreach($this->rows as $row){
            $col = 0;
            foreach($row as $cell){
                if (!isset($max_length[$col]))         $max_length[$col] = 0;
                if (strlen($cell) > $max_length[$col]) $max_length[$col] = strlen($cell);
                $col++;
            }
        }
        
        $with_part = [];
        $avg_part = 0;
        for ($col = 0; $col < $this->num_cols; $col++){
            if ($max_length[$col] > $this->text_max_length*3) {
                $with_part[$col] = 2;
            } elseif ($max_length[$col] > $this->text_max_length*2) {
                $with_part[$col] = 1.6;
            } elseif ($max_length[$col] > $this->text_max_length) {
                $with_part[$col] = 1.3;
            } elseif ($max_length[$col] < $this->text_max_length) {
                $with_part[$col] = 0.05*$max_length[$col];
//             } elseif ($max_length[$col] < 6) {
//                 $with_part[$col] = 0.2;
//             } elseif ($max_length[$col] < $this->text_max_length/2) {
//                 $with_part[$col] = 0.6;
            } else {
                $with_part[$col] = 1;
            }
            $avg_part += $with_part[$col];
        }
        $avg_part = $avg_part / $this->num_cols;
        
//         echo "<br>\n";
//         print_r($with_part);
//         echo "with_part --<br>\n";
//         echo "AVG: $avg_part <br>\n";
        
        # Sätt alla kolumnbredder
        for ($col = 0; $col < $this->num_cols; $col++){
            $this->cell_widths[$col] = round($this->default_cell_width * ($with_part[$col] / $avg_part ));
//             $this->cell_widths[$col] = $this->default_cell_width;
        }

//         print_r($this->cell_widths);
//         echo "Cell widths --<br>\n";
        
        # Beräkna vänster-marginaler
        for ($col = 1; $col < $this->num_cols; $col++){
            $this->lefts[$col] = $current_left + $this->cell_widths[$col-1] + static::$Margin*2;
            $current_left = $this->lefts[$col];
        }
        
//         print_r($this->lefts);
//         echo "Lefts 2 --<br>\n";
        
        $this->AddPage($this->CurOrientation);
        
        $this->title($this->name);
        
        $this->current_cell_height = $this->cell_height;
        
        $rubrik = true;
        foreach($this->rows as $row){
            foreach($row as $cell) {
                $this->set_cell($cell, $rubrik);
            }
            $rubrik = false;
        }
	}
	
	# Dynamiska småfält
	
	# Dra en linje tvärs över arket på höjd $y
	private function bar() {
	    global $y;
	    $this->Line(static::$x_min, $y, $this->x_max, $y);
	}
	
	private function mittlinje($col) {
	    global $y;
	    $x_pos = $this->lefts[$col]; # $this->current_col];
	    $down = $y + $this->current_cell_height;
	    $this->Line($x_pos, $y, $x_pos, $down);
	}
	
	private function cross_over() {
	    global $y, $mitten;
	    $this->Line($this->current_left, $y+static::$Margin*1.5, ($this->current_left+$mitten-(3*static::$Margin)), $y+static::$Margin*1.5);
	}

	
	# Gemensam funktion för all logik för att skriva ut ett fält
	private function set_cell($text, $bold) {
	    global $y;
	    if (empty($text)) $text = ' ';
	    
	    $text = trim(utf8_decode($text));
// 	    $text = "$text - $this->current_col";
	    
	    # Max som får plats är per kolumnbredd = 94 / antalet kolumner:
	    #  2 - 47 tecken
	    #  3 - 31 tecken
	    #  4 - 23 tecken
	    
	    $bold_char = $bold ? 'B' : '';
	    $scaling = 1.2;
	   
	    # Specialbehandling för väldigt långa strängar där vi inte förväntar oss det
	    # Temporärt bortkommenterat så vi tar den logiken senare
 	    if (strlen($text) > $this->text_max_length){
 	        $this->SetFont('Arial', $bold_char, static::$text_fontsize/$scaling);
 	    } else {
 	        $this->SetFont('Helvetica', $bold_char, static::$text_fontsize);
        }
    
	    $x_location = $this->lefts[$this->current_col]+static::$Margin;
	    
	    # Normal utskrift
	    $this->SetXY($x_location, $y + static::$Margin + 1);
	    
	    # Skriv ut texten i cellen
	    $this->MultiCell($this->cell_widths[$this->current_col], static::$cell_y-1.5, $text, 0, 'L');
	    /*
	    if (strlen($text) > ($this->text_max_length*$scaling-2)){
// 	       $this->MultiCell($this->default_cell_width, static::$cell_y-1.5, $text, 0, 'L');
	       $this->MultiCell($this->cell_widths[$this->current_col], static::$cell_y-1.5, $text, 0, 'L');
	    } else {
// 	       $this->Cell($this->default_cell_width, static::$cell_y, $text, 0, 0, 'L');
	       $this->Cell($this->cell_widths[$this->current_col], static::$cell_y, $text, 0, 0, 'L');
	    }
	    */
	    # Hantering om resultatet av cellen är för stort för att få plats.
        $current_y = $this->GetY();
        if ($current_y > $y + $this->current_cell_height) {
            $new_height = $current_y - $y;
            $this->current_cell_height = $new_height;
            # Efterjustera mittlinjen om det behövs
            
        }
            
        # Räkna upp en cell i bredd
        $this->current_col += 1;
        
        if ($this->num_cols == $this->current_col) { 
            # Sista cellen i en rad
            
            # Dra alla mellanstrecken
            for ($col = 0; $col < $this->num_cols; $col++) {
                $this->mittlinje($col);
            }
            
            $this->current_col = 0;
            $y += $this->current_cell_height;
            $this->bar();
            if ($y > 270) { 
                $this->AddPage($this->CurOrientation); # Ny sidan om vi är längst ner
                $y += 5;
            }
            
            $this->current_cell_height = $this->cell_height;
        }
	    
	    return;
	}
	
}
