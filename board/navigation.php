<!DOCTYPE html>
<html>
<head>

	<link href="../css/navigation_admin.css" rel="stylesheet" type="text/css">

	<?php include '../common/navigation_beginning.php';?> 

	   <!--  Egen meny -->
	  <div class="dropdown">
	    <button class="dropbtn">Meny 
	      <i class="fa fa-caret-down"></i>
	    </button>
	    <div class="dropdown-content">
	      	<a href="campaigns.php">Kampanjer</a>
	      	<a href="economy_overview.php">Ekonomisk översikt</a>
	      	<a href="permissions.php">Behörigheter</a>
	      	<a href="../common/mail_admin.php">Skickad epost</a>
	    </div>
	  </div> 


	<?php include '../common/navigation_site_part_selector.php';?>  
	<?php include '../common/navigation_end.php';?> 

