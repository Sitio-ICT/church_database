<?php

include('header.php');

// $randms = generateRandomString(5);

// if ($findPermissions['others'] != 1) {
//     $_SESSION["feedback"] = "You do not have permission to manage Societies!";
//     $_SESSION["Lack_of_intfund_$randms"] = "10";
//     // using js so as to aviod header error
// ?>
    <script>
        // location.replace("index.php?message1=<?php //echo $randms ?>");
//     </script>
 <?php
//     exit();
// }

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">SOCIETIES AND ORGANIZATIONS</h1>

    <div class="row">


        <!-- lists of societies -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left;">
                        <h6 class="m-0 font-weight-bold text-primary">Societies</h6>
                    </div>
                    <div style="float:right">
                        <?php
                        if ($user_type == "admin") {
                        ?>
                            <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#bookLoan">
                                <span class="icon text-white-50">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="text">New Society</span>
                            </a>
                            <!-- Modal -->
                            <form action="functions/operations/create_society.php" method="post" enctype="multipart/form-data" autocomplete="off">
                                <div class="modal fade" id="bookLoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create New Society</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Organisation/Society Name</label>
                                                    <input type="text" name="org_name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <input type="text" name="description" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Society/Organization Type</label>
                                                    <input type="text" name="org_type" class="form-control" required placeholder="Pious society, Committee etc....">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Meeting Days</label>
                                                    <select name="meeting_days" class="form-control" required>
                                                        <option value="Sunday">Sunday</option>
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednessday">Wednessday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                        <option value="Saturday">Saturday</option>
                                                        <option value="All Week">All Week</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Meeting Frequency</label>
                                                    <select name="re_occurence" class="form-control" required>
                                                        <option value="Every">Every</option>
                                                        <option value="First">First</option>
                                                        <option value="Second">Second</option>
                                                        <option value="Third">Third</option>
                                                        <option value="Fourth">Fourth</option>
                                                    </select>
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
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Organization</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Metting days</th>
                                    <th>Meeting Re-occurance</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Organization</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Metting days</th>
                                    <th>Meeting Re-occurance</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findSocieties = findOrganizations();
                                foreach ($findSocieties as $society) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $society['org_name'] ?>
                                        </td>
                                        <td><?php echo $society['description'] ?></td>
                                        <td><?php echo $society['type']; ?></td>
                                        <td>
                                            <?php echo $society['meeting_days']; ?>
                                        </td>
                                        <td><?php echo $society['re_occurance'] ?></td>
                                        <td>
                                            <a href="society_view.php?view=<?php echo $society['id'] ?>" class="btn btn-primary">View</a>
                                            <?php
                                            if ($user_type == "admin") {
                                            ?>
                                                <!-- <a href="functions/business/delete_product.php?delete=<?php //echo $society['id'] ?>" class="btn btn-danger">Delete</a> -->
                                            <?php } ?>
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


<?php

include('footer.php');

?>