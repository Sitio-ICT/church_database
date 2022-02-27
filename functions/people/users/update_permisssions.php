<?php
include("../../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['user'])) {
    $userId =  $_POST['user'];
    $rank = $_POST['rank'];
    if($rank == 1){
        $approval = 1;
        $transaction = 1;
        $product = 1;
        $support = 1;
    }else{
        $support = 1;
        if(isset($_POST['approve']) == 1){
            $approval = 1;
        }else{
            $approval = 0;
        }
        if(isset($_POST['transaction']) == 1){
            $transaction = 1;
        }else{
            $transaction = 0;
        }
        if(isset($_POST['product']) == 1){
            $product = 1;
        }else{
            $product = 0;
        }
    } 

    $permissionData = [
        'approval' => $approval,
        'support' => $support,
        'product' => $product,
        'transactions' => $transaction
    ];
    $updateUser = update('users', $userId, 'id', ['rank' => $rank]);
    $updatePermissions = update('permissions', $userId, 'user', $permissionData);
    if (!$updatePermissions) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not update permissions! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../user_view.php?view=$userId&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "User permissions Successfuly updated";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../user_view.php?view=$userId&message0=$randms");
        exit();
    }
}else{
    $_SESSION["feedback"] = "Something went wrong could not find user!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../../users.php?message1=$randms");
    exit();
}
