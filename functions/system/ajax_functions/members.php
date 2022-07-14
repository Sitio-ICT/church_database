<?php

include("../../methods.php");

if ($_POST['identifier'] != "") {
    // $findMember = findMemeberLike($_POST['identifier']);

    $input = $_POST['identifier'];
    $condition2 = [
        'first_name' => $input,
        'last_name' => $input,
        'middle_name' => $input,
        'registration_no' => $input
    ]; 
    $findMember = findMemeberLike($input);
    // dd($findMember);
    $profile_id = $findMember['id'];
?>
    <div class="form-group">
        <!-- <input type="text" class="form-control" value="<?php //echo $findMember['first_name'] . " " . $findMember['middle_name'] . " " . $findMember['last_name'] ?>" required readonly> -->
        <select name="member" class="form-control">
            <?php echo "<option value='".$profile_id."'>".$findMember['first_name'] . " " . $findMember['middle_name'] . " " . $findMember['last_name']."</option>"?>
        </select>
       <!--  <input type="text" id="profile" name="member" value="<?php //echo $profile_id ?>" required readonly hidden> -->
    </div>
<?php
} else {
?>
    <div class="form-group">
        <input type="text" name="member" class="form-control" placeholder="Input user name" value="" required readonly>
    </div>
<?php
}
