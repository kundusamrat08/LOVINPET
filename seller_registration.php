<?php
// require 'db.php';
// $name = $email = $password = $number = $logo = '';

// if(isset($_POST["submit"])){
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $number = $_POST['number'];
//     // $user_Type ='Seller';
//     $logo = $_FILES["logo"]['name'];


// $query = "INSERT INTO seller_list (Seller_name, Seller_email, seller_password, seller_number, logo, status) VALUES ('$name', '$email', '$password', '$number', '$logo', 'Not Approved')";

//   $query_run=mysqli_query($conn,$query);  
//   if($query_run)
//   {
//     move_uploaded_file($_FILES["logo"]["tmp_name"], "upload/" .$_FILES["logo"]["name"]);
//     header("location: seller_login.php");
//   }
//   else{

//     $error_message = "Invalid Input";
//   }
//   // echo "<script> alert('Register Successfully'); </script>";
  
// }
?>

<?php
require 'db.php';
$name = $email = $password = $number = $logo = '';

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $logo = $_FILES["logo"]['name'];

    // Check if email already exists
    $check_email_query = "SELECT * FROM seller_list WHERE Seller_email='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if(mysqli_num_rows($check_email_result) > 0){
        // Email already exists
        $error_message = "Email already exists.";
    } else {
        // Proceed with insertion
        $query = "INSERT INTO seller_list (Seller_name, Seller_email, seller_password, seller_number, logo, status) VALUES ('$name', '$email', '$password', '$number', '$logo', 'Not Approved')";

        $query_run = mysqli_query($conn, $query);  
        if($query_run){
            move_uploaded_file($_FILES["logo"]["tmp_name"], "upload/" . $_FILES["logo"]["name"]);
            header("location: seller_login.php");
        } else {
            $error_message = "Invalid Input";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <link rel="stylesheet" href="css/seller_regsitration.css">
</head>
<body>
    <!-- <div class="container">
        <h2>Seller Registration</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="number">Phone Number</label>
            <input type="text" id="number" name="number" required>

            <label for="logo">Logo</label>
            <input type="file" id="logo" name="logo" required>

            <input type="submit" name="submit" value="Register">
        </form>
    </div> -->
    <?php if(isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div class="container">
    <div class="heading">Seller Registration</div>
    <form action="" class="form"  method="POST" enctype="multipart/form-data">

      <input class="input" type="text" id="name" name="name" placeholder="Full Name" required>
      <input class="input" type="email" name="email" id="email" placeholder="Email" required>
      <input class="input" type="number" id="number" name="number" placeholder="Phone Number" required>
      <input class="input" type="password" name="password" id="password" placeholder="Password" required><br><br>
      <span class="forgot-password"><a href=""><b>Upload Your ID Proof</b></a></span>
      <input class="input" type="file" id="logo" name="logo" required>
      <input class="login-button" type="submit" name="submit" value="Register">
      <span class="forgot-password">Have an account? <a href="seller_login.php">Login</a></span>
    </form>   
    </div>
</body>
</html>
