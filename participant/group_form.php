<?php

require 'header_subpage.php';

$current_persons = $current_user->getPersons();

if (empty($current_persons)) {
    header('Location: index.php?error=no_person');
    exit;
}

$group = Group::newWithDefault();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $operation = "new";
    if (isset($_GET['operation'])) {
        $operation = $_GET['operation'];
    }
    if ($operation == 'new') {
    } elseif ($operation == 'update') {
        $group = Group::loadById($_GET['id']);
    } else {
    }
}

if ($group->isRegistered($current_larp)) {
    header('Location: view_group.php?id='.$group->Id);
    exit;
}

function default_value($field) {
    GLOBAL $group;
    $output = "";
    
    switch ($field) {
        case "operation":
            if (is_null($group->Id)) {
                $output = "insert";
                break;
            }
            $output = "update";
            break;
        case "action":
            if (is_null($group->Id)) {
                $output = "Registrera";
                break;
            }
            $output = "Uppdatera";
            break;
    }
    
    echo $output;
}



?>

	<div class="content">
		<h1><?php 
		if ($operation == 'update') {
		    echo "Redigera $group->Name";
		} else {
		    echo "Registrering av en grupp";
		}    
		 ?></h1>
		<form action="logic/group_form_save.php" method="post">
    		<input type="hidden" id="operation" name="operation" value="<?php default_value('operation'); ?>"> 
    		<input type="hidden" id="Id" name="Id" value="<?php echo $group->Id; ?>">


			<p>En grupp är en gruppering av roller som gör något tillsammans på
				lajvet. Exempelvis en familj på lajvet, en rånarliga eller ett rallarlag.</p>
				
				
			<h2>Gruppansvarig</h2>
			<p>Gruppansvarig är den som arrangörerna kommer att kontakta när det
				uppstår frågor kring gruppen.
			</p>
			
			<div class="question">
				<label for="Person">Gruppansvarig</label>&nbsp;<font style="color:red">*</font><br>
				<div class="explanation">Vem är gruppansvarig?</div>
				<?php selectionDropdownByArray('Person', $current_persons, false, true, $group->PersonId) ?>
			</div>
			
			
			
			<h2>Information om gruppen</h2>
			
			
			<div class="question">
				<label for="Name">Gruppens namn</label>&nbsp;<font style="color:red">*</font><br> 
				<input type="text" id="Name" name="Name" value="<?php echo $group->Name; ?>" required>
			</div>
			
			<div class="question">
    			<label for="Description">Beskrivning av gruppen</label>&nbsp;<font style="color:red">*</font><br>
    			<textarea id="Description" name="Description" rows="4" cols="50" maxlength="60000" required><?php echo $group->Description; ?></textarea>
			
			 
			</div>
			
			
			<div class="question">
				<label for="Friends">Vänner</label>
				<div class="explanation">Beskriv vilka gruppen anser vara sina vänner. Det vara både grupper och  beskrivning av egenskaper hos dem som är vänner. Exempelvis: Cheriffen, bankrånare och telegrafarbetare</div>
				<textarea id="Friends" name="Friends" rows="4" cols="50" maxlength="60000"><?php echo $group->Friends; ?></textarea>
			</div>
			<div class="question">
				<label for="Enemies">Fiender</label>
				<div class="explanation">Beskriv vilka gruppen anser vara sina fiender. Det vara både grupper och  beskrivning av egenskaper hos dem som är fiender. Exempelvis: Guldletare, Big Bengt och alla som gillar öl.</div>
				<textarea id="Enemies" name="Enemies" rows="4" cols="50" maxlength="60000"><?php echo $group->Enemies; ?></textarea>
			</div>


			<div class="question">
			<label for="Wealth">Hur rik anser du att gruppen är?</label>&nbsp;<font style="color:red">*</font>
			<div class="explanation"><?php Wealth::helpBox(true); ?></div>

			
            <?php

            Wealth::selectionDropdown(false, true, $group->WealthId);
            
            ?> 
			
			
			</div>
			<div class="question">
			<label for="PlaceOfResidence">Var bor gruppen?</label>&nbsp;<font style="color:red">*</font>
			<div class="explanation">Tänk typ folkbokföringsadress, dvs även om gruppen tillfälligt är i Slow River så vill vi veta var gruppen har sitt hem.<br><?php PlaceOfResidence::helpBox(true); ?></div>
			
			
            <?php
            PlaceOfResidence::selectionDropdown(false, true, $group->PlaceOfResidenceId);
            ?> 

			</div>
			
					
			<div class="question">
			<label for="IntrigueIdeas">Intrigidéer</label>
			<div class="explanation">
			Har ni några grupprykten som ni vill ha hjälp med att sprida? 
			</div>
			<textarea id="IntrigueIdeas" name="IntrigueIdeas" rows="4" cols="50" maxlength="60000"><?php echo $group->IntrigueIdeas; ?></textarea>
			
			
			</div>
						
			<div class="question">
			<label for="OtherInformation">Något annat arrangörerna bör veta om er grupp?</label><br>
			<textarea id="OtherInformation" name="OtherInformation" rows="4" cols="50" maxlength="60000"><?php echo $group->OtherInformation; ?></textarea>
			
			 
			</div>
			
			
			<div class="question">
			Genom att kryssa i denna ruta så lovar jag med
			heder och samvete att jag har läst igenom alla hemsidans regler och
			förmedlat dessa till mina gruppmedlemmar. Vi har även alla godkänt
			dem och är införstådda med vad som förväntas av oss som grupp av
			deltagare på lajvet. Om jag inte har läst reglerna så kryssar jag
			inte i denna ruta.&nbsp;<font style="color:red">*</font><br>
			
			<input type="checkbox" id="rules" name="rules" value="Ja" required>
  			<label for="rules">Jag lovar</label> 
			</div>

			  <input type="submit" name="action" value="<?php default_value('action'); ?>">
			  <input type="submit" name="action" value="<?php default_value('action'); ?> och gå direkt till anmälan">
		</form>
	</div>

</body>
</html>