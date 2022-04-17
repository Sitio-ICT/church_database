<?php

include("../connect.php");

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];

	$updateData = [
		'start_date' => $start,
		'end_date' => $end
	];
	$update = update('calendar', $id, 'id', $updateData);

	if (!$update) {
		$_SESSION["feedback"] = "Could not update Date";
        echo header("Location: ../../calender.php?v&message1=$randms");
        exit();;
	}else{
		$_SESSION["feedback"] = "Event updated Successfully";
        echo header("Location: ../../calender.php?v&message0=$randms");
        exit();
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	