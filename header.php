<?php

include("functions/methods.php");
session_start();
// include("ajaxcall.php");
if (!$_SESSION["loggedin"] == True) {
    header("location: login.php");
    exit;
}
$profile_id = $_SESSION['profile_id'];
// find admin permissions
$findPermissions = findPermissions($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Holy Family Catholic Church</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- tinyMce -->
    <script src="https://cdn.tiny.cloud/1/05uzyhq8bcam7g5r97qftgykpmc0nghqqrqg1o9oeb2laxq5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- feedback to customer using sweet alert -->
    <?php
    $exp_error = "";
    $message = $_SESSION['feedback'];
    if ($message != "") {
    ?>
        <input type="text" value="<?php echo $message ?>" id="feedback" hidden>
    <?php
    }
    // feedback messages 0 for success and 1 for errors

    if (isset($_GET["message0"])) {
        $key = $_GET["message0"];
        $tt = 0;

        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
            echo '<script type="text/javascript">
          $(document).ready(function(){
            let feedback =  document.getElementById("feedback").value;
              swal({
                  type: "success",
                  title: "Success",
                  text: feedback,
                  showConfirmButton: true,
                  timer: 7000
              })
          });
          </script>
          ';
            $_SESSION["lack_of_intfund_$key"] = 0;
        }
    } else if (isset($_GET["message1"])) {
        $key = $_GET["message1"];
        $tt = 0;
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
            echo '<script type="text/javascript">
          $(document).ready(function(){
            let feedback =  document.getElementById("feedback").value;
              swal({
                  type: "error",
                  title: "Error",
                  text: feedback,
                  showConfirmButton: true,
                  timer: 7000
              })
          });
          </script>
          ';
            $_SESSION["lack_of_intfund_$key"] = 0;
        }
    }
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                    <img src="uploads/tool-shop-2.png" style="width: 35px" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">Holy Family</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->

            <div class="sidebar-heading">
                Church Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="clients.php">
                    <i class="fas fa-users"></i>
                    <span>Members</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Societies and Others</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Products management:</h6>
                        <?php
                        if ($findPermissions['mass_booking'] == 1) {
                        ?>
                            <a class="collapse-item" href="products.php">Mass Booking</a>
                        <?php
                        }
                        ?>
                        <!-- <a class="collapse-item" href="fixed_price.php">SMS</a>
                        <a class="collapse-item" href="requests.php">RDP Requests</a> -->

                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-users"></i>
                    <span>Transactions</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Transactions:</h6>
                        <?php
                        if ($findPermissions['subscriptions'] == 1) {
                        ?>
                            <a class="collapse-item" href="transactions.php">All Transactions</a>
                            <a class="collapse-item" href="transactions_approval.php">Donations</a>
                            <a class="collapse-item" href="transactions_approval.php">Subscriptions</a>
                        <?php
                        }

                        ?>


                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="support.php?view=REQUEST">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Message</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="warnings.php">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>Feeds/Annoucements</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                System
            </div>


            <!-- Nav Item - Tables -->

            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-user"></i>
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupport" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Configurations</span>
                </a>
                <div id="collapseSupport" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"></h6>
                        <a class="collapse-item" href="support.php?view=TICKET">Subscription Model</a>
                        <a class="collapse-item" href="users.php">Users</a>
                    </div>
                </div>
            </li>
            <?php

            if ($usertype == "USER") {
            ?>
                <!-- Nav Item - Products -->
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Calendar</span></a>
                </li>
                <!-- Nav Item - Transactions -->
                <!-- <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Transactions</span></a>
            </li> -->
                <!-- Nav Item - Support -->
                <li class="nav-item active">
                    <a class="nav-link" href="user_view.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Profile</span></a>
                </li>
                <!-- Nav Item - Account -->
                <li class="nav-item active">
                    <a class="nav-link" href="account.php">
                        <i class="fas fa-user"></i>
                        <span>Orgaizations</span></a>
                </li>
            <?php
            }
            ?>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <!-- Counter - Alerts -->
                                <?php
                                // $request = selectAll('notifications', ['userid' => $userId, 'viewed' => 0]);
                                // $unAssigned = 0;
                                // if ($rank == 1) {
                                //     $unAssigned = selectAll('notifications', ['userid' => 0, 'viewed' => 0]);
                                //     $totalAlerts = count($request) + count($unAssigned);
                                // } else {
                                //     $totalAlerts = count($request);
                                // }


                                // if ($totalAlerts > 0) {
                                ?>
                                    <i class="fas fa-bell fa-fw" style="color:red"></i>
                                    <span class="badge badge-danger badge-counter">0<?php //echo $totalAlerts  ?></span>
                                <?php
                                // } else {
                                ?>
                                    <!-- <i class="fas fa-bell fa-fw"></i>
                                    <span class="badge badge-danger badge-counter"></span> -->
                                <?php
                                // }
                                ?>
                            </a>

                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <?php
                                // foreach ($request as $notication) {
                                //     $supportid = $notication['support_id'];
                                ?>
                                    <a class="dropdown-item d-flex align-items-center" href="support_ticket.php?view=<?php echo $supportid ?>&status=1">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500"></div>
                                            <i class='far fa-circle' style='font-size: 22px; color:yellow'></i> <?php //echo $notication['description'] ?> <span style="color: yellow">Answered</span>
                                        </div>
                                    </a>
                                <?php
                                // }
                                ?>
                                <?php
                                // if ($rank == 1) {
                                //     foreach ($unAssigned as $notications) {
                                //         $supportid = $notications['support_id'];
                                //         $requestId = $notications['rdp_request_id'];
                                //         if ($requestId > 0) {
                                //             $address = "requests.php";
                                //         } else {
                                //             $address = "support_ticket.php?view=$supportid&status=1";
                                //         }
                                ?>
                                        <a class="dropdown-item d-flex align-items-center" href="<?php //echo $address ?>">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"></div>
                                                <i class='far fa-circle' style='font-size: 22px; color:yellow'></i> <?php //echo $notications['description'] ?>
                                            </div>
                                        </a>
                                <?php
                                //     }
                                // }
                                ?>
                                <a class="dropdown-item text-center small text-gray-500" href="#">As at Today - <span class="font-weight-bold"><?php echo date('Y-M-d') ?></span></a>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php //echo $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->