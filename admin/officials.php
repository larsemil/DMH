<?php
include_once 'header_subpage.php';
?>

<div class="content">
    <h1>Funktionärer</h1>
    <?php 
    $persons = Person::getAllOfficials($current_larp);
    echo "<table class='data'><tr><th>Namn</th><th>Epost</th><th>Telefon</th><th>Typ av funktionär</th><th></th></tr>";
    foreach($persons as $person) {
        $registration = $person->getRegistration($current_larp);
        echo "<tr><td>$person->Name</td><td>$person->Email</td><td>$person->PhoneNumber</td><td>".commaStringFromArrayObject($registration->getOfficialTypes()).
        "<a href='edit_official.php?id=$registration->Id'><i class='fa-solid fa-pen'></i></a></td><td>";
    ?>
        <form action="logic/official_save.php" method="post"><input type="hidden" id="Id" name="Id" value="<?php echo $registration->Id;?>"><input type="submit" value="Ta bort"></form>
    <?php     
        echo "</td></tr>";
    }
    echo "</table>";
    
    ?>
    <h2>Deltagare som vill vara funktionärer</h2>
    <?php 
    $persons = Person::getAllWhoWantToBeOffical($current_larp);
    echo "<table class='data'><tr><th>Namn</th><th>Epost</th><th>Telefon</th><th>Önskad typ av funktionär</th><th></th></tr>";
    foreach($persons as $person) {
        $registration = $person->getRegistration($current_larp);
        echo "<tr><td>$person->Name</td><td>$person->Email</td><td>$person->PhoneNumber</td><td>".commaStringFromArrayObject($registration->getOfficialTypes())."</td><td>";
        ?>
        <form action="logic/official_save.php" method="post"><input type="hidden" id="Id" name="Id" value="<?php echo $registration->Id;?>"><input type="submit" value="Lägg till"></form>
    <?php     
        echo "</td></tr>";
    }
        echo "</table>";
    
    ?>

