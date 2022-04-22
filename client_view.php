<?php

include('header.php');

$clientId = $_GET["view"];
$findUser = findUser($clientId);
$findClient = findProfile($findUser['profile_id']);
$profile_id = $findUser['profile_id'];


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findClient['first_name'] . " " . $findClient['middle_name'] . " " . $findClient['last_name'] ?></h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Bio Info</h6>
                    </div>
                    <div style="float:right">
                        <?php
                        if ($profile_id == $_SESSION['profile_id']) {
                        ?>
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#fund">Donate</a>

                            <!-- Modal -->
                            <form action="functions/people/users/update_user.php" method="post" enctype="multipart/form-data">
                                <div class="modal fade" id="fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="text" name="profile_id" id="profile_id" value="<?php echo $profile_id ?>" name="client" hidden>
                                                <input type="text" name="client" id="text" value="<?php echo $clientId ?>" hidden>
                                                <div class="form-group">
                                                    <label for="">First name</label>
                                                    <input type="text" id="first_name" class="form-control form-control-user" value="<?php echo $findUser['first_name'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Middle name</label>
                                                    <input type="text" id="middle_name" class="form-control form-control-user" value="<?php echo $findUser['middle_name'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Last name</label>
                                                    <input type="text" id="last_name" class="form-control form-control-user" value="<?php echo $findUser['last_name'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Username</label>
                                                    <input type="text" id="username" class="form-control form-control-user" value="<?php echo $findUser['username'] ?>" readonly>
                                                </div>
                                                <div id="usernamed"></div>
                                                <div class="form-group">
                                                    <label for="">Maiden Name</label>
                                                    <input type="text" id="maiden_bame" class="form-control form-control-user" value="<?php echo $findUser['username'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Religion</label>
                                                    <input type="text" name="religion" class="form-control form-control-user" value="<?php echo $findClient['religion'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Sex</label>
                                                    <input type="text" name="sex" class="form-control form-control-user" value="<?php echo $findClient['sex'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Date of Birth</label>
                                                    <input type="date" name="dob" class="form-control form-control-user" value="<?php echo $findClient['d_o_b'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Marital status</label>
                                                    <input type="text" name="marital_status" class="form-control form-control-user" value="<?php echo $findClient['marital_status'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Date of Wedding</label>
                                                    <input type="date" name="dow" class="form-control form-control-user" value="<?php echo $findClient['d_o_wedding'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">State of origin</label>
                                                    <input type="text" name="state" class="form-control form-control-user" value="<?php echo $findClient['state_of_origin'] ?>" readonly>
                                                </div>
                                                Í<div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" id="email" class="form-control form-control-user" value="<?php echo $findClient['email'] ?>" readonly>
                                                </div>
                                                <div id="emailed"></div>
                                                Í<div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="tel" name="phone" class="form-control form-control-user" value="<?php echo $findClient['phone_no'] ?>" readonly>
                                                </div>
                                                Í<div class="form-group">
                                                    <label for="">Residential Address</label>
                                                    <input type="email" name="address" class="form-control form-control-user" value="<?php echo $findClient['residentail_address'] ?>" readonly>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#email').on("change blur click", function() {
                                                            var email = $('#email').val();
                                                            $.ajax({
                                                                url: "functions/system/ajax_functions/check_email.php",
                                                                method: "POST",
                                                                data: {
                                                                    email: email
                                                                },
                                                                success: function(data) {
                                                                    $('#emailed').html(data);
                                                                }
                                                            })
                                                        });

                                                        $('#username').on("change blur click", function() {
                                                            var username = $('#username').val();
                                                            $.ajax({
                                                                url: "functions/system/ajax_functions/check_username.php",
                                                                method: "POST",
                                                                data: {
                                                                    username: username
                                                                },
                                                                success: function(data) {
                                                                    $('#usernamed').html(data);
                                                                }
                                                            })
                                                        });
                                                    });
                                                    // add confirm password script
                                                </script>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
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


                    <?php
                    if ($user_type == "admin") {
                    ?>
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

                                            <input type="text" name="profile_id" id="profile_id" value="<?php echo $clientId ?>" name="client" hidden>
                                            <input type="text" name="email" id="email" value="<?php echo $findClient['email'] ?>" hidden>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount(NGN)...." required>
                                            </div>
                                            <div class="form-group">
                                                <select name="payment_type" id="payment_type" class="form-control">
                                                    <option value="Donation">Donation</option>
                                                    <option value="Tithe">Tithe</option>
                                                </select>
                                            </div>

                                            <!-- <script>
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
                                            </script> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" onclick="payWithPaystack()">Pay</button>
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
                                                    location.replace("my_transactions.php");
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
                                            location.replace("my_transactions.php");
                                        }
                                    }
                                });
                            }
                        </script>
                        <!-- /modal ends here -->
                        <!-- </form> -->
                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- relationships comes here -->
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
                        <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Relationship</th>
                                    <th>Person</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Relationship</th>
                                    <th>Person</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findRelations = findRelationships($profile_id);
                                foreach ($findRelations as $relations) {
                                ?>
                                    <tr>

                                        <td><?php echo $relations['relatioship_type'] ?></td>
                                        <td>
                                            <?php
                                            $findPerson = findProfile($relations['related_to']);
                                            echo $findPerson['first_name'] . " " . $findPerson['middle_name'] . " " . $findPerson['last_name'];
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
                                        <td><?php echo $sacrament['tittle'] ?></td>
                                        <td><?php echo $sacrament['description'] ?></td>
                                        <td><?php echo $received['ministered_by'] ?></td>
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
                                    $organization = findOrganization($society['organization_id']);
                                ?>
                                    <tr>
                                        <td><?php echo $organization['org_name'] ?></td>
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

        <!-- pictures -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Pictures</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#picture">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">Upload file</span>
                        </a>
                    </div>
                    <!-- Modal -->
                    <form action="functions/system/image_upload.php" method="post" enctype="multipart/form-data">
                        <div class="modal fade" id="picture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $profile_id ?>" name="profile_id" hidden>
                                        <div class="form-group">
                                            <input type="file" class="form-control form-control-user" name="image" placeholder="" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="upload-image" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /modal ends here -->
                </div>
                <div class="card-body">


                    <style>
                        .fileinput .thumbnail {
                            display: inline-block;
                            margin-bottom: 10px;
                            overflow: hidden;
                            text-align: center;
                            vertical-align: middle;
                            max-width: 250px;
                            box-shadow: 0 10px 30px -12px rgba(0, 0, 0, .42), 0 4px 25px 0 rgba(0, 0, 0, .12), 0 8px 10px -5px rgba(0, 0, 0, .2);
                        }

                        .thumbnail {
                            border: 0 none;
                            border-radius: 4px;
                            padding: 0;
                        }

                        .fileinput .thumbnail>img {
                            max-height: 100%;
                            width: 100%;
                        }

                        html * {
                            -webkit-font-smoothing: antialiased;
                            -moz-osx-font-smoothing: grayscale;
                        }

                        img {
                            vertical-align: middle;
                            border-style: none;
                        }

                        .gallery {
                            display: inline-block;
                        }

                        .close-icon {
                            border-radius: 50%;
                            position: absolute;
                            right: 5px;
                            top: -10px;
                            padding: 0.1px;
                            cursor: pointer;
                        }
                    </style>
                    <!-- Images are here -->
                    <div class="row">
                        <?php
                        // echo $_SESSION['feedback'];
                        $findImages = selectAll('images', ['profile_id' => $profile_id]);
                        foreach ($findImages as $image) {
                        ?>
                            <div class='col-md-4 mt-3'>
                                <a class="fancybox" rel="group" href="uploads/<?php echo $image['image'] ?>">
                                    <img class="img-fluid" alt="" src="uploads/<?php echo $image['image'] ?>" />
                                </a>
                                <form action="functions/system/image_delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $image['id'] ?>">
                                    <input type="hidden" name="profile_id" value="<?php echo $image['profile_id']; ?>">
                                    <button type="submit" id="delete-image" class="close-icon" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <i class="material-icons">clear</i>
                                    </button>
                                </form>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- /images end here -->
                    </div>
                </div>
            </div>
            <!-- /pictiures -->


        </div>

    </div>
    <!-- /.container-fluid -->
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $("#delete-image").click(function() {

            });
        });
    </script>

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable2').DataTable({
                "order": [],
                "lengthMenu": [
                    [50, 100, 250, 500, -1],
                    [50, 100, 250, 500, "All"]
                ],
                "iDisplayLength": 10,
            });
        });
    </script>

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable4').DataTable({
                "order": [],
                "lengthMenu": [
                    [50, 100, 250, 500, -1],
                    [50, 100, 250, 500, "All"]
                ],
                "iDisplayLength": 10,
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
                "iDisplayLength": 10,
            });
        });
    </script>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <?php

    include('footer.php');

    ?>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="assets/fancybox-2.1.7/source/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/jquery.fancybox.js"></script>
    <script type="text/javascript" src="assets/fancybox-2.1.7/source/jquery.fancybox.pack.js"></script>