<?php

include('header.php');

$clientId = $_GET["view"];
$findUser = findUser($clientId);
$findClient = findProfile($findUser['profile_id']);


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findClient['first_name'] . " " . $findClient['middle_name'] . " " . $findClient['last_name'] ?></h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bio Info</h6>
                </div>
                <div class="card-body">
                    <!-- <form action=""> -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findUser['username'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Religion</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['religion'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Sex</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['sex'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Date of Birth</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['d_o_b'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Marital status</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['marital_status'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Date of Wedding</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['d_o_wedding'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="form-group">
                                <label for="">State of origin</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['state_of_origin'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Registration No</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['registration_no'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Registration Date</label>
                                <input type="text" class="form-control form-control-user" value="<?php echo $findClient['registration_date'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Contact Details</label>
                            </div>
                            <p>
                                <i class="fas fa-envelope"></i> : <a href="mailto:<?php echo $findClient['email'] ?>"><?php echo $findClient['email'] ?></a>
                            </p>
                            <p>
                                <i class="fas fa-phone"></i> : <a href="tel:<?php echo $findClient['phone_no'] ?>"><?php echo $findClient['phone_no'] ?></a>
                            </p>
                            <p>
                                <i class="fas fa-home"></i> : <a href="tel:<?php echo $findClient['residentail_address'] ?>"><?php echo $findClient['residentail_address'] ?></a>
                            </p>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="">Status</label>
                        <input type="text" class="form-control form-control-user" value="<?php echo $findUser['status'] ?>" readonly>
                    </div>
                    <?php
                    if ($findUser['status'] == "ACTIVE") {
                    ?>
                        <a href="functions/people/customers/ban.php?ban=<?php echo $clientId ?>" class="btn btn-danger ">Block User</a>
                    <?php
                    } else {
                    ?>
                        <a href="functions/people/customers/activate.php?active=<?php echo $clientId ?>" class="btn btn-success ">Activate</a>
                    <?php
                    }
                    ?>
                    <a href="#" class="btn btn-info " data-toggle="modal" data-target="#fund">Donate</a>

                    <!-- Modal -->
                    <form action="functions/business/fund_account.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="modal fade" id="fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Fund Account</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $clientId ?>" name="client" hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="principal" name="amount" placeholder="Amount($)...." required>
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
                    <!-- </form> -->

                </div>
            </div>
        </div>

        <!-- relationships comes here -->
        <!-- ends here -->

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Sacraments</h6>
                    </div>
                    <div style="float:right">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Sacrament</th>
                                    <th>Description</th>
                                    <th>Minister</th>
                                    <th>Date Receieved</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Sacrament</th>
                                    <th>Description</th>
                                    <th>Minister</th>
                                    <th>Date Receieved</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findSacramentsRecieved = findSacramentReceived($profile_id);
                                foreach ($findSacramentsRecieved as $received) {
                                    $sacrament = findSacrament($received['sacrament_id']);
                                ?>
                                    <tr>
                                        <td><?php echo $sacrament['title'] ?></td>
                                        <td><?php echo $sacrament['description'] ?></td>
                                        <td><?php echo $received['minister'] ?></td>
                                        <td><?php echo $received['date_received'] ?></td>

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
        <!-- /sacraments -->

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Organizations</h6>
                    </div>
                    <div style="float:right">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Organizations</th>
                                    <th>Date Joined</th>
                                    <th>Title(if any)</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Organizations</th>
                                    <th>Date Joined</th>
                                    <th>Title(if any)</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findSocietiesJoined = findOrganizationJoined($profile_id);
                                foreach ($findSocietiesJoined as $society) {
                                    $organization = findOrganizations($profile_id);
                                ?>
                                    <tr>
                                        <td><?php echo $organization['title'] ?></td>
                                        <td><?php echo $society['date_joined'] ?></td>
                                        <td><?php echo $society['position'] ?></td>
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
        <!-- /sacraments -->

        <!-- transactions -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                    </div>
                    <div style="float:right">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <!-- <th>User</th> -->
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
                                    <!-- <th>User</th> -->
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Reference Id</th>
                                    <th>Description</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findPayments = findMembersPayments($profile_id);
                                foreach ($findPayments as $transaction) {
                                ?>
                                    <tr>

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
        <!-- /tranction info -->



    </div>

</div>
<!-- /.container-fluid -->

<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "order": [],
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 100,
        });
    });
</script>

<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable3').DataTable({
            "order": [],
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 100,
        });
    });
</script>

<?php

include('footer.php');

?>