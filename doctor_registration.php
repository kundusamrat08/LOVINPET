<?php
require 'db.php';
$name = $email = $password = $number = $logo = '';

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $fees = $_POST['fees'];
    // $user_Type ='Seller';
    $photo = $_FILES["photo"]['name'];
    $docu = $_FILES["docu"]['name'];

//   $query = "INSERT INTO seller_list VALUES('$name', '$email','$password', '$number', '$user_Type', '$logo','Not Approved')";
$query = "INSERT INTO doctor (Doctor_name, Doctor_email, Doctor_password, Doctor_number, city, fees, photo, docu_img, status) VALUES ('$name', '$email', '$password', '$number', '$city','$fees','$photo','$docu', 'Not Approved')";

  $query_run=mysqli_query($conn,$query);
  if($query_run)
  {
    move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" .$_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["docu"]["tmp_name"], "upload/" .$_FILES["docu"]["name"]);
    header("location: doctor_login.php");
  }
  else {
    // header("location: doctor_login.php"); 
    $error_message = "Invalid Input";
  }
  // echo "<script> alert('Register Successfully'); </script>";
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="css/seller_regsitration.css">
</head>
<body>
    <!-- <div class="container">
        <h2>Doctor Registration</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="number">Phone Number</label>
            <input type="text" id="number" name="number" required>

            <label for="number">Fees</label>
            <input type="number" id="number" name="fees" required>

            <label for="logo">Logo</label>
            <input type="file" id="logo" name="logo" required>

            <input type="submit" name="submit" value="Register">
        </form>
    </div> -->

    <?php if(isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div class="container">
    <div class="heading">Doctor Registration</div>
    <form action="" class="form"  method="POST" enctype="multipart/form-data" autocomplete="off">
      <input class="input" type="text" id="name" name="name" placeholder="Full Name" required>
      <input class="input" type="email" name="email" id="email" placeholder="Email" required>
      <input class="input" type="number" id="number" name="number" placeholder="Phone Number" required>
      <input class="input" type="text" id="city" name="city" placeholder="City" required>
      <input class="input" type="password" name="password" id="password" placeholder="Password" required><br><br>
      <span class="forgot-password"><a href="#photo"><b>Upload Your Photo</b></a></span>
      <input class="input" type="file" id="photo" name="photo" required>
      <span class="forgot-password"><a href="#docu"><b>Upload Your ID Proof</b></a></span>
      <input class="input" type="file" id="docu" name="docu" required>
      <input class="input" type="number" id="number" name="fees" placeholder="₹Fees" required>
      <input class="login-button" type="submit" name="submit" value="Register">
      <span class="forgot-password">Have an account? <a href="doctor_login.php">Login</a></span>
    </form>   
    </div>
</body>
</html>
