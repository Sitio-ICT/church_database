<?php

include('header.php');
$usertype = "damad";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Feeds/Annoucements</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    
    <div class="row">


        <div class="col-lg-12 mb-4">

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Feeds/Annoucements</h6>
                </div>
                <div class="card-body">
                    <style>
                        .scrolling {
                            max-height: 1000px;
                            overflow-y: scroll;
                        }
                    </style>
                    <div class="card-body scrolling">
                        <?php
                        $findActivity = selectAllWithOrder('feeds', [''], 'id', 'DESC');
                        $x = 0;
                        foreach ($findActivity as $activity) {
                            if ($activity['feed_type'] == "Annoucements") {
                                $color = "green";
                            } else if ($activity['feed_type'] == "Bans of Marriage") {
                                $color = "yellow";
                            } else {
                                $color = "blue";
                            }
                        ?>
                            <h3 style="color:<?php echo $color ?>">
                                <?php echo $activity['title'] ?>
                            </h3>
                            <p>
                                <?php echo htmlspecialchars_decode(stripslashes($activity['message'])); ?>
                            </p>
                            <i>Date Announced: <?php echo $activity['date_posted'] ?></i>
                            <hr>
                        <?php
                            
                        }
                        ?>
                    </div>
                    <!-- Above display purchase and transaction data in the form of descriptions -->
                </div>
            </div>

        </div>
    </div>

<!-- /.container-fluid -->


<?php

include('footer.php');

?>