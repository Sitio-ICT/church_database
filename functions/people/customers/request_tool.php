<?php
include("../../connect.php");
session_start();
$userId = $_SESSION['userid'];
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$ticketid = "RE-$randms";
$today = date('Y-m-d');

if (isset($_POST['importance']) && isset($_POST['quantity']) && isset($_POST['need']) && isset($_POST['request'])) {
    $importance = $_POST['importance'];
    $quantity = $_POST['quantity'];
    $need = $_POST['need'];
    $request = $_POST['request'];

    // find random support staff to assign ticket to
    $assignSupport =  selectOneRandDesc('users', ['usertype' => 'ADMIN', 'rank' => 1]);
    $supportPersonnel = $assignSupport['id'];
    $ticketCount = $assignSupport['ticket_count'] + 1;
    $updatePersonnel = mysqli_query($connection, "UPDATE users SET ticket_count = $ticketCount WHERE id = '$supportPersonnel'");

    $requestData = [
        'users_id' => $userId,
        'request' => $request,
        'importance' => $importance,
        'need' => $need,
        'quantity' => $quantity,
        'date' => $today,
        'status' => 'Pending'
    ];

    $storeRequest = insert('request', $requestData);
    if (!$storeRequest) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not make request - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client/index.php?message1=$randms");
        exit();
    } else {
        $complaint = "I need $quantity $need";
        $ticketData = [
            'topic' => $request,
            'ticket_id' => $ticketid,
            'urgency' => $importance,
            'complaint' => $complaint,
            'type' => 'REQUEST',
            'products_id' => 0,
            'users_id' => $userId,
            'admin' => $supportPersonnel,
            'request_id' => $storeRequest,
            'is_resolved' => 0,
            'viewed' => 1
        ];
        $createTicket = insert('support', $ticketData);
        $decription = "REQUEST $ticketid HAS BEEN CREATED";
        $notificationData = [
            'support_id' => $createTicket,
            'description' => $decription,
            'userid' => 0,
            'action_by' => $userId,
            'status' => 2
        ];
        insert('notifications', $notificationData);
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        // dd($error);
        $_SESSION["feedback"] = "Request successfully made";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../client/index.php?message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Kindly fill all necessary details";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../../client/index.php?message1=$randms");
    exit();
}
