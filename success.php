<?php
session_start(); // Start the session

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
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Update password in the database
    $update_password_sql = "UPDATE users SET password='$new_password' WHERE email='$email'";
    if ($conn->query($update_password_sql) === TRUE) {
        // echo "Password updated successfully.";
        header("Location: login.php");
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Reset Password</title>
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
                            <img class="ss" src="images/[Downloader.la]-6612988d73317ss.png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Reset Password</h2>
                        <p>You have successfully verified your OTP. You can now change your password.</p>
                        <form action="" method="post">
                            <input type="password" class="password" name="new_password" placeholder="Enter Your New Password" required>
                            <button name="submit" class="btn" type="submit">Change Password</button>
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