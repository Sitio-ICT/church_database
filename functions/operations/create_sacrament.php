<?php

include("../methods.php");
session_start();
$randms = generateRandomString(5);

if (isset($_POST['title']) && isset($_POST['min_age']) && isset($_POST['max_receivable'])) {
    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);
    $min_age = test_input($_POST['min_age']);
    $max_receivable =  test_input($_POST['max_receivable']);

    $createSacrament = createSacrament($title, $description, $min_age, $max_receivable);
    if ($createSacrament['status'] == "success") {
        $_SESSION["feedback"] = "Sacrament Successfuly Created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../sacraments.php?message0=$randms");
        exit();
    } else {
        $error = $createSacrament['error'];
        $_SESSION["feedback"] = "Sorry could not create Sacrament! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../sacraments.php?message1=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Fill in all required fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../sacraments.php?message1=$randms");
    exit();
}
