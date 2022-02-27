<?php
include("../../methods.php");
session_start();
$randms = generateRandomString(7);

if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['passkey']) && isset($_POST['confirm_passkey'])){
    // initiialize post data
    
    $first_name = test_input($_POST['firstname']);
    $last_name = test_input($_POST['lastname']);
    $passkey = test_input($_POST['passkey']);
    $email = test_input($_POST['email']);
    $confirmed_passkey = test_input($_POST['confirm_passkey']);
    $username = test_input($_POST['username']);
    $findEmail = findEmail($email);
    
    if($passkey != $confirmed_passkey){
        $_SESSION["feedback"] = "Password does not match!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message1=$randms");
        exit();
    }
    
    
    
    $password = password_hash($passkey, PASSWORD_DEFAULT);

    $createUserser =  createUser($username, $password, $first_name, $last_name, $email);
    echo $createUser['status'];
    if ($createUser['status'] != "success") {
        $error = $createUser['error'];
        $_SESSION["feedback"] = "Sorry could not create User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Your account was Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message0=$randms");
        exit();
    }
} 