<?php
include_once 'header.php';
include 'navigation.php';
?>

<div class="content">
    <h1>Köket</h1>
    <div class='linklist'>
    <a href="reports/matlista.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Alla deltagares matval</a><br>  
    <a href="reports/allergy_list.php" target="_blank"><i class="fa-solid fa-file-pdf"></i>Alla allergier</a><br>
    </div> 
    
    Totalt är det <?php echo count(Registration::allBySelectedLARP($current_larp)); ?> anmälda deltagare.<br>
    <h2>Vald mat</h2>
    <?php 
    $foodChoises = Registration::getFoodVariants($current_larp);
    $hasFoodChoices = false;
    echo "<table class='smalldata'>";
    foreach($foodChoises as $foodChoise) {
        if (!empty($foodChoise[0])) $hasFoodChoices = true;
        echo "<tr><td>".$foodChoise[0] . "</td><td>" . $foodChoise[1] . "</td><td>" . $foodChoise[2] . " st</td></tr>"; 
    }
    echo "</table>";

    
    
    ?>

	<h2>Allergier</h2>
    
    <?php 
    if (NormalAllergyType::isInUse()){
        $allAllergies = NormalAllergyType::all();
        
        foreach($allAllergies as $allergy) {
            $persons = Person::getAllWithSingleAllergy($allergy, $current_larp);
            if (isset($persons) && count($persons) > 0) {
                echo "<h3>Enbart $allergy->Name</h3><table class='data'>";
                echo "<tr><th>Namn</th><th>Epost</th><th>Telefon</th><th>Övrigt</th><th>Vald mat</th>";
                if ($hasFoodChoices) echo "<th>Matalternativ</th>";
                echo "</tr>";
                foreach($persons as $person) {
                    $registration=$person->getRegistration($current_larp);
                    echo "<tr><td>$person->Name</td><td>$person->Email ".contactEmailIcon($person->Name,$person->Email)."</td>";
                    echo "<td>$person->PhoneNumber</td><td>$person->FoodAllergiesOther</td><td>".$registration->getTypeOfFood()->Name."</td>";
                    if ($hasFoodChoices) echo "<td>$registration->FoodChoice</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
         
        
        //Multipla allergier
        $persons = Person::getAllWithMultipleAllergies($current_larp);
        if (!empty($persons) && count($persons) > 0) {
            echo "<h3>Multipla vanliga allergier</h3>";
            echo "<table class='data'>";
            echo "<tr><th>Namn</th><th>Epost</th><th>Telefon</th><th>Allergier</th><th>Övrigt</th><th>Vald mat</th>";
            if ($hasFoodChoices) echo "<th>Matalternativ</th>";
            echo "</tr>";
            foreach($persons as $person) {
                $registration=$person->getRegistration($current_larp);
                echo "<tr><td>$person->Name</td><td>$person->Email ".contactEmailIcon($person->Name,$person->Email)."</td>";
                echo "<td>$person->PhoneNumber</td><td>" . commaStringFromArrayObject($person->getNormalAllergyTypes()) . "</td>";
                echo "<td>$person->FoodAllergiesOther</td><td>" . $registration->getTypeOfFood()->Name . "</td>";
                if ($hasFoodChoices) echo "<td>$registration->FoodChoice</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    //Hitta alla som inte har någon vald allergi, men som har en kommentar
    //TODO borde kanske sorteras per matalternativ
    
    $persons = Person::getAllWithoutAllergiesButWithComment($current_larp);
    if (!empty($persons) && count($persons) > 0) {
        echo "<h3>Special</h3><table class='data'>";
        echo "<tr><th>Namn</th><th>Epost</th><th>Telefon</th><th>Övrigt</th><th>Vald mat</th>";
        if ($hasFoodChoices) echo "<th>Matalternativ</th>";
        echo "</tr>";
        foreach($persons as $person) {
            $registration=$person->getRegistration($current_larp);
            echo "<tr><td>$person->Name</td><td>$person->Email ".contactEmailIcon($person->Name,$person->Email)."</td>";
            echo "<td>$person->PhoneNumber</td><td>$person->FoodAllergiesOther</td><td>" . $registration->getTypeOfFood()->Name . "</td>";
            if ($hasFoodChoices) echo "<td>$registration->FoodChoice</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    ?>
</div>
