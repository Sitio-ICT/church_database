<?php

include("../../connect.php");
session_start();
$userId = $_SESSION['userid'];
echo $today = date('Y-m-d');

$supportId = $_POST['support'];
if (isset($_POST['support'])) {
    $commentData = [
        'comment' => $_POST['chat'],
        'support_id' => $supportId,
        'userid' => $userId,
        'admin_viewed' => 1
    ];
    $storeComment = insert('support_comments', $commentData);
    if (!$storeComment) {
        printf('Error: %s\n', mysqli_error($connection)); //checking for errors
        exit();
    } else {
        $findSupport = selectOne('support', ['id' => $supportId]);
        $clientId = $findSupport['users_id'];
        $ticket = $findSupport['ticket_id'];
        $type = $findSupport['type'];
        $decription = "YOUR $type $ticket HAS BEEN UPDATED AND";
        $notificationData = [
            'support_id' => $supportId,
            'description' => $decription,
            'userid' => $clientId,
            'action_by' => $userId,
        ];
        insert('notifications', $notificationData);
        //output
        $findComment = selectAll('support_comments', ['support_id' => $supportId]);
        foreach ($findComment as $comment) {
            $findUser = selectOne('users', ['id' => $comment['userid']]);
            if($findUser['usertype'] == "ADMIN"){
                $color = "danger";
            }else{
                $color = "primary";
            }

?>
            <!-- <div class="card mb-4 py-3 border-left-warning"> -->
            <!-- <div class="card-body"> -->
            <div class="card mb-4 py-3 border-left-<?php echo $color ?>">
                <div class="card-body">
                    <p>
                        <b><?php echo $comment['comment'] ?></b>
                    </p>
                    <p>
                        <b>User:</b> <?php

                                        $findUser = selectOne('users', ['id' => $comment['userid']]);
                                        echo $findUser['username'];
                                        ?>
                    </p>
                    <hr>
                    <p>
                        <i>DATE: <?php echo $comment['created_date'] ?></i>
                    </p>
                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
<?php
        }
    }
}
