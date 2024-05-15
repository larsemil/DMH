<?php
require 'header.php';

if (!$current_larp->isEnded()) {
    header('Location: index.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['PersonId'])) {
        $PersonId = $_POST['PersonId'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET['PersonId'])) {
        $PersonId = $_GET['PersonId'];
    }
}

if (isset($PersonId)) {
    $person = Person::loadById($PersonId);
}
else {
    header('Location: index.php');
    exit;
}

if ($person->UserId != $current_user->Id) {
    header('Location: index.php');
    exit;
}


function slider($headline, $id, $min, $max, $value, ?String $explanation="") {
    echo "<div class='question'>\n";
    echo "<label for='$id'>$headline</label>\n";
    
    if (!empty($explanation)) echo "<div class='explanation'>$explanation</div>\n";
    
    
    echo "<div class='slidecontainer'>\n";
    $value_text = $value;
    if ($value == 0) $value_text = "Vet inte";
    echo "<input type='range' min='$min' max='$max' value='$value' class='slider' id='$id' name='$id' oninput='slider_value(\"$id\")'> &nbsp; &nbsp;Värde: <span id='$id"."_val'>$value_text</span>\n";
    echo "</div>\n";
    echo "</div>\n";
    
}

$campaign = $current_larp->getCampaign();

include 'navigation.php';

?>

<script>

// Update the current slider value (each time you drag the slider handle)
function slider_value(sliderId) {
	slider = document.getElementById(sliderId);
	output = document.getElementById(sliderId+"_val");

	let value = slider.value;
	let value_text = value;
    if (value == 0) value_text = "Vet inte";

	
  	output.innerHTML = value_text;
}



</script>


<style>
body {
  counter-reset: question;
}

label::before {
  counter-increment: question;
  content: counter(question) ". ";
}
</style>

	<div class="content">
		<h1>Utvärdering av <?php echo $current_larp->Name; ?>  för <?php echo $person->Name; ?></h1>
			<p>Vi sparar inte vilka svar du har angett, bara att du har lämnat en utvärdering. Utvärderingen sparas anonymt.</p>
			<form action="logic/evaluation_save.php" method="post">
			<input type="hidden" id="Id" name="Id" value="<?php echo $person->getRegistration($current_larp)->Id ?>">
			<input type="hidden" id="Age" name="Age" value="<?php echo $person->getAgeAtLarp($current_larp)?>">

			<div class="question">
    			<label for="Number_of_larps">Antal lajv du har varit på innan detta</label>
				<select name="Number_of_larps" id="Number_of_larps">
                  <option value="0" checked="checked">0</option>
                  <option value="1-5">1-5</option>
                  <option value="6-10">6-10</option>
                  <option value="10+">10+</option>
                </select> st
            </div>
            
            <h2>Betygsätt lajvet: skala 1-10</h2>
            
    			<div class="explanation">
				1: lägsta, sämst<br>
				10: högsta, bäst
				</div>
				
			<?php slider("Arrangörerna (professionalism, bemötande, nåbarahet m.m)","larp_q1",1,10,5)?>
			<?php slider("Hemsidan (information, navigering, lättläst m.m)","larp_q2",1,10,5)?>
			<?php slider("Prissättning (1 = för högt pris)","larp_q3",1,10,5)?>
			<?php slider("Intrigerna","larp_q4",1,10,5)?>
			<?php slider("Logistik (transporter, parkering m.m.)","larp_q5",1,10,5)?>
			<?php slider("Bekvämligheter (mat, dass, vatten, ved m.m)","larp_q6",1,10,5)?>
			<?php slider("Området","larp_q7",1,10,5)?>
			<?php slider("Betygsätt din upplevelse/-er under lajvet","larp_q8",1,10,5)?>
			<?php slider("Lajvets helhetsbetyg","larp_q9",1,10,5)?>

			<div class="question">
    			<label for="larp_comment">Övrigt/kommentarer</label><br>
    			<textarea id='larp_comment' name='larp_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>

		<h2>Hur väl stämmer följande påståenden överens med din upplevelse av <?php echo $current_larp->Name ?></h2>
			<div class="explanation">
			Om du inte vet eller inte kan svara på frågan lämna värdet på "Vet inte".<br>
			1: stämmer inte alls<br>
			10: stämmer mycket väl överens
			</div>
			<?php slider("Det var ett välorganiserat lajv","exp_q1",0,10,0)?>
			<?php slider("Det var ett nybörjarvänligt lajv","exp_q2",0,10,0)?>
			<?php //slider("Det var ett nybörjarvänligt lajv","exp_q3",0,10,0)?>
			<?php slider("Det var ett lajv för erfarna","exp_q4",0,10,0)?>
			<?php slider("Det var ett barn- och familjevänligt lajv","exp_q5",0,10,0)?>
			<?php slider("Jag hade roligt på lajvet","exp_q6",0,10,0)?>
			<?php slider("Jag tänker åka på fler ".$current_larp->getCampaign()->Name."-lajv om det blir några fler","exp_q7",0,10,0)?>

			<div class="question">
    			<label for="exp_comment">Övrigt/kommentarer</label><br>
    			<textarea id='exp_comment' name='exp_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>

		<h2>Information</h2>
			<?php slider("Det var en lättnavigerad hemsida","info_q1",1,10,5)?>
			<?php slider("Det fanns tillräckligt med information på hemsidan","info_q2",1,10,5)?>
			<?php slider("Uppskatta hur mycket av informationen på hemsidan som du har läst","info_q3",1,10,5, "Siffran 1 = 10% (nästan inget) och siffran 10 = 100% (allt)")?>
			<?php slider("Uppskatta hur mycket av informationen av utskicket som du har läst","info_q4",1,10,5,"Siffran 1 = 10% (nästan inget) och siffran 10 = 100% (allt)")?>

			<div class="question">
    			<label for="info_dev">Vad bör vi utveckla på hemsidan till nästa gång?</label><br>
    			<textarea id='info_dev' name='info_dev' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
			<div class="question">
    			<label for="info_comment">Övrigt/kommentarer</label><br>
    			<textarea id='info_comment' name='info_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>

		<h2>Maten</h2>
			<?php slider("Den förbeställda maten var god","food_q1",0,10,0)?>
			<?php slider("Den förbeställda maten var prisvärd","food_q2",0,10,0)?>
			<div class="question">
    			<label for="food_comment">Övrigt/kommentarer</label><br>
    			<textarea id='food_comment' name='food_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
		<h2>Regler</h2>
			<?php slider("Stridssystemet var enkelt att förstå och spela på","rules_q1",1,10,5)?>
			<?php slider("Reglerna kring alkohol var bra","rules_q2",1,10,5); ?>
			<?php slider("Reglerna kring rökning var bra","rules_q3",1,10,5)?>
			<div class="question">
    			<label for="rules_comment">Övrigt/kommentarer</label><br>
    			<textarea id='rules_comment' name='rules_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
		<h2>In-lajv valutan</h2>
			<?php slider("Valutasystemet var bra","currency_q1",1,10,5)?>
			<?php slider("Det var lätt att förstå vad man skulle ta betalt för en tjänst","currency_q2",1,10,5)?>
			<div class="question">
    			<label for="currency_comment">Övrigt/kommentarer</label><br>
    			<textarea id='currency_comment' name='currency_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
		<h2>Bemötande</h2>
			<?php slider("Arrangörerna var trevliga och hjälpsamma","org_q1",1,10,5)?>
			<?php slider("Arrangörerna var professionella","org_q2",1,10,5)?>
			<?php slider("Arrangörerna var lätta att få kontakt med innan lajvet","org_q3",1,10,5)?>
			<?php slider("Arrangörerna var lätta att få kontakt med under lajvet","org_q4",1,10,5)?>
			<div class="question">
    			<label for="org_comment">Övrigt/kommentarer</label><br>
    			<textarea id='org_comment' name='org_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
		
		<?php if ($campaign->is_kir()) { 
		} else {?>

		<h2>Speltekniska system</h2>
			<?php if ($campaign->is_dmh()) { ?>
    			<?php slider("Det var ett bra system att man kunde gå till telegrafen för att få hjälp med intrigerna","game_q1",1,10,5)?>
    			<?php slider("Handelssystemet med resurskort och verksamheter var ett bra system","game_q2",1,10,5)?>
    			<?php slider("Tjuvsystemet med föremål märkta med grönt band som man fick stjäla var ett roligt inslag på lajvet","game_q3",1,10,5)?>
			<?php } elseif ($campaign->is_doh()) { ?>
				<?php slider("Magisystemet fungerade bra","game_q1",0,10,5)?>
				<?php slider("Alkemisystemet fungerade bra","game_q2",0,10,5)?>
				<?php slider("Synerna fungerade bra","game_q3",0,10,5)?>
				<?php slider("Handelssystemet fungerade bra","game_q4",0,10,5)?>
				<?php slider("Barnaktiviteterna var bra","game_q5",0,10,5)?>
				<?php slider("Jag som förälder kände mig trygg med barnaktiviteterna","game_q6",0,10,5)?>
				<?php slider("Barntältet var bra","game_q7",0,10,5)?>
			
			<?php } elseif ($campaign->is_me()) { ?>
			
			<?php } ?>

			<div class="question">
    			<label for="game_comment">Övrigt/kommentarer</label><br>
    			<textarea id='game_comment' name='game_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
		<?php } ?>

		<h2>Avslutande</h2>
			<div class="question">
    			<label for="finish_positive">Vad tycker du varit positivt med lajvet?</label><br>
    			<textarea id='finish_positive' name='finish_positive' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
			<div class="question">
    			<label for="finish_negative">Vad tycker du varit negativt med lajvet?</label><br>
    			<textarea id='finish_negative' name='finish_negative' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
			<div class="question">
    			<label for="finish_develop">Vad tycker du att vi ska utveckla till nästa gång?</label><br>
    			<textarea id='finish_develop' name='finish_develop' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
			<div class="question">
    			<label for="finish_comment">Övrigt/kommentarer</label><br>
    			<textarea id='finish_comment' name='finish_comment' rows="4" cols="100" maxlength="2000"></textarea>
            </div>
            
            <input type="submit" value="Skicka in">
            </form>

<p>Frågorna kommer från <a href="https://morgondagensgryning.se/" target="_blank">Morgondagens Gryning</a>. Åk gärna på deras lajv också.</p>
