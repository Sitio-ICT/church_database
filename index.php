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
        // $findRequests = selectAll('request', ['status' => 0]);
        // $transactions = selectAll('transaction', ['status' => 0]);
        // $unApprovedInvestment = selectAll('support', ['is_resolved' => 0]);
        // $products = selectAll('products');
        ?>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Donations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php //echo count($transactions) 
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
                                Tithes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">NGN <?php //echo count($transactions) 
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
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php //echo count($products) 
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo count($findRequests) 
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
                        <?php
                            if (++$x == 10) {
                                break;
                            }
                        }
                        ?>
                    </div>
                    <!-- Above display purchase and transaction data in the form of descriptions -->
                </div>
            </div>

        </div>
    </div>



    <?php
    if ($usertype == "USER") {
    ?>
        <!-- Content Row -->
        <div class="row">
            <?php
            $findRequests = selectAll('request', ['status' => 0]);
            $transactions = selectAll('transaction', ['status' => 0]);
            $unApprovedInvestment = selectAll('support', ['is_resolved' => 0]);
            $products = selectAll('products');
            ?>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Accounts</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($transactions) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                    RDP</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($transactions) ?></div>
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
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">One Time Passwords
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo count($products) ?></div>
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
                                    Cards</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($findRequests) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                        <h6 class="m-0 font-weight-bold text-primary">Buy Products</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Product Type</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Name</th>
                                        <th>Product Type</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $findProduct = selectAll('products', ['status' => 0]);
                                    foreach ($findProduct as $product) {
                                    ?>
                                        <tr>
                                            <td><?php echo $product['product_name'] ?></td>
                                            <td><?php echo $product['product_type']; ?></td>
                                            <td><?php echo $product['price']; ?></td>
                                            <td>
                                                <a href="product_view.php?view=<?php echo $product['idcustomers'] ?>" class="btn btn-info btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span class="text">BUY</span>
                                                </a>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php
    }
    ?>

</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>