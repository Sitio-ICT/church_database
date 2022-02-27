<?php
/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
include('functions/connect.php');
// Initialize the session
session_start();
// YHA
$_SESSION['timestamp'] = time();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array();
    $success = array();

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = test_input($_POST["email"]);

    // ensure that the user exists on our system
    $results = selectOne('users', ['email' => $email]);

    if (empty($email)) {
        array_push($errors, "Your email is required");
    } else if (!isset($results)) {
        array_push($errors, "Sorry, no user exists on our system with that email");
    }

    // generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
        // store token in the password-resets database table against the user's email
        $results = create('password_resets', ['email' => $email, 'token' => $token]);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Reset Password Notification | Holy Family";
        $msg = "Hi there, click on this <a href=\"https://holyfamily.com.ng/reset-password.php?token=" . $token . "\">link</a> to reset your password on our site.";
        $msg = wordwrap($msg, 70);
        $headers = "From: no-reply@holyfamily.com.ng";
        $mailed = mail($to, $subject, $msg, $headers);

        if ($mailed) {
            array_push($success, "We sent an email to  <b>'. $email . '</b> to help you recover your account.\\n
            Please login to your email account and click on the link we sent to reset your password.");
            echo '
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            icon: "success",
                            title: "Success",
                            text: "We sent an email to  <b>' . $email . '</b> to help you recover your account.\\n
                                    Please login to your email account and click on the link we sent to reset your password.",
                            button: false,
                            timer: 5000
                        }).then(function() {
                            window.location.href = "login.php";
                        });
                    });
                </script>
            ';
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

    <title>Holy Family Catholic Church</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <?php if (isset($errors)) : ?>
                                    <?php if (count($errors) > 0) : ?>
                                        <?php foreach ($errors as $error) : ?>
                                            <div class="alert alert-danger"><?php echo $error ?></div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                <?php endif ?>
                                <?php if (isset($success)) : ?>
                                    <?php if (count($success) > 0) : ?>
                                        <?php foreach ($success as $success) : ?>
                                            <div class="alert alert-success"><?php echo $success ?></div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                <?php endif ?>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        </div>
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