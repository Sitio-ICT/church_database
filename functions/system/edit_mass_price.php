<?php
include("../connect.php");
session_start();
$randms = generateRandomString(10);

if (isset($_POST['amount'])) {
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $priceData = [
        'price' => $amount,
    ];

    $updatePrice = update('fixed_price','mass', 'price_type', $priceData);
    if ($updatePrice) {
        $_SESSION["feedback"] = "Price updated Successfully";
        echo header("Location: ../../fixed_price.php?message0=$randms");
        exit();
    }else{
        $_SESSION["feedback"] = "Couldn't update Event";
        echo header("Location: ../../fixed_price.php?message1=$randms");
        exit();
    }
}else{
    $_SESSION["feedback"] = "Fill feild can't be empty";
    echo header("Location: ../../fixed_price.php?message1=$randms");
    exit();
}
