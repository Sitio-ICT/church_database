<?php
include("../../connect.php");
session_start();


if (isset($_POST['amount'])) {
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    if ($amount < 200) {
?>
        <p style="color:red">
            Oopsie! Sorry, you cannot Book Mass below NGN200
        </p>
        <div class="form-group">
            <input type="number" id="amounted" name="amounted" hidden required>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-info">
            Good to go </br>
        </div>
        <div class="form-group">
            <input type="number" id="amounted" name="amounted" value="<?php echo $amount ?>" hidden required>
        </div> 

<?php
    }
}

?>