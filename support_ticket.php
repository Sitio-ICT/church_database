<?php

include('header.php');

$supportId = $_GET["view"];
$findSupport = selectOne('support', ['id' => $supportId]);
$type = $findSupport['type'];

$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($viewer != "ALL") {
    if ($type != $viewer) {
        $_SESSION["feedback"] = "You do not have Support permission!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        // using js so as to aviod header error
?>
        <script>
            location.replace("index.php?message1=<?php echo $randms ?>");
        </script>
<?php
        exit();
    }
}

if ($_GET['status'] == 1) {
    if ($rank == 1) {
        if ($findSupport['type'] == "REQUEST") {
            mysqli_query($connection, "UPDATE notifications SET viewed = 1 WHERE support_id = $supportId");
            mysqli_query($connection, "UPDATE support SET admin_viewed = 1 WHERE id = $supportId");
        } else {
            mysqli_query($connection, "UPDATE notifications SET viewed = 1 WHERE support_id = $supportId AND userid = 0");
            mysqli_query($connection, "UPDATE support SET admin_viewed = 1 WHERE id = $supportId");
        }
    } else {
        mysqli_query($connection, "UPDATE notifications SET viewed = 1 WHERE support_id = $supportId AND userid = $userId");
        mysqli_query($connection, "UPDATE support SET admin_viewed = 1 WHERE id = $supportId");
    }
}


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findSupport['topic'] . " - " . $findSupport['ticket_id'] ?></h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resolutions</h6>
                </div>
                <div class="card-body">
                    <?php
                    if ($findSupport['type'] != "REQUEST") {
                    ?>
                        <div id="display_support"></div>
                        <!-- <form action=""> -->
                        <input type="text" id="support-id" value="<?php echo $supportId ?>" hidden>
                        <div class="form-group">
                            <textarea name="chat" id="chat" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <button class="btn btn-info" id="submitchat">Submit</button>
                        <!-- </form> -->
                        <script>
                            $(document).ready(function() {
                                $('#support-id').ready(function() {
                                    var support = $('#support-id').val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/comments.php",
                                        method: "POST",
                                        data: {
                                            support: support
                                        },
                                        success: function(data) {
                                            $('#display_support').html(data);
                                        }
                                    })
                                });

                                //    complete comment section
                                $('#submitchat').on("click", function() {
                                    var support = $('#support-id').val();
                                    var chat = $('#chat').val();
                                    var ticket = $('#ticket').val();

                                    $.ajax({
                                        url: "functions/system/ajax_functions/create_comment_admin.php",
                                        method: "POST",
                                        data: {
                                            support: support,
                                            chat: chat,
                                        },
                                        success: function(data) {
                                            $('#display_support').html(data);
                                            $('#chat').val("");
                                        }
                                    })
                                });
                            });
                        </script>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- loan info -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Support Details</h6>
                    </div>
                </div>
                <div class="card-body">

                    <?php
                    if ($findSupport['type'] == "REQUEST") {
                        $findRequest = selectOne('request', ['id' => $findSupport['request_id']])
                    ?>
                        <div class="form-group">
                            <label for="">My Request Is</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findRequest['request'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Importance</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findRequest['importance'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Need</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findRequest['need'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findRequest['quantity'] ?>" readonly>
                        </div>
                        <?php
                    } else {
                        if ($findSupport['products_id'] != 0) {
                            $findProduct = selectOne('products', ['id' => $findSupport['products_id']]);
                            $productId = $findProduct['id'];
                        ?>
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findProduct['description'] ?>" readonly>
                            </div>
                            <?php
                            if ($findProduct['product_type'] != "rdp") {
                                $productValue = json_decode($findProduct['meta'], true);
                                foreach ($productValue as $key => $value) {
                            ?>
                                    <div class="form-group">
                                        <label for=""><?php echo $key ?></label>
                                        <input type="text" class="form-control form-control-user" value="<?php echo $value ?>" readonly>
                                    </div>
                                <?php
                                }
                            } else {
                                $findRdp = selectOne('rdp_request', ['products_id' => $productId, 'userid' => $findSupport['users_id'], 'purchase_id' => $findSupport['purchase_id']]);
                                $rdpData = json_decode($findRdp['meta'], true);
                                foreach ($rdpData as $key => $value) {
                                ?>
                                    <div class="form-group">
                                        <label for=""><?php echo $key ?></label>
                                        <input type="text" class="form-control form-control-user" value="<?php echo $value ?>" readonly>
                                    </div>
                        <?php
                                }
                            }
                        }

                        ?>
                        <div class="form-group">
                            <label for="">Topic</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findSupport['topic'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Complaint</label>
                            <textarea readonly class="form-control form-control-user" cols="30" rows="10"><?php echo $findSupport['complaint'] ?></textarea>
                        </div>
                        <?php
                        if ($findSupport['product_name'] == "sms") {
                            $findRdp = selectOne('purchase', ['userid' => $findSupport['users_id'], 'id' => $findSupport['purchase_id']]);
                            $rdpData = json_decode($findRdp['value'], true);
                            foreach ($rdpData as $key => $value) {
                        ?>
                                <div class="form-group">
                                    <label for=""><?php echo $key ?></label>
                                    <input type="text" class="form-control form-control-user" value="<?php echo $value ?>" readonly>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label for="">Urgency</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $findSupport['urgency'] ?>" readonly>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($findSupport['is_resolved'] == 0 or $findSupport['is_resolved'] == 3) {
                        if ($findSupport['is_resolved'] == 3) {
                            $title = "Pushed to Admin";
                        } else {
                            $title = "Open";
                        }
                    ?>
                        <div class="form-group">
                            <label for="">Resolved</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo $title ?>" readonly>
                        </div>
                        <?php
                        if ($findSupport['products_id'] > 0 or $findSupport['product_name'] == "sms") {
                        ?>
                            <a href="functions/business/refund.php?refund=<?php echo $supportId ?>&purchase=<?php echo $findSupport['purchase_id'] ?>" class="btn btn-success">Refund</a>
                        <?php
                        }
                        ?>
                        <a href="functions/business/resolved.php?resolve=<?php echo $supportId ?>" class="btn btn-success">Close</a>
                        <?php
                        if ($findSupport['is_resolved'] == 0) {
                        ?>
                            <a href="functions/business/admin_push.php?resolve=<?php echo $supportId ?>" class="btn btn-warning">Push to Admin</a>
                        <?php
                        }
                        ?>
                    <?php
                    } else if ($findSupport['is_resolved'] == 1) {
                    ?>
                        <div class="form-group">
                            <label for="">Resolved</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo "Closed" ?>" readonly>
                        </div>
                    <?php
                    } else if ($findSupport['is_resolved'] == 2) {
                    ?>
                        <div class="form-group">
                            <label for="">Resolved</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo "Refunded" ?>" readonly>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <!-- /loan info -->


    </div>

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>