<?php
include("../../methods.php");

if (isset($_POST['username'])) {
    $findUsername = findUsername($_POST['username']);
    if ($findUsername == "Okay!") {
?>
        <input type="username" hidden name="username" value="<?php echo $_POST['username'] ?>" required>
        <p class="small" style="color: #1cc88a;">Good to go</p>
<?php
    } else {
        ?>
        <input type="username" hidden name="username" value="" required>
        <p class="small" style="color: #e74a3b;">Username Already in Use</p>
        <?php
    }
}

?>