<?php
include_once 'header.php';

    $prop = Prop::newWithDefault();;
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $operation = "new";
        if (isset($_GET['operation'])) {
            $operation = $_GET['operation'];
        }
        if ($operation == 'new') {
        } elseif ($operation == 'update') {
            $prop = Prop::loadById($_GET['id']);            
        } else {
        }
    }
      
    function default_value($field) {
        GLOBAL $prop;
        $output = "";

        switch ($field) {
            case "operation":
                if (is_null($prop->Id)) {
                    $output = "insert";
                    break;
                }
                $output = "update";
                break;
            case "id":
                $output = $prop->Id;
                break;
            case "action":
                if (is_null($prop->Id)) {
                    $output = "Lägg till";
                    break;
                }
                $output = "Uppdatera";
                break;
        }

        echo $output;
    }
    
    include 'navigation_subpage.php';
    ?>
    
<style>

img {
  float: right;
}
</style>


    <div class="content"> 
    <h1><?php echo default_value('action');?> rekvisita</h1>
    
   
	<form action="prop_admin.php" method="post">
		<input type="hidden" id="operation" name="operation" value="<?php default_value('operation'); ?>"> 
		<input type="hidden" id="Id" name="Id" value="<?php default_value('id'); ?>">
        <?php 
            if ($prop->hasImage()) {
                $image = Image::loadById($prop->ImageId);
                echo "<td>";
                echo '<img src="data:image/jpeg;base64,'.base64_encode($image->file_data).'"/>';
                if (!empty($image->Photographer) && $image->Photographer!="") echo "<br>Fotograf $image->Photographer";
                echo "</td>";
            }
            ?>
		
		<table>
			<tr>
				<td><label for="Name">Namn</label></td>
				<td><input type="text" id="Name" name="Name" value="<?php echo $prop->Name; ?>" size="100" maxlength="250" required></td>

			</tr>
			<tr>

				<td><label for="Description">Beskrivning</label></td>
				<td><input type="text" id="Description" name="Description"
					 value="<?php echo $prop->Description; ?>" size="100" maxlength="250" required></td>
			</tr>
			<tr>

				<td><label for="StorageLocation">Lagerplats</label></td>
				<td><input type="text" id="StorageLocation" name="StorageLocation"
					 value="<?php echo $prop->StorageLocation; ?>" size="100" maxlength="250" required></td>
			</tr>
			<tr>
				<td><label for="Marking">Märkning</label></td>
				<td><input type="text" id="Marking" name="Marking" value="<?php echo $prop->Marking; ?>" size="100" maxlength="250" ></td>

			</tr>
			<tr>
				<td><label for="Properties">In-lajv egenskaper</label></td>
				<td><input type="text" id="Properties" name="Properties" value="<?php echo $prop->Properties; ?>" size="100" maxlength="250" ></td>

			</tr>
		</table>

		<input id="submit_button" type="submit" value="<?php default_value('action'); ?>">
	</form>
	</div>
    </body>

</html>