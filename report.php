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

if ($_GET['status'] == 1) {
    update('support', 'REQUEST', 'type', ['admin_viewed' => 1]);
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
                    <h6 class="m-0 font-weight-bold text-primary">REPORT</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Complaint Type</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Topic</th>
                                    <th>Complaint Type</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findTicket = selectAll('support', ['type' => 'REPORT']);
                                foreach ($findTicket as $ticket) {
                                ?>
                                    <tr>
                                        <td><?php echo $ticket['topic']; ?></td>
                                        <th><?php echo $ticket['complaint'] ?></th>
                                        <td>
                                            <?php
                                            if ($ticket['products_id'] > 0) {
                                                $productId =  $ticket['products_id'];
                                                $findProduct = selectOne('products', ['id' => $productId]);
                                                echo $findProduct['product_type'];
                                            } else {
                                                echo $ticket['type'];
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $ticket['urgency'] ?></th>
                                        <th>
                                            <?php
                                            if ($ticket['is_resolved'] == 0) {
                                                echo "Pending";
                                            } else {
                                                echo "Resolved";
                                            }
                                            ?>
                                        </th>
                                        <th>
                                            <a href="support_ticket.php?view=<?php echo $ticket['id'] ?>" class="btn btn-info btn-icon-split">
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

<?php

include('footer.php');

?>