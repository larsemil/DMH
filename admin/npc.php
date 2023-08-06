<?php
include_once 'header.php';

$persons=Person::getAllInterestedNPC($current_larp);


function print_assigned_npc(NPC $npc, $npc_group) {
    echo "<div class='npc'>";
    $person=$npc->getPerson();
    
    echo "<a href='npc_form.php?operation=update&id=$npc->Id'>$npc->Name</a> \n";
    echo "$npc->Time<br>$npc->Description<br>\n";
    echo "Spelas av $person->Name\n";
    echo "<form action='logic/assign_npc.php' method='post' style='display:inline-block'><input type='hidden' name='id' value='$npc->Id'>\n";
    echo "<input type='hidden' name='PersonId' value='null'>\n";
    echo "<button class='invisible' type='submit'><i class='fa-solid fa-xmark' title='Ta bort från deltagaren'></i></button>";
    echo "</form>\n";
    if (empty($npc_group) || ($npc_group->IsReleased() && !$npc->IsReleased())) {
        echo "<form action='logic/release_npc.php' method='post' style='display:inline-block'><input type='hidden' name='id' value='$npc->Id'>\n";
        echo " <button class='invisible' type ='submit'><i class='fa-solid fa-envelope' title=''Skicka NPC:n till deltagaren'></i></button>\n";
        echo "</form>\n";
    }
    echo "</div>";
    
}

function print_unassigned_npc(NPC $npc) {
    global $persons;
    echo "<tr><td style='font-weight:normal'>";
    echo "<div class='npc'>";
    echo "<a href='npc_form.php?operation=update&id=$npc->Id'>$npc->Name</a> ";
    echo "<a href='logic/delete_npc.php?id=$npc->Id'><i class='fa-solid fa-trash'></i></a> ";
    echo "$npc->Time<br>$npc->Description";
    echo "</td><td>";
    echo "<form action='logic/assign_npc.php' method='post'><input type='hidden' name='id' value=$npc->Id>";
    echo selectionDropDownByArray("PersonId", $persons);
    echo "<input type ='submit' value='Tilldela'>";
    echo "</form>";
    echo "</div>";
    echo "</td></tr>";
    
    
}

include 'navigation.php';
?>


<style>
div.groupname {
    margin: 0;
    padding-top: 10px;
    padding-bottom: 0px;
    font-size: 1.4em;
    color: #4a536e;
    font-weight: bold;
}

div.npc {
    margin-left: 10px;
    margin-bottom: 10px;
}

</style>
    <div class="content">   
        <h1>NPC</h1>
            <a href="npc_form.php"><i class="fa-solid fa-file-circle-plus"></i>Skapa NPC</a>  
            <a href="npc_group_form.php"><i class="fa-solid fa-file-circle-plus"></i>Skapa NPC grupp</a>  

            <div>
            <h2>Alla tilldelade NPC'er</h2>
            <p>För att deltagaren ska kunna se en NPC som de har fått tilldelad måste man "Skicka NPC" <i class='fa-solid fa-envelope' title=''Skicka NPC'></i> till dem. Då får deltagaren ett mail om det och NPC'n går att se på deltagarens översiktssida. Det går att skicka en hel grupp på en gång.</p>
            <?php 
            
            
            
            
            $npc_groups = NPCGroup::getAllForLARP($current_larp);
            
            foreach ($npc_groups as $npc_group) {
                $npcs=NPC::getAllAssignedByGroup($npc_group, $current_larp);
                if (!empty($npcs)) {
                    echo "<form action='logic/release_npc_group.php' method='post'><input type='hidden' name='id' value='$npc_group->Id'>\n";
                    echo "<h3><a href='npc_group_form.php?operation=update&id=$npc_group->Id'>$npc_group->Name</a>";
                    
                    if ($npc_group->IsReleased()) {
                        echo "</h3>";
                        echo "<br>Deltagarna har fått sina npc'er.\n";
                    }
                    else {
                        echo " <button class='invisible' type ='submit'><i class='fa-solid fa-envelope' title=''Skicka NPC:n till deltagarna'></i></button>\n";
                        echo "</h2>";
                    }
                    echo "</form>\n";
                }
                foreach($npcs as $npc) {
                    print_assigned_npc($npc, $npc_group);
                }
            }
            $npcs=NPC::getAllAssignedWithoutGroup($current_larp);
            if (!empty($npcs)) {
                echo "<h3>Utan grupp</h3>";
            }
            foreach($npcs as $npc) {
                print_assigned_npc($npc, null);
            }
            
            ?>
            </div>
            
            <div>
            <h2>Alla NPC'er som inte är tilldelade</h2>
            <?php 
            
            $npc_groups = NPCGroup::getAllForLARP($current_larp);
            $unused_group_links = array();
            echo "<table>";
            foreach ($npc_groups as $npc_group) {
                $npcs=NPC::getAllUnassignedByGroup($npc_group, $current_larp);
                
                if(!empty($npcs)) {
                    echo "<tr><td colspan='2'><h3><a href='npc_group_form.php?operation=update&id=$npc_group->Id'>$npc_group->Name</a>";
                    echo "</h3></td></tr>";
                    
    
                    foreach($npcs as $npc) {
                        print_unassigned_npc($npc);
                    }
                }
                else {
                    $unused_group_links[] = "<a href='npc_group_form.php?operation=update&id=$npc_group->Id'>$npc_group->Name</a>".
                        " <a href='logic/delete_npc_group.php?id=$npc_group->Id'><i class='fa-solid fa-trash'></i></a>";
                }
            }
 
            $npcs=NPC::getAllUnassignedWithoutGroup($current_larp);
            if (!empty($npcs)) {
                echo "<tr><td colspan='2'><h3>Utan grupp</h3></td></tr>";
            }
            foreach($npcs as $npc) {
                print_unassigned_npc($npc);
            }

            echo "</table>";
            echo "<h3>Grupper utan npc'er<h3>";
            echo implode(", ", $unused_group_links);
            

            
            ?>
            </div>
            
            <div>
            <h2>Personer som vill vara NPC</h2>
            <?php 

            foreach($persons as $person) {
                $registration = $person->getRegistration($current_larp);
            
                echo "<a href='view_person.php?id=$person->Id'><strong>$person->Name</strong></a>, ";

                echo $person->getMainRole($current_larp)->getLarperType()->Name."<br>";
                echo "karaktär(er): ";
                $roles = Role::getRegistredRolesForPerson($person, $current_larp);
                foreach ($roles as $role) {
                    echo "<a href='view_role.php?id=$role->Id'>$role->Name</a> ";
                }
                echo "<br>";
                echo "Önskemål: $registration->NPCDesire<br><br>";
            }
            ?>
            </div>
  	</div>
</body>

</html>
  