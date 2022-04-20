<?php

include("functions/methods.php");
session_start();
// include("ajaxcall.php");
if (!$_SESSION["loggedin"] == True) {
    header("location: login.php");
    exit;
}
$profile_id = $_SESSION['profile_id'];
$user_type = $_SESSION['usertype'];
// find admin permissions
$findPermissions = findPermissions($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="The Holy Family Catholic Church membership CRM, built to allow the church and its members to digitize key processes">
    <meta name="author" content="Sitio ICT">

    <title>Holy Family Catholic Church</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <!-- tinyMce -->
    <script src="https://cdn.tiny.cloud/1/05uzyhq8bcam7g5r97qftgykpmc0nghqqrqg1o9oeb2laxq5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    <link rel="icon" type="image/png" href="uploads/logo.png" />

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
                    <img src="uploads/logo.png" style="width: 35px" alt="">
                </div>
                <div class="sidebar-brand-text mx-3">Holy Family</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Heading -->
            <div class="sidebar-heading">
                Profile
            </div>

            <!-- Nav Item - Calendar -->
            <li class="nav-item ">
                <a class="nav-link" href="calender.php">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Calendar</span></a>
            </li>
            <!-- Nav Item - Donation/Tithe -->
            <!-- <li class="nav-item ">
                <a class="nav-link" href="payment.php">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Donate/Tithe</span></a>
            </li> -->
            <!-- Nav Item - Transactions -->
            <li class="nav-item ">
                <a class="nav-link" href="my_transactions.php">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Transactions</span></a>
            </li>
            <!-- Nav Item - Organizations -->
            <li class="nav-item ">
                <a class="nav-link" href="societies.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Organizations</span></a>
            </li>
            <!-- Nav Item - Book Mass -->
            <li class="nav-item ">
                <a class="nav-link" href="book_mass.php">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Book Mass</span></a>
            </li>
            <!-- Nav Item - Support -->
            <li class="nav-item ">
                <a class="nav-link" href="client_view.php?view=<?php echo $_SESSION['userid'] ?>">
                    <i class="fas fa-user"></i>
                    <span>Profile</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php

            if ($user_type == "admin") {
            ?>
                <!-- Church management begins here -->
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
                            <h6 class="collapse-header">Societies:</h6>
                            <a class="collapse-item" href="societies.php">Society</a>
                            <h6 class="collapse-header">Others:</h6>
                            <a class="collapse-item" href="record_sacrament.php">Record Sacrament</a>
                            <?php
                            if ($findPermissions['mass_booking'] == 1) {
                            ?>
                                <a class="collapse-item" href="mass_booking.php">Mass Booking</a>
                                <a class="collapse-item" href="feeds.php">Feeds/Annoucements</a>
                            <?php
                            }
                            ?>
                            <!-- 
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
                                <a class="collapse-item" href="manual_payment.php">Manual Payment</a>
                            <?php
                            }

                            ?>


                        </div>
                    </div>
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

                <?php
                if ($findPermissions['configurations'] == 1) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="sacraments.php">
                            <i class="fas fa-fw fa-info-circle"></i>
                            <span>Sacraments</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupport" aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-fw fa-cog"></i>
                            <span>Configurations</span>
                        </a>
                        <div id="collapseSupport" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header"></h6>
                                <!-- <a class="collapse-item" href="subscription.php">Subscription Model</a> -->
                                <a class="collapse-item" href="fixed_price.php">Fixed Price</a>
                            </div>
                        </div>
                    </li>
                <?php
                }

                ?>
                <!-- Church Management ends here -->



                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            <?php
            }
            ?>

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
                                <span class="badge badge-danger badge-counter">0<?php //echo $totalAlerts  
                                                                                ?></span>
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
                                <a class="dropdown-item d-flex align-items-center" href="#&status=1">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"></div>
                                        <i class='far fa-circle' style='font-size: 22px; color:yellow'></i> <?php //echo $notication['description'] 
                                                                                                            ?> <span style="color: yellow">Answered</span>
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
                                <a class="dropdown-item d-flex align-items-center" href="<?php //echo $address 
                                                                                            ?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"></div>
                                        <i class='far fa-circle' style='font-size: 22px; color:yellow'></i> <?php //echo $notications['description'] 
                                                                                                            ?>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php //echo $_SESSION['username'] 
                                                                                            ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
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