<?php
include("../../methods.php");
$randms = generateRandomString(5);
session_start();

if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['passkey']) && isset($_POST['confirm_passkey'])) {
    // initiialize post data

    $first_name = test_input($_POST['firstname']);
    $last_name = test_input($_POST['lastname']);
    $passkey = test_input($_POST['passkey']);
    $email = test_input($_POST['email']);
    $confirmed_passkey = test_input($_POST['confirm_passkey']);
    $username = test_input($_POST['username']);
    $user_type = $_POST['usertype'];
    $findEmail = findEmail($email);
    if ($findEmail != "Okay!") {
        $_SESSION["feedback"] = "Email is in use by another user!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message1=$randms");
        exit();
    }
    if ($passkey != $confirmed_passkey) {
        $_SESSION["feedback"] = "Password does not match!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message1=$randms");
        exit();
    }

    if (isset($_POST['users']) == 1) {
        $users = 1;
    } else {
        $users = 0;
    }
    if (isset($_POST['transaction']) == 1) {
        $transaction = 1;
    } else {
        $transaction = 0;
    }
    if (isset($_POST['config']) == 1) {
        $config = 1;
    } else {
        $config = 0;
    }
    if (isset($_POST['feeds']) == 1) {
        $feeds = 1;
    } else {
        $feeds = 0;
    }
    if (isset($_POST['mass_booking']) == 1) {
        $mass_booking = 1;
    } else {
        $mass_booking = 0;
    }
    if (isset($_POST['mass_booking']) == 1) {
        $others = 1;
    } else {
        $others = 0;
    }

    // dd($support);
    // $password = password_hash($passkey, PASSWORD_DEFAULT);

    $createUser =  createUser($username, $passkey, $first_name, $last_name, $email, $user_type);

    if ($createUser['status'] != "success") {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not create User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message1=$randms");
        exit();
    } else {
        $permissionData = [
            'feeds' => $feeds,
            'user_management' => $users,
            'mass_booking' => $mass_booking,
            'configurations' => $config,
            'subscriptions' => $transaction,
            'others' => $others,
            'users_id' => $createUser['id']
        ];
        insert('permissions', $permissionData);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Welcome | Holy Family";
        $msg = "Hi there $first_name $last_name, we are happy to have you join us online, click here <a href=\"https://members.holyfamilycclc.org/\">link</a> to login our.";
        $msg = wordwrap($msg, 70);
        $headers = "From: no-reply@holyfamilycclc.org";
        $mailed = mail($to, $subject, $msg, $headers);

        $_SESSION["feedback"] = "User Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../users.php?message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Fill in all required fields! - $error";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../../users.php?message1=$randms");
    exit();
}
