<?php

include('header.php');
$usertype = "damad";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php
        $tithes = sumAmount('amount', 'payment', ['payment_type' => 'Tithe', 'profile_id' => $profile_id]);
        $churchDonation = sumAmount('amount', 'payment', ['payment_type' => 'Donation']);
        $churchTithes = sumAmount('amount', 'payment', ['payment_type' => 'Tithe']);
        $transactions = sumAmount('amount', 'payment', []);
        $massesBooked = countRecords('mass_booking');
        $Donation = sumAmount('amount', 'payment', ['payment_type' => 'Donation', 'profile_id' => $profile_id]);
        $findSacramentReceived = countRecordsWhere('sacraments_recieved', $profile_id, 'profile_id');
        $societies = countRecordsWhere('organization_has_profile', $profile_id, 'profile_id');
        // ddA($Donation);
        ?>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Total Donations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php echo number_format($churchDonation['SUM(amount)'], 2)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Earnings (Monthly) Card Example -->
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Total Tithes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php echo number_format($churchTithes['SUM(amount)'], 2)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Earnings (Monthly) Card Example -->
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Total Transactions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php echo number_format($transactions['SUM(amount)'], 2)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Earnings (Monthly) Card Example -->
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Total Masses Booked</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo number_format($massesBooked)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               Your Donations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php echo number_format($Donation['SUM(amount)'], 2)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                              Your  Tithes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php echo number_format($tithes['SUM(amount)'], 2)
                                                                                    ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Societies <br>
                                I belong to
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $societies
                                                                                                ?></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Sacraments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $findSacramentReceived
                                                                                ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- Content Row -->
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
                            max-height: 340px;
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
                            <hr>
                        <?php
                            if (++$x == 10) {
                                break;
                            }
                        }
                        ?>
                    </div>
                    <a href="feeds_view.php" class="btn btn-success">View All</a>
                    <!-- Above display purchase and transaction data in the form of descriptions -->
                </div>
            </div>

        </div>
    </div>

<!-- /.container-fluid -->


<?php

include('footer.php');

?>