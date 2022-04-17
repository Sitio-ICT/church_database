<?php
include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST)) {
    $profile_id = $_POST['profile_id'];

    if (!empty($_FILES['image']['name'])) {

        $name = $_FILES['image']['name'];
        list($txt, $ext) = explode(".", $name);
        $image_name = time() . "." . $ext;
        $tmp = $_FILES['image']['tmp_name'];
        $uploaded_at = date('Y-m-d H:i:s');

        $valid_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array(strtolower($ext), $valid_extensions)) {
            if (move_uploaded_file($tmp, '../../uploads/' . $image_name)) {
                $imageData = [
                    'profile_id' => $profile_id,
                    'image' => $image_name
                ];
                $uploadImage = insert('images', $imageData);
                // dd($uploadImage);
                if (!$uploadImage) {
                    $error = "Error: \n" . mysqli_error($connection); //checking for errors
                    $_SESSION["feedback"] = "Sorry could not upload image! - $error";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../client_view.php?view=$profile_id&message1=$randms");
                    exit();
                } else {
                    $_SESSION["feedback"] = "Image Successfuly Uploaded";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../client_view.php?view=$profile_id&message0=$randms");
                    exit();
                }
            } else {
                $_SESSION["feedback"] = "Image Upload Failed";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../client_view.php?view=$profile_id&message1=$randms");
                exit();
            }
        } else {
            $_SESSION["feedback"] = "Invalid File Format";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../client_view.php?view=$profile_id&message1=$randms");
            exit();
        }
    } else {
        $_SESSION["feedback"] = "Please Select Image";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../client_view.php?view=$profile_id&message1=$randms");
        exit();
    }
}
