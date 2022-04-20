<?php
include("../connect.php");
session_start();
$randms = generateRandomString(10);

if (isset($_POST['activity_name']) && isset($_POST['color']) && isset($_POST['start'])) {
    $eventData = [
        'activity_name' => test_input($_POST['activity_name']),
        'activity_color' => test_input($_POST['color']),
        'start_date' => $_POST['start'],
        'end_date' => $_POST['end'],
        'description' => test_input($_POST['description'])
    ];

    $addEvent = insert('calendar', $eventData);
    if ($addEvent) {
        $_SESSION["feedback"] = "Event Added Successfully";
        echo header("Location: ../../calender.php?message0=$randms");
        exit();
    }else{
        $_SESSION["feedback"] = "Couldn't add Event";
        echo header("Location: ../../calender.php?message1=$randms");
        exit();
    }
}else{
    $_SESSION["feedback"] = "Fill All required fields";
    echo header("Location: ../../calender.php?message1=$randms");
    exit();
}
