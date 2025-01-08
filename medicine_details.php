<?php
include('db.php');
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Fetch user information based on the stored email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Access user information
        $user_id = $user['user_id']; // Assuming 'user_id' is a column in your 'users' table
        $username = $user['username']; // Assuming 'username' is a column in your 'users' table
        $user_email = $user['email'];

$sql_cart_count = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = '{$user['user_id']}'"; // Fetch user_id from $user array
$result_cart_count = mysqli_query($conn, $sql_cart_count);

// Check if cart count query is successful
if ($result_cart_count) {
    $row_cart_count = mysqli_fetch_assoc($result_cart_count);
    $cartCount = $row_cart_count['cart_count']; // Store the cart count
}
    }
}



if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_image = $_POST['image'];
        $product_type = $_POST['type'];
        $product_stock = $_POST['stock'];

        $product_price = $_POST['price'];
        $usertype = $_POST['User_Type'];    

            $sql_insert_cart = "INSERT INTO cart (user_id, user_name, product_id, product_category, product_name, image, acc_type, stock, price, User_Type, email, quantity) VALUES ('$user_id', '$username', '$product_id', 'Medicine','$product_name', '$product_image', '$product_type', '$product_stock', '$product_price', '$usertype', '$user_email', 1)";


            if (mysqli_query($conn, $sql_insert_cart)) {
                // header("Location: medicine_details.php");
            } else {
                echo "Error: " . $sql_insert_cart . "<br>" . mysqli_error($conn);
            }
        // } 
        // else {
        //     echo "User not found.";
        // }
    } 
    else {
        // echo "User not logged in.";
        header("Location: login.php");

    }
}

if (isset($_POST['buy_now'])) {
    // Assuming you've already established a database connection

    // Retrieve product information from the form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_image = $_POST['image'];
    $product_type = $_POST['type'];
    $product_stock = $_POST['stock'];
    $product_price = $_POST['price'];
    $usertype = $_POST['User_Type'];

    // Insert into cart table
    $sql_insert_cart = "INSERT INTO cart (user_id, user_name, product_id, product_category, product_name, image, acc_type, stock, price, User_Type, email,quantity,buy_now) VALUES ('$user_id', '$username', '$product_id', 'Medicine','$product_name', '$product_image', '$product_type', '$product_stock', '$product_price', '$usertype', '$user_email', 1,'bn')";

    if (mysqli_query($conn, $sql_insert_cart)) {
        // Redirect to a confirmation page or reload the current page
        header("Location: buy_now.php");
        exit(); // Exit to prevent further execution
    } else {
        // Handle insertion error
        echo "Error: " . $sql_insert_cart . "<br>" . mysqli_error($conn);
    }
}
$isLoggedIn = isset($username) && !empty($username);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Details</title>
    <!-- <link rel="stylesheet" href="nav.css"> -->
    <link rel="stylesheet" href="temp/product_details_footer.css">
    <link rel="stylesheet" href="temp/nav.css">
    <link rel="stylesheet" href="temp/product_style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style2.css"> -->
    
    <!-- sections -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
    <!-- <link rel="stylesheet" href="Footer.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css"/>
   <style>
    /* .add-cart-btn{
        width: 166px;
    height: 54px;
    } */
    /* .hello{
        position: relative;
    right: 54px;
    } */
    /* .buy-now-txt-add{
        position: relative;
    top: -24px;
    right: -6px;
    } */
   </style> 
</head>
<body>
 
<?php
if(isset($_GET['id'])) {


    $product_id = $_GET['id'];
    $sql = "SELECT * FROM medicine WHERE id = $product_id ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row['medicine_name'];
        $product_price = $row['medicine_price'];
        $product_cate = $row['medicine_pet'];
        $product_type = $row['medicine_unit'];

        $product_description = $row['medi_desc'];
        // $product_images = $row['image1'];

        $product_images = array();
        for ($i = 1; $i <= 5; $i++) {
            $image_path = $row["image$i"];
            if (!empty($image_path)) {
                $product_images[] = $image_path;
            }
        }

        $conn->close();
    } else {
        echo "Product not found.";
    }
    
} 
else {
    echo "Product ID not provided.";
}


?>

<div class="main-navbar shadow-sm sticky-top">
        <div class="top-navbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                        <img class="upper-logo" src="temp/lovinpet-high-resolution-logo-white-transparent.png" alt="">
                    </div>
                    <div class="col-md-5 my-auto sb" style="position: relative; top: -35px;">
                        <form role="search" class="sb">
                            <div class="input-group">
                                <input type="search" placeholder="Search your product" class="form-control"/>
                                <button class="btn bg-white" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 my-auto">
                        <ul class="nav justify-content-end">
                            <img class="mobile-logo" src="temp/lovinpet-high-resolution-logo-white-transparent.png" alt="">
                            <li class="nav-item cart" style="margin-bottom: 82px;">
                            <?php if($isLoggedIn): ?>
                                <a class="nav-link" href="my_cart.php">
                                    <!-- <i class="fa fa-shopping-cart"></i> Cart -->
                                    <i class="fa fa-shopping-cart"></i> Cart (<?php echo $cartCount; ?>)
                                </a>
                                <?php else: ?>  
                                    <a class="nav-link" href="my_cart.php">
                                    <i class="fa fa-shopping-cart"></i> Cart (0)
                                </a>  
                                <?php endif; ?>
                            </li>   
                        <li class="nav-item dropdown username">
                            <?php if($isLoggedIn): ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user"></i><?php echo $username;?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <!-- <li><a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a></li> -->
                                <li><a class="dropdown-item" href="order_track.php"><i class="fa fa-list"></i> My Orders</a></li>
                                <!-- <li><a class="dropdown-item" href="#"><i class="fa fa-shopping-cart"></i> My Cart</a></li> -->
                                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                            <?php else: ?>
                                <a class="nav-link dropdown-toggle" href="login.php" id="navbarDropdown" role="button" data-bs-toggle="" aria-expanded="false">
                                    <i class="fa fa-user"></i>Login
                                </a>
                            <?php endif; ?>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg mobile-bar">
            <div class="container-fluid">
                
                <button class="navbar-toggler menubar" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon navbar-dark"></span>
                </button>
                <h6 class="menu-txt">Hey Pet Lover Welcome to LovinPet</h6>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pets
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                                <li><a class="dropdown-item" href="pet_dog.php">Dog</a></li>
                                <li><a class="dropdown-item" href="pet_cat.php">Cat</a></li>
                                <li><a class="dropdown-item" href="pet_rabbit.php">Rabbit</a></li>
                                <li><a class="dropdown-item" href="pet_bird.php">Bird</a></li>
                                <li><a class="dropdown-item" href="pet_fish.php">Fish</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <!-- <a class="nav-link" href="accessories_product_display.php">Accessories</a> -->
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Accessories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                                <li><a class="dropdown-item" href="accessories_product_display.php?category=Dog">Dog</a></li>
                                <li><a class="dropdown-item" href="accessories_product_display.php?category=Cat">Cat</a></li>
                                <li><a class="dropdown-item" href="accessories_product_display.php?category=Rabbit">Rabbit</a></li>
                                <li><a class="dropdown-item" href="accessories_product_display.php?category=Bird">Bird</a></li>
                                <li><a class="dropdown-item" href="accessories_product_display.php?category=Fish">Fish</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <!-- <a class="nav-link" href="food_display2.php">Foods</a> -->
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Foods
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                                <li><a class="dropdown-item" href="food_display2.php?category=Dog">Dog</a></li>
                                <li><a class="dropdown-item" href="food_display2.php?category=Cat">Cat</a></li>
                                <li><a class="dropdown-item" href="food_display2.php?category=Rabbit">Rabbit</a></li>
                                <li><a class="dropdown-item" href="food_display2.php?category=Bird">Bird</a></li>
                                <li><a class="dropdown-item" href="food_display2.php?category=Fish">Fish</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <!-- <a class="nav-link" href="medicine_display.php">Medicines</a> -->
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Medicines
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                                <li><a class="dropdown-item" href="medicine_display.php?category=Dog">Dog</a></li>
                                <li><a class="dropdown-item" href="medicine_display.php?category=Cat">Cat</a></li>
                                <li><a class="dropdown-item" href="medicine_display.php?category=Rabbit">Rabbit</a></li>
                                <li><a class="dropdown-item" href="medicine_display.php?category=Bird">Bird</a></li>
                                <li><a class="dropdown-item" href="medicine_display.php?category=Fish">Fish</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Appliances</a>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pet Services
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">

                                <li><a class="dropdown-item" href="doctor_list.php">Consult A Vet</a></li>
                                <li><a class="dropdown-item" href="trainer_list.php">Pet Training & Grooming</a></li>
                                <!-- <li><a class="dropdown-item" href="#">Grooming</a></li> -->
                            </ul>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link ss" href="ngo/ngo.html">NGO</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>




<div class="main-wrapper">
    <div class="container">
        <div class="product-div">
            <div class="product-div-left">
                <div class="img-container">
                    <?php
                    if (!empty($product_images)) {
                        $upload_folder = "upload/";
                        echo "<img id='mainImage' src='" . $upload_folder . $product_images[0] . "' alt='$product_name'>";
                    }
                    ?>
                </div>
                <div class="hover-container">
                    <?php
                    $upload_folder = "upload/";

                    foreach ($product_images as $image) {
                        echo "<div class='thumbnail'>";
                        echo "<img src='$upload_folder$image' alt='$product_name'>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            <div class="product-div-right">
                <span class="product-name"><?php echo $product_name; ?></span>
                <span class="product-price">₹<?php echo $product_price; ?></span>
                <p class="product-description"><b>Category: </b><?php echo $product_cate; ?></p>
                <p class="product-description"><b>Type: </b><?php echo $product_type; ?></p>
                <p class="product-description"><b>Description: </b><?php echo $product_description; ?></p>




                <div class="btn-groups">
                    <form method="post" action="" autocomplete="off">
                        <!-- Add hidden input fields for product information -->
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['medicine_name']; ?>">
                        <input type="hidden" name="image" value="<?php echo $row['image1']; ?>">
                        <input type="hidden" name="type" value="<?php echo $row['medicine_unit']; ?>">
                        <input type="hidden" name="stock" value="<?php echo $row['medi_stock']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['medicine_price']; ?>">
                        <input type="hidden" name="User_Type" value="<?php echo $row['User_Type']; ?>">

                        <!-- Add to cart button -->
                        <button type="submit" name="add_to_cart" class="add-cart-btn"><i class="fas fa-shopping-cart hello"></i><span class="buy-now-txt-add">Add to cart</span>
                        </button>
                        
                    </form>
                    
                    <form method="post" action="">
                        <!-- Add hidden input fields for product information -->
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['medicine_name']; ?>">
                        <input type="hidden" name="image" value="<?php echo $row['image1']; ?>">
                        <input type="hidden" name="type" value="<?php echo $row['medicine_unit']; ?>">
                        <input type="hidden" name="stock" value="<?php echo $row['medi_stock']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['medicine_price']; ?>">
                        <input type="hidden" name="User_Type" value="<?php echo $row['User_Type']; ?>">

                    <button type="submit" name="buy_now" class="buy-now-btn">
                        <i class="fas fa-wallet bn"></i>
                        <span class="buy-now-txt" href="">Buy Now</span>
                    </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
        <?php
        
        ?>
    </div>
<div class="related-products">
    <h2 class="related-txt">Related Products</h2>
    <div class="product-row">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pet_adoption";
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // $sql_related = "SELECT * FROM accessories WHERE id != $product_id ORDER BY RAND() LIMIT 4";
        $sql_related = "SELECT * FROM medicine WHERE id != $product_id AND status = 'Activate' ORDER BY RAND() LIMIT 4";

        $result_related = $conn->query($sql_related);

        if ($result_related->num_rows > 0) {
            while ($row_related = $result_related->fetch_assoc()) {
                echo "<div class='product-item'>";
                echo "<a class='id-txt' href='medicine_details.php?id=" . $row_related['id'] . "'>";
                // Display the first image from the related products
                echo "<img src='upload/" . $row_related['image1'] . "' alt='" . $row_related['medicine_name'] . "'>";
                echo "<h3 class='name-txt'>" . $row_related['medicine_name'] . "</h3>";
                echo "<p class='price-txt'>₹" . $row_related['medicine_price'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No related products found.";
        }
        ?>
    </div>
</div>
<?php
include('temp/footer_less.php')
?>
<script>
    const thumbnails = document.querySelectorAll('.thumbnail img');
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('mouseover', function() {
            document.getElementById('mainImage').src = this.src;
        });
    });

    function showNotification() {
    var notification = document.getElementById('notification');
    notification.style.display = 'block';

    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000); // Hide the notification after 3 seconds
}

    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
