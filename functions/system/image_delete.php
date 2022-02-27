<?php
include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);


if (isset($_POST) && !empty($_POST['id']) && !empty($_POST['client_id'])) {
    $image_id = $_POST['id'];
    $client_id = $_POST['client_id'];

    // Delete image file from server
    $sql = "SELECT image_name FROM images WHERE idimages = {$image_id}";
    $image_data = mysqli_query($connection, $sql);
    $image = mysqli_fetch_array($image_data)["image"];
    unlink('uploads/' . $image);

    // Delete image upload record from database
    $sql = "DELETE FROM images WHERE idimages = {$image_id}";
    $result = mysqli_query($connection, $sql);


    if (!$result) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not delete image! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../client_view.php?view=$client_id&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Image Deleted Successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../client_view.php?view=$client_id&message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Please Select Image";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../client_view.php?view=$client_id&message1=$randms");
    exit();
}
