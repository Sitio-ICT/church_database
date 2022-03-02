<?php

include('header.php');
$randms = generateRandomString(5);

if ($findPermissions['subscriptions'] != 1) {
    $_SESSION["feedback"] = "You do not have permission!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?message1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">TRANSACTIONS</h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Funding and Purchase</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Member</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Description</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findTransaction = findPayments();
                                foreach ($findTransaction as $transaction) {
                                    $profile = findProfile($transaction['profile_id']);
                                ?>
                                    <tr>
                                        <td><?php echo $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile['last_name'] ?></td>
                                        <td><?php echo $transaction['payment_type'] ?></td>
                                        <td><?php echo number_format($transaction['amount'], 2) ?></td>
                                        <th><?php echo $transaction['transaction_date'] ?></th>
                                        <th><?php echo $transaction['transaction_id'] ?></th>
                                        <th><?php echo $transaction['description'] ?></th>

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