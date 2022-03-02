<?php

include('header.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">MANUAL TRANSACTIONS</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Record Transaction</h6>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <?php
                        
                        // $input = 'Samuel';
                        // $condition2 = [
                        //     'first_name' => $input,
                        //     'last_name' => $input,
                        //     'middle_name' => $input,
                        //     'registration_no' => $input
                        // ]; 
                        // $findMember = selectOneLikeOR2('profile', [''], $condition2);
                        // var_dump($findMember);
                        ?>
                        <div class="form-group">
                            <label for="">Member</label>
                            <input type="text" name="indetifier" id="identifier" class="form-control">
                        </div>
                        <div id="member"></div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control">
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#identifier').on("keyup change blur", function() {
                                    var identifier = $(this).val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/members.php",
                                        method: "POST",
                                        data: {
                                            identifier: identifier
                                        },
                                        success: function(data) {
                                            $('#member').html(data);
                                        }
                                    })
                                });
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