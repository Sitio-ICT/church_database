<?php
include("../../connect.php");

$today = date('Y-m-d H:i:s');
$today2 = date('Y-m-d');
if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $date2 = date('Y-m-d', strtotime($_POST['date']));
    $purchaseId = $_POST['id'];
    $seconds = (strtotime($today) - strtotime($date));
    $diff = floor(($seconds / 60) % 60);
    // $diffMonth = $diff->m;
    // $diffDay = $diff->d;
    // $diffHours = $diff->h;
    // $diffMin = $diff->i;
    // $sum = $diffMonth + $diffDay + $diffHours + $diffMin;
    
    if ($today2 > $date) {
?>
        <a href="#" class="btn btn-danger" disabled>Expired</a>
        <?php
    } else {
        $findDiff = mysqli_query($connection, "SELECT * FROM purchase WHERE id = $purchaseId AND purchase_date >= now() - interval 10 minute");
        if (mysqli_num_rows($findDiff) > 0) {
            $findReport =  selectOne('support', ['purchase_id' => $purchaseId]);
            if (!$findReport) {
        ?>
                <a href="#" data-toggle="modal" data-target="#complain<?php echo $purchaseId; ?>" class="btn btn-warning">Report</a>

                <!-- complaint form -->
                <form action="..//functions/business/create_ticket.php" method="post">
                    <!-- Modal -->

                    <div class="modal fade" id="complain<?php echo $purchaseId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Complain</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" hidden name="purchase" value="<?php echo $purchaseId ?>">
                                    <div class="form-group">
                                        <label for="">Topic</label>
                                        <input type="text" class="form-control" name="topic" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Complaint</label>
                                        <textarea name="complaint" class="form-control" cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Urgency</label>
                                        <select name="urgency" id="urgency" class="form-control" required>
                                            <option value="Urgent">I need Urgently</option>
                                            <option value="Asap">Asap</option>
                                            <option value="No matter">No matter</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Report</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /modal ends here -->
                </form>
            <?php
            } else {
            ?>
                <a href="#" class="btn btn-warning" disabled>Reported</a>
            <?php
            }
        } else {
            ?>
            <a href="#" class="btn btn-danger" disabled>Expired</a>
<?php
        }
    }
    // 
}


?>