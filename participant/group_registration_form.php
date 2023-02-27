<?php

require 'header.php';

$current_groups = $current_user->getUnregisteredGroupsForUser($current_larp);

if (empty($current_groups)) {
    header('Location: index.php?error=no_group');
    exit;
}

$new_group = null;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['new_group'])) {
        $new_group = Group::loadById($_GET['new_group']);
    }
}

?>

        <nav id="navigation">
          <a href="#" class="logo"><?php echo $current_larp->Name;?></a>
          <ul class="links">
            <li><a href="index.php"><i class="fa-solid fa-house"></i></i>Hem</a></li>
	       	<li><a href="../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logga ut</a></li>
          </ul>
        </nav>


	<div class="content">
		<?php 
		if (isset($new_group) && !is_null($new_group)) {
            echo "<h1>Anmälan av gruppe '$new_group->Name' till $current_larp->Name</h1>";
        } else {
            echo "<h1>Anmälan av grupp till $current_larp->Name</h1>";
		} ?>
		<form action="logic/group_registration_form_save.php" method="post">
    		<input type="hidden" id="operation" name="operation" value="insert"> 
    		<input type="hidden" id="LARPId" name="LARPId" value="<?php echo $current_larp->Id ?>">


			<p>När en grupp är anmäld till lajvet går det för karaktärer att anmäla sig som medlemmar i gruppen. <br>
			   Du som gruppansvarig, har möjlighet att ta bort någon ur gruppen om någon anmäler sig till den men inte hör till den.<br><br>
			   Efter anmälan går det inte längre att redigera gruppen.
			   </p>
				
				
			<div class="question">
				<label for="GroupId">Grupp</label><br>
				<?php 
				if (isset($new_group) && !is_null($new_group)) {
				    selectionDropdownByArray('Group', $current_groups, false, true, $new_group->Id);
				} else {
				    selectionDropdownByArray('Group', $current_groups, false, true);
				} ?>
				
			</div>
            <div class="question">
    			<label for="WantIntrigue">Vill gruppen ha intriger?</label>
    			<div class="explanation">Oavsett vad ni svara på den här frågan kan det hända att ni får/inte får intriger. Men vi ska ha era önskemål i åtanke.</div>
    			<input type="radio" id="WantIntrigue_yes" name="WantIntrigue" value="1"> 
    			<label for="WantIntrigue_yes">Ja</label><br> 
    			<input type="radio" id="WantIntrigue_no" name="WantIntrigue" value="0"> 
    			<label for="WantIntrigue_no">Nej</label>
    		</div>
			<div class="question">
    			<label for="IntrigueType">Intrigtyper</label>
    			<div class="explanation">Vilken typ av intriger vill gruppen helst ha?  <br>
    			    <?php IntrigueType::helpBox(true); ?></div>
                <?php
    
                IntrigueType::selectionDropdown(true, false);
                
                ?>
            </div>

			<div class="question">
    			<label for="RemainingIntrigues">Kvarvarande intriger</label>
    			<div class="explanation">Har gruppen någon pågående/oavslutad intrig sedan tidigare? </div>
				<textarea id="RemainingIntrigues" name="RemainingIntrigues" rows="4" cols="100"></textarea>
            </div>

			
			<div class="question">
				<label for="ApproximateNumberOfMembers">Antal medlemmar</label><br> 
					<div class="explanation">Ungefär hur många
					gruppmedlemmar kommer ni att bli?</div>
					<input type="text"
					id="ApproximateNumberOfMembers"
					name="ApproximateNumberOfMembers" required>
			</div>
			<div class="question">
    			<label for="HousingRequest">Boende</label>
    			<div class="explanation">Hur vill gruppen helst bo? Vi kan inte garantera plats i hus. <br><?php HousingRequest::helpBox(true); ?></div>
                <?php
    
                HousingRequest::selectionDropdown(false,true);
                
                ?>
            </div>
            <div class="question">
    			<label for="NeedFireplace">Behöver ni eldplats?</label><br> 
    			<input type="radio" id="NeedFireplace_yes" name="NeedFireplace" value="1"> 
    			<label for="NeedFireplace_yes">Ja</label><br> 
    			<input type="radio" id="NeedFireplace_no" name="NeedFireplace" value="0"> 
    			<label for="NeedFireplace_no">Nej</label>
    		</div>
			

			  <input type="submit" value="Anmäl">

		</form>
	</div>

</body>
</html>