<?php

include_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $emailId = $_GET['id'];
    }
    else {
        header('Location: index.php');
        exit;
    }
}

$email = Email::loadById($emailId); 


if ($current_larp->Id != $email->LarpId) {
    header('Location: index.php'); //Emailet är inte för detta lajvet
    exit;
}

$user = User::loadById($email->SenderUserId);

include 'navigation.php';
?>


	<div class="content">
		<h1><?php echo $email->Subject ?></h1>
	
		<div>
		<table>
			<tr><td>Skickat av</td><td><?php echo $user->Name ?></td></tr>
			<tr><td>Till</td><td><?php echo "$email->ToName ($email->To)"; ?></td></tr>
			<tr><td>Ämne</td><td><?php echo $email->Subject ?></td></tr>
			<tr><td>Skickat av</td><td><?php echo $user->Name ?></td></tr>
			<tr><td>När</td><td><?php echo $email->SentAt ?></td></tr>
			<?php 
			if (!empty($email->ErrorMessage)) {
			    echo "<tr><td>Felmeddelande</td><td>$email->ErrorMessage</td></tr>";

			}
			?>
			<tr><td colspan = '2' style='font-weight: normal'>
			<hr>
			<?php echo nl2br($email->Text); ?>
			</td>
			</tr>
		</table>		
		</div>

</body>
</html>
