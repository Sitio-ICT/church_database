<?php

include('header.php');
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findRights['product'] != 1) {
    $_SESSION["feedback"] = "You do not have permission!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?message1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

$findSms = selectOne('fixed_price', ['product_name' => 'sms']);
// Processing form data when form is submitted

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">SMS</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="functions/business/sms_price.php">

                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="text" name="price" value="<?php echo $findSms['price'] ?>" class="form-control">
                        </div>
                        <button type="reset" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Reset</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        

    </div>

</div>
<!-- /.container-fluid -->



<?php

include('footer.php');

?>