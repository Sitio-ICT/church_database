<?php

include("../../methods.php");
session_start();
$randms = generateRandomString();

$profile_id = $_GET['client_id'];
if (isset($_GET['client_id']) && isset($_GET['relation'])) {
    $relation = $_GET['relation'];
    

    $deleteRelation = delete('relationships', $relation, 'id');

    if (!$deleteRelation) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not delete relationship! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client_view.php?view=$profile_id&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Relationship Deleted Successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client_view.php?view=$profile_id&message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Please Select Relationship";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../../client_view.php?view=$profile_id&message1=$randms");
    exit();
}
