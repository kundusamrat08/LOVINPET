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
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Check if email exists in the database
    $check_email_sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email_sql);
    if ($result->num_rows > 0) {
        // Store email in session
        $_SESSION['email'] = $email;

        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Store OTP in the database
        $update_otp_sql = "UPDATE users SET otp='$otp' WHERE email='$email'";
        if ($conn->query($update_otp_sql) === TRUE) {
            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'lovinpet.service@gmail.com'; // Your Gmail address
                $mail->Password = 'fdxh xhjw hikr eznn'; // Your Gmail password
                // $mail->Username = 'samratk271@gmail.com'; // Your Gmail address
                // $mail->Password = 'wlwa utbw skkv xamg'; // Your Gmail password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('lovinpet.service@gmail.com'); // Your Gmail address
                // $mail->setFrom('samratk271@gmail.com'); // Your Gmail address
                $mail->addAddress($email); // Recipient email

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'OTP for Password Reset';
                $mail->Body = "Your LovinPet Password Reset OTP is: $otp";

                $mail->send();
                // Redirect to OTP verification page
                header("Location: otp_verification_new.php");
                exit();
            } catch (Exception $e) {
                echo "Failed to send OTP. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error updating OTP: " . $conn->error;
        }
    } else {
        // echo "Email not found in our records. Please enter a valid email address.";
        $msg = "<div class='alert alert-danger'>Email not found in our records. Please enter a valid email address.</div>";
    }

    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Forget Password</title>
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
include ('temp/nav.php');
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
                            <img class="fp" src="images/[Downloader.la]-661282df441599.png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Forgot Password</h2>
                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p> -->
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <button name="submit" class="btn" type="submit">Send Reset OTP</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a class="ld" href="login.php">Login</a>.</p>
                        </div>
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