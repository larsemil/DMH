<?php
include_once 'header.php';

include 'navigation_subpage.php';
?>


    <div class="content">   
        <h1>Roller i kampanjen som inte är anmälda (än) i år</h1>
        
        
        <p>Om man lägger till en sidokaraktär härifrån kommer inga intrigtyper att väljas. Det får du redigera på rollen efteråt.<br>
        <br>Om man anmäler någon härifrån kommer de att välja det första alternativet på boende. Du får redigera det på personen. Och rollen blir som ovan.</p>

     		<?php 
    		$roles = Role::getAllUnregisteredRoles($current_larp);
    		if (empty($roles)) {
    		    echo "Inga anmälda roller";
    		} else {
    		    echo "<table class='data'>";
    		    echo "<tr><th>Namn</th><th>Yrke</th><th>Grupp</th><th>Spelare</th><th>Senast spelad</th></tr>\n";
    		    foreach ($roles as $role)  {
    		        $person = $role->getPerson();
    		        echo "<tr>\n";
    		        echo "<td>" . $role->Name;
    		        if ($role->IsDead ==1) echo " <i class='fa-solid fa-skull-crossbones' title='Död'></i>";
    		        echo "</td>\n";
    		        echo "<td>$role->Profession</td>\n";
    		        $group = $role->getGroup();
    		        if (is_null($group)) {
    		            echo "<td>&nbsp;</td>\n";
    		        } else {
    		            echo "<td>$group->Name</td>\n";
    		        }
    		        echo "<td>$person->Name</td>";
    		        if ($person->isRegistered($current_larp)) {
    		            echo "<td><a href='logic/add_role.php?id=$role->Id'>Lägg till som sidokaraktär</a><td>";
    		        }
                    else {
                        echo "<td><a href='logic/register_person.php?id=$role->Id'>Anmäl med denna som huvudkaraktär</a><td>";
                    }

    		        //TODO leta rätt på när rollen senast var anmäld
    		        echo "<td></td>";
    		        echo "</tr>\n";
    		    }
    		    echo "</table>";
    		}
    		?>
	</div>
</body>

</html>
