<?php

include('header.php');

$findAccount = selectOne('accounts', ['users_id' => $userId]);


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"> MY ACCOUNT </h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#bookLoan">
                            <span class="icon text-white-50">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <span class="text">Fund Account</span>
                        </a>
                    </div>
                    <!-- Modal -->
                    <form action="functions/business/fixed_deposit/book_deposit.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="modal fade" id="bookLoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Fund Toolshop Account</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $investorId ?>" name="investor" hidden>
                                        <input type="text" value="<?php echo $baranchId ?>" name="branch" hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="principal" name="principal" placeholder="Amount BTC...." required>
                                        </div>
                                        
                                        <script>
                                            $(document).ready(function() {
                                                $('#principal').on("change blur", function() {
                                                    var amount = $(this).val();
                                                    $.ajax({
                                                        url: "functions/system/converter.php",
                                                        method: "POST",
                                                        data: {
                                                            amount: amount
                                                        },
                                                        success: function(data) {
                                                            $('#principal').val(data);
                                                        }
                                                    })
                                                });

                                            });
                                        </script>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Fund</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /modal ends here -->
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="form-group">
                            <label for="">Account Balance</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo number_format($findAccount['account_balance'], 2) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Total Deposit</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo number_format($findAccount['total_deposit'], 2) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Total Withdrawal</label>
                            <input type="text" class="form-control form-control-user" value="<?php echo number_format($findAccount['total_withdrawal'], 2) ?>" readonly>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <!-- account transactions -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transactions Statement</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $accountUserId = $findAccount['id'];
                                $findTransactions = selectAll('transaction', ['accounts_id' => $accountUserId]);
                                foreach ($findTransactions as $transaction) {
                                ?>
                                    <tr>
                                        <td> <?php echo $transaction['transaction_type'] ?></td>
                                        <td><?php echo number_format($transaction['amount'], 2) ?></td>
                                        <td><?php echo $transaction['transaction_date'] ?></td>

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
        <!-- /account Transactions -->



    </div>

</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>