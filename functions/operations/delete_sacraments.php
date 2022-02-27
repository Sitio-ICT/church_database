<?php

include("../methods.php");
session_start();
$randms = generateRandomString(5);

if(isset($_GET['delete'])){
    $deleteSacrament = deleteSacrament($_GET['delete']);
    if ($deleteSacrament['status'] == "success") {
        $_SESSION["feedback"] = "Sacrament Successfuly Deleted";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../sacraments.php?message0=$randms");
        exit();
    } else {
        echo $error = $createSacrament['error'];
        $_SESSION["feedback"] = "Sorry could not delete Sacrament! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../sacraments.php?message1=$randms");
        exit();
    }
}