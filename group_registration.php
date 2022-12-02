<?php
include_once 'includes/db.inc.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Gruppanmälan DMH 2023</title>
<link rel="stylesheet" href="includes/registration_system.css">
</head>
<body>
<?php 
function showDropDownData($db_conn) {
    echo "In function";
    $sql = "SELECT * FROM HousingRequests;";
    $result = mysqli_query($db_conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['Id'] . "'>" . utf8_decode($row['Name']) . "</option>";
        }
    }
    
}


?>
	<div id="site-header">
		<a href="https://dmh.berghemsvanner.se/" rel="home"> <img
			src="images//IMG_1665485583436.png" width="1080" height="237"
			alt="Död mans hand" />
		</a>
	</div>

	<div id="simpleCenter">
		<form>

			<h1>Gruppanmälan</h1>
			<p>En grupp är en gruppering av roller som gör något tillsammans på
				lajvet. Exempelvis en familj på lajvet, en rånarliga eller ett
				rallarlag.</p>
			<h2>Gruppledare</h2>
			<p>
				Gruppledaren är den som arrangörerna kommer att kontakta när det
				uppstår frågor kring gruppen.
				<div class="question">
				<label for="group_leader_name">Gruppledarens
					namn</label><br> <input type="text" id="group_leader_name"
					name="group_leader_name" required>
					</div>
					<div class="question">
					<label for="email">E-post</label><br>
				<input type="email" id="email" name="email" required>
				</div>
			</p>
			
			
			<h2>Information om gruppen</h2>
			
			
			<div class="question">
				<label for="group_name">Gruppens namn</label><br> <input
					type="text" id="group_name" name="group_name" required>
			</div>
			<div class="question">
				<label for="approximate_number_of_participants">Ungefär hur många
					gruppmedlemmar kommer ni att bli?</label><br> <input type="text"
					id="approximate_number_of_participants"
					name="approximate_number_of_participants" required>
			</div>
						<div class="question">
			<label for="housing_request">Hur vill ni bo som grupp?</label><br>
        	<select name="housing_request" id="housing_requests">        
            <?php
    
            showDropDownData($conn);
            
            ?> 
        	</select>
        </div>
        			<div class="question">
				<label for="need_fireplace">Behöver ni eldplats?</label><br> <input
					type="radio" id="html" name="need_fireplace" value="yes"> <label
					for="html">Ja</label><br> <input type="radio" id="css"
					name="need_fireplace" value="no"> <label for="css">Nej</label>
			</div>
			<div class="question">
				<label for="friends">Vänner</label><br>
				<textarea id="friends" name="friends" rows="4" cols="50">
		</textarea>
			</div>
			<div class="question">
				<label for="enemies">Fiender</label><br>
				<textarea id="enemies" name="enemies" rows="4" cols="50">
		</textarea>
			</div>


<div class="question">
			Hur rik anser du att ni är? (1= äger inget, 5 = badar i pengar) 
			
			</div>
			<div class="question">
			Var
			kommer grupen från? Dvs var är ni bosatta? 
			</div>
			<div class="question">
			Vill ni ha en
			arrangörsskriven gruppintrig inför lajvet? 
			Om ni svarar "Nej" är det
			inte en garanti för att ni inte får några intriger ändå. Speciellt om
			ni redan är en existerande grupp i kampanjen så är det troligare att
			ni är inblandade i något. 
			</div>
			
			<div class="question">
			
			Vilka typer av gruppintriger är ni
			intresserade av? Har ni några grupprykten som ni vill ha hjälp med
			att sprida? (Om ja, specificera nedan) 
			</div>
						<div class="question">
			Något annat arrangörerna bör
			veta om er grupp? 
</div>
			<div class="question">
			Genom att kryssa i denna ruta så lovar jag med
			heder och samvete att jag har läst igenom alla hemsidans regler och
			förmedlat dessa till mina gruppmedlemmar. Vi har även alla godkänt
			dem och är införstådda med vad som förväntas av oss som grupp av
			deltagare på lajvet. Om jag inte har läst reglerna så kryssar jag
			inte i denna ruta. 
			</div>
						<div class="question">
			Härmed samtycker jag till att föreningen Berghems
			Vänner får spara och lagra mina uppgifter - såsom namn/
			e-postadress/telefonnummer/hälsouppgifter/annat. Detta för att kunna
			arrangera lajvet.
</div>
		</form>
	</div>

</body>
</html>