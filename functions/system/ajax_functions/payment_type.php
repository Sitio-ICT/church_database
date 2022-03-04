<?php

include("../../methods.php");

if ($_POST['payment_type'] == "Subscription") {
    // $findMember = findMemeberLike($_POST['identifier']);

    $findSubscriptions = findSubscriptionModels();
?>
    <div class="form-group">
        <label for="">Subscription Type</label>
        <select name="susbcription_model" class="form-control" required>
            <?php
            foreach ($findSubscriptions as $subscriptions) {
            ?>
                <option value="<?php echo $subscriptiions['id'] ?>"><?php echo $subscriptiions['title'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>
<?php
} else {
?>

<?php
}
