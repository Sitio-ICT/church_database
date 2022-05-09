<?php

include('header.php');
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findPermissions['mass_booking'] != 1) {
    $_SESSION["feedback"] = "You do not have permission!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?mass_intention1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $person = test_input($_POST['person']);
    $mass_intention = test_input($_POST['mass_intention']);
    // $profile_id = test_input($_POST['profile_id']);


    // create feed
    $feed_created = create('mass_booking', ['person' => $person, 'mass_intention' => $mass_intention, 'status' => 0, 'profile_id' => $profile_id]);

    if ($feed_created) {
        echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        icon: "success",
                        title: "Success",
                        text: "Mass Booked Successfully!",
                        button: false,
                        timer: 3000
                    });
                });
            </script>
            ';
    }
}

?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">BOOKED MASS</h1>

    <div class="row">

        <!-- lists of users -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float: left;">
                        <h6 class="m-0 font-weight-bold text-primary">Mass Bookings</h6>
                    </div>
                    <div style="float: right;">
                        <!-- <b>Total: <span id="total"></span></b> 
                        || -->
                        <a href="#" class="btn btn-info btn-icon-split export" data-export-type="excel">
                            <span class="icon text-white-50">
                                <i class="fas fa-download fa-sm text-white-50"></i>
                            </span>
                            <span class="text">Export EXCEL</span>
                        </a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Booked By</th>
                                    <th>Mass Intention</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Date booked</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mass_booking = selectAll('mass_booking');
                                foreach ($mass_booking as $feed) {
                                ?>
                                    <tr>
                                        <td><?php echo strtoupper($feed['person']); ?></td>
                                        <td><?php echo $feed['mass_intention'] ?></td>
                                        <td><?php echo $feed['day'] ?></td>
                                        <td><?php echo $feed['mass_time'] ?></td>
                                        <td><?php echo $feed['day_booked'] ?></td>
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

        // export table
        $(".export").click(function() {
            var export_type = $(this).data('export-type');
            $('#dataTable').tableExport({
                type: export_type,
                escape: 'false',
                ignoreColumn: []
            });
        });

    });
</script>
<?php

include('footer.php');

?>