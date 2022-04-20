<?php

include("../connect.php");
$randms = generateRandomString(10);

if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$query = delete('calendar', $id, 'id');
	if (!$query) {
		$_SESSION["feedback"] = "Could not delete Event";
        echo header("Location: ../../calender.php?message1=$randms");
        exit();
	}else{
		$_SESSION["feedback"] = "Event deleted Successfully";
        echo header("Location: ../../calender.php?message0=$randms");
        exit();
	}
	
}elseif (isset($_POST['activity_name']) && isset($_POST['activity_color']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['activity_name'];
	$color = $_POST['activity_color'];
    $updateData = [
        'activity_name' => $title,
        'activity_color' => $color
    ];
	
	
	$update = update('calendar', $id, 'id', $updateData);

	if (!$update) {
		$_SESSION["feedback"] = "Could not update Event";
        echo header("Location: ../../calender.php?message1=$randms");
        exit();
	}else{
		$_SESSION["feedback"] = "Event updated Successfully";
        echo header("Location: ../../calender.php?message0=$randms");
        exit();
	}

}else{
	$_SESSION["feedback"] = "Fields can not be empty";
	echo header("Location: ../../calender.php?message1=$randms");
	exit();
}
