<?php
require 'header.php';
include_once '../includes/error_handling.php';
include "navigation.php";
?>
		<div class="content">
			<h1>Omnes Mundos administration</h1>
			<p>			    
				<a href="campaign_admin.php">Kampanjer</a><br>
			    <a href="house_admin.php">Hus i byn</a><br>
			    <a href="user_admin.php">Användare / Logins /Admin behörighet</a><br>
		    </p>
		    <h2>Basdata</h2>
		    <p>	    			
    		    <a href="selection_data_general_admin.php?type=normalallergytypes">Vanliga allergier</a>	<br>
    		    <a href="selection_data_general_admin.php?type=experiences">Erfarenhet som lajvare</a>	<br>
    		    <br>
    		    <a href="bookkeeping_account_admin.php">Konteringskonton</a>	<br>
		    </p>
		</div>
	</body>
</html>