<?php

session_start();
include("../methods.php");
$randms = generateRandomString(15);
$today = date("Y-m-d");

// Processing form data when form is submitted
if (isset($_POST['person']) && isset($_POST['mass_intention'])) {

    $person = test_input($_POST['person']);
    $mass_intention = test_input($_POST['mass_intention']);
    $day = test_input($_POST['day']);
    $time = test_input($_POST['time']);
    $profile_id = test_input($_POST['profile_id']);
    $amount = $_POST['amount'] / 100;

    // create feed
    $feed_created = create('mass_booking', ['person' => $person, 'mass_intention' => $mass_intention, 'day' => $day, 'mass_time' => $time, 'status' => 0, 'profile_id' => $profile_id]);

    if ($feed_created) {
        $storePayment = makePayment($profile_id, 'Mass Booking', 0, $amount, "Mass booked $today", $today, $randms);

        $to = $_SESSION['email'];
        $subject = "Mass Booking | Holy Family";
        $msg = "Hey, <br> You just booked mass at Holy Family Church, thank you for worshiping with us, may God grant you your heart desires. Amen.";
        $msg = "
        <html> 
        <body> 
            <p style=\"text-align:center;height:100px;background-color:#abc;border:1px solid #456;border-radius:3px;padding:10px;\">
                Hey, <br> You just booked mass at Holy Family Church, thank you for worshiping with us, may God grant you your heart desires. Amen.
            </p>
        </body>
        </html>";
        $headers = "From: no-reply@holyfamilycclc.org\r\n";
        $headers .= "Content-type: text/html\r\n";
        $mailed = mail($to, $subject, $msg, $headers);
        // $_SESSION["feedback"] = "Mass Successfully Booked";
        // $_SESSION["Lack_of_intfund_$randms"] = "10";
        // echo header("Location: ../../book_mass.php?&message0=$randms");
        // exit();
        $output = "success";
    } else {
        // $error = $storePayment['error'];
        // $_SESSION["feedback"] = "Sorry could not complete Transaction! - $error";
        // $_SESSION["Lack_of_intfund_$randms"] = "10";
        // echo header("Location: ../../transactions.php?message1=$randms");
        // exit();
        $output = "error";
    }
    echo $output;
}
