<?php

include('header.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">MANUAL TRANSACTIONS</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Record Transaction</h6>
                </div>
                <div class="card-body">
                    <form action="functions/operations/manual_transaction.php" method="post">
                        
                        <div class="form-group">
                            <label for="">Member</label>
                            <input type="text" name="indetifier" id="identifier" class="form-control">
                        </div>
                        <div id="member"></div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Transaction Type</label>
                            <select name="payment_type" id="payment_type" class="form-control" required>
                                <option value="Donation">Donation</option>
                                <option value="Subscription">Subscription</option>
                                <option value="Tithe">Tithe</option>
                            </select>
                        </div>
                        <div id="sub_model"></div>
                        <script>
                            $(document).ready(function() {
                                $('#identifier').on("keyup change blur", function() {
                                    var identifier = $(this).val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/members.php",
                                        method: "POST",
                                        data: {
                                            identifier: identifier
                                        },
                                        success: function(data) {
                                            $('#member').html(data);
                                        }
                                    })
                                });
                                $('#amount').on("change blur", function() {
                                    var amount = $(this).val();
                                    $.ajax({
                                        url: "functions/system/converter.php",
                                        method: "POST",
                                        data: {
                                            amount: amount
                                        },
                                        success: function(data) {
                                            $('#amount').val(data);
                                        }
                                    })
                                });
                                $('#payment_type').on("click change blur", function() {
                                    var payment_type = $(this).val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/payment_type.php",
                                        method: "POST",
                                        data: {
                                            payment_type: payment_type
                                        },
                                        success: function(data) {
                                            $('#sub_model').html(data);
                                        }
                                    })
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary">Record Payment</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>