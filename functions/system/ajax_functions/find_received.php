<?php

include("../../methods.php");

if ($_POST['sacrament'] != "") {
    // $findMember = findMemeberLike($_POST['identifier']);
    $findMember = findSacramentLimit($_POST['profile'], $_POST['sacrament']);
    if ($findMember['can_receive'] == "Yes") {
?>
        <button type="submit" class="btn btn-primary">Record Sacrament Received</button>
    <?php
    } else {
    ?>
        <p>Can't receive this Sacrament more than Once</p>
        <button type="submit" disabled class="btn btn-primary">Record Sacrament Received</button>
    <?php
    }
} else {
    ?>
    <button type="submit" disabled class="btn btn-primary">Record Sacrament Received</button>
<?php
}
