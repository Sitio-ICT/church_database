<?php

include("../methods.php");
session_start();

if (isset($_POST['org_name']) && isset($_POST['meeting_days']) && isset($_POST['org_type']) && isset($_POST['re_occurence'])){
    $org_name = test_input($_POST['org_name']);
    $description = test_input($_POST['description']);
    $meeting_days = test_input($_POST['meeting_days']);
    $org_type = test_input($_POST['org_type']);
    $re_occurence = test_input($_POST['re_occurence']);
    $time = test_input($_POST['time']);

    $createOrganization = createOrganizations($org_name, $description, $org_type, $meeting_days, $re_occurence, $time);
    if ($createOrganization['status'] == "success") {
        $_SESSION["feedback"] = "Organization Successfuly Created";
        echo header("Location: ../../societies.php?message0=$randms");
        exit();
    } else {
        $error = $createOrganization['error'];
        $_SESSION["feedback"] = "Sorry could not create Organization! - $error";
        echo header("Location: ../../societies.php?message1=$randms");
        exit();
    }
}else{
    $_SESSION["feedback"] = "Fill in all required fields";
    echo header("Location: ../../societies.php?message1=$randms");
    exit();
}