<?php


class BaseModel extends Dbh{
    
//     public static $tableName = 'Set this!';
    public static $orderListBy = 'Set this!';
    
    # Hämta alla av den här sorten
    public static function all() {
        $sql = "SELECT * FROM ".strtolower(static::class)." ORDER BY ".static::$orderListBy.";";
        $stmt = static::connectStatic()->prepare($sql);
        
        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            return array();
        }
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultArray = array();
        foreach ($rows as $row) {
            $resultArray[] = static::newFromArray($row);
        }   
        $stmt = null;
        return $resultArray;
    }
    
    # Hur många finns det av den här sorten
    public static function numberOff() {
        $sql = "SELECT * FROM ".strtolower(static::class)." ORDER BY ".static::$orderListBy.";";
        $stmt = static::connectStatic()->prepare($sql);
        
        if (!$stmt->execute()) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        return $stmt->rowCount();
    }
    
    public static function loadById($id)
    {
        # Gör en SQL där man söker baserat på ID och returnerar ett object mha newFromArray
        $stmt = static::connectStatic()->prepare("SELECT * FROM ".strtolower(static::class)." WHERE Id = ?");
        
        if (!$stmt->execute(array($id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            return null;
        }
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $row = $rows[0];
        $stmt = null;
        
        return static::newFromArray($row);
    }
    
    # Normalt bör man inte anropa den här direkt utan newWithDefault
    public function __construct() {}
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        $object = new self();
        return $object;
    }
    
    public static function delete($id)
    {
               
        $stmt = static::connectStatic()->prepare("DELETE FROM ".strtolower(static::class)." WHERE Id = ?");
        
        if (!$stmt->execute(array($id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    public function destroy()
    {
        static::delete($this->id);
    }
    
}