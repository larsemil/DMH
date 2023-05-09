<?php
include_once 'header.php';

include 'navigation_subpage.php';
?>


    <div class="content">   
        <h1>Reservlistan</h1>
        Genom att klicka på "Gör till en anmälan" omvandlas deltagare på reservlistan till en vanlig anmälan som får hanteras i vanlig ordning med eventuella godkännanden.
     		<?php 
    		$persons = Person::getAllReserves($current_larp);
    		if (empty($persons)) {
    		    echo "<br><br>Reservlistan är tom";
    		} else {
    		    $tableId = "participants";
    		    echo "<table id='$tableId' class='data'>";
    		    echo "<tr><th onclick='sortTable(0, \"$tableId\");'>Namn</th>".
    		      "<th onclick='sortTable(1, \"$tableId\")'>Epost</th>".
    		      "<th onclick='sortTable(2, \"$tableId\")'>Ålder<br>på lajvet</th>".
    		      "<th onclick='sortTable(2, \"$tableId\")'>Roller</th>".
    		      "<th onclick='sortTable(3, \"$tableId\")'>Funktionärsönskemål</th>";
    		    echo "<th></th></tr>\n";
    		    foreach ($persons as $person)  {
    		        $reserve_registration = $person->getReserveRegistration($current_larp);
    		        echo "<tr>\n";
    		        echo "<td>" . $person->Name . "</td>\n";
    		        echo "<td>" . $person->Email . " ".contactEmailIcon($person->Name,$person->Email)."</td>\n";
    		        echo "<td>" . $person->getAgeAtLarp($current_larp) . " år ";

    		        if ($person->getAgeAtLarp($current_larp) < $current_larp->getCampaign()->MinimumAgeWithoutGuardian) {

    		            if (empty($reserve_registration->GuardianId)) {
    		                echo showStatusIcon(false);
    		            }
    		                

		            }
    		        echo "</td>\n";

    		        
    		        echo "<td>";
    		        $reserve_roles = Reserve_LARP_Role::getReserveRolesForPerson($current_larp->Id, $person->Id);
    		        foreach ($reserve_roles as $reserve_role) {
    		            $role = Role::loadById($reserve_role->RoleId);
    		            $group = $role->getGroup();
    		            echo "$role->Name";
    		            if ($reserve_role->IsMainRole == 0) {
    		                echo " (Sidokaraktär)";
    		            }
    		            if (isset($group)) {
    		                echo " - $group->Name";
    		            }
    		            echo "<br>\n";
    		        }
    		        echo "</td>\n";
    		        
    		        echo "<td>" .  commaStringFromArrayObject($reserve_registration->getOfficialTypes()) . "</td>\n";
    		        
    		        echo "<td>";
    		        echo "<form method='post' action='logic/give_make_into_registration.php'>";
    		        echo "<input type='hidden' id='Reserve_RegistrationId' name='Reserve_RegistrationId' value='$reserve_registration->Id'>";
    		        
    		        echo "<input type='submit' value='Gör till en anmälan'>";
    		        echo "</form>";
    		        echo "</td>";
    		            
    		        echo "</tr>\n";
    		    }
    		    echo "</table>";
    		}
    		?>

        
        
        
	</div>
</body>

<?php include_once '../javascript/table_sort.js';?>
</html>
