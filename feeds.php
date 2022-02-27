<?php

include('header.php');
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if ($findRights['approval'] != 1) {
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

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $product_type = test_input($_POST['product_type']);
    $warning = test_input($_POST['warning']);

    $warning_saved = selectOne('warnings', ['product_type' => $product_type])['warning'];

    if (empty($warning_saved)) {
        // create warning
        $warning_created = create('warnings', ['product_type' => $product_type, 'warning' => $warning]);

        if ($warning_created) {
            echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        icon: "success",
                        title: "Success",
                        text: "New Warning Created!",
                        button: false,
                        timer: 3000
                    });
                });
            </script>
            ';
        }
    } else {
        // update warning
        $warning_updated = update('warnings', $product_type, 'product_type', ['warning' => $warning]);

        if ($warning_updated) {
            echo '
                <script type="text/javascript">
                    $(document).ready(function() {
                        swal({
                            icon: "success",
                            title: "Success",
                            text: "Warning Updated!",
                            button: false,
                            timer: 3000
                        });
                    });
                </script>
            ';
        }
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Feeds/ Annoucements</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                        <div class="form-group">
                            <label for="">Feed type</label>
                            <select name="product_type" class="form-control" id="product_type" required>
                                <option value="account">Annoucements</option>
                                <option value="card">Bans of Marriage</option>
                                <option value="rdp">Feeds</option>
                            </select>
                        </div>
                        <div id="show-warning"></div>
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
        <!-- lists of users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Feeds</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Product Type</th>
                                    <th>Warning</th>
                                    <th>Date Posted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $warnings = selectAll('feeds');
                                foreach ($warnings as $warning) {
                                ?>
                                    <tr>
                                        <td><?php echo strtoupper($warning['feed_type']); ?></td>
                                        <td><?php echo $warning['message'] ?></td>
                                        <td><?php echo $warning['date_posted'] ?></td>
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

<script>
    $(document).ready(function() {
        var product_type = $('#product_type').val();
        $.ajax({
            url: "functions/warnings/show_warning.php",
            method: "POST",
            cache: false,
            data: {
                product_type: product_type
            },
            success: function(data) {
                $('#show-warning').html(data);
            }
        });

        $('#product_type').change(function() {
            var product_type = $(this).val();
            $.ajax({
                url: "functions/warnings/show_warning.php",
                method: "POST",
                cache: false,
                data: {
                    product_type: product_type
                },
                success: function(data) {
                    tinymce.remove();
                    $('#show-warning').html(data);
                    tinymce.init({
                        selector: '#warning'
                    });
                }
            });
        });
    });
</script>

<?php

include('footer.php');

?>