<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");
$msg = "";
if (isset($_SESSION['email'])) {
    // Redirect to the dashboard if already logged in
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user has been verified
    $verified_sql = "SELECT verified FROM users WHERE email='$email'";
    $verified_result = mysqli_query($conn, $verified_sql);
    $row = mysqli_fetch_assoc($verified_result);
    $verified = $row['verified'];

    if ($verified == 1) { // User is verified
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['email'] = $email;
            header("Location: index.php");
        } else {
            // echo "Invalid email or password";
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    } else {
        // echo "Please verify your email first.";
        $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login</title>
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
                            <img class="ab" src="images/[GetPaidStock.com]-6611bbfc2b93b (2).png" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p> -->
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <p><a class="ld" href="forget.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        <div class="social-icons">
                            <p>Create Account! <a class="ld" href="register.php">Register</a>.</p>
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