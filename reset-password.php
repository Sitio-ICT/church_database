<?php
/*
  Enter a new password
*/
include('functions/connect.php');
// Initialize the session
session_start();
// $_SESSION['token'] = $_GET['token'];
// YHA
$_SESSION['timestamp'] = time();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array();

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $new_pass = test_input($_POST['new_pass']);
    $new_pass_c = test_input($_POST['new_pass_c']);

    // Grab the token that came from the email link
    $token = $_POST['token'];

    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");

    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");

    if (count($errors) == 0) {
        // select email address of user from the password_resets table 
        $results = selectOne('password_resets', ['token' => $token]);
        $email = $results['email'];

        if ($email) {
            $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $update_password = update('users', $email, 'email', ['password' => $new_pass]);
            // $update_password = mysqli_query($connection, "UPDATE users SET password = '$new_pass' WHERE email = '$email'");

            if ($update_password) {
                echo '
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                icon: "success",
                                title: "Success",
                                text: "Password Reset Successful!",
                                button: false,
                                timer: 3000
                            }).then(function() {
                                window.location.href = "login.php";
                            });
                        });
                    </script>
                ';
            } else {
                array_push($errors, "Password Reset Failed!");
                // echo '
                //     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                //     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                //     <script type="text/javascript">
                //         $(document).ready(function(){
                //             swal({
                //                 icon: "fail",
                //                 title: "Failed",
                //                 text: "Password Reset Failed!",
                //                 button: false,
                //                 timer: 3000
                //             })
                //         });
                //     </script>
                // ';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Toolshop | Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background-color: #003A99;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <?php if (isset($errors)) : ?>
                    <?php if (count($errors) > 0) : ?>
                        <?php foreach ($errors as $error) : ?>
                            <div class="alert alert-danger"><?php echo $error ?></div>
                        <?php endforeach ?>
                    <?php endif ?>
                <?php endif ?>

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="uploads/images_2.jfif" style="margin-left: -50px;" width="140%" alt="" /></div>
                            <div class="col-lg-6" style="background-color: #011716">
                                <div class="p-5">
                                    <div class="text-center mb-3"><img src="uploads/tool-shop-2.png" style="max-width: 80px" alt=""></div>
                                    <div class="text-center">
                                        <h1 class="h4 text-light mb-4">Reset Password</h1>
                                    </div>
                                    <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="text" hidden name="token" value="<?php echo $_GET['token'] ?>">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="" placeholder="New password" name="new_pass" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="" placeholder="Confirm new password" name="new_pass_c" required>
                                        </div>
                                        <!-- <a href="#" class="btn btn-primary btn-user btn-block">
                                            
                                        </a> -->
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
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