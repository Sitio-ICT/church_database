<?php

include('header.php');

$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findPermissions['configurations'] != 1) {
    $_SESSION["feedback"] = "You do not have permission to manage Sacraments!";
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
    <h1 class="h3 mb-4 text-gray-800">SACRAMENTS MANAGEMENT</h1>

    <div class="row">

        <!-- lists of sacraments -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left;">
                        <h6 class="m-0 font-weight-bold text-primary">Sacraments</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#sacrament">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">New Sacrament</span>
                        </a>
                        <!-- Modal -->
                        <form action="functions/operations/create_sacrament.php" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="modal fade" id="sacrament" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create New Sacarament</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Title</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Description</label>
                                                <textarea name="description" cols="10" rows="10" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Minimum Age</label>
                                                <input type="number" name="min_age" min="0" class="form-control" required>
                                            </div>
                                            <div class=form-group>
                                                <label for="">Maximum Times Receivable</label>
                                                <input type="number" name="max_receivable" min="0" class="form-control" required>
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
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Min Age</th>
                                    <th>Max Time Receivable</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Min Age</th>
                                    <th>Max Time Receivable</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findSacraments = findSacraments();
                                foreach ($findSacraments as $sacrament) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $sacrament['tittle'] ?>
                                        </td>
                                        <td><?php echo $sacrament['description'] ?></td>
                                        <td><?php echo $sacrament['minimum_age']; ?></td>
                                        <td><?php echo $sacrament['max_receivable']
                                            ?></td>
                                        <td>
                                            <a href="functions/operations/delete_sacraments.php?delete=<?php echo $sacrament['id'] ?>" class="btn btn-danger">Delete</a>
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