<?php
global $root;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";

require $root . '/includes/init.php';

$future_open_larp_array = LARP::allFutureOpenLARPs();
$future_closed_larp_array = LARP::allFutureNotYetOpenLARPs();
$past_larp_array = LARP::allPastLarpsWithRegistrations($current_user);

?>
<!DOCTYPE html>
<html>
<head>
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://kit.fontawesome.com/30d6e99205.js" crossorigin="anonymous"></script>
    <link href="../css/navigation_participant.css" rel="stylesheet" type="text/css">
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/x-icon" href="../images/bv.ico">
	<title>Berghems vänners anmälningssystem</title>
	
</head>
<body>
<div class="topnav"  id="myTopnav">
    <div id="right">

	  
	  <div id="placeholder" class="dropdown">&nbsp;<br>&nbsp;
	    <button class="dropbtn">   
	    </button>
	  </div> 


	  <a href="../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logga ut&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
	  </div>
    
    </div>

		<div class="content">
			<h1>Vilket lajv?</h1>
    			<?php

    			$resultCheck = count($future_open_larp_array);
    			 if ($resultCheck > 0) {
    			     ?>
    			     <h3>Kommande lajv</h3>
					<form action="../includes/set_larp.php" method="POST">
					<label for="larp">Välj lajv:</label>
    			     
    			     <select name='larp' id='larp'>
    			<?php
    
    			     foreach ($future_open_larp_array as $larp) {
    			         echo "<option value='" . $larp->Id . "'>". $larp->Name . "</option>\n";
    			     }
    			     echo "</select>";
    			     echo '<input type="submit" value="Välj">';    			 }
    			 
    			 ?>

			 </form>
			 <br>
    			<?php

    			$resultCheck = count($future_closed_larp_array);
    			 if ($resultCheck > 0) {
    			     ?>
    			     <h3>Kommande lajv (anmälan är inte öppen än)</h3>

					<form action="../includes/set_larp.php" method="POST">
 					<label for="larp">Välj lajv: </label>
    			    <select name='larp' id='larp'>
    
    			<?php
    			     foreach ($future_closed_larp_array as $larp) {
    			         echo "<option value='" . $larp->Id . "'>". $larp->Name . "</option>\n";
    			     }
    			     echo "</select>";
    			     echo '<input type="submit" value="Välj">';
    			 }
    			 
    			 ?>
    			 
			 </form>
			 <br>
    			<?php

    			$resultCheck = count($past_larp_array);
    			 if ($resultCheck > 0) {
    			     ?>
    			 <h3>Tidigare lajv</h3> 
    			 <p>Välj det här om du vill fylla i vad som hände på lajvet.</p>   
				<form action="../includes/set_larp.php" method="POST">
				<label for="larp">Välj lajv:</label>
			    <select name='larp' id='larp'>
      			<?php  
    			     foreach ($past_larp_array as $larp) {
    			         echo "<option value='" . $larp->Id . "'>". $larp->Name . "</option>\n";
    			     }
    			     echo "</select>";
    			     echo '<input type="submit" value="Välj">';
    			 }
    			 
    			 ?>
			 </form>
			 </div>

	</body>
</html>