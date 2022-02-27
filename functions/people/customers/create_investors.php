<?php
include("../../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['phone'])){
    
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname =  $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $findEmail = selectAll('fixed_deposit', ['email' => $bvn]);
    if($findEmail){
        $_SESSION["feedback"] = "Email is in use by another Investor!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../investors.php?message1=$randms");
        exit();
    }
    // concatenate investors names
    $fullname = $firstname . " " . $middlename . " " . $lastname;


    $investorData = [
        'name' => $fullname,
        'email' => $email,
        'phone_no'=> $phone,
    ];
    $createInvestor =  insert('fixed_deposit', $investorData);
    if (!$createInvestor) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not create Investor! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../investors.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Investor Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../investors.php?message0=$randms");
        exit();
    }
}