<?php

include('header.php');

$randms = generateRandomString(5);

if ($findPermissions['subscriptions'] != 1) {
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

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Fixed Price</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mass Booking</h6>
                </div>
                <div class="card-body">
                    <form action="functions/system/edit_mass_price.php" method="post">
                        <?php
                        $findPrice = selectOne('fixed_price', ['price_type' => "mass"]);
                        ?>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="<?php echo $findPrice['price'] ?>" required>
                        </div>

                        <script>
                            $(document).ready(function() {

                                $('#amount').on("change blur", function() {
                                    var amount = $(this).val();
                                    $.ajax({
                                        url: "functions/system/converter.php",
                                        method: "POST",
                                        data: {
                                            amount: amount
                                        },
                                        success: function(data) {
                                            $('#amount').val(data);
                                        }
                                    })
                                });

                            });
                        </script>
                        
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary">Change Price</button>
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