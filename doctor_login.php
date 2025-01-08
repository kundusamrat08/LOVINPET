<?php
session_start();
if(isset($_POST["submit"])){

$con=mysqli_connect("localhost","root","","pet_adoption");
// Check connection

if(mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM doctor where Doctor_email='" . $email . "' and Doctor_password='" . $password . "'";

$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result);

if($row==null)
{
  $error_message = "Invalid id/password";
}elseif ($row['status'] == 'Not Approved') {
  $error_message = "Your account has not been approved yet. Please wait for approval.";
}else
{   
    //check wheather the employer has approved or not
    session_start();    
	$_SESSION['email'] = $row['Doctor_email'];
	// $_SESSION['name'] = $row['Seller_name'];
	// $_SESSION['logo'] = $row['cpny_logo'];

	header( 'Location: doctor_panel.php' ) ;
}
mysqli_close($con);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="css/seller_login.css">
</head>
<body>
    <!-- <div class="container">
        <h2>Doctor Login</h2>
        <form method="POST">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="submit" value="Login">
        </form>
    </div> -->

    <?php if(isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <div class="container">
    <div class="heading">Doctor Login</div>
    <form action="" class="form"  method="post">
      <input class="input" type="email" name="email" id="email" placeholder="Email" required>
      <input class="input" type="password" name="password" id="password" placeholder="Password" required>

      <input class="login-button" type="submit" name="submit" value="Login">
      <span class="forgot-password">Don't have an account? <a href="doctor_registration.php">Register</a></span>
    </form>   
    </div>
</body>
</html>
