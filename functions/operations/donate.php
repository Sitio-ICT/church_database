<?php
include("../methods.php");
$today = date('Y-m-d');
$randms = generateRandomString(5);
$transaction_id = generateRandomString(15);

if (isset($_POST['amount']) && isset($_POST['profile_id']) && isset($_POST['type'])) {
    $amount = $_POST['amount'];
    if ($_POST['type'] == "Subscription") {
        $description = "Subscription payment";
        $storeSubcription = subscribe($_POST['profile_id'], $_POST['type'], $amount, $_POST['subscriptionModel'], $today);
        if ($storeSubcription['status'] == "success") {
            $id = $storeSubcription['id'];
        }else{
            $error = $storeSubcription = "error";
        }
    } else {
        if($_POST['type'] == "Donation"){
            $description = "Donation on $today";
        }else{
            $description = "Tithe paid on " . getMonth($today) . " " . getYear($today);
        }
        
        $storeDonation = makeDonation($_POST['profile_id'], $_POST['type'], $amount, $description, $today);
        if ($storeDonation['status'] == "success") {
            $id = $storeDonation['id'];
        }else{
            $error = $storeDonation = "error";
        }
    }

    if($id == ""){
        // $_SESSION["feedback"] = "Sorry could not complete Transaction! - $error";
        // $_SESSION["Lack_of_intfund_$randms"] = "10";
        // echo header("Location: ../../transactions.php?message1=$randms");
        // exit();
        $output = "Not Done";
    }
    // store payment details 
    $storePayment = makePayment($profile_id, $_POST['payment_type'], $id, $amount, $description, $today, $transaction_id);
    if($storePayment['status'] == "success"){
        // $_SESSION["feedback"] = "Transaction Successful";
        // $_SESSION["Lack_of_intfund_$randms"] = "10";
        // echo header("Location: ../../transactions.php?message0=$randms");
        // exit();
        $output = "success";
    }else{
        // $error = $storePayment['error'];
        // $_SESSION["feedback"] = "Sorry could not complete Transaction! - $error";
        // $_SESSION["Lack_of_intfund_$randms"] = "10";
        // echo header("Location: ../../transactions.php?message1=$randms");
        // exit();
        $output = "error";
    }
}