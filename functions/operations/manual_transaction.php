<?php

include("../methods.php");
$today = date('Y-m-d');
$randms = generateRandomString(5);
$transaction_id = generateRandomString(15);

if (isset($_POST['amount']) && isset($_POST['member']) && isset($_POST['payment_type'])) {
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $description = $_POST['description'];
    if ($_POST['payment_type'] == "Subscription") {
        $storeSubcription = subscribe($_POST['member'], $_POST['payment_type'], $amount, $_POST['subscriptionModel'], $today);
        if ($storeSubcription['status'] == "success") {
            $id = $storeSubcription['id'];
        }else{
            $error = $storeSubcription = "error";
        }
    } else {
        $storeDonation = makeDonation($_POST['member'], $_POST['payment_type'], $amount, $description, $today);
        if ($storeDonation['status'] == "success") {
            $id = $storeDonation['id'];
        }else{
            $error = $storeDonation = "error";
        }
    }
    if($id == ""){
        $_SESSION["feedback"] = "Sorry could not complete Transaction! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../manual_payment.php?message1=$randms");
        exit();
    }
    // store payment details 
    $storePayment = makePayment($profile_id, $_POST['payment_type'], $id, $amount, $description, $today, $transaction_id);
    if($storePayment['status'] == "success"){
        $_SESSION["feedback"] = "Transaction Successful";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../manual_payment.php?message0=$randms");
        exit();
    }else{
        $error = $storePayment['error'];
        $_SESSION["feedback"] = "Sorry could not complete Transaction! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../manual_payment.php?message1=$randms");
        exit();
    }
}
