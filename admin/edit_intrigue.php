<?php

include_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $RoleId = $_GET['id'];
    }
    else {
        header('Location: index.php');
        exit;
    }
}

$role = Role::loadById($RoleId);


if (!$role->isRegistered($current_larp)) {
    header('Location: index.php'); //Rollen är inte anmäld
    exit;
}

$larp_role = LARP_Role::loadByIds($role->Id, $current_larp->Id);


if (isset($role->GroupId)) {
    $group=Group::loadById($role->GroupId);
}

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
}
else {
    $referer = "";
}

include 'navigation_subpage.php';
?>


	<div class="content">
		<h1><?php echo $role->Name;?>&nbsp;<a href='edit_role.php?id=<?php echo $role->Id;?>'><i class='fa-solid fa-pen'></i></a></h1>
		<table>
			<tr><td valign="top" class="header">Spelas av</td><td><a href ="view_person.php?id=<?php echo $role->PersonId;?>"><?php echo $role->getPerson()->Name; ?></a></td></tr>
		<?php if (isset($group)) {?>
			<tr><td valign="top" class="header">Grupp</td><td><a href ="view_group.php?id=<?php echo $group->Id;?>"><?php echo $group->Name; ?></a></td></tr>
		<?php }?>
			<tr><td valign="top" class="header">Huvudkaraktär</td><td><?php echo ja_nej($larp_role->IsMainRole);?></td></tr>
			<tr><td valign="top" class="header">Yrke</td><td><?php echo $role->Profession;?></td></tr>
			<tr><td valign="top" class="header">Beskrivning</td><td><?php echo nl2br($role->Description);?></td></tr>
			<tr><td valign="top" class="header">Beskrivning för grupp</td><td><?php echo nl2br($role->DescriptionForGroup);?></td></tr>
			<tr><td valign="top" class="header">Beskrivning för andra</td><td><?php echo nl2br($role->DescriptionForOthers);?></td></tr>
			<tr><td valign="top" class="header">Tidigare lajv</td><td><?php echo $role->PreviousLarps;?></td></tr>
			<tr><td valign="top" class="header">Varför befinner sig karaktären i Slow River?</td><td><?php echo $role->ReasonForBeingInSlowRiver;?></td></tr>
			<tr><td valign="top" class="header">Religion</td><td><?php echo $role->Religion;?></td></tr>
			<tr><td valign="top" class="header">Mörk hemlighet</td><td><?php echo $role->DarkSecret;?></td></tr>
			<tr><td valign="top" class="header">Mörk hemlighet - intrig idéer</td><td><?php echo nl2br($role->DarkSecretIntrigueIdeas); ?></td></tr>
			<tr><td valign="top" class="header">Intrigtyper</td><td><?php echo commaStringFromArrayObject($larp_role->getIntrigueTypes());?></td></tr>
			<tr><td valign="top" class="header">Intrigidéer</td><td><?php echo nl2br($role->IntrigueSuggestions); ?></td></tr>
			<tr><td valign="top" class="header">Saker karaktären inte vill spela på</td><td><?php echo $role->NotAcceptableIntrigues;?></td></tr>
			<tr><td valign="top" class="header">Relationer med andra</td><td><?php echo $role->CharactersWithRelations;?></td></tr>
			<tr><td valign="top" class="header">Annan information</td><td><?php echo $role->OtherInformation;?></td></tr>
			<tr><td valign="top" class="header">Rikedom</td><td><?php echo $role->getWealth()->Name;?></td></tr>
			<tr><td valign="top" class="header">Var är karaktären född?</td><td><?php echo $role->Birthplace; ?></td></tr>
			<tr><td valign="top" class="header">Var bor karaktären?</td><td><?php echo $role->getPlaceOfResidence()->Name; ?></td></tr>

		</table>		

		
		<h2>Intrig</h2>
		<form action="logic/edit_intrigue_save.php" method="post">
    		<input type="hidden" id="Id" name="Id" value="<?php echo $role->Id; ?>">
    		<input type="hidden" id="Referer" name="Referer" value="<?php echo $referer;?>">
		<textarea id="Intrigue" name="Intrigue" rows="20" cols="150" maxlength="60000"><?php    echo $larp_role->Intrigue; ?></textarea>
		
		<input type="submit" value="Spara">

			</form>

		

	</div>


</body>
</html>
