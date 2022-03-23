<?php

session_start();
include("../methods.php");
$randms = generateRandomString(5);

// Processing form data when form is submitted
if (isset($_POST['person']) && isset($_POST['mass_intention'])) {

    $person = test_input($_POST['person']);
    $mass_intention = test_input($_POST['mass_intention']);
    // $profile_id = test_input($_POST['profile_id']);


    // create feed
    $feed_created = create('mass_booking', ['person' => $person, 'mass_intention' => $mass_intention, 'status' => 0, 'profile_id' => $profile_id]);

    if ($feed_created) {
        $_SESSION["feedback"] = "Mass Successfully Booked";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../book_mass.php?&message0=$randms");
        exit();
    }
}