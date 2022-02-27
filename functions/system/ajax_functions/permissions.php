<?php

if (isset($_POST['rank'])) {
    if ($_POST['rank'] == 1) {
?>
        <div class="row">
            <div class="form-group col-lg-6">
                User/Warnings <input type="checkbox" name="approve" value="1" checked disabled class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Support <input type="checkbox" name="support" value="1" checked disabled class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Transactions <input type="checkbox" name="transaction" value="1" checked disabled class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Product <input type="checkbox" name="product" value="1" checked disabled class="form-comtrol">
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="row">
            <div class="form-group col-lg-6">
                User/Warnings <input type="checkbox" name="approve" value="1" disabled class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Support <input type="checkbox" name="support" value="1" checked disabled class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Transactions <input type="checkbox" name="transaction" value="1" class="form-comtrol">
            </div>
            <div class="form-group col-lg-6">
                Product <input type="checkbox" name="product" value="1" class="form-comtrol">
            </div>
        </div>
<?php
    }
}
