<?php

include('header.php');

$randms = generateRandomString();

if ($findPermissions['user_management'] != 1) {
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
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">MEMBERS</h1>

    <div class="row">


        <!-- lists of users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Active Members</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $finduser = findUsers();
                                    foreach ($finduser as $user) {
                                        $profile = findProfile($user['profile_id']);
                                    ?>
                                        <tr>
                                            <td><?php echo $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile ['last_name'] ?></td>
                                            <td><?php echo $user['username']; ?></td>
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

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Blocked Members</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $finduser = findBannedUsers();
                                    foreach ($finduser as $user) {
                                        $profile = findProfile($user['profile_id']);
                                    ?>
                                        <tr>
                                        <td><?php echo $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile ['last_name'] ?></td>
                                            <td><?php echo $user['username']; ?></td>
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
<?php

include('footer.php');

?>