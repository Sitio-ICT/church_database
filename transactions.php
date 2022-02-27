<?php

include('header.php');

if ($findRights['transactions'] != 1) {
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
                                    <th>User</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>User</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Product</th>
                                    <th>Description</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findTransaction = selectAllWithOrder('transaction', [''], 'id', 'DESC');
                                foreach ($findTransaction as $transaction) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $accountId = $transaction['accounts_id'];
                                            $findAccount = selectOne('accounts',  ['id' => $accountId]);
                                            $clientId = $findAccount['users_id'];
                                            $findUser = selectOne('users',  ['id' => $clientId]);
                                            echo $findUser['username'];
                                            ?>
                                        </td>
                                        <td><?php echo $transaction['transaction_type'] ?></td>
                                        <td><?php echo number_format($transaction['amount'], 2) ?></td>
                                        <th><?php echo $transaction['transaction_date'] ?></th>
                                        <th><?php echo $transaction['reference_id'] ?></th>
                                        <td><?php
                                            $transactionId = $transaction['id'];
                                            $findPurchase = selectOne('purchase',  ['transaction_id' => $transactionId]);
                                            $productId = $findPurchase['products_id'];
                                            if ($findPurchase['product_type'] == 'sms') {
                                                echo "SMS";
                                            } else {
                                                $findProduct = selectOne('products',  ['id' => $productId]);
                                                if ($findProduct['product_type'] != "rdp") {
                                                    echo $findProduct['product_name'];
                                                } else {
                                                    echo $findProduct['product_type'];
                                                }
                                                if ($transaction['transaction_type'] == "REFUND") {
                                                    $purchaseId = $transaction['purchase_id'];
                                                    $findPurchase = selectOne('purchase',  ['id' => $purchaseId]);
                                                    $productId = $findPurchase['products_id'];
                                                    $findProducts = selectOne('products',  ['id' => $productId]);
                                                    if ($findProducts['product_type'] != "rdp") {
                                                        echo $findProducts['product_name'];
                                                    } else {
                                                        echo $findProducts['product_type'];
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($findPurchase['product_type'] == 'sms') {
                                                echo "SMS number purchase";
                                            } else {
                                                if ($transaction['transaction_type'] == "REFUND") {
                                                    echo $findProducts['description'];
                                                } else {
                                                    echo $findProduct['description'];
                                                }
                                            }
                                            ?>
                                        </td>

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