<?php

include("../../methods.php");
session_start();
$randms = generateRandomString(7);

$clientId = $_POST['client'];
if (isset($_POST['profile_id']) && isset($_POST['member'])) {
    // initiialize post data

    $profile_id = $_POST['profile_id'];
    $userData = [
        'profile_id' => $profile_id,
        'related_to' => $_POST['member'],
        'relationship_type' => test_input($_POST['realationship'])
    ];

    // find if relationship already created
    $findRelationship = findRelationships($profile_id);
    foreach ($findRelationship as $relations) {
        if ($findRelationship['profile_id'] == $profile_id or $findRelationship['related_to'] == $profile_id) {
            // dd($profile_id);
            $_SESSION["feedback"] = "Relationship Already Recorded";
            echo header("Location: ../../../client_view.php?view=$clientId&message1=$randms");
            exit();
        }
    }
    
    $relationDetails = findProfile($_POST['member']);
    $first_name = $relationDetails['first_name'];
    $last_name = $relationDetails['last_name'];
    $relationShip = $_POST['relationship'];
    $personDetails = findProfile($profile_id);
    $perons_first_name = $personDetails['first_name'];
    $perons_last_name = $personDetails['last_name'];


    $adsRelationship =  insert('relationships', $userData);
    // dd($adsRelationship);
    if ($adsRelationship) {
        // Send email to user with the token in a link they can click on
        $to = $relationDetails['email'];
        $subject = "Relationship Details | Holy Family";
        $msg = "
        <html> 
        <body> 
            <p style=\"text-align:center;height:100px;background-color:#abc;border:1px solid #456;border-radius:3px;padding:10px;\">
                Hi there $first_name $last_name, <br>$persons_first_name $persons_last_name has recorderd you as their <b>$relationship</b> on the Holy Family Member site. If this was not done by you or with your permission, kindly contact the church. Thank you.
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
} else {
    $_SESSION["feedback"] = "Fill in all required fields";
    echo header("Location: ../../../client_view.php?view=$clientId&message1=$randms");
    exit();
}
