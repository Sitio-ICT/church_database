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
                            <p>
                                <?php echo $findOrganisation['description'] ?>
                            </p>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label for="">Reoccurence</label>
                                    <input type="text" class="form-control" value="<?php echo $findOrganisation['re_occurance'] ?>" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Metting Days</label>
                                    <input type="text" class="form-control" value="<?php echo $findOrganisation['meeting_days'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div style="float: left;">
                            <h6 class="m-0 font-weight-bold text-primary">Members</h6>
                        </div>

                        <div style="float: right;">
                            <a href="#" class="btn btn-info " data-toggle="modal" data-target="#add">Add Member</a>

                            <!-- Modal -->
                            <form action="functions/operations/add_member.php" method="post" enctype="multipart/form-data" autocomplete="off">
                                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <input type="text" value="<?php echo $_GET['view'] ?>" name="organization" hidden>
                                                <div class="form-group">
                                                    <label for="">Member</label>
                                                    <input type="text" name="indetifier" id="identifier" class="form-control">
                                                </div>
                                                <div id="member"></div>
                                                <div class="form-group">
                                                    <label for="">Date Joined</label>
                                                    <input type="date" name="date_joined" class="form-control" max="<?php echo date("Y-m-d"); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Position</label>
                                                    <input type="text" name="position" class="form-control">
                                                </div>
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

                                                    });
                                                </script>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /modal ends here -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

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
                                    // dd($findSocietiesJoined);
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