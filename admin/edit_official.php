<?php

include_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $RegistrationId = $_GET['id'];
    }
    else {
        header('Location: index.php');
        exit;
    }
}


$registration = Registration::loadById($RegistrationId);
$person = Person::loadById($registration->PersonId);

include 'navigation_subpage.php';

?>


	<div class="content">
		<h1><?php echo $person->Name;?></h1>
		<form action="logic/edit_official_save.php" method="post">
    		<input type="hidden" id="RegistrationId" name="RegistrationId" value="<?php echo $registration->Id; ?>">
		<table>
    		
 			<tr><td valign="top" class="header">Typ av funktionär</td><td><?php OfficialType::selectionDropdown(true,false,$registration->getSelectedOfficialTypeIds());?></td></tr>

		</table>		
			<input type="submit" value="Spara">

			</form>


	</div>


</body>
</html>
