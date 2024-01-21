<?php
include_once 'header.php';


include 'navigation.php';
?>

    <div class="content">
        <h1>Handel</h1>
        <p>
        <a href="resource_admin.php">Resurser</a><br>
        <a href="titledeed_admin.php">Verksamheter</a><br>
        <a href="selection_data_admin.php?type=titledeedplace">Platser för verksamheter</a><br>
        <a href="titledeed_economy_overview.php">Översikt ekonomi för verksamheter</a><br>        
        <a href="titledeed_economy_DOH_rules.php">Regler för nivåer på verksamheter för DÖH</a><br>        
        <br>
        <a href="resource_titledeed_overview_normal.php">Resursfördelning - normala resurser</a><br>
        <a href="resource_titledeed_overview_rare.php">Resursfördelning - ovanliga resurser</a><br>
        <br>
        <a href="commerce_roles.php">Karaktärer med handel</a><br>
        <a href="commerce_groups.php">Grupper med handel</a><br>
        <br>
        <a href="roles_money.php">Pengar till karaktärer i början på lajvet</a><br>
        <a href="groups_money.php">Pengar till grupper i början på lajvet</a><br>
        <br>
        <br>
        <a href="logic/all_titledeeds_pdf.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Generera ägarbevis till verksamheterna</a><br>
        <a href="logic/all_resources_pdf.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Generera resurskort till verksamheterna</a> 
        <br>
        <br>
        <a href="reports/titledeeds_info_pdf.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Lista med lagfarter (för notarie)</a><br>  
        <a href="reports/titledeeds_info_pdf.php?all_info=1" target="_blank"><i class="fa-solid fa-file-pdf"></i>Lista med lagfarter (för handelsansvarig)</a><br><br>  
        <a href="reports/resources_info_pdf.php?all_info=1" target="_blank"><i class="fa-solid fa-file-pdf"></i>Prislista</a><br><br>  
        </p>

</body>
</html>