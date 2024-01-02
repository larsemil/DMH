<?php
include_once 'header.php';



if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
        Magic_School::delete($_GET['Id']);
    }
}


include 'navigation.php';
?>
<script src="../javascript/table_sort.js"></script>

 
    <div class="content">
        <h1>Magiskolor <a href="magic.php"><i class="fa-solid fa-arrow-left" title="Tillbaka till magi"></i></a></h1>
            <a href="magic_school_form.php?operation=new"><i class="fa-solid fa-file-circle-plus"></i>Lägg till</a>  
        
       <?php
    
       $schools = Magic_School::allByCampaign($current_larp);
       if (!empty($schools)) {
           $tableId = "schools";
           echo "<table id='$tableId' class='data'>";
           echo "<tr><th onclick='sortTable(0, \"$tableId\");'>Namn</th>".
               "<th onclick='sortTable(1, \"$tableId\")'>Beskrivning</th>".
               "<th onclick='sortTable(2, \"$tableId\")'>Anteckningar</th>".
           "<th></th><th></th>";
           
            foreach ($schools as $school) {
                echo "<tr>\n";
                echo "<td>" . $school->Name . "</td>\n";
                echo "<td>" . $school->Description . "</td>\n";
                echo "<td>" . $school->OrganizerNotes . "</td>\n";
                
                echo "<td>" . "<a href='magic_school_form.php?operation=update&Id=" . $school->Id . "'><i class='fa-solid fa-pen'></i></td>\n";
                echo "<td>" . "<a href='magic_school_form.php?operation=delete&Id=" . $school->Id . "'><i class='fa-solid fa-trash'></i></td>\n";
                echo "</tr>\n";
            }
            echo "</table>";
        }
        else {
            echo "<p>Inga registrerade ännu</p>";
        }
        ?>
    </div>
	
</body>

</html>