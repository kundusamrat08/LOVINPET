<?php
session_start(); // Start the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "pet_adoption";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $otp_entered = isset($_POST['otp']) ? $_POST['otp'] : '';

    // Retrieve OTP from the database
    $get_otp_sql = "SELECT otp FROM users WHERE email='$email'";
    $result = $conn->query($get_otp_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_otp = $row['otp'];

        // Verify the entered OTP
        if ($otp_entered == $stored_otp) {
            // OTP is correct, redirect to success page
            header("Location: success.php");
            exit();
        } else {
            // Incorrect OTP, display error message
            $msg = "Invalid OTP. Please try again.";
        }
    } else {
        // Email not found in the database
        $msg = "Email not found in our records. Please try again.";
    }

    $conn->close();
}

// If no POST data and no email in session, redirect to the forgot password page
if (!isset($_SESSION['email'])) {
    echo "Email not set in session. Please make sure you are redirected from the forgot password page.";
    exit();
}
?>




<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>OTP Verification</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="login_css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

<?php   
include ('temp/nav_c.php');
?>
<!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <!-- <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div> -->
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img class="ov" src="images/Downloader.la-6612968a13145.png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Verify OTP</h2>
                        <p>OTP has been sent Successfully, Check Your Registered Email</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" id="otp" name="otp" required autocomplete="off">
                            <button name="submit" class="btn" type="submit">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->
<?php 
include ('temp/lg_footer.php');
?>
    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>