<?php

include('header.php');

$findUser = findUser($profile_id);
$findClient = findProfile($findUser['profile_id']);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Donations/Tithe</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
                </div>
                <div class="card-body">
                    <form id="paymentForm">

                        <input type="text" id="profile_id" value="<?php echo $profile_id ?>" name="client" hidden>
                        <input type="text" name="email" id="email" value="<?php echo $findClient['email'] ?>" hidden>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount(NGN)...." required>
                        </div>
                        <div class="form-group">
                            <select name="type" id="payment_type" class="form-control">
                                <option value="Donation">Donation</option>
                                <option value="Tithe">Tithe</option>
                                <option value="Harvest">Harvest</option>
                                <option value="Project">Project</option>
                            </select>
                        </div>

                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary" onclick="payWithPaystack()">Pay</button>
                    </form>
                    <script>
                        const paymentForm = document.getElementById('paymentForm');
                        paymentForm.addEventListener("submit", payWithPaystack, false);

                        function payWithPaystack(e) {
                            e.preventDefault();
                            let handler = PaystackPop.setup({
                                key: 'pk_test_381f76fca3b0f850654e352c0424f2a6d78466e2', // Replace with your public key
                                email: document.getElementById("email").value,
                                payment_type: document.getElementById("payment_type").value,
                                profile_id: document.getElementById("profile_id").value,
                                amount: 100 * document.getElementById("amount").value,
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
                                                location.replace("transactions.php");
                                            }
                                        }
                                    });
                                }
                            });
                            handler.openIframe();
                        }

                        function ajaxCall2() {

                            var payment_type = document.getElementById("payment_type").value;
                            var profile_id = document.getElementById("profile_id").value;
                            var amount = 100 * document.getElementById("amount").value;
                            $.ajax({
                                url: 'https://members.holyfamilycclc.org/functions/operations/donate.php',
                                method: 'post',
                                data: {
                                    amount: amount,
                                    payment_type: payment_type,
                                    profile_id: profile_id
                                },
                                success: function(response2) {
                                    // the transaction status is in response.data.status
                                    if (response2 == "success") {
                                        location.replace("transactions.php");
                                    }
                                }
                            });
                        }
                    </script>
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