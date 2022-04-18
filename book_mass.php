<?php

include('header.php');

$randms = generateRandomString(15);
$today = date("Y-m-d");
$findProfile = findProfile($profile_id);

$response = '';
if (isset($_GET['response'])) {
    $response = $_GET['response'];
    $refrennce = $_GET['reference'];
    $storePayment = makePayment($profile_id, 'Mass Booking', 0, 1000, "Mass booked $today", $today, $randms);
    if ($response == 'success') {
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                swal({
                    icon: "success",
                    title: "Success",
                    text: "Mass Booked Successfully!",
                    button: true,
                    timer: 3000
                });
            });
        </script>
        ';
    } else if ($response == 'error') {
        $deleteBooking = delete('mass_booking', $_SESSION['pay_id'], 'id');
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                swal({
                    icon: "error",
                    title: "Error",
                    text: "Mass not Booked!",
                    button: true,
                    timer: 3000
                });
            });
        </script>
        ';
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $person = test_input($_POST['person']);
    $mass_intention = test_input($_POST['mass_intention']);
    $email = test_input($_POST['email']);


    // create feed
    $feed_created = create('mass_booking', ['person' => $person, 'mass_intention' => $mass_intention, 'status' => 0, 'profile_id' => $profile_id]);

    if ($feed_created) {

        // echo "New record created successfully";
        $_SESSION['email'] = $email;
        $_SESSION['pay_id'] = $feed_created;
?>
        <script>
            location.replace("https://paystack.com/pay/mass_booking");
        </script>
<?php
        die();
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
    <h1 class="h3 mb-4 text-gray-800">MASS BOOKING</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <!-- <form id="paymentForm"> -->
                    <form class="user" autocomplete="off" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="form-group">
                            <label for="">Person</label>
                            <input type="text" name="person" id="person" class="form-control" required value="<?php echo $findProfile['first_name'] . " " . $findProfile['middle_name'] . " " . $findProfile['last_name'] ?>" readonly>
                        </div>
                        <input type="text" name="email" id="email" value="<?php echo $findProfile['email'] ?>" hidden>
                        <input type="text" name="profile_id" id="profile_id" value="<?php echo $findProfile['id'] ?>" hidden>
                        <div class="form-group col-lg-6">
                            Annonymous <input type="checkbox" name="anonymous" id="anonymous" value="anonymous" class="form-comtrol">
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
                    <!-- <script>
                        const paymentForm = document.getElementById('paymentForm');
                        paymentForm.addEventListener("submit", payWithPaystack, false);

                        function payWithPaystack(e) {
                            e.preventDefault();
                            let handler = PaystackPop.setup({
                                key: 'pk_test_381f76fca3b0f850654e352c0424f2a6d78466e2', // Replace with your public key
                                email: document.getElementById("email").value,
                                mass_intention: document.getElementById("mass_intention").value,
                                anonymous: document.getElementById("anonymous").value,
                                profile_id: document.getElementById("profile_id").value,
                                person: document.getElementById("person").value,
                                amount: 100 * 100,
                                ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                // label: "Optional string that replaces customer email"
                                onClose: function() {
                                    alert('Window closed.');
                                },
                                callback: function(response) {
                                    // let message = 'Payment complete! Reference: ' + response.reference;
                                    // alert(message);
                                    $.ajax({
                                        url: 'https://https://members.holyfamilycclc.org/verify_transaction.php?reference=' + response.reference,
                                        method: 'get',
                                        success: function(response) {
                                            // the transaction status is in response.data.status
                                            alert(response.data.status);
                                            if (response == "success") {
                                                $.ajax({
                                                    url: 'https://https://members.holyfamilycclc.org/functions/operations/add_mass.php',
                                                    method: 'post',
                                                    data: {
                                                        mass_intention: mass_intention,
                                                        anonymous: anonymous,
                                                        profile_id: profile_id,
                                                        person: person
                                                    },
                                                    success: function(response) {
                                                        // the transaction status is in response.data.status
                                                        location.replace("book_mass.php");
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }
                            });
                            handler.openIframe();
                        }
                    </script> -->

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
                                $mass_booking = selectAll('mass_booking', ['profile_id' => $profile_id]);
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

<!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->
<?php

include('footer.php');

?>