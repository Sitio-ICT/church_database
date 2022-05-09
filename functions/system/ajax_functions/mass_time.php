<?php
include("../../connect.php");
session_start();


if (isset($_POST['day'])) {

    if ($_POST['day'] == "Weekdays") {
?>
        <div class="form-group">
            <label for="">Time</label>
            <select name="time" id="time" class="form-control" required>
                <option value="Morning">Morining</option>
                <option value="Evening">Evening</option>
            </select>
        </div>
        <?php
    } else {
        if ($_POST['day'] == "Weekdays") {
        ?>
            <div></div>
        <?php
        } else {
        ?>
            <div class="form-group">
                <label for="">Time</label>
                <select name="time" id="time" class="form-control" required>
                    <option value="6am">6am</option>
                    <option value="8am">8am</option>
                    <option value="10am">10am</option>
                    <option value="9pm">9pm</option>
                </select>
            </div>

<?php
        }
    }
}

?>