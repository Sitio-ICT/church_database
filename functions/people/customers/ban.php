<?php
include("../../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$clientId = $_GET['ban'];
if (isset($_GET['ban'])) {
    $banUser = update('users', $_GET['ban'], 'id', ['status' => 'CLOSED']);
    if (!$banUser) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not BAN User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client_view.php?view=$clientId&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "User Successfuly Banned";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client_view.php?view=$clientId&message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Something went wrong could not find user!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../../client_view.php?view=$clientId&message1=$randms");
    exit();
}
