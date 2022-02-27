<?php

include('header.php');
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findRights['support'] != 1) {
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
$view = $_GET['view'];
if ($_GET['status'] == 1) {
    update('support', 'REQUEST', 'type', ['admin_viewed' => 1]);
} else if ($_GET['status'] == 2) {
    update('support', 'TICKET', 'type', ['admin_viewed' => 1]);
}
if ($viewer != "ALL") {
    if ($view != $viewer) {
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
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">SUPPORT</h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $view ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Topic</th>
                                    <th><?php echo $view ?> ID</th>
                                    <th><?php echo $view ?> Info</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>User</th>
                                    <th>Topic</th>
                                    <th><?php echo $view ?> ID</th>
                                    <th><?php echo $view ?> Info</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                if ($rank == 1) {
                                    $findTicket = selectAllWithOrder('support', ['type' => $view], 'id', 'DESC');
                                } else {
                                    $findTicket = selectAllWithOrder('support', ['type' => $view, 'admin' => $userId], 'id', 'DESC');
                                }
                                foreach ($findTicket as $ticket) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $clientId = $ticket['users_id'];
                                            $findUser = selectOne('users',  ['id' => $clientId]);
                                            echo $findUser['username'];
                                            ?>
                                        </td>
                                        <td><?php echo $ticket['topic']; ?></td>
                                        <td><?php echo $ticket['ticket_id']; ?></td>
                                        <th><?php echo $ticket['complaint'] ?></th>
                                        <td>
                                            <?php
                                            if ($ticket['products_id'] > 0) {
                                                $productId =  $ticket['products_id'];
                                                $findProduct = selectOne('products', ['id' => $productId]);
                                                echo $findProduct['product_type'];
                                            } else {
                                                echo $ticket['product_name'];
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $ticket['urgency'] ?></th>
                                        <th>
                                            <?php
                                            if ($ticket['is_resolved'] == 0) {
                                                if ($ticket['admin_viewed'] == 0) {
                                                    echo "<span style='color: red'><i class='far fa-circle' style='font-size: 22px;'></i> New</span>";
                                                } else {
                                                    echo "<span style='color: yellow'><i class='far fa-circle' style='font-size: 22px;'></i> Open</span>";
                                                }
                                            } else if ($ticket['is_resolved'] == 1) {
                                                echo "<span style='color: green'><i class='far fa-circle' style='font-size: 22px;'></i> Closed</span>";
                                            } else if ($ticket['is_resolved'] == 2) {
                                                echo "<span style='color: green'><i class='far fa-circle' style='font-size: 22px;'></i> Refunded</span>";
                                            } else if ($ticket['is_resolved'] == 3) {
                                                echo "<span style='color: green'><i class='far fa-circle' style='font-size: 22px;'></i> Pushed to Admin</span>";
                                            }
                                            ?>
                                        </th>
                                        <th>
                                            <a href="support_ticket.php?view=<?php echo $ticket['id'] ?>&status=1" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">View</span>
                                            </a>
                                        </th>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<!-- /.container-fluid -->
<!-- <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 100,
        });
    });
</script> -->
<?php

include('footer.php');

?>