<?php

include("../../connect.php");
session_start();
$userId = $_SESSION['userid'];
$today = date('Y-m-d');

$supportId = $_POST['support'];
if (isset($_POST['support'])) {
    $commentData = [
        'comment' => $_POST['chat'],
        'support_id' => $supportId,
        'userid' => $userId,
        'viewed' => 1
    ];
    $storeComment = insert('support_comments', $commentData);
    if (!$storeComment) {
        printf('Error: %s\n', mysqli_error($connection)); //checking for errors
        exit();
    } else {
        $findSupport = selectOne('support', ['id' => $supportId]);
        $clientId = $findSupport['admin'];
        $ticket = $findSupport['ticket_id'];
        $type = $findSupport['type'];
        $decription = "$type $ticket HAS BEEN UPDATED AND";
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
            if ($findUser['usertype'] == "ADMIN") {
                $color = "danger";
                if ($findUser['rank'] == 1) {
                    $username = "Admin";
                } else {
                    $username = "Support";
                }
            } else {
                $color = "primary";
                $username = $findUser['username'];
            }
?>
            <style>
                .card22 {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    background-color: #fff;
                    background-clip: border-box;
                    border: 1px solid #e3e6f0;
                    border-radius: 0.35rem;
                }

                .card22>hr {
                    margin-right: 0;
                    margin-left: 0;
                }

                .card2-body {
                    flex: 1 1 auto;
                    min-height: 1px;
                    padding: 1.25rem;
                }

                .card2-title {
                    margin-bottom: 0.75rem;
                }


                .card2-header {
                    padding: 0.75rem 1.25rem;
                    margin-bottom: 0;
                    background-color: #f8f9fc;
                    border-bottom: 1px solid #e3e6f0;
                }

                .card2-header:first-child {
                    border-radius: calc(0.35rem - 1px) calc(0.35rem - 1px) 0 0;
                }

                .card2-footer {
                    padding: 0.75rem 1.25rem;
                    background-color: #f8f9fc;
                    border-top: 1px solid #e3e6f0;
                }

                .pt-3,
                .py-3 {
                    padding-top: 1rem !important;
                }

                .mb-4,
                .my-4 {
                    margin-bottom: 1.5rem !important;
                }

                .border-left {
                    border-left: 1px solid #e3e6f0 !important;
                }

                .border-left-primary {
                    border-left: 0.25rem solid #4e73df !important;
                }

                .border-left-danger {
                    border-left: 0.25rem solid #e74a3b !important;
                }
            </style>
            <div class="card2 mb-4 py-3 border-left-<?php echo $color ?>">
                <div class="card2-body">
                    <h5><b>User:</b>
                        <?php
                        echo $username
                        ?>
                    </h5>
                    <hr>

                    <p>
                        <b><?php echo $comment['comment'] ?></b>
                    </p>

                    <hr>
                    <p>
                        <i>DATE: <?php echo $comment['created_date'] ?></i>
                    </p>
                </div>
            </div>
<?php
        }
    }
}
