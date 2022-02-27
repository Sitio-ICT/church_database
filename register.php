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
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- feedback to customer using sweet alert -->
    <?php
    session_start();
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
                  
              })
          });
          </script>
          ';
            $_SESSION["lack_of_intfund_$key"] = 0;
        }
    }
    ?>


</head>

<body class="bg-gradient-light">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="functions/people/users/register_user.php" method="POST">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="firstname" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="lastname" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="email" class="form-control form-control-user" id="email" placeholder="Email">
                                        <div id="emailed"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="username" placeholder="Username">
                                        <div id="usernamed"></div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#email').on("change blur click", function() {
                                            var email = $('#email').val();
                                            $.ajax({
                                                url: "functions/system/ajax_functions/check_email.php",
                                                method: "POST",
                                                data: {
                                                    email: email
                                                },
                                                success: function(data) {
                                                    $('#emailed').html(data);
                                                }
                                            })
                                        });

                                        $('#username').on("change blur click", function() {
                                            var username = $('#username').val();
                                            $.ajax({
                                                url: "functions/system/ajax_functions/check_username.php",
                                                method: "POST",
                                                data: {
                                                    username: username
                                                },
                                                success: function(data) {
                                                    $('#usernamed').html(data);
                                                }
                                            })
                                        });
                                    });
                                    // add confirm password script
                                </script>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="passkey" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="password" name="confirm_passkey" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" onclick="show()">
                                            Show Password
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <script>
                                        function show() {
                                            var x = document.getElementById("exampleInputPassword");
                                            if (x.type === "password") {
                                                x.type = "text";
                                            } else {
                                                x.type = "password";
                                            }
                                        }
                                    </script>
                                </div>
                                <p>
                                    <?php echo $_SESSION['feedback']; 
                                    ?>
                                </p>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>

                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot_password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>