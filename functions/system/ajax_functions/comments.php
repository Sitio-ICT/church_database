<?php
include("../../connect.php");

$supportId = $_POST['support'];
if (isset($_POST['support'])) {

    $findComment = selectAll('support_comments', ['support_id' => $supportId]);
    foreach ($findComment as $comment) {
        $findUser = selectOne('users', ['id' => $comment['userid']]);
            if($findUser['usertype'] == "ADMIN"){
                $color = "danger";
            }else{
                $color = "primary";
            }

?>
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
<?php
    }
}

?>