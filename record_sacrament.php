<?php

include('header.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">SACRAMENTS</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Record Sacraments</h6>
                </div>
                <div class="card-body">
                    <form action="functions/operations/receive_sacrament.php" method="post">

                        <div class="form-group">
                            <label for="">Member</label>
                            <input type="text" name="member" value="<?php echo $profile_id ?>" required readonly>
                        </div>
                        <div id="member"></div>

                        <div class="form-group">
                            <label for="">Sacraments</label>
                            <select name="sacrament" id="sacrament" class="form-control" required>
                                <?php
                                $findSacraments = findSacraments();
                                foreach ($findSacraments as $sacraments) {
                                ?>
                                    <option value="<?php echo $sacraments['id'] ?>"><?php echo $sacraments['tittle'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
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
                                
                                $('#sacrament').on("click change blur", function() {
                                    var sacrament = $(this).val();
                                    var profile = $('#profile').val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/find_received.php",
                                        method: "POST",
                                        data: {
                                            sacrament: sacrament,
                                            profile: profile
                                        },
                                        success: function(data) {
                                            $('#sacrament_received').html(data);
                                        }
                                    })
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label for="">Minister</label>
                            <input type="text" name="minister" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Date Received</label>
                            <input type="date" name="date" class="form-control">
                        </div>
                        <!-- <button type="reset" class="btn btn-danger">Reset</button> -->
                        <div id="sacrament_received"></div>
                        
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