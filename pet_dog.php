<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");
$username = ""; 
// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Fetch user information based on the stored email
    $sql_user = "SELECT * FROM users WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
    $result_user = mysqli_query($conn, $sql_user);

    // Check if user information is found
    if (mysqli_num_rows($result_user) == 1) {
        $user = mysqli_fetch_assoc($result_user);
        $username = $user['username']; // Store the username
        
        // Update cart count for the user
$sql_cart_count = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = '{$user['user_id']}'"; // Fetch user_id from $user array
$result_cart_count = mysqli_query($conn, $sql_cart_count);

// Check if cart count query is successful
if ($result_cart_count) {
    $row_cart_count = mysqli_fetch_assoc($result_cart_count);
    $cartCount = $row_cart_count['cart_count']; // Store the cart count
}

    }
}
$isLoggedIn = !empty($username);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="temp/pet_display.css">
    
    <link rel="stylesheet" href="temp/nav.css">
    <!-- footer  -->
    <link rel="stylesheet" href="temp/Footer.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css"/>
        <!-- footer -->
        <style>
            /* Modal Styling */
        </style>
</head>


<body style="background-color: #e1e1e1 ; background-image: url(https://d1oco4z2z1fhwp.cloudfront.net/templates/default/6791/bg_pet.png);">
 
<div class="main-navbar shadow-sm sticky-top">
        <div class="top-navbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                        <img class="upper-logo" src="images/lovinpet-high-resolution-logo-white-transparent.png" alt="">
                        <!-- <h5 class="brand-name">LovinPet</h5> -->
                        <!-- <h6 class="upper-slogan">Pawsitively Adopt Where hearts find homes</h6> -->
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
                <!-- <a class="navbar-brand d-block d-sm-block d-md-none d-lg-none" href="#">
                </a> -->
                <button class="navbar-toggler menubar" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon navbar-bright"></span> -->
                    <span class="navbar-toggler-icon navbar-dark"></span>
                </button>
                <h6 class="menu-txt">Hey Pet Lover Welcome to LovinPet</h6>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">All Categories</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">New Arrivals</a>
                        </li> -->
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

<div class="container" style="max-width: 1172px;">
    <!-- <input type="checkbox" id="filter-toggle" style="display: none;">
    <label for="filter-toggle" class="filter-button">Filter</label> -->
    <input type="checkbox" id="filter-toggle"  class="filter-button"style="display: none;">
    <label for="filter-toggle" class="filter-button">Filter</label>

        
        <div class="filter-container">
            <h2>Filters</h2>
            <form method="get">
                <label for="breed">Breed:</label>
                <select id="breed" name="breed">
                    <option class="cates" value="">All</option>
                    <option class="cates" value="Labrador">Labrador</option>
                    <option class="cates" value="Beagle">Beagle</option>
                    <option class="cates" value="German Shepherd">German Shepherd</option>
                    <option class="cates" value="Golden Retriever">Golden Retriever</option>
                    <!-- <option class="cates" value="Rabbit">Rabbit</option> -->
                </select>
                <br><br>
                <label for="age">Age:</label>
                <select id="age" name="age">
                    <option class="cates" value="">All</option>
                    <option class="cates" value="Puppy">Puppy</option>
                    <option class="cates" value="Young Adulthood">Young Adulthood</option>
                    <option class="cates" value="Adulthood">Adulthood</option>
                    <option class="cates" value="Senior">Senior</option>
                </select>
                <br><br>
                <label for="price">Price Range:</label>
                <select id="price" name="price">
                    <option value="">Any</option>
                    <option value="0-50">₹0 - ₹50</option>
                    <option value="50-100">₹50 - ₹100</option>
                    <option value="100-200">₹100 - ₹200</option>
                    <option value="200-500">₹200 - ₹500</option>
                    <option value="500-1000">₹500 - ₹1000</option>
                    <option value="1001-10000">Above ₹1000</option>
                </select>
                <br><br>
                <input type="submit" value="Apply Filters">
            </form>
        </div>

        <div class="product-container">


        <?php
    $conn = mysqli_connect("localhost", "root", "", "pet_adoption");
    // Base SQL query
    $sql = "SELECT * FROM pets WHERE category='Dog' AND status='Activate'";
    
    // Applying filters if they are set
    if(isset($_GET['breed']) && !empty($_GET['breed'])) {
        $sql .= " AND breed='" . $_GET['breed'] . "'";
    }
    if(isset($_GET['age']) && !empty($_GET['age'])) {
        $sql .= " AND age='" . $_GET['age'] . "'";
    }
    if(isset($_GET['price']) && !empty($_GET['price'])) {
        $price_range = explode('-', $_GET['price']);
        $min_price = $price_range[0];
        $max_price = $price_range[1];
        $sql .= " AND price BETWEEN $min_price AND $max_price";
    }
    
    $result = mysqli_query($conn, $sql);

    // if ($result && mysqli_num_rows($result) > 0) {
    //     while ($pet = mysqli_fetch_assoc($result)) {
    //         echo "<div class='product'>";
    //         echo "<h2>" . $pet['name'] . "</h2>";
    //         echo "<p>Category: " . $pet['category'] . "</p>";
    //         echo "<p>Breed: " . $pet['breed'] . "</p>";
    //         echo "<p>Age: " . $pet['age'] . "</p>"; // Show age
    //         echo "<p>Price: " . $pet['price'] . "</p>";
    //         echo "<img src='upload/" . $pet['image'] . "' alt='Pet Image'>";
    //         echo "<button class='add-to-cart-btn' onclick='addToCart(" . $pet["id"] . ")'>Booking</button>";
    //         echo "</div>";
    //     }
    // } else {
    //     echo "<p class='no-pets'>No pets found matching the criteria.</p>";
    // }

// Display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        // echo "<a class='id-txt' href='product_details2.php?id=" . $row['id'] . "'>";
        // echo "<a class='id-txt' href='product_details2.php?id=" . $row['id'] . "' target='_blank'>";
        echo "<div class='product-content'>";
        echo "<img class='imgs' src='upload/" . ($row['image'] ?? '') . "' alt='Product Image'>";
        echo "<h3>" . ($row['name'] ?? '') . "</h3>";
        // echo "<p class='category-txt'>Category: " . ($row['acc_category'] ?? '') . "</p>";
        echo "<p class='type-txt'>Breed: " . ($row['breed'] ?? '') . "</p>";
        echo "<p class='type-txt'>Age: " . ($row['age'] ?? '') . "</p>";
        echo "<p class='price-txt'>Price: ₹" . ($row['price'] ?? '') . "</p>";
        // echo "<p>Description: " . ($row['about_accessories'] ?? '') . "</p>";
        // $userType = isset($row['User_Type']) ? $row['User_Type'] : ''; 
        
        // echo "<button class='add-to-cart' name='add_to_cart' onclick='addToCart(" . $row["id"] . ")'><p>Book Now</p></button>";    
        // echo "<button class='add-to-cart' onclick='addToCart(" . $row["id"] . ", \"" . $row["name"] . "\")'>Book Now</button>";
        echo "<button class='add-to-cart' onclick='addToCart(" . $row["id"] . ", \"" . $row["name"] . "\", \"" . $row["category"] . "\", \"" . $row["breed"] . "\", \"" . $row["age"] . "\", \"" . $row["price"] . "\", \"" . $row["User_Type"] . "\", \"" . $row["image"] . "\")'>Book Now</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No Pets found.";
}

$conn->close();
?>

</div>
    </div>
<!-- footer section starts here -->

<div class="bee-page-container">
<div class="bee-row bee-row-32 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-spacer bee-mobile_hide">
        <div class="spacer" style="height:65px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-33">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w4">
        <div class="bee-block bee-block-1 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="company logo" height="64px" src="images/lovinpet-high-resolution-logo-white-transparent.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;">"Pawsitively Adopt Where Hearts Find Homes." </p>
        </div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w3">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:18px;font-weight:normal;line-height:200%;text-align:left;margin-top:0;margin-bottom:0;"><strong>Links</strong> </h1>
        </div>
        <div class="bee-block bee-block-4 bee-paragraph">
        <p style="word-break:break-word;"><a href="pet.php" rel="noopener" style="text-decoration: none;" target="_blank">Pets</a></p>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break:break-word;"><a href="accessories_product_display.php" rel="noopener" style="text-decoration: none;" target="_blank">Accessories</a></p>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break:break-word;"><a href="food_display2.php" rel="noopener" style="text-decoration: none;" target="_blank">Foods</a></p>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break:break-word;"><a href="medicine_display.php" rel="noopener" style="text-decoration: none;" target="_blank">Medicines</a></p>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break:break-word;"><a href="doctor_list.php" rel="noopener" style="text-decoration: none;" target="_blank">Veterinarians</a></p>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break:break-word;"><a href="trainer_list.php" rel="noopener" style="text-decoration: none;" target="_blank">Training & Grooming</a></p>
        </div>
        </div>

        <div class="bee-col bee-col-2 bee-col-w3">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:18px;font-weight:normal;line-height:200%;text-align:left;margin-top:0;margin-bottom:0;"><strong>Became Our Partner</strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break:break-word;"><a href="seller_login.php" rel="noopener" style="text-decoration: none;" target="_blank">Join us as a Seller</a></p>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break:break-word;"><a href="doctor_login.php" rel="noopener" style="text-decoration: none;" target="_blank">Join us as a Veterinarian</a></p>
        </div>
        <div class="bee-block bee-block-4 bee-paragraph">
        <p style="word-break:break-word;"><a href="Trainer_login.php" rel="noopener" style="text-decoration: none;" target="_blank">Join us as a Trainer & Groomer</a></p>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break:break-word;"><a href="http://www.example.com" rel="noopener" style="text-decoration: none;" target="_blank"></a></p>
        </div>
        </div>

        <div class="bee-col bee-col-3 bee-col-w3">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:18px;font-weight:400;line-height:200%;text-align:left;margin-top:0;margin-bottom:0;"><strong>Contact</strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><a href="mailto:lovinpet.service@gmail.com" rel="noopener" style="text-decoration: none;" target="_blank">lovinpet.service@gmail.com</a></p>
        </div>
        <!-- <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break:break-word;"><a href="http://www.example.com" rel="noopener" style="text-decoration: none;" target="_blank">Help Center</a></p>
        </div> -->
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break:break-word;"><a href="tel:+918479055734" rel="noopener" style="text-decoration: none;" target="_blank">+91 8479055734 / 6289799403</a></p>
        </div>
        <div class="bee-block bee-block-4 bee-social">
        <div class="content"><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.facebook.com" target="_self"><img alt="Facebook" src="images/facebook2x.png" title="facebook"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.twitter.com" target="_self"><img alt="Twitter" src="images/twitter2x.png" title="twitter"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.linkedin.com" target="_self"><img alt="Linkedin" src="images/linkedin2x.png" title="linkedin"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.instagram.com" target="_self"><img alt="Instagram" src="images/instagram2x.png" title="instagram"/></a></span></div>
        </div>
        </div>
        <!-- <div class="bee-col bee-col-4 bee-col-w2"> -->
        <!-- <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:18px;font-weight:400;line-height:200%;text-align:left;margin-top:0;margin-bottom:0;"><strong>Contact</strong> </h1>
        </div> -->
        <!-- <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><a href="lovinpet.service@gmail.com" rel="noopener" style="text-decoration: none;" target="_blank">lovinpet.service@gmail.com</a></p>
        </div> -->
        <!-- </div> -->
        </div>
        </div>
        <div class="bee-row bee-row-34">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-spacer bee-mobile_hide">
        <div class="spacer" style="height:65px;"></div>
        </div>
        </div>
        </div>
        </div>        
</div>
<!-- footer section ends here -->
 <?php
// include 'temp\footer.php'

 ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const filterButton = document.querySelector('.filter-button');
    const filterContainer = document.querySelector('.filter-container');
    const categorySelect = document.getElementById('category');
    const priceSelect = document.getElementById('price');
    
    // Function to save filter values to local storage
    function saveFiltersToLocalStorage() {
        localStorage.setItem('selectedCategory', categorySelect.value);
        localStorage.setItem('selectedPrice', priceSelect.value);
    }

    // Function to retrieve filter values from local storage
    // function retrieveFiltersFromLocalStorage() {
    //     const selectedCategory = localStorage.getItem('selectedCategory');
    //     const selectedPrice = localStorage.getItem('selectedPrice');
    //     if (selectedCategory) {
    //         categorySelect.value = selectedCategory;
    //     }
    //     if (selectedPrice) {
    //         priceSelect.value = selectedPrice;
    //     }
    // }

    // // Apply filters stored in local storage if available
    // retrieveFiltersFromLocalStorage();

    filterButton.addEventListener('click', function () {
        filterContainer.style.display = filterContainer.style.display === 'block' ? 'none' : 'block';
    });

    // Save filters to local storage when form is submitted
    const filterForm = document.querySelector('.filter-container form');
    filterForm.addEventListener('submit', saveFiltersToLocalStorage);

});


    document.addEventListener('DOMContentLoaded', function() {
    // Toggle checkbox state when filter button is clicked
    var filterButton = document.querySelector('.filter-button');
    filterButton.addEventListener('click', function() {
        var filterToggle = document.getElementById('filter-toggle');
        filterToggle.checked = !filterToggle.checked;
    });
});

// function addToCart(productId) {
//         // Redirect to the add to cart page with the product ID
//         window.location.href = "manage_cart.php?id=" + productId;
//     }


// JavaScript to show the modal popup
// function addToCart(productId) {
//         // Redirect to the add to cart page with the product ID
//         window.location.href = "pet_booking.php?id=" + productId;
//     }
// function addToCart(productId, productName) {
//         // Redirect to the add to cart page with the product ID and name
//         window.location.href = "pet_booking.php?id=" + productId + "&name=" + productName;
//     }
function addToCart(productId, productName, category, breed, age, price, User_Type, image) {
        // Redirect to the add to cart page with all the product information
        window.location.href = "pet_booking2.php?id=" + productId + "&name=" + productName + "&category=" + category + "&breed=" + breed + "&age=" + age + "&User_Type=" + User_Type +"&price=" + price + "&image=" + encodeURIComponent(image);
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
