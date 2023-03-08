<?php

// Now we check if the data was submitted, isset() function will check if the data exists.
if (isset($_POST['submit'])) {
    
    //Grabbing the data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordrepeat = $_POST['passwordrepeat'];
    
    //Instantiate SignupController class
    include "../classes/dbh.php";
    include "../classes/signup.php";
    include "../classes/signup_controller.php";
    $signup = new SignupController($email, $password, $passwordrepeat);
        
    //Running error handlers and user signup
    $signup->signupUser();
    
    //Going back to front page
    header("location: ../index.php?message=user_created"); 
    exit;
}
else {
    //Going back to front page
    header("location: ../index.php?error=noSubmit");
}