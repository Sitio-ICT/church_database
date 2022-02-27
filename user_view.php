<?php

include('header.php');

$clientId = $_GET["view"];
$findClient = selectOne('users', ['id' => $clientId]);
if ($findClient['rank'] == 1) {
    $view = "SUPPORT";
} else if ($findClient['rank'] == 2) {
    $view = "REPORT";
} else if ($findClient['rank'] == 3) {
    $view = "TICKET";
} else if ($findClient['rank'] == 4) {
    $view = "REQUEST";
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findClient['username'] ?></h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bio Info</h6>
                </div>
                <div class="card-body">
                    <!-- <form action=""> -->
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control form-control-user" name="branch" value="<?php echo $findClient['username'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Contact Details</label>
                    </div>
                    <p>
                        <i class="fas fa-envelope"></i> : <a href="mailto:<?php echo $findClient['email'] ?>"><?php echo $findClient['email'] ?></a>
                    </p>

                    <div class="form-group">
                        <label for="">Status</label>
                        <input type="text" class="form-control form-control-user" name="branch" value="<?php echo $findClient['status'] ?>" readonly>
                    </div>
                    <?php
                    if ($findClient['status'] == "ACTIVE") {
                    ?>
                        <a href="functions/people/users/ban.php?ban=<?php echo $clientId ?>" class="btn btn-danger ">Block User</a>
                    <?php
                    } else {
                    ?>
                        <a href="functions/people/users/activate.php?active=<?php echo $clientId ?>" class="btn btn-success ">Activate</a>
                    <?php
                    }
                    ?>

                    <a href="#" class="btn btn-info " data-toggle="modal" data-target="#fund">Permissions</a>
                    <!-- Modal -->
                    <form action="functions/people/users/update_permisssions.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="modal fade" id="fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">User Permission</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <select name="rank" id="rank" class="form-control">
                                                    <option value="1">Admin</option>
                                                    <option value="2">Reports</option>
                                                    <option value="3">Tickets</option>
                                                    <option value="4">Requests</option>
                                                    <option value="5">Tickets and Requests</option>
                                                </select>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    $('#rank').on("click", function() {
                                                        var rank = $('#rank').val();
                                                        $.ajax({
                                                            url: "functions/system/ajax_functions/permissions.php",
                                                            method: "POST",
                                                            data: {
                                                                rank: rank
                                                            },
                                                            success: function(data) {
                                                                $('#permissions').html(data);
                                                            }
                                                        })
                                                    });
                                                });
                                            </script>
                                            <div id="permissions"></div>
                                            <input type="text" value="<?php echo $clientId ?>" name="user" hidden>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /modal ends here -->
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!-- user support issues assigned -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Assigned Support</h6>
                    </div>
                    <div style="float:right">

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th><?php echo $view ?> ID</th>
                                    <th><?php echo $view ?> Info</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Topic</th>
                                    <th><?php echo $view ?> ID</th>
                                    <th><?php echo $view ?> Info</th>
                                    <th>Product</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php

                                $findTicket = selectAllWithOrder('support', ['admin' => $clientId], 'id', 'DESC');

                                foreach ($findTicket as $ticket) {
                                ?>
                                    <tr>
                                        <td><?php echo $ticket['topic']; ?></td>
                                        <td><?php echo $ticket['ticket_id']; ?></td>
                                        <th><?php echo $ticket['complaint'] ?></th>
                                        <td>
                                            <?php
                                            if ($ticket['products_id'] > 0) {
                                                $productId =  $ticket['products_id'];
                                                $findProduct = selectOne('products', ['id' => $productId]);
                                                echo $findProduct['product_type'];
                                            } else {
                                                echo $ticket['product_name'];
                                            }
                                            ?>
                                        </td>
                                        <th><?php echo $ticket['urgency'] ?></th>
                                        <th>
                                            <?php
                                            if ($ticket['is_resolved'] == 0) {
                                                if ($ticket['admin_viewed'] == 0) {
                                                    echo "<span style='color: red'><i class='far fa-circle' style='font-size: 22px;'></i> New</span>";
                                                } else {
                                                    echo "<span style='color: yellow'><i class='far fa-circle' style='font-size: 22px;'></i> Open</span>";
                                                }
                                            } else {
                                                echo "<span style='color: green'><i class='far fa-circle' style='font-size: 22px;'></i> Closed</span>";
                                            }
                                            ?>
                                        </th>
                                        <th>
                                            <a href="support_ticket.php?view=<?php echo $ticket['id'] ?>" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">View</span>
                                            </a>
                                        </th>

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

</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>