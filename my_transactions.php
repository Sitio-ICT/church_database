<?php

include('header.php');
$randms = generateRandomString(5);

$findUser = findUser($profile_id);
$findClient = findProfile($findUser['profile_id']);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">TRANSACTIONS</h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float: left;">
                        <h6 class="m-0 font-weight-bold text-primary">Donations and Tithes</h6>
                    </div>
                    <div style="float: right;">
                        <b>Total: <span id="total"></span></b> ||
                        <a href="#" class="btn btn-info btn-icon-split export" data-export-type="excel">
                            <span class="icon text-white-50">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                            </span>
                            <span class="text">Export EXCEL</span>
                        </a>
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#fund">Donate</a>

                        <!-- Modal -->
                        <form id="paymentForm">
                            <div class="modal fade" id="fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Donate or Pay Tithe</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <input type="text" id="profile_id" value="<?php echo $profile_id ?>" name="client" hidden>
                                            <input type="text" name="email" id="email" value="<?php echo $findProfile['email'] ?>" hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount(NGN)...." required>
                                            </div>
                                            <div class="form-group">
                                                <select name="type" id="type" class="form-control">
                                                    <option value="Donation">Donation</option>
                                                    <option value="Tithe">Tithe</option>
                                                </select>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
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

                                                });
                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" onclick="payWithPaystack()">Fund</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            const paymentForm = document.getElementById('paymentForm');
                            paymentForm.addEventListener("submit", payWithPaystack, false);

                            function payWithPaystack(e) {
                                e.preventDefault();
                                let handler = PaystackPop.setup({
                                    key: 'pk_test_381f76fca3b0f850654e352c0424f2a6d78466e2', // Replace with your public key
                                    email: document.getElementById("email").value,
                                    payment_type: document.getElementById("payment_type").value,
                                    profile_id: document.getElementById("profile_id").value,
                                    amount: 100 * document.getElementById("amount").value,
                                    ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                    // label: "Optional string that replaces customer email"
                                    onClose: function() {
                                        alert('Window closed.');
                                    },
                                    callback: function(response) {
                                        // let message = 'Payment complete! Reference: ' + response.reference;
                                        // alert(message);
                                        $.ajax({
                                            url: 'https://members.holyfamilycclc.org/pay.php?reference=' + response.reference,
                                            method: 'get',
                                            success: function(response) {
                                                // the transaction status is in response.data.status
                                                // alert(response);
                                                if (response == "success") {
                                                    // alert(profile_id);
                                                    ajaxCall2();
                                                } else {
                                                    location.replace("transactions.php");
                                                }
                                            }
                                        });
                                    }
                                });
                                handler.openIframe();
                            }

                            function ajaxCall2() {

                                var payment_type = document.getElementById("payment_type").value;
                                var profile_id = document.getElementById("profile_id").value;
                                var amount = 100 * document.getElementById("amount").value;
                                $.ajax({
                                    url: 'https://members.holyfamilycclc.org/functions/operations/donate.php',
                                    method: 'post',
                                    data: {
                                        amount: amount,
                                        payment_type: payment_type,
                                        profile_id: profile_id
                                    },
                                    success: function(response2) {
                                        // the transaction status is in response.data.status
                                        if (response2 == "success") {
                                            location.replace("transactions.php");
                                        }
                                    }
                                });
                            }
                        </script>
                        <!-- /modal ends here -->
                        <!-- </form> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Description</th>
                                </tr>
                                <tr id="filterrow">
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
                                    <th colspan="6"></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findTransaction = findMembersPayments($profile_id);
                                foreach ($findTransaction as $transaction) {
                                    $profile = findProfile($profile_id);
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

<script>
    $(document).ready(function() {

        $('#dataTable2 thead tr#filterrow th').each(function() {
            var title = $('#dataTable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" onclick="stopPropagation(event);" placeholder="Search ' + title + '" />');
        });

        // DataTable
        var table = $('#dataTable2').DataTable({
            orderCellsTop: true,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                // Remove the formatting to get integer data for summation
                var intVal = function(i) {

                    if (typeof i === 'string') {
                        i = i.replace(/[\£,]/g, '') * 1;
                    }
                    // check if you got a valid number.
                    if (Number.isNaN(i)) {
                        return 0;
                    }
                    return i;
                };
                var intVal = function(i) {

                    if (typeof i === 'string') {
                        i = i.replace(/[\£,]/g, '') * 1;
                    }
                    // check if you got a valid number.
                    if (Number.isNaN(i)) {
                        return 0;
                    }
                    return i;
                };

                // Total over all pages
                var dance;
                total = api
                    .column(2)
                    .data()
                    .reduce(function(a, b) {
                        return dance = intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(4).footer()).html(
                    'Amount ' + pageTotal.toFixed(2) + ' ( Amount ' + total.toFixed(2) + ' total)'
                );
                // Update Header
                var answer = 'Amount ' + pageTotal.toFixed(2) + ' ( Amount ' + total.toFixed(2) + ' total)';
                $('#total').html(answer);
                // let isNaN = (maybeNaN) => maybeNaN != maybeNaN;
                // console.log(isNaN(pageTotal));
                // console.log(intVal);
            }

        });

        // Apply the filter
        $("#dataTable2 thead input").on('keyup change', function() {
            table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });

        function stopPropagation(evt) {
            if (evt.stopPropagation !== undefined) {
                evt.stopPropagation();
            } else {
                evt.cancelBubble = true;
            }
        }
        $(".export").click(function() {
            var export_type = $(this).data('export-type');
            $('#dataTable2').tableExport({
                type: export_type,
                escape: 'false',
                ignoreColumn: []
            });
        });

    });
</script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<?php

include('footer.php');

?>