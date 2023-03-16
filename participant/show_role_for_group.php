<?php 


require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET['id'])) {
        $role = Role::loadById($_GET['id']);
    } else {
        
        header('Location: index.php');
        exit;
    }
}

//Finns ingen sådan roll, eller rollen har ingen bild
if (!isset($role)){
    header('Location: index.php');
    exit;
}

$group = Group::loadById($role->GroupId);

//Man måste vara med i samma grupp för att få se
if (!empty($group) && !$current_user->isMember($group) && !$current_user->isGroupLeader($group)) {
    header('Location: index.php?error=no_member'); //Inte medlem i gruppen
    exit;
}


$ih = ImageHandler::newWithDefault();
$image = $ih->loadImage($role->ImageId);

include 'navigation_subpage.php';
?>

<div class="content">
	<h1><?php echo $role->Name?></h1>

<?php if ($role->hasImage()) {
echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'"/>';
}
?>
<p><?php echo $role->DescriptionForGroup?></p>

	</div>


</body>
</html>