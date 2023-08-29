<?php
$showError = false;
// $showAlert = false;
if($_SERVER['REQUEST_METHOD']=="POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail1'];
    $user_pass = $_POST['signuppassword'];
    $user_cpass = $_POST['signupcpassword'];

    // Check whether this email exists 
    $existsSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existsSql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0){
        $showError = "Email already in use";
    }
    else{
        if($user_pass == $user_cpass){
            $hash = password_hash($user_pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
}


?>