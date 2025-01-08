<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'pet_adoption');

  echo "<script> window.open('doctor_login.php','_self') </script>";

session_destroy();

?>