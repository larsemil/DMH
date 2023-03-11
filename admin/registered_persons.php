 <?php
 include_once 'header_subpage.php';
 

?>


    <div class="content">   
        <h1>Anmälda deltagare</h1>
     		<?php 
    		$persons = Person::getAllRegistered($current_larp);
    		if (empty($persons)) {
    		    echo "Inga anmälda deltagare";
    		} else {
    		    echo "<table class='data'>";
    		    echo "<tr><th>Namn</th><th>Epost</th><th>Ålder på lajvet</th><th>Mobilnummer</th><th></th><th>Godkänd</th>";
    		    echo "<th>Medlem</th><th>Betalnings-<br>referens</th><th colspan='2'>Betalat</th></tr>\n";
    		    foreach ($persons as $person)  {
    		        echo "<tr>\n";
    		        echo "<td>" . $person->Name . "</td>\n";
    		        echo "<td>" . $person->Email . " <a href='contact_email.php?email=$person->Email&name=$person->Name'><i class='fa-solid fa-envelope-open-text'></i></a></td>\n";
    		        echo "<td>" . $person->getAgeAtLarp($current_larp) . " år</td>\n";
    		        echo "<td>" . $person->PhoneNumber . "</td>\n";
    		        
    		        echo "<td>" . "<a href='view_person.php?id=" . $person->Id . "'><i class='fa-solid fa-eye'></i></a>\n";
    		        echo "<a href='edit_person.php?id=" . $person->Id . "'><i class='fa-solid fa-pen'></i></a></td>\n";
    		        echo "<td align='center'>" . showStatusIcon($person->isApproved($current_larp)) . "</td>\n";
    		        echo "<td align='center'>" . showStatusIcon($person->isMember($current_larp)) . "</td>\n";
    		        echo "<td>".$person->getRegistration($current_larp)->PaymentReference .  "</td>\n";
    		        echo "<td align='center'>" . showStatusIcon($person->hasPayed($current_larp)) . "</td>";
    		        echo "<td><a href='person_payment.php?id=" . $person->Id . "'><i class='fa-solid fa-pen'></i></a></td>\n";
    		        echo "</tr>\n";
    		    }
    		    echo "</table>";
    		}
    		?>

        
        
        
	</div>
</body>

</html>
