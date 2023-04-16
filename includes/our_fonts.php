<?php 

class OurFonts {
    
    public static function fontArray() {
        
        global $root;
        $root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
        $path = $root . '/includes/fpdf185/font';

        $files = array_diff(scandir($path), array('.', '..'));
        
        $out_files = Array();
        foreach ($files as $file) {
            if (str_ends_with($file, '.php')) {
                $out_files[] = substr($file, 0, -4);
            }
        }

        return $out_files;
    }
    
    # Dom här fonterna ingår inte i de inkluderade PDF-fonterna och måste läsas in med $pdf->AddFont('FontName','');
    # Alltså dom fonterna vi lagt till själva i font-biblioteket
    public static function fontsToLoad() {
        global $root;
        $root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
        $path = $root . '/includes/fpdf185/font';
        
        $files = array_diff(scandir($path), array('.', '..'));
        
        $out_files = Array();
        foreach ($files as $file) {
            if (str_ends_with($file, '.z')) {
                $out_files[] = substr($file, 0, -2);
            }
        }
        
        return $out_files;
    }
    
    
    
}