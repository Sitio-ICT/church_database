<?php

include('header.php');

$randms = generateRandomString(10);

if ($findPermissions['user_management'] != 1) {
    $_SESSION["feedback"] = "You do not have User Management permission!";
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
    <h1 class="h3 mb-4 text-gray-800">ADMIN USER MANAGEMENT</h1>

    <div class="row">

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create New User</h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="functions/people/users/create_user.php">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="firstname" placeholder="Firstname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="lastname" placeholder="Lastname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="username" class="form-control form-control-user" name="username" placeholder="username" required>
                            <div id="usernamed"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="Email...">
                            <div id="emailed"></div>
                        </div>
                        <!-- <div class="form-group">
                            <input type="tel" class="form-control form-control-user" name="phone" placeholder="Phone" required>
                        </div> -->
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
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" name="passkey" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>

                            <div class="col-sm-6">
                                <input type="password" name="confirm_passkey" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" onclick="show()">
                                    Show Password
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <script>
                                function show() {
                                    var x = document.getElementById("exampleInputPassword");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }
                            </script>
                        </div>
                        <legend>Role and Permissions:</legend>
                        <div class="row">
                            <input type="text" name="usertype" value="admin" hidden>
                            <div class="form-group col-lg-6">
                                User Management <input type="checkbox" name="users" value="1" class="form-comtrol">
                            </div>
                            <div class="form-group col-lg-6">
                                Configurations <input type="checkbox" name="config" value="1" class="form-comtrol">
                            </div>
                            <div class="form-group col-lg-6">
                                Feeds <input type="checkbox" name="feeds" value="1" class="form-comtrol">
                            </div>
                            <div class="form-group col-lg-6">
                                Mass Booking <input type="checkbox" name="mass_booking" value="1" class="form-comtrol">
                            </div>
                            <div class="form-group col-lg-12">
                                Transactions(Subscriptions, Donations...) <input type="checkbox" name="transaction" value="1" class="form-comtrol">
                            </div>
                            <div class="form-group col-lg-8">
                                Others(Societies, ....) <input type="checkbox" name="others" value="1" class="form-comtrol">
                            </div>
                        </div>


                        <button type="reset" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Reset</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
        <!-- lists of users -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $finduser = findAdminUsers();
                                foreach ($finduser as $x => $user) {
                                    $profile = findProfile($user['profile_id']);
                                ?>
                                    <tr>
                                        <td><?php echo $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile['last_name'] ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <td><?php echo $profile['phone_no']; ?></td>
                                        <td><?php echo $profile['email']; ?></td>
                                        <td>
                                            <a href="client_view.php?view=<?php echo $user['id'] ?>" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">View</span>
                                            </a>
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
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "order": [],
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 50,
        });
    });
</script>
<?php

include('footer.php');

?>