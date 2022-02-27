<?php
include("../../methods.php");
session_start();

if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['passkey']) && isset($_POST['confirmed_passkey'])){
    // initiialize post data
    
    $first_name = test_input($_POST['firstname']);
    $last_name = test_input($_POST['lastname']);
    $passkey = test_input($_POST['passkey']);
    $email = test_input($_POST['email']);
    $confirmed_passkey = test_input($_POST['confirmed_passkey']);
    $username = test_input($_POST['username']);
    $findEmail = findEmail($email);
    if($findEmail != "Okay!"){
        $_SESSION["feedback"] = "Email is in use by another user!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message1=$randms");
        exit();
    }
    if($rank == 1){
        $approval = 1;
        $transaction = 1;
        $product = 1;
        $support = 1;
    }else{
        $support = 1;
        if(isset($_POST['approve']) == 1){
            $approval = 1;
        }else{
            $approval = 0;
        }
        if(isset($_POST['transaction']) == 1){
            $transaction = 1;
        }else{
            $transaction = 0;
        }
        if(isset($_POST['product']) == 1){
            $product = 1;
        }else{
            $product = 0;
        }
    } 
    
    // dd($support);
    $password = "password25";
    $passkey = password_hash($password, PASSWORD_DEFAULT);

    $userData = [
        'fullname' => $fullname,
        'username' => $username,
        'password' => $passkey,
        'email' => $email,
        'phone'=> $phone,
        'usertype' => "ADMIN",
        'rank' => $rank
    ];
    $createUser =  insert('users', $userData);
    
    if (!$createUser) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not create User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message1=$randms");
        exit();
    } else {
        $permissionData = [
            'approval' => $approval,
            'support' => $support,
            'product' => $product,
            'transactions' => $transaction,
            'user' => $createUser
        ];
        insert('permissions', $permissionData);
    // $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "User Successfuly created - Default Password is. - password25";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message0=$randms");
        exit();
    }
}