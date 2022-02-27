<?php
include("../../connect.php");

$type = $_POST['type'];
if (isset($_POST['type'])) {
    if ($type == "rdp") {
?>
        <div class="form-group">
            <label for="">Product</label>
            <textarea required name="product" placeholder="Use | to seperate - Product Type(rdp)|country|description|price|" id="value" class="form-control" cols="30" rows="10"></textarea>
        </div>

    <?php
    } else if ($type == "account") {
    ?>
        <div class="form-group">
            <label for="">Product</label>
            <textarea required name="product" placeholder="Use | to seperate - Product Name(Facebook, Youtube...)|country|description|url|price|email|password" id="value" class="form-control" cols="30" rows="10"></textarea>
        </div>
    <?php
    } else if ($type == "card") {
    ?>
        <div class="form-group">
            <label for="">Product</label>
            <textarea required name="product" placeholder="Use | to seperate - Product Type(card)|country|description|card-number|price|expiry-date|cvv" id="value" class="form-control" cols="30" rows="10"></textarea>
        </div>
<?php
    }
}
?>