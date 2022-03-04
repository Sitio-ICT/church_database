<?php

session_start();
include("../methods.php");
$randms = generateRandomString(5);

if (isset($_POST['date']) && isset($_POST['member'])) {
    $position = test_input($_POST['minister']);
    $sacrament_id = $_POST['sacrament'];
    $addMember = recordSacramentReceieved($_POST['member'], $_POST['sacrament'], $_POST['date'], $position);
    if ($addMember['status'] == "success") {
        $_SESSION["feedback"] = "Sacrament Added Successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../record_sacrament.php?&message0=$randms");
        exit();
    } else {
        $error = $addMember['error'];
        $_SESSION["feedback"] = "Sorry could not Record Sacrament! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../record_sacrament.php?&message1=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Please Fill in all required fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../record_sacrament.php?&message1=$randms");
    exit();
}
