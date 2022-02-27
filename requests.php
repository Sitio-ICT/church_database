<?php

include('header.php');
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findRights['product'] != 1) {
    $_SESSION["feedback"] = "You do not have Support permission!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?message1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">RDP REQUESTS</h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">RDP Request</h6>
                </div>
                <div class="card-body">
                    <?php echo $_SESSION['feedback'] ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>RDP</th>
                                    <th>Value</th>
                                    <th>Sent On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>User</th>
                                    <th>RDP</th>
                                    <th>Value</th>
                                    <th>Sent On</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findRequest = selectAllWithOrder('rdp_request', [''], 'id', 'DESC');
                                foreach ($findRequest as $request) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $clientId = $request['userid'];
                                            $findUser = selectOne('users',  ['id' => $clientId]);
                                            echo $findUser['username'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $productId = $request['products_id'];
                                            $findProduct = selectOne('products',  ['id' => $productId]);
                                            echo $findProduct['country'] . "<br>" . "$ " . $findProduct['price'] . "<br>" . $findProduct['description'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($request['meta'] != "") {
                                                $values = json_decode($request['meta']);
                                                foreach ($values as $key => $value) {
                                                    echo "$key = <b>$value</b> <br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $request['date_updated'] ?></td>
                                        <td>
                                            <?php
                                            if ($request['status'] == 0){
                                            ?>
                                            <a href="functions/business/refund_rdp.php?refund=<?php echo $request['products_id'] ?>&id=<?php echo $request['id'] ?>&purchase=<?php echo $request['purchase_id'] ?>" class="btn btn-warning">Refund</a>
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#bookLoan<?php echo $request['id']; ?>">
                                                View
                                            </a>
                                            <!-- Modal -->
                                            <form action="functions/business/create_rdp.php" method="post" enctype="multipart/form-data" autocomplete="off">
                                                <div class="modal fade" id="bookLoan<?php echo $request['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Requested by <b><?php echo $findUser['username'] ?></b></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="text" value="<?php echo $request['id'] ?>" name="request" hidden>
                                                                <input type="text" value="<?php echo $request['userid'] ?>" name="client" hidden>
                                                                <div class="form-group">
                                                                    <label for="">RDP</label>
                                                                    <textarea required name="product" placeholder="Use | to seperate - IP|email|password" id="value" class="form-control" cols="30" rows="10"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <!-- <button type="submit" class="btn btn-warning">Deny</button> -->
                                                                <button type="submit" class="btn btn-primary">Create</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- /modal ends here -->
                                            <?php
                                            } else if($request['status'] == 1){
                                                echo "<span style='color: green'><i class='far fa-circle' style='font-size: 22px;'></i> Value Sent</span>";
                                            } else if($request['status'] == 2){
                                                echo "<span style='color: yellow'><i class='far fa-circle' style='font-size: 22px;'></i> Refunded</span>";
                                            }
                                            ?>
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

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>