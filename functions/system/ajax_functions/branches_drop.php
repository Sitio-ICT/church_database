<?php
include("../../connect.php");

$product_type = $_POST['product_type'];
if (isset($_POST['product_type'])) {
    if ($product_type == 1) {
?>
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="product_name" placeholder="Product Name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="value" placeholder="Value" required>
        </div>

    <?php
    } else if ($product_type == 2) {
    ?>
        <div class="form-group">
            <label for="">RDP</label>
            <textarea name="value" placeholder="Use | to seperate - Name/Price/Value/description" id="value" class="form-control" cols="30" rows="10"></textarea>
        </div>
<?php
    }else if($product_type == 3){
        ?>
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="product_name" placeholder="Account Name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user" name="value" placeholder="Account Value" required>
        </div>
        <?php
    }
}
?>