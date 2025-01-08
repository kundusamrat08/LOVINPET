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
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LovinPet</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- sections -->
    <link rel="stylesheet" href="css/style_index.css">
       
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css2?family=Droid+Serif:wght@100;200;300;400;500;600;700;800;900" rel="stylesheet" type="text/css"/>


    <style>
    @import url('https://fonts.googleapis.com/css2?family=Oleo+Script:wght@400;700&display=swap');
    
    .main-navbar{
    border-bottom: 1px solid #ccc;
}
.main-navbar .top-navbar{
    /* background-color: #f80042; */
    /* background-color: #ff2962; */
    background-color: #c50035;
    background-image: url(https://d1oco4z2z1fhwp.cloudfront.net/templates/default/6791/bg_pet.png);
    padding-top: 10px;
    padding-bottom: 10px;
}
.main-navbar .top-navbar .brand-name{
    color: #fff;
}
.main-navbar .top-navbar .nav-link{
    color: #fff;
  font-size: 18px;
  font-weight: 500;
  padding: 12px 25px;
  position: relative;
  top: 8px;
}
.main-navbar .top-navbar .dropdown-menu{
    padding: 0px 0px;
    border-radius: 0px;
}
.main-navbar .top-navbar .dropdown-menu .dropdown-item{
    padding: 8px 16px;
    border-bottom: 1px solid #ccc;
    font-size: 14px;
}
.main-navbar .top-navbar .dropdown-menu .dropdown-item i{
    width: 20px;
    text-align: center;
    color: #2874f0;
    font-size: 14px;
}
.main-navbar .navbar{
    padding: 0px;
    /* background-color: #ddd; */
    background-color: antiquewhite;
}
.main-navbar .navbar .nav-item .nav-link{
    padding: 8px 20px;
    color: #000;
    font-size: 15px;
}
.logo-text{
    display: none;
}
.upper-logo{
    height: 50px;
  width: 209px;
  position: relative;
  top: -29px;
}
.brand-name{
    font-size: 27px;
    font-weight: bold;
    position: relative;
    top: -60px;
    right: -75px;
}
.upper-slogan{
    position: relative;
    top: -66px;
    right: -70px;
    font-weight: bold;
    color: white;
    /* font-family: ; */
    font-size: 16px;

}
/* .input-group{
    top: -20px;
  right: -61px;
} */
.mobile-logo{
    display: none;
}
.top-navbar{
    height: 82px;
}
.menu-txt{
        display: none;
}
.nav-link, .dropdown-item{
  font-family: "Oleo Script", system-ui;
  font-weight: 400;
  font-style: normal;

}
.ss{
    font-family:"Arial";
    font-weight:bold;
}

@media only screen and (max-width: 600px) {
    .main-navbar .top-navbar .nav-link{
        font-size: 12px;
        padding: 12px 14px;
        position: relative;
        top: -1px;
    }
    .logo-text{
        position: relative;
        display: block;
        right: 70px;
        top: 2px;
        color: white;
        font-weight: bold;
        font-size: 22px;
    }
    .slogan-text{
        font-size: 11px;
        font-weight: bold;
  /* color:  */
        padding: 0 18px;
        position: relative;
        right: -7px;
    }
    /* .input-group{
        top: 16px;
        right: -3px;
        
    } */
    .mobile-logo{
        height: 30px;
        position: relative;
        top: 9px;
        /* right: 8px;
        width: 110px; */
        right: 15px;
        width: 127px;
        display: block;
}
.form-control{
    height: 31px;
}
 .bg-white{
    height: 31px;
}
.fa{
    position: relative;
    top: -1px;
    font-size: 21px;
}
.cart{
    position: relative;
    right: -19px;
}
.username{
    position: relative;
    right: -10px;
}
.menubar{
    position: relative;
    right: 9px;
    top: -53px;
}
.mobile-bar{
    height: 0px;
}
.navbar-toggler:focus{
    box-shadow: none;
}
.sf{
    position: relative;
    right: 10px;
}
.top-navbar{
    height: 108px;
}
.navbar-brand.d-block img.mobile-logo {
        display: inline-block;
        vertical-align: middle;
        height: auto;
        max-width: 100%; /* Ensure image responsiveness */
    }
    .sb{
        position: relative;
        top: 35px;
    }
    .form-control{
        height: 38px;
        border: none;
    }
    .btn{
        height: 38px;
    }
    .main-navbar .top-navbar{
        height: 121px;
    }
    .nav{
        margin-top: 16px;
    }
    /* .navbar-nav{
        background-color: antiquewhite;
    } */
    .navbar .container-fluid{
        background-color: antiquewhite;
    }
    .menu-txt{
        display: block;
        position: relative;
        /* left: -112px; */
        left: -67px;
        font-weight: bold;
    }
    /* .bee-image{
			margin-top: 20px;
		} */
    }
    @media only screen and (min-width: 420px){
.mobile-logo{
    position: relative;
    top: 9px;
    /* right: -4px; */
    right: 28px;
    height: 30px;
    /* width: 104px; */
    width: 116px;
}
    }
    
@media only screen and (max-width: 360px){
.mobile-logo{
    position: relative;
    top: 9px;
    right: -2px;
    height: 30px;
    width: 104px;
}
}
@media only screen and (max-width: 384px){
.mobile-logo{
    position: relative;
    /* top: 9px;
    right: -2px;
    height: 30px;
    width: 104px; */
    top: 12px;
    /* right: -9px; */
    right: 14px;
    /* height: 24px;
    width: 89px; */
    height: 28px;
    width: 108px;
}
    }


    @media only screen and (max-width: 331px){
.mobile-logo{
    position: relative;
    top: 12px;
    /* right: -18px;
    height: 21px;
    width: 74px; */
    right: -2px;
    height: 24px;
    width: 80px;
}
}

    @media only screen and (max-width: 315px){
.mobile-logo{
    position: relative;
    top: 12px;
    right: -23px;
    height: 21px;
    width: 74px;
}
}


    </style>
</head>
<body>

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



    <div class="bee-page-container">
        <div class="bee-row bee-row-1">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w3">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w6">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:30px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:42px;font-weight:700;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><span class="tinyMce-placeholder">Love Your Animal</span> </h1>
        </div>
        <div class="bee-block bee-block-3 bee-spacer">
        <div class="spacer" style="height:30px;"></div>
        </div>
        <div class="bee-block bee-block-4 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:42px;font-weight:700;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><span class="tinyMce-placeholder">They Are Your Family</span> </h1>
        </div>
        <!-- <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="www.example.com" style="font-size: 16px; background-color: #893bff; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">SEE MORE</span></a></div> -->
        <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="" style="font-size: 16px; background-color: #c50035; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;"><span style="word-break: break-word; font-size: 16px; line-height: 200%;"></span></a></div>
        <div class="bee-block bee-block-6 bee-image"><img alt="Dog wearing jacket" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/cat-dog-parrot-fish-rabbit-kot-sobaka-popugai-rybki-krolik-fotor-bg-remover-20240317125829.png" style="max-width:720px;"/></div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w3">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-2 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:20px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-3">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w2">
        <div class="bee-block bee-block-1 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:40px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-heading">
        <h1 style="color:#c50035;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:38px;font-weight:700;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><span class="tinyMce-placeholder">Shop by Pet</span> </h1>
        </div>
        <!-- <div class="bee-block bee-block-3 bee-image"><a href="accessories_product_display.php" target="_blank"><img alt="" class="bee-center bee-fixedwidth" src="images/NPW_button2.png" style="max-width:132px;"/></a></div> -->
        <div class="bee-block bee-block-3 bee-image"><img alt="" class="bee-center bee-fixedwidth" src="images/NPW_button2.png" style="max-width:132px;"/></div>
        <div class="bee-block bee-block-4 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:75px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w2">
        <div class="bee-block bee-block-1 bee-image"><a href="accessories_product_display.php?category=Dog" target="_blank"><img alt="" class="bee-center bee-autowidth" src="images/Frame_106723146-min_7bd3c217-f022-40ef-ab02-e3f0f90046a8.webp" style="max-width:240px;"/></a></div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w2">
        <div class="bee-block bee-block-1 bee-image"><a href="accessories_product_display.php?category=Cat" target="_blank"><img alt="" class="bee-center bee-autowidth" src="images/Frame_106723147-min_e02eca19-2353-4f1e-a325-9c6eb2192234.webp" style="max-width:240px;"/></a></div>
        </div>
        <div class="bee-col bee-col-4 bee-col-w2">
        <div class="bee-block bee-block-1 bee-image"><a href="accessories_product_display.php?category=Rabbit" target="_blank"><img alt="" class="bee-center bee-autowidth" src="images/Frame_106723149-min_f0b1c8c1-a85c-4161-9c84-7e7e043400ea.webp" style="max-width:240px;"/></a></div>
        </div>
        <div class="bee-col bee-col-5 bee-col-w2">
        <div class="bee-block bee-block-1 bee-image"><a href="accessories_product_display.php?category=Bird" target="_blank"><img alt="" class="bee-center bee-autowidth" src="images/Frame_106723198-min_84423f4b-c707-409b-a436-961e490814e0.webp" style="max-width:240px;"/></a></div>
        </div>
        <div class="bee-col bee-col-6 bee-col-w2">
        <div class="bee-block bee-block-1 bee-image"><a href="accessories_product_display.php?category=Fish" target="_blank"><img alt="" class="bee-center bee-autowidth" src="images/Frame_106723148-min_efc73749-e2cf-4089-8920-c65ee02913f3.webp" style="max-width:240px;"/></a></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-4 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:20px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-5">
        <div class="bee-row-content reverse">
        <div class="bee-col bee-col-1 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><strong><span class="tinyMce-placeholder">"Animals Have Come<br/>to Mean in Our Lives."</span></strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p><em><span style="color: #000000;">Adopting a pet offers love, companionship, and a second chance for animals in need. Each adopted pet brings joy and loyalty, creating a lasting bond. Consider opening your heart to adoption today.</span></em></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Adopting a pet brings joy and companionship into your life.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Pets offer emotional support, reducing stress and loneliness.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">"Adopt Love, Buy Joy: Welcome Home a Furry Friend Today!"</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        <div class="bee-block bee-block-7 bee-button"><a class="bee-button-content" href="pet.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">ADOPT NOW</span></a></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="" class="bee-center bee-fixedwidth" src="images/animals-block.png" style="max-width:504px;"/></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-6 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-7 bee-mobile_hide">
        <div class="bee-background-video-container"><video autoplay="autoPlay" loop="loop" muted="muted" playsinline="playsInline">
        <source src="https://92fe4ca127.imgdist.com/pub/bfra/eve70nmg/ffk/5ho/nuz/2023-09-10-drool-worthy-treats-desktop.mp4" type="video/mp4"/>
        </video></div>
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:435px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-8 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-9">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Hamster " class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/ph8pESziKQUFxN57G3OdA-transformeddgauydtua.png" style="max-width:720px;"/></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#000000;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><span style="color: #000000;"><strong><span class="tinyMce-placeholder">"Shop from our Website for Top-Notch Pet Accessories!"</span></strong></span> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p><span style="color: #000000;"><em>"Elevate your pet's style and comfort with our exclusive accessories. Shop now for the best in quality and pamper your furry friend like never before!"</em></span></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Quality Selection.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Superior Comfort.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Unmatched Satisfaction.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        <div class="bee-block bee-block-7 bee-button"><a class="bee-button-content" href="accessories_product_display.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">SHOP NOW</span></a></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-10 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-11">
        <div class="bee-row-content reverse">
        <div class="bee-col bee-col-1 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><strong>"Nourish Your Friend, Shop Pet Food Delight!"</strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><em>"Discover top-quality pet food for your furry friends on our website. From nutritious meals to tasty treats, we have everything to keep them happy and healthy."</em></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Premium Selection.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Trusted Quality.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Tailored Nutrition.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="food_display2.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">SHOP NOW</span></a></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Lady Hugging Dog" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/Shop-all-your-favorite-Dog-Treats-2-2daxax-Photoroom.png-Photoroom.png" style="max-width:720px;"/></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-12 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-13">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Hamster " class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/Bottles-Flat-2.png" style="max-width:720px;"/></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:41px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><span style="color: #ffffff;"><strong><span class="tinyMce-placeholder">"Your Pet's Health, Our Priority: Care for Your Pet with Us!"</span></strong></span> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p><span style="color: #ffffff;"><em>"Keep your pet healthy with our trusted medicines. Find everything you need on our website."</em></span></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Comprehensive Selection.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Trusted Quality.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Veterinary Guidance.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="medicine_display.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">SHOP NOW</span></a></div>
        <div class="bee-block bee-block-7 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-14 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-15 bee-mobile_hide">
        <div class="bee-background-video-container"><video autoplay="autoPlay" loop="loop" muted="muted" playsinline="playsInline">
        <source src="https://92fe4ca127.imgdist.com/pub/bfra/eve70nmg/m8y/lus/tz3/2023-09-10-kitty-pawrty-supplies-desktop.mp4" type="video/mp4"/>
        </video></div>
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:435px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-16 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-17">
        <div class="bee-row-content reverse">
        <div class="bee-col bee-col-1 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><strong>"Consult a veterinarian</strong><br/><strong>Anytime and Anywhere."</strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><em>"Access professional veterinary advice online. Schedule a consultation with our experts for personalized care and guidance tailored to your pet's needs."</em></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Professional Expertise</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Personalized Advice.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Convenient Accessibility.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        <div class="bee-block bee-block-7 bee-button"><a class="bee-button-content" href="doctor_list.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">Consult Now</span></a></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Lady Hugging Dog" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/output-removebg.png" style="max-width:648px;"/></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-18 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-19">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Hamster " class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/higcom-image-marquee-industries-sc-pet-trainer-Photoroom.png-Photoroom.png" style="max-width:720px;"/></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><span style="color: #000000;"><strong>"From Ruff to Ready: Train Your Pet with Our Experts!"</strong></span> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;"><em>"Unlock your pet's potential with our online pet training services. Book a session with our experienced trainers for personalized guidance and effective solutions."</em></span></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Positive Reinforcement.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Experienced Professionals.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Breed-Specific Training.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="trainer_list.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">HIRE NOW</span></a></div>
        <div class="bee-block bee-block-7 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-20 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-21">
        <div class="bee-row-content reverse">
        <div class="bee-col bee-col-1 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><strong><span style="color: #ffffff;">Pamper Your Furry Friend with Our Pawsome Grooming</span> <span style="color: #ffffff;">Service!</span></strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><strong><span style="color: #ffffff;"><em>"Need a makeover for your furry friend? Our team specializes in grooming services for dogs and cats, ensuring they look their best!"</em></span></strong></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Professional Experts</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Customized Styling</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Gentle Handling</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        <div class="bee-block bee-block-7 bee-button"><a class="bee-button-content" href="trainer_list.php" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_blank"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">Book Now</span></a></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Lady Hugging Dog" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/295870758_5484768604879729_8586380582309425112_n_2.png" style="max-width:432px;"/></div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-22 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-23">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w6">
        <div class="bee-block bee-block-1 bee-image"><img alt="Hamster " class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="images/Pet-NGO--Complete-Rescue-Journey.jpg" style="max-width:720px;"/></div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w1">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:1px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w5">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#7747FF;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:48px;font-weight:700;letter-spacing:normal;line-height:120%;text-align:left;margin-top:0;margin-bottom:0;"><strong><span style="color: #000000;">Be a hero for a Furry Friend!</span></strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;"><em><strong>"If you find a lost or injured animal, reach out to our NGOs to be their ultimate superhero and help them find a loving home through adoption!"</strong></em></span></p>
        </div>
        <div class="bee-block bee-block-3 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Social Impact.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Advocacy Work.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="check mark" height="32px" src="images/check_mar_purple.png" width="auto"/></div>
        <div class="bee-icon-label bee-icon-label-right">Community Empowerment.</div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="ngo/ngo.html" style="font-size: 16px; background-color: #c50035; border-bottom: 1px solid #011627; border-left: 1px solid #011627; border-radius: 0px; border-right: 1px solid #011627; border-top: 1px solid #011627; color: #ffffff; direction: ltr; font-family: inherit; font-weight: 400; max-width: 100%; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 5px; width: auto; display: inline-block;" target="_self"><span style="word-break: break-word; font-size: 16px; line-height: 200%;">SEE MORE</span></a></div>
        <div class="bee-block bee-block-7 bee-spacer">
        <div class="spacer" style="height:25px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-24 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-25">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#000000;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:33px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><span class="tinyMce-placeholder">Services Loved And Offer</span> </h1>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-26">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w3">
        <div class="bee-block bee-block-1 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Support" height="128px" src="images/57v08lyyMPj5x_VuVX9aE-transformed.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-3 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        <div class="bee-block bee-block-4 bee-heading">
        <h1 style="color:#000000;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:28px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>Vaccinated & Insured Pet</strong> </h1>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break: break-word;"><span>Vaccinated and insured pets ensure both their own well-being and that of their owners, promoting a healthy and secure bond between them.</span></p>
        </div>
        <div class="bee-block bee-block-6 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:10px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w3">
        <div class="bee-block bee-block-1 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Safe" height="128px" src="images/Downloader.la-65fbdbd02e1ed.jpg" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-3 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        <div class="bee-block bee-block-4 bee-heading">
        <h1 style="color:#000000;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:28px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>High-Quality Products</strong> </h1>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break: break-word;">Premium pet accessories crafted for style and durability, ensuring the utmost comfort and safety for your beloved companion.</p>
        </div>
        <div class="bee-block bee-block-6 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:5px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w3">
        <div class="bee-block bee-block-1 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Daycare" height="128px" src="images/OxK-ZHmxJFDQzR__qvyEP-transformed.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-3 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        <div class="bee-block bee-block-4 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:28px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>Experienced Veterinarians & Trainers</strong> </h1>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break: break-word;"><span>Veterinarians and trainers with seasoned expertise dedicated to optimizing your pet's health and behavior for a thriving, harmonious life.</span></p>
        </div>
        <div class="bee-block bee-block-6 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:10px;"></div>
        </div>
        </div>
        <div class="bee-col bee-col-4 bee-col-w3">
        <div class="bee-block bee-block-1 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-2 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Daycare" height="128px" src="images/hassle-free.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-3 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        <div class="bee-block bee-block-4 bee-heading">
        <h1 style="color:#000000;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:28px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>Easy and Hassle-free Process</strong> </h1>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p>Experience a seamless and hassle-free process on our website, making your online journey effortless and enjoyable.</p>
        </div>
        <div class="bee-block bee-block-6 bee-divider bee-mobile_hide">
        <div class="spacer" style="height:10px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-27">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-spacer">
        <div class="spacer" style="height:15px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-28 bee-mobile_hide">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="spacer" style="height:0px;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-29">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#171614;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:42px;font-weight:400;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><span class="tinyMce-placeholder">What People Says About Us</span> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-divider bee-mobile_hide">
        <div class="center bee-separator" style="border-top:20px solid #ffffff;width:100%;"></div>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-30">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w4">
        <div class="bee-block bee-block-1 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="quote" height="64px" src="images/testimonials.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-2 bee-divider">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;">"Amazing selection of pets and supplies! The adoption process was seamless, and the website offers everything I need to care for my new furry friend. Highly recommend to all pet lovers!"</span></p>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Testimonial Avatar" height="64px" src="images/help.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p><span style="color: #000000;">Samrat Kundu</span></p>
        </div>
        </div>
        <div class="bee-col bee-col-2 bee-col-w4">
        <div class="bee-block bee-block-1 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="quote" height="64px" src="images/testimonials.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-2 bee-divider">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;">"Great variety of accessories and top-quality food options for pets! From stylish collars to nutritious meals. Convenient shopping experience with fast delivery!"</span></p>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Testimonial Avatar" height="64px" src="images/help.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;">Sayon Dey</span></p>
        </div>
        </div>
        <div class="bee-col bee-col-3 bee-col-w4">
        <div class="bee-block bee-block-1 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="quote" height="64px" src="images/testimonials.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-2 bee-divider">
        <div class="spacer" style="height:15px;"></div>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;">"Access to experienced trainers and trusted veterinarians ensures my pet receives the best care and guidance possible. A reliable one-stop-shop for all pet needs!"</span></p>
        </div>
        <div class="bee-block bee-block-4 bee-icons">
        <div class="bee-icon bee-icon-last">
        <div class="bee-content">
        <div class="bee-icon-image"><img alt="Testimonial Avatar" height="64px" src="images/help.png" width="auto"/></div>
        </div>
        </div>
        </div>
        <div class="bee-block bee-block-5 bee-paragraph">
        <p style="word-break: break-word;"><span style="color: #000000;">Nikita Mallick</span></p>
        </div>
        </div>
        </div>
        </div>
        <div class="bee-row bee-row-31">
        <div class="bee-row-content">
        <div class="bee-col bee-col-1 bee-col-w12">
        <div class="bee-block bee-block-1 bee-divider">
        <div class="center bee-separator" style="border-top:20px solid #ffffff;width:100%;"></div>
        </div>
        </div>
        </div>
        </div>
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
        <p style="word-break:break-word;"><a href="" rel="noopener" style="text-decoration: none;" target="_blank"></a></p>
        </div>
        </div>

        <div class="bee-col bee-col-3 bee-col-w3">
        <div class="bee-block bee-block-1 bee-heading">
        <h1 style="color:#ffffff;direction:ltr;font-family:Source Sans Pro, Tahoma, Verdana, Segoe, sans-serif;font-size:18px;font-weight:400;line-height:200%;text-align:left;margin-top:0;margin-bottom:0;"><strong>Contact</strong> </h1>
        </div>
        <div class="bee-block bee-block-2 bee-paragraph">
        <p style="word-break: break-word;"><a href="mailto:lovinpet.service@gmail.com" rel="noopener" style="text-decoration: none;" target="_blank">lovinpet.service@gmail.com</a></p>
        </div>
        <div class="bee-block bee-block-3 bee-paragraph">
        <p style="word-break:break-word;"><a href="tel:+918479055734" rel="noopener" style="text-decoration: none;" target="_blank">+91 8479055734 / 6289799403</a></p>
        </div>
        <div class="bee-block bee-block-4 bee-social">
        <div class="content"><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.facebook.com" target="_self"><img alt="Facebook" src="images/facebook2x.png" title="facebook"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.twitter.com" target="_self"><img alt="Twitter" src="images/twitter2x.png" title="twitter"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.linkedin.com" target="_self"><img alt="Linkedin" src="images/linkedin2x.png" title="linkedin"/></a></span><span class="icon" style="padding:0 2.5px 0 2.5px;"><a href="https://www.instagram.com" target="_self"><img alt="Instagram" src="images/instagram2x.png" title="instagram"/></a></span></div>
        </div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>