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
                    <div style="float: left;">
                        <h6 class="m-0 font-weight-bold text-primary">Donations and Tithes</h6>
                    </div>
                    <div style="float: right;">
                        <b>Total: <span id="total"></span></b> 
                        <!-- || -->
                        <!-- <a href="#" class="btn btn-info btn-icon-split export" data-export-type="excel">
                            <span class="icon text-white-50">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                            </span>
                            <span class="text">Export EXCEL</span>
                        </a> -->
                        
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