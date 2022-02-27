<?php

include('header.php');
$bankId = $_GET["view"];
$findBank = selectOne('banks', ['idbanks' => $bankId]);
$findMainBranch = selectOne('branches', ['banks_idbanks' => $bankId, 'main_branch' => 1]);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findBank['name'] ?></h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bank Info</h6>
                </div>
                <div class="card-body">
                    <form action="">
                        <?php echo $findBank['description'] ?>
                        <hr>
                        <div class="form-group">
                            <label for="">Main Branch</label>
                            <input type="text" class="form-control form-control-user" name="branch" value="<?php echo $findBank['name'] . " - " . $findMainBranch['branch_name'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" class="form-control form-control-user" name="location" value="<?php echo $findMainBranch['location'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Primary Contact</label>
                            <input type="text" class="form-control form-control-user" name="pc_name" value="<?php echo $findMainBranch['primary_contact_fullname'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="pc_email" aria-describedby="emailHelp" readonly value="<?php echo $findMainBranch['primary_contact_email'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="pc_phone" value="<?php echo $findMainBranch['primary_contact_phone'] ?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- list of branches -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Branches</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">Create Branch</span>
                        </a>
                    </div>
                    <!-- Modal -->
                    <form action="functions/business/banks/create_branch.php" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Branch</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $bankId ?>" name="bank" hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="branch_name" placeholder="Branch Name..." required>
                                        </div>


                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="location" placeholder="Branch address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="pc_name" placeholder="Primary Contact Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="pc_email" aria-describedby="emailHelp" placeholder="Primary Contact Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="pc_phone" placeholder="Primary Contact Phone" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /modal ends here -->

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Primary Contact</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Primary Contact</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findbank = selectAll('branches', ['banks_idbanks' => $bankId]);
                                foreach ($findbank as $bank) {
                                ?>
                                    <tr>
                                        <td><?php echo $bank['branch_name'] ?></td>
                                        <td><?php echo $bank['location'] ?></td>
                                        <td><?php echo $bank['primary_contact_fullname'] ?></td>
                                        <td><?php echo $bank['primary_contact_email'] ?></td>
                                        <td><?php echo $bank['primary_contact_phone'] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#exampleModal<?php echo $bank['idbranches'] ?>">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>
                                        </td>
                                        <!-- Modal -->
                                        <form action="functions/business/banks/update_branch.php" method="post">
                                            <div class="modal fade" id="exampleModal<?php echo $bank['idbranches'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Branch</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" value="<?php echo $bankId ?>" name="bank" hidden>
                                                            <input type="text" value="<?php echo $bank['idbranches'] ?>" name="branch" hidden>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-user" name="branch_name" value="<?php echo $bank['branch_name'] ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Main Branch <i>Altering this would change your current main branch</i></label>
                                                                <select name="main_branch" id="" class="form-control form-control-user">
                                                                    <option value="0">Not Main</option>
                                                                    <option value="1">Main</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-user" name="location" value="<?php echo $bank['location'] ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-user" name="pc_name" value="<?php echo $bank['primary_contact_fullname'] ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-user" name="pc_email" aria-describedby="emailHelp" value="<?php echo $bank['primary_contact_email'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-user" name="pc_phone" value="<?php echo $bank['primary_contact_phone'] ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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