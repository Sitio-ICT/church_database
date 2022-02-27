<?php
include("../../methods.php");

if (isset($_POST['email'])) {
    $findEmail = findEmail($_POST['email']);
    if ($findEmail == "Okay!") {
?>
        <input type="email" hidden name="email" value="<?php echo $_POST['email'] ?>" required>
        <p class="small" style="color: #1cc88a;">Good to go</p>
<?php
    } else {
        ?>
        <input type="email" hidden name="email" value="" required>
        <p class="small" style="color: #e74a3b;">Email Already in Use</p>
        <?php
    }
}

?>