<?php

//         bind_param
//     i	corresponding variable has type int
//     d	corresponding variable has type float
//     s	corresponding variable has type string
//     b	corresponding variable is a blob and will be sent in packets

class SelectionData extends BaseModel{
    
    public  $Id;
    public  $Name;
    public  $Description;
    public  $Active = true;
    public  $SortOrder;
    
    public static $tableName = 'wealths';
    public static $orderListBy = 'SortOrder';
    
    public static function newFromArray($post){
        $selectionData = static::newWithDefault();
        if (isset($post['SortOrder'])) $selectionData->SortOrder = $post['SortOrder'];
        if (isset($post['Active'])) $selectionData->Active = $post['Active'];
        if (isset($post['Description'])) $selectionData->Description = $post['Description'];
        if (isset($post['Name'])) $selectionData->Name = $post['Name'];
        if (isset($post['Id'])) $selectionData->Id = $post['Id'];
        
        return $selectionData;
    }
     
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        return new self();
    }
    
    public static function allActive() {
        global $conn;
        
        $sql = "SELECT * FROM ".static::$tableName." WHERE active = 1 ORDER BY SortOrder;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        $resultArray = array();
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                //                 print_r($row);
                $resultArray[] = static::newFromArray($row);
            }
        } else { # Om det inte finns något i tabellen ännu
            $testrad = static::newWithDefault();
            $testrad->Id = 1;
            $testrad->Name = 'Inget data finns ännu i:';
            $testrad->Description = 'Notering för admins';
            $resultArray[] = $testrad;
            
            $testrad = static::newWithDefault();
            $testrad->Id = 19;
            $testrad->Name = static::$tableName;
            $testrad->Description = 'Tabellen som är tom';
            
            $resultArray[] = $testrad;
            $testrad = static::newWithDefault();
            $testrad->Id = 29;
            $testrad->Name = static::class;
            $testrad->Description = 'Klassen som saknar object';
            
            $resultArray[] = $testrad;
        }
        return $resultArray;
    }
    
    # Update an existing telegram in db
    public function update()
    {
        global $conn;
        
        $stmt = $conn->prepare("UPDATE ".static::$tableName." SET SortOrder=?, Active=?, Description=?, Name=? WHERE id = ?");
        $stmt->bind_param("iissi", $this->SortOrder, $this->Active, $this->Description, $this->Name, $this->Id);
        
        // set parameters and execute
//         $id = $this->Id;
//         $name = $this->Name;
//         $description = $this->Description;
//         $active = $this->Active;
//         $sortOrder = $this->SortOrder;
        $stmt->execute();
    }
    
    # Create a new telegram in db
    public function create()
    {
        global $conn;
        
        $stmt = $conn->prepare("INSERT INTO ".static::$tableName." (SortOrder, Active, Description, Name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss",  $this->SortOrder, $this->Active, $this->Description, $this->Name);
        
        // set parameters and execute
//         $name = $this->name;
//         $description = $this->description;
//         $active = $this->active;
//         $sortOrder = $this->sortOrder;
        $stmt->execute();
    }
    
    # En dropdown där man kan välja den här
    public static function selectionDropdown(?bool $multiple=false, ?bool $required=true, ?bool $only_active=true){
        $selectionDatas = ($only_active) ? static::allActive() : static::all();
//         $name   = ($multiple) ? (static::$tableName . "[]") : static::class ;
        $name   = ($multiple) ? (strtolower(static::class) . "[]") : strtolower(static::class) ;
        $option = ($multiple) ? ' multiple' : '';
        $option = ($required) ? $option . ' required' : $option;
        $size   = count($selectionDatas);
        
        echo "<div class='selectionDropdown'>\n";
        echo "<select name='" . $name . "' id='" . static::$tableName . "' size=".$size." " . $option . ">\n";
        foreach ($selectionDatas as $selectionData) {
            echo "  <option value='" . $selectionData->Id . "' title='" . $selectionData->Description . "'>" . $selectionData->Name . "</option>\n";
        }
        echo "</select>\n";
        echo "</div>\n";
    }
    
    # Hjälptexter till dropdown som förklarar de olika valen.
    public static function helpBox(?bool $only_active=true){
        $selectionDatas = ($only_active) ? static::allActive() : static::all();
        echo "<div class='tooltip'>\n";
        echo "<table class='helpBox'>\n";
        foreach ($selectionDatas as $selectionData) {
            echo "  <tr><td>" . $selectionData->Name . "</td><td>" . $selectionData->Description . "</td></tr>\n";
        }
        echo "</table>\n";
        echo "</div>\n";
    }
      
}