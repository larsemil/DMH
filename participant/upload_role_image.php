<?php

require 'header.php';


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET['id'])) {
        echo "Laddar " . $_GET['id'] . "<br>";
        
        $role = Role::loadById($_GET['id']);
    } else {

        header('Location: index.php');
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['id'])) {
        $role = Role::loadById($_POST['id']);
    } else {

        header('Location: index.php');
        exit;
    }
}

if (!isset($role)) {
    header('Location: index.php');
    exit;
}


if (Person::loadById($role->PersonId)->UserId != $current_user->Id) {

    header('Location: index.php'); //Inte din roll
    exit;
}


// (A) SAVE IMAGE INTO DATABASE
if (isset($_FILES["upload"])) {
    $ih = ImageHandler::newWithDefault();
    $error = $ih->maySave();
    if (!isset($error)) {
        $id = $ih->saveImage();
        $role->ImageId = $id;
        $role->update();
        header('Location: index.php?message=image_uploaded');
        exit;
    }
}



?>
 
     <nav id="navigation">
      <a href="#" class="logo"><?php echo $current_larp->Name; ?></a>
      <ul class="links">
        <li><a href="index.php"><i class="fa-solid fa-house"></i>Hem</a></li>
       	<li><a href="../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logga ut</a></li>
      </ul>
    </nav>
	<div class="content">
		<h1>Ladda upp bild för <?php echo $role->Name?></h1>
        	  <?php if (isset($error) && strlen($error)>0) {
        	      echo '<div class="error">'.$error.'</div>';
        	  }?>

    	<form method="post" enctype="multipart/form-data">
        	<input type="hidden" id="id" name="id" value="<?php echo $role->Id; ?>">
          	<input type="file" name="upload" required>
          	<input type="submit" name="submit" value="Ladda upp bild">
          	<p><strong>OBS:</strong> Bara .jpg, .jpeg, .gif, .png bilder är tillåtna och max storlek 0.5 MB.<br>
          	Bäst blir det om du har en bild som är 300 * 400 pixlar.</p>
        </form>
    </div>
</body>
</html>
  
