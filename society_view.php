<?php

include('header.php');

$findOrganisation = findOrganization($_GET['view']);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findOrganisation['org_name'] ?></h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Organization Info</h6>
                </div>
                <div class="card-body">
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
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Members</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Date Joined</th>
                                    <th>Title(if any)</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Member</th>
                                    <th>Date Joined</th>
                                    <th>Title(if any)</th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findSocietiesJoined = findOrganizationsMember($_GET['view']);
                                var_dump($findOrganisation);
                                foreach ($findSocietiesJoined as $x => $society) {
                                    $organization = findOrganizationJoinedMember($society['id'], $_GET['view']);
                                ?>
                                    <tr>
                                        <td><?php echo $society['first_name'] . " " . $society['middle_name'] . " " . $society['last_name'] ?></td>
                                        <td><?php echo $organization['date_joined'] ?></td>
                                        <td><?php echo $organization['position'] ?></td>
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