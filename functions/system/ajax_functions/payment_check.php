<?php

if (isset($_POST['principal']) && isset($_POST['total']) && isset($_POST['interest'])) {
    $principal = floatval(preg_replace('/[^\d.]/', '', $_POST['principal']));
    $interest = floatval(preg_replace('/[^\d.]/', '', $_POST['interest']));
    $total = $_POST['total'];

    $paymentTotal = $principal + $interest;
    if ($total > $paymentTotal) {
?>
        <div class="card mb-4 py-3 border-left-warning">
            <div class="card-body">
                Inputed Amount is less than the total Expected amount, only continue if this is intentional
            </div>
        </div>
    <?php
    } else if ($total < $paymentTotal) {

    ?>
        <div class="card mb-4 py-3 border-left-warning">
            <div class="card-body">
                Inputed Amount is more than the total Expected amount, this transaction would not go through
            </div>
        </div>
    <?php
    } else if($total == $paymentTotal) {
    ?>
        <div class="card mb-4 py-3 border-left-success">
            <div class="card-body">
                Everything Looks perfect
            </div>
        </div>
<?php
    }
}else{
    ?>
    Kindly Fill all required Fields
    <?php
}
