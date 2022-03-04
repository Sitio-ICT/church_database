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
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">MASS BOOKING</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="form-group">
                            <label for="">Person</label>
                            <input type="text" name="person" class="form-control" required placeholder="Who's booking">
                        </div>
                        
                        <script>
                            tinymce.init({
                                selector: '#mass_intention'
                            });
                        </script>
                        <div class="form-group">
                            <label for="">Mass Intention</label>
                            <textarea name="mass_intention" id="mass_intention" cols="30" rows="10" required></textarea>
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
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mass Bookings</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Booked By</th>
                                    <th>Mass Intention</th>
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