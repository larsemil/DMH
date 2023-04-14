<?php

require 'header.php';

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

if (Person::loadById($role->PersonId)->UserId != $current_user->Id) {
    header('Location: index.php'); //Inte din karaktär
    exit;
}

if (!$role->isRegistered($current_larp)) {
    header('Location: index.php'); // karaktären är inte anmäld
    exit;
}

$larp_role = LARP_Role::loadByIds($role->Id, $current_larp->Id);


if (isset($role->GroupId)) {
    $group=Group::loadById($role->GroupId);
}


include 'navigation.php';
?>

	<div class="content">
		<h1><?php echo $role->Name;?></h1>
		<table>
			<tr><td valign="top" class="header">Spelas av</td><td><?php echo $role->getPerson()->Name; ?></td>
		<?php 
		if ($role->hasImage()) {
		    
		    $image = Image::loadById($role->ImageId);
		    echo "<td rowspan='20' valign='top'><img width='300' src='data:image/jpeg;base64,".base64_encode($image->file_data)."'/></td>";
		    if (!empty($image->Photographer) && $image->Photographer!="") echo "<br>Fotograf $image->Photographer";
		}
		?>
			
			</tr>
		<?php if (isset($group)) {?>
			<tr><td valign="top" class="header">Grupp</td><td><a href ="view_group.php?id=<?php echo $group->Id;?>"><?php echo $group->Name; ?></a></td></tr>
		<?php }?>
			<tr><td valign="top" class="header">Huvudkaraktär</td><td><?php echo ja_nej($larp_role->IsMainRole);?></td></tr>
			<tr><td valign="top" class="header">Yrke</td><td><?php echo $role->Profession;?></td></tr>
			<tr><td valign="top" class="header">Beskrivning</td><td><?php echo nl2br($role->Description);?></td></tr>
			<tr><td valign="top" class="header">Beskrivning för gruppen</td><td><?php echo nl2br($role->DescriptionForGroup);?></td></tr>
			<tr><td valign="top" class="header">Beskrivning för andra</td><td><?php echo nl2br($role->DescriptionForOthers);?></td></tr>
			<tr><td valign="top" class="header">Tidigare lajv</td><td><?php echo $role->PreviousLarps;?></td></tr>
			<tr><td valign="top" class="header">Varför befinner sig karaktären i Slow River?</td><td><?php echo $role->ReasonForBeingInSlowRiver;?></td></tr>
			<tr><td valign="top" class="header">Religion</td><td><?php echo $role->Religion;?></td></tr>
			<tr><td valign="top" class="header">Mörk hemlighet</td><td><?php echo $role->DarkSecret;?></td></tr>
			<tr><td valign="top" class="header">Mörk hemlighet - intrig idéer</td><td><?php echo nl2br($role->DarkSecretIntrigueIdeas); ?></td></tr>
			<tr><td valign="top" class="header">Intrigtyper</td><td><?php echo commaStringFromArrayObject($role->getIntrigueTypes());?></td></tr>
			<tr><td valign="top" class="header">Intrigidéer</td><td><?php echo nl2br($role->IntrigueSuggestions); ?></td></tr>
			<tr><td valign="top" class="header">Saker karaktären inte vill spela på</td><td><?php echo $role->NotAcceptableIntrigues;?></td></tr>
			<tr><td valign="top" class="header">Relationer med andra</td><td><?php echo $role->CharactersWithRelations;?></td></tr>
			<tr><td valign="top" class="header">Annan information</td><td><?php echo $role->OtherInformation;?></td></tr>
			<tr><td valign="top" class="header">Rikedom</td><td><?php echo $role->getWealth()->Name; ?></td></tr>
			<tr><td valign="top" class="header">Var är karaktären född?</td><td><?php echo $role->Birthplace;?></td></tr>
			<tr><td valign="top" class="header">Var bor karaktären?</td><td><?php echo $role->getPlaceOfResidence()->Name; ?></td></tr>

		</table>		

		
		<h2>Intrig</h2>
			<?php if ($current_larp->DisplayIntrigues == 1) {
			    echo $larp_role->Intrigue;    
			}
			else {
			    echo "Intrigerna är inte klara än.";
			}
			?>
			<?php 
			
	    $previous_larp_roles = $role->getPreviousLarpRoles();
		if (isset($previous_larp_roles) && count($previous_larp_roles) > 0) {
		    echo "<h2>Historik</h2>";
            foreach ($previous_larp_roles as $prevoius_larp_role) {
                $prevoius_larp = LARP::loadById($prevoius_larp_role->LARPId);
                echo "<h3>$prevoius_larp->Name</h3>";
                echo "<strong>Vad hände för $role->Name?</strong><br>";
                if (isset($prevoius_larp_role->WhatHappened) && $prevoius_larp_role->WhatHappened != "")
                    echo $prevoius_larp_role->WhatHappened;
                    else echo "Inget rapporterat";
                echo "<br><br>";
                echo "<strong>Vad hände för andra?</strong><br>";
                if (isset($prevoius_larp_role->WhatHappendToOthers) && $prevoius_larp_role->WhatHappendToOthers != "")
                    echo $prevoius_larp_role->WhatHappendToOthers;
                else echo "Inget rapporterat";
    
            }

		}
		?>
	</div>


</body>
</html>
