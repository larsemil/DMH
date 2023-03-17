<?php
    require 'header.php'; 
    $person = Person::newWithDefault();
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $operation = "new";
        if (isset($_GET['operation'])) {
            $operation = $_GET['operation'];
        }
        if ($operation == 'new') {
        } elseif ($operation == 'update') {
            $person = Person::loadById($_GET['id']);
        } else {
        }
    }
    
    
    if ($operation == 'update' && $person->UserId != $current_user->Id) {
        header('Location: index.php'); //Inte din person
        exit;
    }
    
    
    if ($person->isRegistered($current_larp)) {
        header('Location: view_person.php?id='.$person->Id);
        exit;
    }
    
    function default_value($field) {
        GLOBAL $person;
        $output = "";

        switch ($field) {
            case "operation":
                if (is_null($person->Id)) {
                    $output = "insert";
                    break;
                }
                $output = "update";
                break;            
            case "action":
                if (is_null($person->Id)) {
                    $output = "Registrera";
                    break;
                }
                $output = "Uppdatera";
                break;
        }

        echo $output;
    }
    
    include 'navigation_subpage.php';
?>

	<div class="content">
		<h1>Registrering av deltagare</h1>
		<form action="logic/person_form_save.php" method="post">
    		<input type="hidden" id="operation" name="operation" value="<?php default_value('operation'); ?>"> 
    		<input type="hidden" id="Id" name="Id" value="<?php echo $person->Id; ?>">
    		<input type="hidden" id="UserId" name="UserId" value="<?php echo $person->UserId; ?>">


			<p>

			Vi behöver veta en del saker om dig som person som är skilt från de karaktärer du spelar.</p>
			<h2>Personuppgifter</h2>
			<p>
				<div class="question">
					<label for="Name">För och efternamn</label>&nbsp;<font style="color:red">*</font>
					<br> <input class="input_field" type="text" id="Name" name="Name" value="<?php echo $person->Name; ?>" size="100" maxlength="25" required>
				</div>
				<div class="question">
					<label for="Email">E-post</label>&nbsp;<font style="color:red">*</font><br>
					<div class="explanation">E-post är det sättet arrangörerna skickar ut information till deltagare, dvs allmänna utskick, intrig och boendeinformation. Det är också det sättet vi kommer att kontakta dig om vi har några frågor kring din anmälan. Se till att det är en epost som du läser regelbundet.</div>
					<input  class="input_field" type="Email" id="email" name="Email" value="<?php echo $person->Email; ?>"  size="100" maxlength="100" required>
				</div>
				<div class="question">
					<label for="SocialSecurityNumber">Personnummer</label>&nbsp;<font style="color:red">*</font><br> 
					<div class="explanation">Nummret ska vara ÅÅÅÅMMDD-NNNN.<br />
					Om du saknar personnummer/samordningsnummer får du skriva xxxx på de fyra sista.<br />
					Personnumret kommer att kontrolleras mot medlemsregistret eftersom medlemsskap krävs för att få delta på lajvet. </div>
					<input type="text" id="SocialSecurityNumber" value="<?php echo $person->SocialSecurityNumber; ?>"
					name="SocialSecurityNumber" pattern="\d{8}-\d{4}|\d{8}-x{4}|\d{12}|\d{8}x{4}"  placeholder="ÅÅÅÅMMDD-NNNN" size="20" maxlength="13" required>
				</div>
				<div class="question">
					<label for="PhoneNumber">Mobilnummer</label>
					<br> <input class="input_field" type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo $person->PhoneNumber; ?>"  size="100" maxlength="100">
				</div>
				<div class="question">
					<label for="EmergencyContact">Närmaste anhörig</label>&nbsp;<font style="color:red">*</font>
					<br> 
					<div class="explanation">Namn, funktion och mobilnummer till närmast anhöriga. Används enbart i nödfall, exempelvis vid olycka. T ex Greta, Mamma, 08-12345678. <br />
					Det bör vara någon som inte är med på lajvet.</div>
    				<textarea class="input_field" id="EmergencyContact" name="EmergencyContact" rows="4" cols="100" maxlength="60000" required><?php echo $person->EmergencyContact; ?></textarea>
				</div>
			</p>
			
			<h2>Husförvaltare</h2>
			<div class="question">
				<label for="House">Är du husförvaltare?</label><br>
				<div class="explanation">I så fall välj ditt hus</div>
				<?php selectionDropdownByArray('House', House::all(), false, false, $person->HouseId); ?>
			</div>

			
			<h2>Lajvrelaterat</h2>
			
			<div class="question">
				<label for="LarperTypesId">Vilken typ av lajvare är du?</label>&nbsp;<font style="color:red">*</font><br>
       			<div class="explanation">Tänk igenom ditt val noga. Det är det här som i första hand kommer 
       			att avgöra hur mycket energi arrangörerna kommer lägga ner på dina intriger.     
       			Är du ny på lajv? Vi rekommenderar då att du att du väljer ett alternativ som ger mycket intriger. 
       			Erfarenhetsmässigt brukar man som ny lajvare ha mer nytta av mycket intriger än en 
       			erfaren lajvare som oftast har enklare hitta på egna infall under lajvet.   
       			<br><?php LarperType::helpBox(true); ?></div>
                <?php LarperType::selectionDropdown(false, true, $person->LarperTypeId); ?>
            </div>
				<div class="question">
				<div class="explanation">Exempel:<br>
				                         Jag är passiv lajvare, men kan tänka mig aktiva intriger som rör X, Y och Z.<br>
				                         Jag är karaktärslajvare och klarar mig utan intriger, men om ni har tankar om saker min karaktär kann vara involverad i som ger spel åt andra kan jag vara intresserad.<br>
				                         Jag är aktiv lajvare, men vill helst undvika våldsamma intriger.<br>
				                         Jag är action-lajvare och vill spela den sökta rollen NN.<br>
				                         Jag är action-lajvare och har inget emot en våldsam död.</div>
					<label for="TypeOfLarperComment">Kommentar till typ av lajvare</label>
					<br> <input class="input_field" type="text" id="TypeOfLarperComment" value="<?php echo $person->TypeOfLarperComment; ?>" name="TypeOfLarperComment"  size="100" maxlength="200">
				</div>
			<div class="question">
				<label for="ExperiencesId">Hur erfaren lajvare är du?</label>&nbsp;<font style="color:red">*</font><br>
       			<div class="explanation"><?php Experience::helpBox(true); ?></div>
                <?php Experience::selectionDropdown(false, true, $person->ExperienceId); ?>
            </div>
			<div class="question">
				<label for="NotAcceptableIntrigues">Vilken typ av intriger vill du absolut inte spela på?</label>
				<br> 
				<div class="explanation">Eftersom vi inte vill att någon ska må dåligt är det bra att veta vilka begränsningar du som person har vad det gäller intriger.</div>
				<input class="input_field" type="text" id="NotAcceptableIntrigues" name="NotAcceptableIntrigues" value="<?php echo $person->NotAcceptableIntrigues; ?>" size="100" maxlength="200" >
			</div>

			<h2>Hälsa</h2>
			<div class="question">
				<label for="TypesOfFoodId">Viken typ av mat vill du äta?</label>&nbsp;<font style="color:red">*</font>
				<br> 
				<div class="explanation"><?php TypeOfFood::helpBox(true); ?></div>
				<?php TypeOfFood::selectionDropdown(false, true, $person->TypeOfFoodId); ?>
			</div>

			<div class="question">
				<label for="NormalAllergyType">Har du någon eller några av de vanligaste mat-allergierna?</label>
				<br> 
				<div class="explanation"><?php NormalAllergyType::helpBox(true); ?></div>
				<?php NormalAllergyType::selectionDropdown(true, false, $person->getSelectedNormalAllergyTypeIds()); ?>
			</div>
			
			<div class="question">
				<label for="FoodAllergiesOther">Har du matallergier eller annan specialkost? </label><br>
				<div class="explanation">Om du har allergier eller specialkost som inte täcks av de två ovanstående frågorna vill vi att du skriver om det här.</div>
				<textarea class="input_field" id="FoodAllergiesOther" name="FoodAllergiesOther" rows="4" cols="100" maxlength="60000"><?php echo $person->FoodAllergiesOther; ?></textarea>
			</div>
			
			<div class="question">
				<label for="OtherInformation">Övrig information</label><br>
				<div class="explanation">Är det något annat kring din off-person arrangörerna bör veta? Tex andra allergier eller sjukdomar, eller bra kunskaper tex sjukvårdare.</div>
				<textarea class="input_field" id="OtherInformation" name="OtherInformation" rows="4" cols="100" maxlength="60000"><?php echo $person->OtherInformation; ?></textarea>
			
			 
			</div>
			

			<div class="question">
			Härmed samtycker jag till att föreningen Berghems
			Vänner får spara och lagra mina uppgifter - såsom namn/
			e-postadress/telefonnummer/hälsouppgifter/annat. Detta för att kunna
			arrangera lajvet.&nbsp;<font style="color:red">*</font><br>
			<input type="checkbox" id="PUL" name="PUL" value="Ja" required>
  			<label for="PUL">Jag samtycker</label> 
			</div>

			  <input type="submit" value="<?php default_value('action'); ?>">
		</form>
	</div>

</body>
</html>