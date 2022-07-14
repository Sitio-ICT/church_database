<?php

include("../../methods.php");
session_start();
$randms = generateRandomString(7);

$profile_id = $_SESSION['profile_id'];
if (isset($_POST)) {
    // initiialize post data


    if (!empty($_FILES['image']['name'])) {

        $name = $_FILES['image']['name'];
        list($txt, $ext) = explode(".", $name);
        $image_name = time() . "." . $ext;
        $tmp = $_FILES['image']['tmp_name'];
        $uploaded_at = date('Y-m-d H:i:s');
        $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        // dd($imageFileType);

        // $valid_extensions = getimagesize("jpg", "jpeg", "png");

        if ($imageFileType == "jpg" or $imageFileType == "png" or $imageFileType == "jpeg" or $imageFileType == "JPEG") {
            if ($_FILES["image"]["size"] < 2000000) {

                if (copy($tmp, '../../../img/members/profile_pic/' . $image_name)) {

                    $userData = [
                        'image' => $image_name
                    ];
                }
            } else {
                $_SESSION["feedback"] = "Sorry, your file is too large.";
                echo header("Location: ../../../profile.php?message1=$randms");
                exit();
            }
        } else {
            $_SESSION["feedback"] = "Sorry Extention not Valid";
            echo header("Location: ../../../profile.php?message1=$randms");
            exit();
        }
    } else {
        $error = mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Image not Selected";
        echo header("Location: ../../../profile.php?message1=$randms");
        exit();
    }


    $updateUser =  update('profile', $profile_id, 'id', $userData);
    // dd($updateUser);
    if ($updateUser) {

        // Send email to user with the token in a link they can click on
        $to = $_POST['email'];
        $subject = "Profile Update | Holy Family";
        $msg = "
        <html> 
        <body> 
            <p style=\"text-align:center;height:100px;background-color:#abc;border:1px solid #456;border-radius:3px;padding:10px;\">
                Hi there $first_name $last_name, your profile picture has be <b>updated successfully</b>. If this was not done by you or with your permission, kindly contact the church. Thank you.
            </p>
        </body>
        </html>";
        $headers = "From: no-reply@holyfamilycclc.org\r\n";
        $headers .= "Content-type: text/html\r\n";
        $mailed = mail($to, $subject, $msg, $headers);

        $_SESSION["feedback"] = "Your account was Successfuly updated";
        echo header("Location: ../../../profile.php?message0=$randms");
        exit();
    } else {
        $error = mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not Update User! - $error";
        echo header("Location: ../../../profile.php?message1=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Fill in all required fields";
    echo header("Location: ../../../profile.php?message1=$randms");
    exit();
}
