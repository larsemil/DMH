<?php

require 'header.php';

// TODO Lägg till diverse kontroller som behövs för att kolla om man bland annat har en person registrerad.

?>

        <nav id="navigation">
          <a href="#" class="logo"><?php echo $current_larp->Name;?></a>
          <ul class="links">
            <li><a href="index.php"><i class="fa-solid fa-house"></i></i>Hem</a></li>
	       	<li><a href="../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logga ut</a></li>
          </ul>
        </nav>


	<div class="content">
		<h1>Registrering av person</h1>
		<form action="includes/person_registration_save.php" method="post">
    		<input type="hidden" id="operation" name="operation" value="<?php default_value('operation'); ?>"> 
    		<input type="hidden" id="Id" name="Id" value="<?php default_value('id'); ?>">
    		<input type="hidden" id="UsersId" name="UsersId" value="<?php default_value('usersid'); ?>">


			<p>

			Vi behöver veta en del saker om dig som person som är skilt från de karaktärer du spelar.</p>
			<h2>Personuppgifter</h2>
			<p>
				<div class="question">
					<label for="Name">För och efternamn</label>
					<br> <input type="text" id="Name" name="Name"  size="100" maxlength="250" required>
				</div>
				<div class="question">
					<label for="Email">E-post</label><br>
					<input type="Email" id="email" name="Email"  size="100" maxlength="250" required>
				</div>
				<div class="question">
					<label for="SocialSecurityNumber">Personnummer</label><br> 
					<div class="explanation">Nummret ska vara ÅÅÅÅMMDD-NNNN om du saknar personnummer/samordningsnummer får du skriva xxxx på de fyra sista.</div>
					<input type="text" id="SocialSecurityNumber"
					name="SocialSecurityNumber" pattern="\d{8}-\d{4}|\d{8}-x{4}"  size="15" maxlength="13" required>
				</div>
				<div class="question">
					<label for="PhoneNumber">Mobilnummer</label>
					<br> <input type="text" id="PhoneNumber" name="PhoneNumber"  size="100" maxlength="250">
				</div>
				<div class="question">
					<label for="EmergencyContact">Närmaste anhörig</label>
					<br> 
					<div class="explanation">Namn, funktion och mobilnummer till närmast anhöriga. Används enbart i nödfall, exempelvis vid olycka. T ex Greta, Mamma, 08-12345678.    
Det bör vara någon som inte är med på lajvet.</div>
    				<textarea id="EmergencyContact" name="EmergencyContact" rows="4" cols="100">
    				</textarea>
				</div>
			</p>
			
			
			<h2>Lajvrelaterat</h2>
			
			<div class="question">
				<label for="LarperTypesId">Vilken typ av lajvare är du?</label><br>
       			<div class="explanation">Tänk igenom ditt val noga. Det är det här som i första hand kommer 
       			att avgöra hur mycket energi arrangörerna kommer lägga ner på dina intriger.     
       			Är du ny på lajv? Vi rekommenderar då att du inte väljer alternativ Myslajvare. 
       			Erfarenhetsmässigt brukar man som ny lajvare ha mer nytta av mycket intriger än en 
       			erfaren lajvare som oftast har enklare hitta på egna infall under lajvet.   
       			Myslajvare får heller ingen handel och blir troligen varken fattigare eller rikare under lajvet.<br><?php LarperType::helpBox(true); ?></div>
                <?php LarperType::selectionDropdown(false,true); ?>
            </div>
				<div class="question">
					<label for="TypeOfLarperComment">Kommentar till typ av lajvare</label>
					<br> <input type="text" id="TypeOfLarperComment" name="TypeOfLarperComment"  size="100" maxlength="250">
				</div>
			<div class="question">
				<label for="ExperiencesId">Hur erfaren lajvare är du?</label><br>
       			<div class="explanation"><?php Experience::helpBox(true); ?></div>
                <?php Experience::selectionDropdown(false,true); ?>
            </div>
			<div class="question">
				<label for="NotAcceptableIntrigues">Vilken typ av intriger vill du absolut inte spela på?</label>
				<br> 
				<div class="explanation">Eftersom vi inte vill att någon ska må dåligt är det bra att veta vilka begränsningar du som person har vad det gäller intriger.</div>
				<input type="text" id="NotAcceptableIntrigues" name="NotAcceptableIntrigues" size="100" maxlength="250" >
			</div>

			<h2>Hälsa</h2>
			<div class="question">
				<label for="TypesOfFoodId">Viken typ av mat vill du äta?</label>
				<br> 
				<div class="explanation"><?php TypeOfFood::helpBox(true); ?></div>
				<?php TypeOfFood::selectionDropdown(false,true); ?>
			</div>

			<div class="question">
				<label for="NormalAllergyType">Har du av de vanligaste mat-allergierna?</label>
				<br> 
				<div class="explanation"><?php NormalAllergyType::helpBox(true); ?></div>
				<?php NormalAllergyType::selectionDropdown(false,true); ?>
			</div>
			
			<div class="question">
				<label for="FoodAllergiesOther">Har du matallergier eller annan specialkost? </label><br>
				<div class="explanation">Om du har allergier eller specialkost som inte täcks av de två ovanstående frågorna vill vi att du skriver om det här.</div>
				<textarea id="FoodAllergiesOther" name="FoodAllergiesOther" rows="4" cols="100">
				</textarea>
			</div>
			
			<div class="question">
				<label for="OtherInformation">Övrig information</label><br>
				<div class="explanation">Är det något annat kring din off-person arrangörerna bör veta? Tex andra allergier eller sjukdomar, eller bra kunskaper tex sjukvårdare.</div>
				<textarea id="OtherInformation" name="OtherInformation" rows="4" cols="100">
				</textarea>
			
			 
			</div>
			

			<div class="question">
			Härmed samtycker jag till att föreningen Berghems
			Vänner får spara och lagra mina uppgifter - såsom namn/
			e-postadress/telefonnummer/hälsouppgifter/annat. Detta för att kunna
			arrangera lajvet.<br>
			<input type="checkbox" id="PUL" name="PUL" value="Ja" required>
  			<label for="PUL">Jag samtycker</label> 
			</div>

			  <input type="submit" value="Registrera">
		</form>
	</div>

</body>
</html>