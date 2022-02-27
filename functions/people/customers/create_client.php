<?php
include("../../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['account']) && isset($_POST['bvn'])){
    
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname =  $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $bvn = $_POST['bvn'];
    $findEmail = selectAll('customers', ['bvn' => $bvn]);
    if($findEmail){
        $_SESSION["feedback"] = "BVN is in use by another client!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../clients.php?message1=$randms");
        exit();
    }
    $branch = $_POST['branches'];
    $address = $_POST['address'];
    $accountNo = $_POST['account'];
    $guarantorName = $_POST['gua_fullname'];
    $guarantorPhone = $_POST['gua_phone'];
    $guaratorEmail = $_POST['gua_email'];
    $guarantorAddress = $_POST['gua_address'];


    $clientData = [
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'account_number' => $accountNo,
        'address' => $address,
        'guarantor_name' => $guarantorName,
        'guarantor_email' => $guaratorEmail,
        'guarantor_phone' => $guarantorPhone,
        'guarantor_address' => $guarantorAddress,
        'bvn' => $bvn,
        'email' => $email,
        'phone'=> $phone,
        'isapproved' => 0,
        'branches_idbranches' => $branch
    ];
    $createclient =  insert('customers', $clientData);
    if (!$createclient) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not create client! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../clients.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Client Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../clients.php?message0=$randms");
        exit();
    }
}