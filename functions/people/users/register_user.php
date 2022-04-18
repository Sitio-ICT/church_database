<?php
include("../../methods.php");
session_start();
$randms = generateRandomString(7);

if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['passkey']) && isset($_POST['confirm_passkey'])) {
    // initiialize post data

    $first_name = test_input($_POST['firstname']);
    $last_name = test_input($_POST['lastname']);
    $passkey = test_input($_POST['passkey']);
    $email = test_input($_POST['email']);
    $confirmed_passkey = test_input($_POST['confirm_passkey']);
    $username = test_input($_POST['username']);
    $findEmail = findEmail($email);

    if ($passkey != $confirmed_passkey) {
        $_SESSION["feedback"] = "Password does not match!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message1=$randms");
        exit();
    }



    // $password = password_hash($passkey, PASSWORD_DEFAULT);

    $createUser =  createUser($username, $passkey, $first_name, $last_name, $email, 'user');
    echo $createUser['status'];
    if ($createUser['status'] != "success") {
        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Welcome | Holy Family";
        $msg = "Hi there $first_name $last_name, we are happy to have you join us online, click here <a href=\"https://members.holyfamilycclc.org/\">link</a> to login our.";
        $msg = wordwrap($msg, 70);
        $headers = "From: no-reply@holyfamilycclc.org";
        $mailed = mail($to, $subject, $msg, $headers);

        $error = $createUser['error'];
        $_SESSION["feedback"] = "Sorry could not create User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Your account was Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../register.php?message0=$randms");
        exit();
    }
}
