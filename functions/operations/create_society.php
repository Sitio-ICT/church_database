<?php

include("../methods.php");

if (isset($_POST['org_name']) && isset($_POST['meeting_days']) && isset($_POST['org_type']) && isset($_POST['re_occurence'])){
    $org_name = test_input($_POST['org_name']);
    $description = test_input($_POST['description']);
    $meeting_days = test_input($_POST['meeting_days']);
    $org_type = test_input($_POST['org_type']);
    $re_occurence = test_input($_POST['re_occurence']);

    $createOrganization = createOrganizations($org_name, $description, $org_type, $meeting_days, $re_occurence);
    if ($createOrganization['status'] == "success") {
        $_SESSION["feedback"] = "Organization Successfuly Created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../societies.php?message0=$randms");
        exit();
    } else {
        $error = $createOrganization['error'];
        $_SESSION["feedback"] = "Sorry could not create Organization! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../societies.php?message1=$randms");
        exit();
    }
}else{
    $_SESSION["feedback"] = "Fill in all required fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../societies.php?message1=$randms");
    exit();
}