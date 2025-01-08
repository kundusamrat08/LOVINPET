<?php
$con=mysqli_connect("localhost","root","","pet_adoption");

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: Trainer_login.php");
    exit();
}

if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM trainer WHERE Trainer_email='$email'";
$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer & Groomer Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Additional custom styles can be added here */
    
        body{
            background-color: #c50035;
            background-image: url(https://d1oco4z2z1fhwp.cloudfront.net/templates/default/6791/bg_pet.png);
        }
        .container {
            margin-top: 50px;
        }
        .doctor-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1{
            color: cornsilk;
            margin-bottom: 25px;
            text-align:center;
        }
        .logo-img {
            max-width: 100px;
            height: auto;
        }
        .booking-info {
            background-color: cornsilk;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        button{
            background-color: #c50035;
            color: white;
            border-radius: 10px;
        }
        a{
            text-decoration: none;

            color: white;
        }
        a:hover{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">

    <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="doctor-info text-center">
                    <h2>Welcome, <?php echo $row['Trainer_name']; ?></h2>
                    <p>Email: <?php echo $row['Trainer_email']; ?></p>
                    <p>Phone Number: <?php echo $row['Trainer_number']; ?></p>
                    <!-- <p><img src="upload/<?php echo $row['photo']; ?>" alt="Doctor Logo" class="logo-img"></p> -->
                    <button><a href="trainer_logout.php">LOGOUT</a></button>
                </div>
            </div>
        </div>

        <h1 class="mt-5">Recent Client Bookings</h1>
        <?php
        require 'db.php';

        $query = "SELECT * FROM trainer_booking WHERE status = 'Approved' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        
        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                echo "<div class='booking-info'>";
                echo "<p><strong>Client Name:</strong> " . $row['client_name'] . "</p>";
                echo "<p><strong>Client Email:</strong> " . $row['clinet_email'] . "</p>";
                echo "<p><strong>Client Phone:</strong> " . $row['client_phone'] . "</p>";
                echo "</div>";
            }
        } else {

            echo "<p>No approved bookings.</p>";
        }
        ?>
    </div>
</body>
</html>
<?php
} else {
    echo "No doctor found with this email.";
}

mysqli_close($con);
?>