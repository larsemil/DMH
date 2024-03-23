<?php
include_once 'header.php';

$cols = 5;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['Id'])) {
        $intrigue=Intrigue::loadById($_GET['Id']);
    } else {
        header("Location: index.php?Id");
        exit;
        
    }
    if ($current_larp->Id != $intrigue->LarpId) {
        header("Location: view_previous_intrigue.php?Id=$intrigue->Id");
        exit;
    }
}

function printActorIntrigue(IntrigueActor $intrgueActor, $name) {
    $section = "section_$intrgueActor->Id";
    echo "<h2 id='$section'>Intrig för ";
    if (!empty($intrgueActor->RoleId)) echo "<a href='view_role.php?id=$intrgueActor->RoleId'>";
    elseif (!empty($intrgueActor->GroupId)) echo "<a href='view_group.php?id=$intrgueActor->GroupId'>";
    
    echo "$name</a> <a href='actor_intrigue_form.php?IntrigueActorId=$intrgueActor->Id&name=$name&section=$section'><i class='fa-solid fa-pen'></i></a></h2>\n";
    echo "<table width='100%''>\n";
    
    
    echo "<tr><td width='10%'>Intrigtext</td>";
    $previousActor = $intrgueActor->getPrevious();
    if (!empty($previousActor)) {
        echo "<td><textarea id='IntrigueText:$intrgueActor->Id' name='IntrigueText' rows='4' cols='100' maxlength='60000' onkeyup='saveIntrigueTextForActor(this)'  onchange='saveIntrigueTextForActor(this)'>".
            htmlspecialchars($intrgueActor->IntrigueText)."</textarea></td>";
            echo "<td><strong>Intrigtext förra lajvet</strong><br>".nl2br(htmlspecialchars($previousActor->IntrigueText));
            if (!empty($previousActor->WhatHappened)) echo "<br><br><strong>Vad hände?</strong><br>".nl2br(htmlspecialchars($previousActor->WhatHappened));
            "</td>";
            
    } else {
        echo "<td colspan='2'><textarea id='IntrigueText:$intrgueActor->Id' name='IntrigueText' rows='4' cols='100' maxlength='60000' onkeyup='saveIntrigueTextForActor(this)'  onchange='saveIntrigueTextForActor(this)'>".
            htmlspecialchars($intrgueActor->IntrigueText)."</textarea></td>";
    }
    echo "</tr>\n";
    echo "<tr><td>Off-info<br>till deltagaren</td><td colspan='2'>".nl2br(htmlspecialchars($intrgueActor->OffInfo))."</td></tr>\n";
    echo "<tr><td>Ska ha vid incheck</td>\n";
    echo "<td colspan='2'>";
    echo "<a href='choose_intrigue_checkin.php?IntrigueActorId=$intrgueActor->Id&section=$section'><i class='fa-solid fa-plus' title='Lägg till'></i></a>\n";
    $checkinProps = $intrgueActor->getAllPropsForCheckin();
    printAllProps($checkinProps, $intrgueActor, true, $section);
    $checkinLetters = $intrgueActor->getAllLettersForCheckin();
    printAllLetters($checkinLetters, $intrgueActor, $section);
    $checkinTelegrams = $intrgueActor->getAllTelegramsForCheckin();
    printAllTelegrams($checkinTelegrams, $intrgueActor, $section);
    
    echo "</td></tr>\n";
    echo "<tr><td>Rekvisita och PDF aktören känner till</td><td colspan='2'>\n";
    echo "<a href='choose_intrigue_props.php?IntrigueActorId=$intrgueActor->Id&section=$section'><i class='fa-solid fa-plus' title='Lägg till'></i></a>\n";
    $knownProps = $intrgueActor->getAllPropsThatAreKnown();
    printAllProps($knownProps, $intrgueActor, false, $section);
    $knownPdfs = $intrgueActor->getAllPdfsThatAreKnown();
    printAllPdfs($knownPdfs, $intrgueActor, $section);
    echo "</td></tr>\n";
    echo "<tr><td>Karaktärer aktören känner till</td><td colspan='2'>\n";
    echo "<a href='choose_intrigue_knownactors.php?IntrigueActorId=$intrgueActor->Id&section=$section'><i class='fa-solid fa-plus' title='Lägg till'></i></a>\n";
    $knownActors = $intrgueActor->getAllKnownActors();
    printAllKnownActors($knownActors, $intrgueActor, $section);
    $knownNPCGroups = $intrgueActor->getAllKnownNPCGroups();
    printAllKnownNPCGroups($knownNPCGroups, $intrgueActor, $section);
    $knownNPCs = $intrgueActor->getAllKnownNPCs();
    printAllKnownNPCs($knownNPCs, $intrgueActor, $section);
    echo "</td></tr>\n";
    if (!empty($intrgueActor->WhatHappened)) {
        echo "<tr><td>Vad hände</td>\n";
        echo "<td>".nl2br($intrgueActor->WhatHappened)."</td></tr>\n";
    }
    echo "</table>\n";
    
}



function printAllProps($props, $intrigueActor, $isCheckin, $section) {
    global $cols;
    if ($isCheckin){
        $remove_operation = "remove_prop_checkin";
    }
    else {
        $remove_operation = "remove_prop_known";
    }
    echo "<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
    $temp=0;
    foreach ($props as $prop) {
        echo "\n";
        echo "<li style='display:table-cell; width:19%;'>\n";
        echo "<div class='name'>$prop->Name</div>\n";
        if ($prop->hasImage()) {
            echo "<img width=100 src='../includes/display_image.php?id=$prop->ImageId'/>\n";
        }
        echo "<div align='right'>";
        echo "<a href='logic/view_intrigue_logic.php?operation=$remove_operation&PropId=$prop->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'>";
        echo "<i class='fa-solid fa-xmark' title='Ta bort från rekvisita'></i></a>";
        echo "</div>";
        echo "</li>\n";
        $temp++;
        if($temp==$cols)
        {
            echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
            $temp=0;
        }
    }


	echo "</ul>";
}

function printAllPdfs($intrigue_pdfs, $intrigueActor, $section) {
    foreach($intrigue_pdfs as $intrigue_pdf) {
        echo "<a href='view_intrigue_pdf.php?id=$intrigue_pdf->Id' target='_blank'>$intrigue_pdf->Filename</a>";
        echo " <a href='logic/view_intrigue_logic.php?operation=remove_pdf_known&PdfId=$intrigue_pdf->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'><i class='fa-solid fa-xmark'></i></a>";
        echo "<br>";
    }
    
}

function printAllLetters($letters, $intrigueActor, $section) {
    foreach($letters as $letter) {
        echo "Från: $letter->Signature, Till: $letter->Recipient, ".mb_strimwidth(str_replace('\n', '<br>', $letter->Message), 0, 50, '...');
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_letter_checkin&LetterId=$letter->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'><i class='fa-solid fa-xmark' title='Ta bort från incheck'></i></a>";
        echo "<br>";
    }
    
}


function printAllTelegrams($telegrams, $intrigueActor, $section) {
    foreach($telegrams as $telegram) {
        echo "$telegram->Deliverytime, Från: $telegram->Sender, Till: $telegram->Reciever, ".mb_strimwidth(str_replace('\n', '<br>', $telegram->Message), 0, 50, '...');
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_telegram_checkin&TelegramId=$telegram->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'><i class='fa-solid fa-xmark' title='Ta bort från incheck'></i></a>";
        echo "<br>";
    }
    
}

function printKnownActor(IntrigueActor $knownIntrigueActor, $intrigueActor, $section) {
    if (!empty($knownIntrigueActor->GroupId)) {
        $group=$knownIntrigueActor->getGroup();
        echo "<li style='display:table-cell; width:19%;'>";
        echo "<div class='name'>$group->Name</div>";
        echo "<div>Grupp</div>";
        echo "</div>";
        echo "<div align='right'>";
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_intrigueactor_knownGroup&GroupId=$group->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'>";
        echo "<i class='fa-solid fa-xmark' title='Ta bort från rekvisita'></i></a>";
        echo "</div>";
        echo "</li>";
        
    } else {
        $role = $knownIntrigueActor->getRole();
        echo "<li style='display:table-cell; width:19%;'>";
        echo "<div class='name'>$role->Name</div>";
        $role_group = $role->getGroup();
        if (!empty($role_group)) {
            echo "<div>$role_group->Name</div>";
        }
        
        if ($role->hasImage()) {
            echo "<img src='../includes/display_image.php?id=$role->ImageId'/>\n";
        }
        echo "<div align='right'>";
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_intrigueactor_knownRole&RoleId=$role->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'>";
        echo "<i class='fa-solid fa-xmark' title='Ta bort från rekvisita'></i></a>";
        echo "</div>";
    }
}

function printAllKnownActors($known_actors, $intrigue_actor, $section) {
    global $cols;
    echo "<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
    $temp=0;
    foreach($known_actors as $known_actor) {
        $ka = $known_actor->getKnownIntrigueActor();
        printKnownActor($ka, $intrigue_actor, $section);
        $temp++;
        if($temp==$cols)
        {
            echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
            $temp=0;
        }
    }
    echo "</ul>";
}


function printAllKnownNPCs($known_npcs, $intrigueActor, $section) {
    global $cols;
    echo "<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
    $temp=0;
    foreach($known_npcs as $known_npc) {
        $npc=$known_npc->getIntrigueNPC()->getNPC();
        echo "<li style='display:table-cell; width:19%;'>\n";
        echo "<div class='name'>$npc->Name</div>\n";
        $npc_group = $npc->getNPCGroup();
        if (!empty($npc_group)) {
            echo "<div>$npc_group->Name</div>";
        }
        if ($npc->IsAssigned()) {
            $person = $npc->getPerson();
            echo "<div>Spelas av $person->Name</div>";
        } else {
            echo "Spelas inte";
        }
        
        
        if ($npc->hasImage()) {
            echo "<img width='100' src='../includes/display_image.php?id=$npc->ImageId'/>\n";
        }
        echo "<div align='right'>";
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_npc_intrigueactor&NPCId=$npc->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'>";
        echo "<i class='fa-solid fa-xmark' title='Ta bort NPC'></i></a>";
        echo "</div>";
        echo "</li>\n";
        $temp++;
        if($temp==$cols)
        {
            echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
            $temp=0;
        }
    }
    echo "</ul>";
}

function printAllKnownNPCGroups($known_npcgroups, $intrigueActor, $section) {
    global $cols;
    echo "<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
    $temp=0;
    foreach($known_npcgroups as $known_npcgroup) {
        $npcgroup=$known_npcgroup->getIntrigueNPCGroup()->getNPCGroup();
        echo "<li style='display:table-cell; width:19%;'>\n";
        echo "<div class='name'>$npcgroup->Name</div>\n";
        echo "<div>NPC-grupp</div>";
        echo "<div align='right'>";
        echo "<a href='logic/view_intrigue_logic.php?operation=remove_npcgroup_intrigueactor&NPCGroupId=$npcgroup->Id&IntrigueActorId=$intrigueActor->Id&Section=$section'>";
        echo "<i class='fa-solid fa-xmark' title='Ta bort NPC-grupp'></i></a>";
        echo "</div>";
        echo "</li>\n";
        $temp++;
        if($temp==$cols)
        {
            echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
            $temp=0;
        }
    }
    echo "</ul>";
}

if (empty($intrigue)) {
    header('Location: intrigue_admin.php');
    exit;
    
}


include 'navigation.php';
?>
<style>
th, td {
  border-style:solid;
  border-color: #d4d4d4;
}
</style>

    <div class="content">
        <h1>Intrigspår: <?php echo "$intrigue->Number. $intrigue->Name" ?> 
        <a href="intrigue_form.php?operation=update&id=<?php echo $intrigue->Id ?>"><i class='fa-solid fa-pen' title='Redigera intrigen'></i></a>
        &nbsp; 
        <a href="reports/intrigues_pdf.php?Id=<?php echo $intrigue->Id;?>" target='_blank'><i class='fa-solid fa-file-pdf' title='Intrigen som PDF'></i></a>
        </h1>
<table width='100%'>
<?php 

    $previous_instances = $intrigue->getPreviousInstaces();
    if (!empty($previous_instances)) {
        echo "<tr><td>Tidigare lajv</td><td>";
        foreach($previous_instances as $previous_instance) {
            echo "<a href='view_previous_intrigue.php?Id=$previous_instance->Id'>$previous_instance->Name på ".$previous_instance->getLarp()->Name."<br>";
        }
        
        echo "</td></tr>";
    }


?>


<tr><td width="10%">Aktuell</td><td><?php echo ja_nej($intrigue->isActive()); ?></td></tr>
<tr><td>Huvudintrig</td><td><?php echo ja_nej($intrigue->MainIntrigue); ?></td></tr>
<tr><td>Intrigtyp</td><td><?php echo commaStringFromArrayObject($intrigue->getIntriguetypes())?></td></tr>
<tr><td>Ansvarig</td><td>
	<?php                  
	  $responsibleUser = $intrigue->getResponsibleUser();
      echo $responsibleUser->Name;
?></td></tr>
<tr><td>Text till alla aktörer</td><td><?php  echo nl2br($intrigue->CommonText); ?></td></tr>
<tr><td>Anteckningar</td><td><?php  echo nl2br($intrigue->Notes); ?></td></tr>
<tr><td>Aktörer<br>(Grupper och karaktärer som är inblandade i intrigen)</td>
<td>

<div class='container'>
<a href="choose_group.php?operation=add_intrigue_actor_group&Id=<?php echo $intrigue->Id?>&intrigueTypeFilter=1">
	<i class='fa-solid fa-plus' title="Lägg till grupp"></i><i class='fa-solid fa-users' title="Lägg till grupp"></i>
</a>
<ul class='image-gallery' style='display:table; border-spacing:5px;'>
	<?php 
	$groupActors = $intrigue->getAllGroupActors();
	$temp=0;
	foreach ($groupActors as $groupActor) {
	    $group = $groupActor->getGroup();
	    echo "<li style='display:table-cell; width:19%;'>";
	    echo "<div class='name'><a href='../admin/view_group.php?id=$group->Id'>$group->Name</a></div>";
	    echo "<div>Grupp</div>";
	    $actor_intrigues = $groupActor->getAllIntrigues();
	    foreach ($actor_intrigues as $actor_intrigue) {
	        if ($actor_intrigue->Id != $intrigue->Id) {
	            echo "<div><a href='view_intrigue.php?Id=$actor_intrigue->Id'>$actor_intrigue->Number. $actor_intrigue->Name</a></div>";
	        }
	    }
	    if ($group->hasImage()) {
	        echo "<img src='../includes/display_image.php?id=$group->ImageId'/>\n";
	    }
	    echo "<div align='right'>";
	    if (!$groupActor->isAtLARP()) echo "<i class='fa-solid fa-bed' title='Inte anmäld till lajvet'></i> ";
	    echo "<a href='choose_group.php?operation=exhange_intrigue_actor_group&Id=$groupActor->Id?'><i class='fa-solid fa-rotate' title='Byt ut grupp som får intrigen'></i></a> ";
	    echo "<a ";
	    if (!empty($groupActor->IntrigueText)) echo ' onclick="return confirm(\'Det finns en skriven intrigtext. Vill du ta bort gruppen i alla fall?\')" ';
	    echo " href='logic/view_intrigue_logic.php?operation=remove_intrigueactor&IntrigueActorId=$groupActor->Id&Id=$intrigue->Id'";
        
	    echo "><i class='fa-solid fa-xmark' title='Ta bort grupp'></i></a>";
	    echo "</div>";
	    echo "</li>";
	    $temp++;
	    if($temp==$cols)
	    {
	        echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
	        $temp=0;
	    }
	}
	?>
</ul>	
<a href="choose_role.php?operation=add_intrigue_actor_role&Id=<?php echo $intrigue->Id?>&intrigueTypeFilter=1">
<i class='fa-solid fa-plus' title="Lägg till karaktär"></i>
<i class='fa-solid fa-user' title="Lägg till karaktär"></i></a>
<ul class='image-gallery' style='display:table; border-spacing:5px;'>
	<?php 
	$roleActors = $intrigue->getAllRoleActors();
	$temp=0;
	foreach ($roleActors as $roleActor) {
	    $role = $roleActor->getRole();
	    echo "<li style='display:table-cell; width:19%;'>";
	    echo "<div class='name'><a href='../admin/view_role.php?id=$role->Id'>$role->Name</a></div>";
	    $role_group = $role->getGroup();
	    if (!empty($role_group)) {
	        echo "<div>$role_group->Name</div>";
	    }
	    $actor_intrigues = $roleActor->getAllIntrigues();
	    foreach ($actor_intrigues as $actor_intrigue) {
	        if ($actor_intrigue->Id != $intrigue->Id) {
	           echo "<div><a href='view_intrigue.php?Id=$actor_intrigue->Id'>$actor_intrigue->Number. $actor_intrigue->Name</a></div>";
	        }
	    }
	    if ($role->hasImage()) {
	        echo "<img src='../includes/display_image.php?id=$role->ImageId'/>\n";
	    }
	    echo "<div align='right'>";
	    if (!$roleActor->isAtLARP()) echo "<i class='fa-solid fa-bed' title='Inte anmäld till lajvet'></i> ";
	    echo "<a href='choose_role.php?operation=exhange_intrigue_actor_role&Id=$roleActor->Id'><i class='fa-solid fa-rotate' title='Byt ut karaktär som får intrigen'></i></a> ";
	    echo "<a href='logic/view_intrigue_logic.php?operation=remove_intrigueactor&IntrigueActorId=$roleActor->Id&Id=$intrigue->Id'";
	    if (!empty($roleActor->IntrigueText)) echo ' onclick="return confirm(\'Det finns en skriven intrigtext. Vill du ta bort karaktären i alla fall?\')" ';
	    echo "><i class='fa-solid fa-xmark' title='Ta bort karaktär'></i></a>";
	    echo "</div>";
	    echo "</li>";
	    $temp++;
	    if($temp==$cols)
	    {
	        echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
	        $temp=0;
	    }
	}
	?>


</ul>
	</td>
	</tr>
<tr><td>Rekvisita</td><td>
<a href="choose_prop.php?operation=add_intrigue_prop&Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till rekvisita"></i></a>

<ul class='image-gallery' style='display:table; border-spacing:5px;'>
	<?php 
	$intrigue_props = $intrigue->getAllProps();
	$temp=0;
	foreach ($intrigue_props as $intrigue_prop) {
	    $prop = $intrigue_prop->getProp();
	    echo "<li style='display:table-cell; width:19%;'>\n";
	    echo "<div class='name'><a href='prop_form.php?operation=update&id=$prop->Id'>$prop->Name</a></div>\n";
	    $prop_intrigues = $intrigue_prop->getAllIntrigues();
	    foreach ($prop_intrigues as $prop_intrigue) {
	        if ($prop_intrigue->Id != $intrigue->Id) {
	            echo "<div><a href='view_intrigue.php?Id=$prop_intrigue->Id'>Intrig: $prop_intrigue->Number. $prop_intrigue->Name</a></div>";
	        }
	    }
	    if ($prop->hasImage()) {
	        echo "<img width='100' src='../includes/display_image.php?id=$prop->ImageId'/>\n";
	    }
	    echo "<div align='right'>";
	    echo "<a href='logic/view_intrigue_logic.php?operation=remove_prop&IntriguePropId=$intrigue_prop->Id&Id=$intrigue->Id'>";
	    echo "<i class='fa-solid fa-xmark' title='Ta bort karaktär'></i></a>";
	    echo "</div>";
	    echo "</li>\n";
	    $temp++;
	    if($temp==$cols)
	    {
	        echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
	        $temp=0;
	    }
	}
    ?>

</ul>
</td></tr>
<tr><td>NPC</td>
<td>
<a href="choose_npcgroup.php?operation=add_intrigue_npcgroup&Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till NPC-grupp"></i></a>
<ul class='image-gallery' style='display:table; border-spacing:5px;'>
	<?php 
	$intrigue_npcgroups = $intrigue->getAllNPCGroups();
	$temp=0;
	foreach ($intrigue_npcgroups as $intrigue_npcgroup) {
	    $npcgroup = $intrigue_npcgroup->getNPCGroup();
	    echo "<li style='display:table-cell; width:19%;'>\n";
	    echo "<div class='name'><a href='npc_group_form.php?operation=update&id=$npcgroup->Id'>$npcgroup->Name</a></div>\n";
	    echo "<div>NPC-grupp</div>";
	    $npcgroup_intrigues = $intrigue_npcgroup->getAllIntrigues();
	    foreach ($npcgroup_intrigues as $npcgroup_intrigue) {
	        if ($npcgroup_intrigue->Id != $intrigue->Id) {
	            echo "<div><a href='view_intrigue.php?Id=$npcgroup_intrigue->Id'>Intrig: $npcgroup_intrigue->Number. $npcgroup_intrigue->Name</a></div>";
	        }
	    }
	    echo "<div align='right'>";
	    echo "<a href='logic/view_intrigue_logic.php?operation=remove_npcgroup&IntrigueNPCGroupId=$intrigue_npcgroup->Id&Id=$intrigue->Id'>";
	    echo "<i class='fa-solid fa-xmark' title='Ta bort NPC'></i></a>";
	    echo "</div>";
	    echo "</li>\n";
	    $temp++;
	    if($temp==$cols)
	    {
	        echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
	        $temp=0;
	    }
	}
    ?>
   </ul>

<a href="choose_npc.php?operation=add_intrigue_npc&Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till NPC"></i></a>
<ul class='image-gallery' style='display:table; border-spacing:5px;'>
	<?php 
	$intrigue_npcs = $intrigue->getAllNPCs();
	$temp=0;
	foreach ($intrigue_npcs as $intrigue_npc) {
	    $npc = $intrigue_npc->getNPC();
	    echo "<li style='display:table-cell; width:19%;'>\n";
	    echo "<div class='name'><a href='npc_form.php?operation=update&id=$npc->Id'>$npc->Name</a></div>\n";
	    $npc_group = $npc->getNPCGroup();
	    if (!empty($npc_group)) {
	        echo "<div>$npc_group->Name</div>";
	    }
	    if ($npc->IsAssigned()) {
	        $person = $npc->getPerson();
	        echo "<div>Spelas av $person->Name</div>"; 
	    } else {
	        echo "Spelas inte";
	    }
	    $npc_intrigues = $intrigue_npc->getAllIntrigues();
	    foreach ($npc_intrigues as $npc_intrigue) {
	        if ($npc_intrigue->Id != $intrigue->Id) {
	            echo "<div><a href='view_intrigue.php?Id=$npc_intrigue->Id'>Intrig: $npc_intrigue->Number. $npc_intrigue->Name</a></div>";
	        }
	    }
	    
	    
	    if ($npc->hasImage()) {
	        echo "<img width='100' src='../includes/display_image.php?id=$npc->ImageId'/>\n";
	    }
	    echo "<div align='right'>";
	    echo "<a href='logic/view_intrigue_logic.php?operation=remove_npc&IntrigueNPCId=$intrigue_npc->Id&Id=$intrigue->Id'>";
	    echo "<i class='fa-solid fa-xmark' title='Ta bort NPC'></i></a>";
	    echo "</div>";
	    echo "</li>\n";
	    $temp++;
	    if($temp==$cols)
	    {
	        echo"</ul>\n<ul class='image-gallery' style='display:table; border-spacing:5px;'>";
	        $temp=0;
	    }
	}
    ?>
    </ul>
</td></tr>
<?php if ($current_larp->hasTelegrams() || $current_larp->hasLetters()) {?>

<tr><td>Meddelanden</td><td>
<a href="choose_telegram_letter.php?operation=add_intrigue_message&Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till telegram och brev"></i></a>
<br>
<?php 
$intrigue_letters = $intrigue->getAllLetters();
foreach ($intrigue_letters as $intrigue_letter) {
    $letter=$intrigue_letter->getLetter();
    echo "Från: $letter->Signature, Till: $letter->Recipient, ".str_replace('\n', '<br>', $letter->Message);
    echo "<a href='letter_form.php?operation=update&id=$letter->Id'><i class='fa-solid fa-pen'></i></a>";
    echo " ";
    echo "<a href='logic/view_intrigue_logic.php?operation=remove_letter&IntrigueLetterId=$intrigue_letter->Id&Id=$intrigue->Id'><i class='fa-solid fa-xmark' title='Ta bort brev'></i></a>";

    $letter_intrigues = $intrigue_letter->getAllIntrigues();
    foreach ($letter_intrigues as $letter_intrigue) {
        if ($letter_intrigue->Id != $intrigue->Id) {
            echo "<br>&nbsp;&nbsp;&nbsp;<a href='view_intrigue.php?Id=$letter_intrigue->Id'>Intrig: $letter_intrigue->Number. $letter_intrigue->Name</a>";
        }
    }
    
    echo "<br><br>"; 
}
$intrigue_telegrams = $intrigue->getAllTelegrams();
foreach ($intrigue_telegrams as $intrigue_telegram) {
    $telegram=$intrigue_telegram->getTelegram();
    echo "$telegram->Deliverytime, Från: $telegram->Sender, Till: $telegram->Reciever, ".str_replace('\n', '<br>', $telegram->Message);
    echo "<a href='telegram_form.php?operation=update&id=$telegram->Id'><i class='fa-solid fa-pen'></i></a>";
    echo " ";
    echo "<a href='logic/view_intrigue_logic.php?operation=remove_telegram&IntrigueTelegramId=$intrigue_telegram->Id&Id=$intrigue->Id'><i class='fa-solid fa-xmark' title='Ta bort telegram'></i></a>";
    $telegram_intrigues = $intrigue_telegram->getAllIntrigues();
    foreach ($telegram_intrigues as $telegram_intrigue) {
        if ($telegram_intrigue->Id != $intrigue->Id) {
            echo "<br>&nbsp;&nbsp;&nbsp;<a href='view_intrigue.php?Id=$telegram_intrigue->Id'>Intrig: $telegram_intrigue->Number. $telegram_intrigue->Name</a>";
        }
    }
    echo "<br><br>";
}


?>
</td></tr>
<?php }?>

<tr><td>PDF</td><td>
<a href="add_intrigue_pdf.php?Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till PDF"></i></a>
<br>
<?php 
$intrigue_pdfs = $intrigue->getAllPdf();
foreach ($intrigue_pdfs as $intrigue_pdf) {
    echo "<a href='view_intrigue_pdf.php?id=$intrigue_pdf->Id' target='_blank'>$intrigue_pdf->Filename</a>";
    echo " <a href='logic/view_intrigue_logic.php?operation=delete_pdf&pdfId=$intrigue_pdf->Id'><i class='fa-solid fa-trash'></i></a>";    
    echo "<br>"; 
}
?>
</td></tr>

<tr><td>Länkade intriger</td><td>
  <a href="choose_intrigue.php?operation=add_intrigue_relation&Id=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Lägg till länk till annan intrig"></i></a>
  <br>
<?php 
$intrigue_relations = $intrigue->getAllIntrigueRelations();
foreach ($intrigue_relations as $intrigue_relation) {
    echo "<a href='view_intrigue.php?Id=$intrigue_relation->Id'>Intrig: $intrigue_relation->Number. $intrigue_relation->Name</a>";
    if (!$intrigue_relation->isActive()) echo " (inte aktuell)";
    echo " <a href='logic/view_intrigue_logic.php?operation=remove_intrigue_relation&IntrigueRelationId=$intrigue_relation->Id&Id=$intrigue->Id'><i class='fa-solid fa-xmark' title='Ta bort relation'></i></a>";
    echo "<br>";
}
?>
</td></tr>
<tr><td>Händelser</td><td>
  <a href="timeline_form.php?operation=insert&IntrigueId=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Skapa händelse under lajvet"></i></a>
  <br>
<?php 
$timeline_array = $intrigue->getTimeline();
foreach ($timeline_array as $timeline) {
    echo substr($timeline->When,0,16)." $timeline->Description";
    echo " <a href='timeline_form.php?operation=update&id=$timeline->Id'><i class='fa-solid fa-pen'></i></a>";
    echo " <a href='timeline_admin.php?operation=delete&id=$timeline->Id&gotoreferer='true'><i class='fa-solid fa-trash'></i></a>";
    echo "<br>";
}
?>
</td></tr>

<?php if ($current_larp->hasRumours()) {?>
<tr><td>Rykten</td><td>
  <a href="rumour_form.php?operation=insert&IntrigueId=<?php echo $intrigue->Id?>"><i class='fa-solid fa-plus' title="Skapa rykte under lajvet"></i></a>
  <br>
<?php 
$rumour_array = $intrigue->getRumours();
foreach ($rumour_array as $rumour) {
    $knows_rumour = $rumour->getKnows();
    $knows_rumour_array = array();
    foreach($knows_rumour as $knows) $knows_rumour_array[] = $knows->getName();
    $knows_txt = "Vet om: ". implode(", ", $knows_rumour_array);
    
    
    
    echo $rumour->Text;
    echo " <a href='rumour_form.php?operation=update&id=$rumour->Id'><i class='fa-solid fa-pen'></i></a>";
    echo " <a href='rumour_admin.php?operation=delete&id=$rumour->Id&gotoreferer='true'><i class='fa-solid fa-trash'></i></a>";
    echo "<br>";
    echo $knows_txt."<br><br>";
}
?>
</td></tr>
<?php }?>
</table>

<?php 

foreach ($groupActors as $groupActor) {
    $group = $groupActor->getGroup();
    if ($groupActor->isAtLARP()) printActorIntrigue($groupActor, $group->Name);

}

foreach ($roleActors as $roleActor) {
    $role = $roleActor->getRole();
    if ($roleActor->isAtLARP()) printActorIntrigue($roleActor, $role->Name);
    
}


?>

<script src="../javascript/saveIntrigueText_ajax.js"></script>
       