<?php

session_start();
include("../methods.php");
$randms = generateRandomString(5);

if (isset($_POST['date_joined']) && isset($_POST['member'])) {
    $position = test_input($_POST['position']);
    $organization_id = $_POST['organization'];
    $addMember = addMember($_POST['member'], $_POST['organization'], $_POST['date_joined'], $_POST['position']);
    if ($addMember['status'] == "success") {
        $_SESSION["feedback"] = "Member Added Successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../society_view.php?view=$organization_id&message0=$randms");
        exit();
    } else {
        $error = $addMember['error'];
        $_SESSION["feedback"] = "Sorry could not add Member! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../society_view.php?view=$organization_id&message1=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Please Fill in all required fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../society_view.php?view=$organization_id&message1=$randms");
    exit();
}
