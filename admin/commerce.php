<?php
include_once 'header.php';


include 'navigation.php';
?>

    <div class="content">
        <h1>Handel</h1>
        <p>
        <a href="resource_admin.php">Resurser</a><br>
        <a href="titledeed_admin.php">Lagfarter</a><br>
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
        <a href="logic/all_titledeeds_pdf.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Generera ägarbevis till lagfarterna</a><br>
        <a href="logic/all_resources_pdf.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Generera resurskort till lagfarterna som kvitton</a> 
        </p>

</body>
</html>