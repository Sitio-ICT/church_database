<?php
include("../../methods.php");
session_start();
$randms = generateRandomString(7);

if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username'])) {
    // initiialize post data

    $profile_id = $_POST['profile_id'];
    $clientId = $_POST['client'];
    $userData = [
        'first_name' => test_input($_POST['first_name']),
        'middle_name' => test_input($_POST['middle_name']),
        'last_name' => test_input($_POST['last_name']),
        'maiden_name' => test_input($_POST['maiden_name']),
        'sex' => test_input($_POST['sex']),
        'marital_status' => test_input($_POST['marital_status']),
        'd_o_wedding' => test_input($_POST['dow']),
        'd_o_b' => test_input($_POST['dob']),
        'state_of_origin' => test_input($_POST['state']),
        'phone_no' => test_input($_POST['phone']),
        'email' => test_input($_POST['email']),
        'residentail_address' => test_input($_POST['address']),
        'religion' => test_input($_POST['religion'])
    ];

    $updateUser =  update('profile', $profile_id, 'id', $userData);
    if ($updateUser) {
        // Send email to user with the token in a link they can click on
        $to = $_POST['email'];
        $subject = "Profile Update | Holy Family";
        $msg = "
        <html> 
        <body> 
            <p style=\"text-align:center;height:100px;background-color:#abc;border:1px solid #456;border-radius:3px;padding:10px;\">
                Hi there $first_name $last_name, your profile has be <b>updated successfully</b>. If this was not done by you or with your permission, kindly contact the church. Thank you.
            </p>
        </body>
        </html>";
        $headers = "From: no-reply@holyfamilycclc.org\r\n";
        $headers .= "Content-type: text/html\r\n";
        $mailed = mail($to, $subject, $msg, $headers);

        $_SESSION["feedback"] = "Your account was Successfuly created";
        echo header("Location: ../../../client_view.php?view=$clientId&message0=$randms");
        exit();
    } else {
        $error = mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not Update User! - $error";
        echo header("Location: ../../../client_view.php?view=$clientId&message1=$randms");
        exit();
    }
}
