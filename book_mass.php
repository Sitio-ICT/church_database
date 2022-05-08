<?php

include('header.php');

$randms = generateRandomString(15);
$today = date("Y-m-d");
$findProfile = findProfile($profile_id);


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
                    <form id="paymentForm">
                        <!-- <form class="user" autocomplete="off" method="POST" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); 
                                                                                            ?>" novalidate> -->
                        <div class="form-group">
                            <label for="">Person</label>
                            <input type="text" name="person" id="person" class="form-control" required value="<?php echo $findProfile['first_name'] . " " . $findProfile['middle_name'] . " " . $findProfile['last_name'] ?>" readonly>
                        </div>
                        <input type="text" name="email" id="email" value="<?php echo $findProfile['email'] ?>" hidden>
                        <input type="text" name="profile_id" id="profile_id" value="<?php echo $findProfile['id'] ?>" hidden>
                        <!-- <div class="form-group col-lg-6">
                            Annonymous <input type="checkbox" name="anonymous" id="anonymous" value="anonymous" class="form-comtrol">
                        </div> -->

                        <!-- <script>
                            tinymce.init({
                                selector: '#mass_intention'
                            });
                        </script> -->
                        <div class="form-group">
                            <label for="">Mass Intention</label>
                            <textarea name="mass_intention" class="form-control" id="mass_intention" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Day</label>
                            <select name="day" id="day" class="form-control" required>
                                <option value="">....</option>
                                <option value="Weekdays">Weekdays</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div id="timed"></div>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount(NGN)...." required>
                        </div>
                        <div id="amountmin"></div>
                        <script>
                            $(document).ready(function() {
                               
                                $('#amount').on("change blur", function() {
                                    var amount = $(this).val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/minimum_balance.php",
                                        method: "POST",
                                        data: {
                                            amount: amount
                                        },
                                        success: function(data) {
                                            $('#amountmin').html(data);
                                        }
                                    })
                                });

                                $('#day').on("change blur", function() {
                                    var day = $(this).val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/mass_time.php",
                                        method: "POST",
                                        data: {
                                            day: day
                                        },
                                        success: function(data) {
                                            $('#timed').html(data);
                                        }
                                    })
                                });

                            });
                        </script>

                        <button type="reset" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Reset</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-icon-split" onclick="payWithPaystack()">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>
                    </form>
                    <script>
                        const paymentForm = document.getElementById('paymentForm');
                        paymentForm.addEventListener("submit", payWithPaystack, false);

                        function payWithPaystack(e) {
                            e.preventDefault();
                            let handler = PaystackPop.setup({
                                key: 'pk_test_381f76fca3b0f850654e352c0424f2a6d78466e2', // Replace with your public key
                                email: document.getElementById("email").value,
                                mass_intention: document.getElementById("mass_intention").value,
                                profile_id: document.getElementById("profile_id").value,
                                amount: 100 * document.getElementById("amounted").value,
                                ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                // label: "Optional string that replaces customer email"
                                onClose: function() {
                                    alert('Window closed.');
                                },
                                callback: function(response) {
                                    // let message = 'Payment complete! Reference: ' + response.reference;
                                    // alert(message);
                                    $.ajax({
                                        url: 'https://members.holyfamilycclc.org/pay.php?reference=' + response.reference,
                                        method: 'get',
                                        success: function(response) {
                                            // the transaction status is in response.data.status
                                            // alert(response);
                                            if (response == "success") {
                                                // alert(profile_id);
                                                ajaxCall2();
                                            } else {
                                                location.replace("my_transactions.php");
                                            }
                                        }
                                    });
                                }
                            });
                            handler.openIframe();
                        }

                        function ajaxCall2() {

                            var mass_intention = document.getElementById("mass_intention").value;
                            var email = document.getElementById("email").value;
                            var person = document.getElementById("person").value;
                            var profile_id = document.getElementById("profile_id").value;
                            var day = document.getElementById("day").value;
                            var time = document.getElementById("time").value;
                            var amount = 100 * document.getElementById("amounted").value;
                            $.ajax({
                                url: 'https://members.holyfamilycclc.org/functions/operations/add_mass.php',
                                method: 'post',
                                data: {
                                    amount: amount,
                                    mass_intention: mass_intention,
                                    profile_id: profile_id,
                                    person: person,
                                    day: day,
                                    time: time,
                                    email: email
                                },
                                success: function(response2) {
                                    // the transaction status is in response.data.status
                                    if (response2 == "success") {
                                        location.replace("my_transactions.php");
                                    }
                                }
                            });
                        }
                    </script>

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

<script src="https://js.paystack.co/v1/inline.js"></script>
<?php

include('footer.php');

?>