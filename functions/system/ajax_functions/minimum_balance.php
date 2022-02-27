<?php
include("../../connect.php");
session_start();


if (isset($_POST['amount'])) {
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    if ($amount < 20) {
?>
        <p style="color:red">
            Oopsie! Sorry, you cannot Top Up below $20
        </p>
    <?php
    } else {
    ?>
        <div class="alert alert-info">
            Send exactly <?php echo substr(USDtoBTC($amount), 0, 10); ?> to </br>
        </div>
        <?php

        $generatedAddress =  generateAddress();
        $userID = $_SESSION['userid'];
        $findAccount =  selectOne('accounts', ['users_id' => $userID]);
        $accountId = $findAccount['id'];
        $updateId = update('accounts', $accountId, 'id', ['uuid' => $generatedAddress]);

        // QR code generation using google apis
        $cht = "qr";
        $chs = "300x300";
        $chl = $generatedAddress;
        $choe = "UTF-8";

        $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;

        // Status translation
        $status = -1;
        $statusval = $status;
        $info = "";
        if ($status == 0) {
            $status = "<span style='color: orangered' id='status'>PENDING</span>";
            $info = "<p>You payment has been received. Invoice will be marked paid on two blockchain confirmations.</p>";
        } else if ($status == 1) {
            $status = "<span style='color: orangered' id='status'>PENDING</span>";
            $info = "<p>You payment has been received. Invoice will be marked paid on two blockchain confirmations.</p>";
        } else if ($status == 2) {
            $status = "<span style='color: green' id='status'>PAID</span>";
        } else if ($status == -1) {
            $status = "<span style='color: red' id='status'>UNPAID</span>";
        } else if ($status == -2) {
            $status = "<span style='color: red' id='status'>Too little paid, please pay the rest.</span>";
        } else {
            $status = "<span style='color: red' id='status'>Error, expired!</span>";
        }

        ?>
        <div class="form-group">
            <input type="text" name="address" class="form-control" id="address" value="<?php echo $generatedAddress ?>" readonly>
        </div>
        <div class="qr-hold">
            <img src="<?php echo $qrcode ?>" alt="My QR code" style="width:250px;">
        </div>
        <?php echo $status ?>
        <script>
            var status = <?php echo $statusval; ?>

            // Create socket variables
            if (status < 2 && status != -2) {
                var addr = document.getElementById("address").innerHTML;
                var timestamp = Math.floor(Date.now() / 1000) - 5;
                var wsuri2 = "wss://www.blockonomics.co/payment/" + addr;
                // Create socket and monitor
                var socket = new WebSocket(wsuri2, "protocolOne")
                socket.onmessage = function(event) {
                    console.log(event.data);
                    response = JSON.parse(event.data);
                    //Refresh page if payment moved up one status
                    if (response.status > status)
                        setTimeout(function() {
                            window.location = window.location
                        }, 1000);
                }
            }
        </script>
<?php
    }
}

?>