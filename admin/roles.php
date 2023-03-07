 <?php
 include_once 'header_subpage.php';
 

?>


    <div class="content">   
        <h1>Roller</h1>
        <h2>Huvudroller</h2>
     		<?php 
    		$roles = Role::getAllMainRoles($current_larp);
    		if (empty($roles)) {
    		    echo "Inga anmälda roller";
    		} else {
    		    echo "<table class='data'>";
    		    echo "<tr><th>Namn</th><th>Profession</th><th>Group</th><th>Intrig</th><th></th></tr>\n";
    		    foreach ($roles as $role)  {
    		        echo "<tr>\n";
    		        echo "<td>" . $role->Name . "</td>\n";
    		        echo "<td>" . $role->Profession . "</td>\n";
    		        echo "<td>" . $role->getGroup()->Name . "</td>\n";
    		        echo "<td>" . showStatusIcon($role->hasIntrigue($current_larp)) . "</td>\n";
    		        echo "<td>" . "<a href='view_role.php?id=" . $role->Id . "'><i class='fa-solid fa-eye'></i></a>\n";
    		        echo "<a href='edit_role.php?id=" . $role->Id . "'><i class='fa-solid fa-pen'></i></a></td>\n";
    		        echo "</tr>\n";
    		    }
    		    echo "</table>";
    		}
    		?>

        
                <h2>Övriga roller</h2>
     		<?php 
    		$roles = Role::getAllNotMainRoles($current_larp);
    		if (empty($roles)) {
    		    echo "Inga anmälda roller";
    		} else {
    		    echo "<table class='data'>";
    		    echo "<tr><th>Namn</th><th>Profession</th><th>Group</th><th>Intrig</th><th></th></tr>\n";
    		    foreach ($roles as $role)  {
    		        echo "<tr>\n";
    		        echo "<td>" . $role->Name . "</td>\n";
    		        echo "<td>" . $role->Profession . "</td>\n";
    		        echo "<td>" . $role->getGroup()->Name . "</td>\n";
    		        echo "<td>" . showStatusIcon($role->hasIntrigue($current_larp)) . "</td>\n";
    		        echo "<td>" . "<a href='view_role.php?id=" . $role->Id . "'><i class='fa-solid fa-eye'></i></a>\n";
    		        echo "<a href='edit_role.php?id=" . $role->Id . "'><i class='fa-solid fa-pen'></i></a></td>\n";
    		        echo "</tr>\n";
    		    }
    		    echo "</table>";
    		}
    		?>
        
	</div>
</body>

</html>
