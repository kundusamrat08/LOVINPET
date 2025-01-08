<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $details = $_POST['details'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $productId = $_POST['productId']; // Assuming you pass the product ID via hidden input
    $productname = $_GET['name']; // Assuming you pass the product ID via GET parameter
    $productcategory = $_GET['category']; // Assuming you pass the product ID via GET parameter
    $productbreed = $_GET['breed']; // Assuming you pass the product ID via GET parameter
    $productage = $_GET['age']; // Assuming you pass the product ID via GET parameter
    $productprice = $_GET['price']; // Assuming you pass the product ID via GET parameter
    $productseller = $_GET['User_Type']; // Assuming you pass the product ID via GET parameter
    $productimage = $_GET['image']; // Assuming you pass the product ID via GET parameter


    $conn = mysqli_connect("localhost", "root", "", "pet_adoption");
    $sql = "INSERT INTO pet_booking (pet_name, pet_category, pet_breed, pet_age, pet_price, pet_image, name, phone, email, details, address, pincode, product_id, User_Type, status) VALUES ('$productname','$productcategory','$productbreed','$productage','$productprice','$productimage','$name', '$phone', '$email', '$details', '$address', '$pincode', '$productId','$productseller','Not-Approve')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    // Send confirmation email
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'lovinpet.service@gmail.com'; // SMTP username
        $mail->Password = 'fdxh xhjw hikr eznn'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('lovinpet.service@gmail.com', 'Lovinpet');
        $mail->addAddress($email, $name); // User's email and name

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Pet Booking Confirmation';
        // $mail->Body = "Dear $name,<br><br>Your booking details:<br>Pet Name: $productname<br>Pet Category: $productcategory <br>Pet Breed: $productbreed<br>Pet Age: $productage<br>Price: $productprice<br>Pet Iamge: $productimage<br><br>Thank you for booking!";
        $mail->Body = "Dear $name,<br><br><u>Your Pet Booking Details:-</u><br><br>Pet Name: $productname<br>Pet Category: $productcategory <br>Pet Breed: $productbreed<br>Pet Age: $productage<br>Price: $productprice<br><br>Thank You for Booking Your Furry Friend!<br>We will Contact You soon.";


        // File path of the image to attach (assuming it's in an 'uploads' folder)
    $imagePath = 'upload/' . $productimage;

    // Check if the file exists
    if (file_exists($imagePath)) {
        // Add attachment
        $mail->addAttachment($imagePath); // Add the image as an attachment
    } else {
        echo 'Image file not found.';
    }


    $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Redirect to confirmation page after successful booking
    // header("Location: pet_dog.php");
    include('temp/nav_s.php');
    echo "<div style='text-align: center;'><p><br><br><br><br><h1>Pet Booked Sucessfully,</h1><br>Check Your Mail!<br><a href='index.php'>Shop More!</a><br><br><br><br><br><br></p></div>";
    include('temp/footer.php');
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "pet_adoption");
// Retrieve pet information based on product ID
$productId = $_GET['id'];
$sql = "SELECT * FROM pets WHERE id = '$productId'";
$result = mysqli_query($conn, $sql);

// Check if the pet exists
if ($result && mysqli_num_rows($result) > 0) {
    $pet = mysqli_fetch_assoc($result);
} else {
    // Handle case where pet with given ID doesn't exist
    echo "Pet not found.";
    exit;
}
?>
<?php
include('temp/nav_s.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom CSS styles */
        /* Ensure that images are responsive */
        .imgs {
            margin-bottom: 17px;
    margin-top: 14px;
    /* padding: 0 16px; */
    width: 352px;
    height: auto;
    max-height: 228px;
    max-width: 278px;
    margin-left: 1px;
    border: 1px solid #c50035;
    border-radius:10px;
        }
        /* Style for the "Change Image" button */
        .change-image-btn {
            background-color: #c50035; /* Bootstrap primary color */
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-left:390px;
            height: 40px;
    width: 125px;
    padding: 9px;
    margin-bottom: 16px;
    font-size: 14px;
    position: relative;
    top: -128px;
    right: 60px;
        }
        /* Style for the right arrow icon */
        .fa-arrow-right {
            margin-left: 5px;
        }
        .card-body{
           
        }
        .card{
            /* overflow-x :auto; */
            max-height: 530px;
            /* background-color: #c50035; */
    background-image: url(https://d1oco4z2z1fhwp.cloudfront.net/templates/default/6791/bg_pet.png);

        }
        .btn-b{
            background-color: #c50035;
            height: 32px;
    font-size: 13px;
    border-radius:10px;
        }
       
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 style="text-align: center;" class="card-title">Pet Information</h2>
                    <!-- Product Information Content -->
                    <p style="text-align: center;" class="card-text"><b>Name: </b><?php echo $pet['name']; ?></p>
                    <p style="text-align: center;" class="card-text"><b>Category: </b><?php echo $pet['category']; ?></p>
                    <p style="text-align: center;" class="card-text"><b>Breed: </b><?php echo $pet['breed']; ?></p>
                    <p style="text-align: center;" class="card-text"><b>Age: </b><?php echo $pet['age']; ?></p>
                    <p style="text-align: center;" class="card-text"><b>Price: </b><?php echo $pet['price']; ?></p>
                    <img class='imgs' id="productImage" src='upload/<?php echo ($pet['image'] ?? ''); ?>' alt='Product Image'>
                    <button class="change-image-btn" onclick="changeImage()">See More <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <h2 style="text-align: center;" class="card-title">Booking Details</h2><br>
                        <input type="hidden" name="productId" value="<?php echo $_GET['id']; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"><b>Name:</b></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"><b>Phone Number:</b></label>
                                    <input type="number" class="form-control" id="phone" name="phone" id required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><b>Email:</b></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode"><b>Pincode:</b></label>
                                    <input type="text" class="form-control" id="postal_code" name="pincode" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address"><b>Address:</b></label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="details"><b>Any Suggestion for us:</b></label>
                            <textarea class="form-control" name="details"></textarea>
                        </div>
                        <button type="submit" class="btn-b btn-primary">Book Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    var images = ['<?php echo ($pet['image'] ?? ''); ?>', '<?php echo ($pet['image2'] ?? ''); ?>']; // Add more images if needed
    var currentImageIndex = 0;

    function changeImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        document.getElementById('productImage').src = 'upload/' + images[currentImageIndex];
    }

        document.getElementById('phone').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 10) {
                event.target.value = value.slice(0, 10);
            }
        });

        document.getElementById('postal_code').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 6) {
                event.target.value = value.slice(0, 6);
            }
        });    
</script>

</body>

</html>

