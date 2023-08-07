<?php 

session_start();
session_unset();

include_once 'includes/error_handling.php';

if (!handleEmailQueue()) {
    //     echo "<h1>Failing sending Email</h1>"; # Vad gör vi nu? Skicka felnotering till admin?
}

?>


<!DOCTYPE html>
<html>
	<head>
	<style>
	
	.center {
  display: block;
  margin-left: auto;
  margin-right: auto;

}
	
	</style>
		<meta charset="utf-8">
		<title>Berghems vänners Omnes Mundos</title>
		<link href="css/loginpage.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/x-icon" href="../images/bv.ico">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
	<img  class="center" src="images/omnes_mundos_header.jpg">

	  <?php if (isset($error_message) && strlen($error_message)>0) {
	      echo '<div class="error">'.$error_message.'</div>';
	  }?>
	  <?php if (isset($message_message) && strlen($message_message)>0) {
	      echo '<div class="message">'.$message_message.'</div>';
	  }?>
	  <div class="login-register">
	  <div>
		<div class="login">
			<h1>Logga in</h1>
			<form action="includes/authenticate.php" method="POST">
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="Epost" id="email" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Lösenord" id="password" required>
			
				<input type="submit" value="Logga in" name="submit">
			</form>
			</div>
			<div class="link"><a href="send_to_me_please.php?action=password">Glömt lösenord</a></div>
			
			
		</div>
		<div>
		<div class="register">
			<h1>Registrera nytt konto</h1>
			<form action="includes/register.php" method="POST" autocomplete="off">
				<label for="name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="name" placeholder="Förnamn Efternamn" id="name" maxlength="250" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Epost" id="email" maxlength="250" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Lösenord" id="password" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="passwordrepeat" placeholder="Repetera lösenord" id="password" required>
				<input type="submit" value="Registrera"  name="submit">
			</form>
			</div>
			<div class="link"><a href="send_to_me_please.php?action=activation">Skicka om aktiveringsbrevet</a></div>
		</div>
	  </div>

	</body>
</html>