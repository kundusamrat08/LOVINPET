<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$msg = ""; // Initialize $msg variable here

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
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $otp = mt_rand(100000, 999999); // Generate random OTP

    // Verify email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
    } else {
        // Check if email already exists
        $check_email_sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check_email_sql);
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-info'>Email already exists.</div>";
        } else {
            // Insert user data into database with OTP
            $sql = "INSERT INTO users (username, email, password, otp) VALUES ('$username', '$email', '$password', '$otp')";
            if ($conn->query($sql) === TRUE) {
                // Send OTP via email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'lovinpet.service@gmail.com';
                    $mail->Password = 'fdxh xhjw hikr eznn';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('lovinpet.service@gmail.com');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'OTP for Registration';
                    $mail->Body = "Your OTP is: $otp";

                    $mail->send();

                    $_SESSION['email'] = $email;
                    $_SESSION['otp'] = $otp;

                    header("Location: verify_otp.php");
                    exit();
                } catch (Exception $e) {
                    $msg = "<div class='alert alert-danger'>Failed to send OTP. Error: {$mail->ErrorInfo}</div>";
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Register</title>
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
                            <img class="rg" src="images/dl.beatsnoop.com-ultra-jq5X049tsz.png" alt="">
                       </div>   
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now!</h2>
                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p> -->
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="username" placeholder="Enter Your Name" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a class="ld" href="login.php">Login</a>.</p>
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