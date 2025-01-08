<?php
session_start();
$msg = "";
if(isset($_POST['entered_otp']) && isset($_POST['email'])) {
    $entered_otp = $_POST['entered_otp'];
    $email = $_POST['email'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "pet_adoption";
    
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $check_otp_sql = "SELECT otp FROM users WHERE email='$email'";
    $result = $conn->query($check_otp_sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_otp = $row['otp'];
        
        if($entered_otp == $stored_otp) {
            // Update user as verified
            $update_sql = "UPDATE users SET verified = 1 WHERE email = '$email'";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: index.php");
                exit();
            } else {
                // echo "Error updating record: " . $conn->error;
                $msg = "<div class='alert alert-danger'>Error updating record:{$conn->error}</div>";
            }
        } else {
            // echo "Incorrect OTP. Please try again.";
            $msg = "<div class='alert alert-danger'>Incorrect OTP. Please try again.</div>";
        }
    } else {
        // echo "User not found.";
        $msg = "<div class='alert alert-info'>User not found.</div>";
    }
    
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Verify Otp</title>
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
                        <p>OTP has been sent Successfully, Check Your Email</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="email" name="entered_otp" placeholder="Enter Your OTP" required autocomplete="off">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
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