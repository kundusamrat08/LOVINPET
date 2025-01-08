<?php
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: seller_login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT id, Seller_name FROM seller_list WHERE Seller_email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $seller = $row['id'];
    $seller_name = $row['Seller_name'];
} else {
    // $seller = "Unknown"; // Set a default name if seller's name is not found
    header("Location: seller_login.php");
}


// $conn->close();

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
function getTotalCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}


$totalPetBookingCount = getTotalCount($conn, "pet_booking where User_Type='$seller'");
$totalOrdersCount = getTotalCount($conn, "orders where User_Type='$seller'");
$totalAccessoriesCount = getTotalCount($conn, "accessories where User_Type='$seller'");
$totalPetsCount = getTotalCount($conn, "pets where User_Type='$seller'");
$totalMedicineCount = getTotalCount($conn, "medicine where User_Type='$seller'");
$totalFoodCount = getTotalCount($conn, "food where User_Type='$seller'");

// $conn->close();
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['add_pet'])) {
        $petname = $_POST['pet_name'];
        $Petcategory = $_POST['pet_category'];
        $Petbreed = $_POST['pet_breed'];
        $Petage = $_POST['pet_age'];
        $Petprice = $_POST['pet_price'];
        $pet_about = $_POST['pet_about'];

        $Petimage = $_FILES['pet_image']['name']; 
        $target = "upload/" . basename($Petimage);
        move_uploaded_file($_FILES['pet_image']['tmp_name'], $target);

        $Petimage2 = $_FILES['pet_image2']['name']; 
        $target = "upload/" . basename($Petimage2);
        move_uploaded_file($_FILES['pet_image2']['tmp_name'], $target);

        // $Petimage3 = $_FILES['pet_image3']['name']; 
        // $target = "upload/" . basename($Petimage3);
        // move_uploaded_file($_FILES['pet_image3']['tmp_name'], $target);

        // $Petimage4 = $_FILES['pet_image4']['name']; 
        // $target = "upload/" . basename($Petimage4);
        // move_uploaded_file($_FILES['pet_image4']['tmp_name'], $target);

        // $Petimage5 = $_FILES['pet_image5']['name']; 
        // $target = "upload/" . basename($Petimage5);
        // move_uploaded_file($_FILES['pet_image5']['tmp_name'], $target);

        // if (move_uploaded_file($_FILES['pet_image']['tmp_name'], $target)) {
          $sql_add_pet = "INSERT INTO pets (name,category,breed,age,price,image,image2,about_pet,status,User_Type) VALUES ('$petname','$Petcategory','$Petbreed','$Petage','$Petprice','$Petimage','$Petimage2','$pet_about','Activate','$seller')";
          if (mysqli_query($conn, $sql_add_pet)) {
              echo "New pet Inserted successfully";
              header("Location: seller_panelf.php");
              exit;
          } else {
              echo "Error: " . mysqli_error($conn);
          }
    //   } else {
    //       echo "Failed to upload image"; 
    //   }
  }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_accessory'])) {
    $name = $_POST['accessory_name'];
    $acc_category = $_POST['acc_category'];
    $acc_type = $_POST['acc_type'];
    $acc_stock = $_POST['acc_stock'];
    $price = $_POST['accessory_price'];
    $about_accessories = $_POST['about_accessories'];
  
  //   File upload
    $image = $_FILES['accessory_image']['name'];
    $target = "upload/" . basename($image);
    move_uploaded_file($_FILES['accessory_image']['tmp_name'], $target);
  
    $image2 = $_FILES['accessory_image2']['name'];
    $target = "upload/" . basename($image2);
    move_uploaded_file($_FILES['accessory_image2']['tmp_name'], $target);
  
    $image3 = $_FILES['accessory_image3']['name'];
    $target = "upload/" . basename($image3);
    move_uploaded_file($_FILES['accessory_image3']['tmp_name'], $target);
  
    $image4 = $_FILES['accessory_image4']['name'];
    $target = "upload/" . basename($image4);
    move_uploaded_file($_FILES['accessory_image4']['tmp_name'], $target);
  
    $image5 = $_FILES['accessory_image5']['name'];
    $target = "upload/" . basename($image5);
    move_uploaded_file($_FILES['accessory_image5']['tmp_name'], $target);
  
  
    $sql_add_accessory = "INSERT INTO accessories (name,acc_category,acc_type,image1,image2,image3,image4,image5,stock,price,about_accessories,status,User_Type) VALUES ('$name', '$acc_category', '$acc_type', '$image', '$image2', '$image3', '$image4', '$image5', '$acc_stock', '$price', '$about_accessories', 'Activate', '$seller')";
    if (mysqli_query($conn, $sql_add_accessory)) {
        echo "New Accessory Inserted successfully";
        header("Location: seller_panelf.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_medicine'])) {
    $medicine_name = $_POST['medicine_name'];
    $medicine_pet = $_POST['medicine_pet'];
    $medicine_unit = $_POST['medicine_unit'];
    $medicine_price = $_POST['medicine_price'];
    $medicine_stock = $_POST['medicine_stock'];
    $medi_desc = $_POST['medi_desc'];
  
    $image = $_FILES['medicine_image']['name'];
    $target = "upload/" . basename($image);
    move_uploaded_file($_FILES['medicine_image']['tmp_name'], $target);
  
    $image2 = $_FILES['medicine_image2']['name'];
    $target = "upload/" . basename($image2);
    move_uploaded_file($_FILES['medicine_image2']['tmp_name'], $target);
  
    $image3 = $_FILES['medicine_image3']['name'];
    $target = "upload/" . basename($image3);
    move_uploaded_file($_FILES['medicine_image3']['tmp_name'], $target);
  
    $image4 = $_FILES['medicine_image4']['name'];
    $target = "upload/" . basename($image4);
    move_uploaded_file($_FILES['medicine_image4']['tmp_name'], $target);
  
    $image5 = $_FILES['medicine_image5']['name'];
    $target = "upload/" . basename($image5);
    move_uploaded_file($_FILES['medicine_image5']['tmp_name'], $target);
  
    $sql_add_medicine = "INSERT INTO medicine (medicine_name, medicine_pet,medicine_unit, medicine_price, medi_stock, image1,image2,image3,image4,image5, medi_desc,status,user_type) VALUES ('$medicine_name', '$medicine_pet','$medicine_unit','$medicine_price','$medicine_stock', '$image', '$image2', '$image3', '$image4', '$image5', '$medi_desc','Activate', '$seller')";
  
    if (mysqli_query($conn, $sql_add_medicine)) {
        // Success message or redirect
        echo "New medicine Inserted successfully";
        header("Location: seller_panelf.php");
        exit;
    } else {
    
        echo "Error: " . mysqli_error($conn);
    }
  
    // mysqli_close($conn);
}
  
  
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_food'])) {
    $food_name = $_POST['food_name'];
    $food_pet = $_POST['food_for_pet'];
    $food_unit = $_POST['food_unit'];
    $food_price = $_POST['food_price'];
    $food_stock = $_POST['food_stock'];
    $food_desc = $_POST['food_desc'];
    
    
    // File upload
    $image = $_FILES['food_image']['name'];
    $target = "upload/" . basename($image);
    move_uploaded_file($_FILES['food_image']['tmp_name'], $target);
  
    $image2 = $_FILES['food_image2']['name'];
    $target = "upload/" . basename($image2);
    move_uploaded_file($_FILES['accessory_image2']['tmp_name'], $target);
  
    $image3 = $_FILES['food_image3']['name'];
    $target = "upload/" . basename($image3);
    move_uploaded_file($_FILES['accessory_image3']['tmp_name'], $target);
  
    $image4 = $_FILES['food_image4']['name'];
    $target = "upload/" . basename($image4);
    move_uploaded_file($_FILES['accessory_image4']['tmp_name'], $target);
  
    $image5 = $_FILES['food_image5']['name'];
    $target = "upload/" . basename($image5);
    move_uploaded_file($_FILES['accessory_image5']['tmp_name'], $target);
  
    $sql_add_food = "INSERT INTO food (food_name, food_for_pet, food_unit, food_price, food_stock, image1,image2,image3,image4,image5, food_description,status,user_type) VALUES ('$food_name', '$food_pet','$food_unit','$food_price','$food_stock', '$image', '$image2', '$image3', '$image4', '$image5', '$food_desc','Activate','$seller')";
  
    if (mysqli_query($conn, $sql_add_food)) {
        echo "New food Inserted successfully";
        header("Location: seller_panelf.php");
          exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
  
    // mysqli_close($conn);
  }


//   if (isset($_GET['email'])) {
//     $email = $_GET['email'];
//     $sql = "UPDATE seller_list SET status='Approved' WHERE Seller_email='" . $email . "'";
//     mysqli_query($conn, $sql);
//     // echo "Successfully Approved<br>";
//     }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel</title>
    <!-- <link rel="stylesheet" href="indexx5.css"> -->
    <link rel="stylesheet" href="css/adp.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
  .stat-box {
      background-color: #f0f0f0;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
    }
    .chart-container {
      margin-top: 20px;
    }


/* You may need to adjust other styles to fit your design */

</style>
<body>

    <div class="sidebar">
        <!-- <h1>ADMIN</h1> --> 
        <div class="logo" style="display: flex; justify-content: center; align-items: center;">
        <img src="images/lovinpet-high-resolution-logo-white-transparent.png" alt="" style="width: 150px; height: 40px; margin-top: 10px;">
        </div>
        <ul>
            <li>
                <a href="#dashboard" class="dt">Seller Information</a>
            </li>
            
            <li>
                <a class="dropdown-toggle">Add Products</a>
                <div class="dropdown-content">
                    <a href="#pet-table" class="col">Pet Table</a>
                    <a href="#accessories-table" class="col">Accessories Table</a>
                    <a href="#medicine-table" class="col">Medicine Table</a>
                    <a href="#food-table" class="col">Food Table</a>
                </div>

            </li>
            <li>
                <a href="#petbooking" class="dt">Pet Booking List</a>
            </li>
            <li>
                <a href="#order" class="dt">Order List</a>
            </li>
            <!-- <li> -->
                <div class="tt">
                <a href="seller_logout.php">Logout</a>
                </div>
            <!-- </li> -->
        </ul>
    </div>

<main>
<section id="dashboard" class="content-section">
<?php
        // Display seller's name and email
        echo "<p><strong>Name:</strong> " . $seller_name . "</p>";
        echo "<p><strong>Email:</strong> " . $email . "</p>";
        // You can add more details here if needed
        ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="container">
        <!-- <h2 class="mt-4">Dashboard</h2> -->
<div class="row">
  
  <div class="col-lg-4 col-md-6">
    <div class="stat-box bg-primary text-white">
      <h3>Total Pets</h3>
      <p class="mb-0"><?php echo $totalPetsCount; ?></p>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-box bg-info text-white custom-color-2">
      <h3>Total Accessories</h3>
      <p class="mb-0"><?php echo $totalAccessoriesCount; ?></p>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-box bg-success text-white custom-color-4">
      <h3>Total Medicine</h3>
      <p class="mb-0"><?php echo $totalMedicineCount; ?></p>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-box bg-dark text-white custom-color-5">
      <h3>Total Foods</h3>
      <p class="mb-0"><?php echo $totalFoodCount; ?></p>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-box bg-warning text-white custom-color-6">
      <h3>Total Orders</h3>
      <p class="mb-0"><?php echo $totalOrdersCount; ?></p>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>
</div>
</section>
        
        <section id="pet-table" class="content-section table-container">
            <h2>Pet Table</h2>
            <button id="showFormButton">Add Pet</button>
             <table border="1">

                    <tr class="trrt">
                        <th>ID</th>
                        <th>Pet Name</th>
                        <th>Category</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Image 2</th>
                        <!-- <th>Image 3</th>
                        <th>Image 4</th>
                        <th>Image 5</th> -->
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
            <?php
            // Fetch pets from the database for the current seller

            $sql_pets = "SELECT * FROM pets WHERE User_Type='$seller' ORDER BY id DESC";
            $result_pets = mysqli_query($conn, $sql_pets);

            // Display pets added by the seller
            if ($result_pets && mysqli_num_rows($result_pets) > 0) {
                while ($pet = mysqli_fetch_assoc($result_pets)) {
                    echo "<tr>";
                    echo "<td>" . $pet['id'] . "</td>";
                    echo "<td>" . $pet['name'] . "</td>";
                    echo "<td>" . $pet['category'] . "</td>";
                    echo "<td>" . $pet['breed'] . "</td>";
                    echo "<td>" . $pet['age'] . "</td>";
                    echo "<td>" . $pet['price'] . "</td>";
                    // echo "<td><img src='upload/" . $pet['image'] . "' alt='Pet Image'></td>";
                    echo "<td>";
                    if (!empty($pet['image'])) {
                    echo "<img src='upload/" . $pet['image'] . "' alt='Pet Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($pet['image2'])) {
                    echo "<img src='upload/" . $pet['image2'] . "' alt='Pet Image2'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    // echo "<td>";
                    // if (!empty($pet['image3'])) {
                    // echo "<img src='upload/" . $pet['image3'] . "' alt='Pet Image3'>";
                    // } else {
                    //     echo "No image available";
                    // }
                    // echo "</td>";

                    // echo "<td>";
                    // if (!empty($pet['image4'])) {
                    // echo "<img src='upload/" . $pet['image4'] . "' alt='Pet Image4'>";
                    // } else {
                    //     echo "No image available";
                    // }
                    // echo "</td>";

                    // echo "<td>";
                    // if (!empty($pet['image5'])) {
                    // echo "<img src='upload/" . $pet['image5'] . "' alt='Pet Image5'>";
                    // } else {
                    //     echo "No image available";
                    // }
                    // echo "</td>";

                    echo "<td>" . $pet['status'] . "</td>";
                    echo " <td><form method='post' action='update_status.php'>";
                    echo "<input type='hidden' name='pet_id' value='" . $pet['id'] . "'>";
                    echo "<input type='hidden' name='current_status' value='" . $pet['status'] . "'>";
                    if ($pet['status'] == 'Deactivate') {
                        echo "<button type='submit' class='change-abtn' name='activate'>Activate</button>";
                    } else {
                        echo "<button type='submit' class='change-dbtn' name='deactivate'>Deactivate</button>";
                    }
                    echo "</form></td>";

                    echo "<td><button class='edit-btn'><a class='dlbn' href='update_pet.php?id=" . $pet['id'] . "'>Update</a></button></td>";
                    echo "<td><button class='dlt-btn'><a class='dlbn' href='delete_pet.php?id=" . $pet['id'] . "'>Delete</a></button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No pets added.</td></tr>";
            }
            ?>  
            </table>
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div>
        </section>

        <section id="accessories-table" class="content-section table-container">
        <h2>Accessories Table</h2>
        <!-- <div class="table-wrapper"> -->
            <button id="showFormButton1">Add Accessories</button>
             <table border="1">
                <!-- <thead> -->
                    <tr class="trrt">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Image1</th>
                        <th>Image2</th>
                        <th>Image3</th>
                        <th>Image4</th>
                        <th>Image5</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                <!-- </thead> -->
                <!-- <tbody>
                    <td>1</td>
                    <td>Buddy</td>
                    <td>Labrador Retriever</td>
                    <td>2</td>
                    <td><img src="https://via.placeholder.com/150" alt="Image 1"></td>
                    <td><img src="https://via.placeholder.com/150" alt="Image 2"></td>
                    <td><img src="https://via.placeholder.com/150" alt="Image 3"></td>
                    <td><img src="https://via.placeholder.com/150" alt="Image 4"></td>
                    <td><img src="https://via.placeholder.com/150" alt="Image 5"></td>
                    <td>Active</td>
                    <td><button>Change</button></td>
                    <td><button>Edit</button></td>
                    <td><button>Delete</button></td>
                </tbody> -->
                <?php
            // Fetch accessories from the database for the current seller
            $sql_accessories = "SELECT * FROM accessories WHERE User_Type='$seller' ORDER BY id DESC";
            $result_accessories = mysqli_query($conn, $sql_accessories);

            // Display accessories added by the seller
            if ($result_accessories && mysqli_num_rows($result_accessories) > 0) {
                while ($accessory = mysqli_fetch_assoc($result_accessories)) {
                    echo "<tr>";
                    echo "<td>" . $accessory['id'] . "</td>";
                    echo "<td>" . $accessory['name'] . "</td>";
                    echo "<td>" . $accessory['acc_category'] . "</td>";
                    echo "<td>" . $accessory['acc_type'] . "</td>";
                    echo "<td>" . $accessory['stock'] . "</td>";
                    echo "<td>" . $accessory['price'] . "</td>";
                    
                    // echo "<td><img src='upload/" . $accessory['image'] . "' alt='Accessory Image'></td>";
                    echo "<td>";
                    if (!empty($accessory['image1'])) {
                    echo "<img src='upload/" . $accessory['image1'] . "' alt='Accessories Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($accessory['image2'])) {
                    echo "<img src='upload/" . $accessory['image2'] . "' alt='Accessories Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($accessory['image3'])) {
                    echo "<img src='upload/" . $accessory['image3'] . "' alt='Accessories Image'>";
                    } else {
                        echo "No image";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($accessory['image4'])) {
                    echo "<img src='upload/" . $accessory['image4'] . "' alt='Accessories Image'>";
                    } else {
                        echo "No image";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($accessory['image5'])) {
                    echo "<img src='upload/" . $accessory['image5'] . "' alt='Accessories Image'>";
                    } else {
                        echo "No image";
                    }
                    echo "</td>";


                    echo "<td>" . $accessory['status'] . "</td>";
                    echo " <td><form method='post' action='update_status_acc.php'>";
                    echo "<input type='hidden' name='acc_id' value='" . $accessory['id'] . "'>";
                    echo "<input type='hidden' name='current_status' value='" . $accessory['status'] . "'>";
                    // Button for activating
                    if ($accessory['status'] == 'Deactivate') {
                        echo "<button class='change-abtn type='submit' name='activate'>Activate</button>";
                    } else {
                        // Button for deactivating
                        echo "<button class='change-dbtn' type='submit' name='deactivate'>Deactivate</button>";
                    }
                    echo "</form></td>";

                    echo "<td><button class='edit-btn'><a class='dlbn' href='update_accessries.php?id=" . $accessory['id'] . "'>Update</a></button></td>";
                    echo "<td><button class='dlt-btn'><a class='dlbn' href='delete_accessries.php?id=" . $accessory['id'] . "'>Delete</a></button></td>";
                    // echo "<td><input type='checkbox' name='accessory[]' value='" . $accessory['id'] . "'></td>"; // Add checkbox for selection
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No accessories added.</td></tr>";
            }
            ?>
            </table>
            <!-- </div> -->
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div>
        </section>

        <section id="medicine-table" class="content-section table-container">
            <h2>Medicine Table</h2>
             <button id="showFormButton2">Add Medicine</button>
             <table border="1">
                <!-- <thead> -->
                    <tr class="trrt">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Image1</th>
                        <th>Image2</th>
                        <th>Image3</th>
                        <th>Image4</th>
                        <th>Image5</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                <!-- </thead> -->
                <?php
            // Fetch medicine from the database for the current seller
            $sql_medicine = "SELECT * FROM medicine WHERE User_Type='$seller' ORDER BY id DESC";
            $result_medicine = mysqli_query($conn, $sql_medicine);

            // Display medicine added by the seller
            if ($result_medicine && mysqli_num_rows($result_medicine) > 0) {
                while ($medicine = mysqli_fetch_assoc($result_medicine)) {
                    echo "<tr>";
                    echo "<td>" . $medicine['id'] . "</td>";
                    echo "<td>" . $medicine['medicine_name'] . "</td>";
                    echo "<td>" . $medicine['medicine_pet'] . "</td>";
                    echo "<td>" . $medicine['medicine_unit'] . "</td>";
                    echo "<td>" . $medicine['medicine_price'] . "</td>";

                    // echo "<td><img src='upload/" . $medicine['medicine_image'] . "' alt='Medicine Image'></td>";
                    echo "<td>";
                    if (!empty($medicine['image1'])) {
                    echo "<img src='upload/" . $medicine['image1'] . "' alt='Medicine Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($medicine['image2'])) {
                    echo "<img src='upload/" . $medicine['image2'] . "' alt='Medicine Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($medicine['image3'])) {
                    echo "<img src='upload/" . $medicine['image3'] . "' alt='Medicine Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($medicine['image4'])) {
                    echo "<img src='upload/" . $medicine['image4'] . "' alt='Medicine Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($medicine['image5'])) {
                    echo "<img src='upload/" . $medicine['image5'] . "' alt='Medicine Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>" . $medicine['status'] . "</td>";
                    echo " <td><form method='post' action='update_status_medi.php'>";
                    echo "<input type='hidden' name='medi_id' value='" . $medicine['id'] . "'>";
                    echo "<input type='hidden' name='current_status' value='" . $medicine['status'] . "'>";
                    // Button for activating
                    if ($medicine['status'] == 'Deactivate') {
                        echo "<button class='change-abtn' type='submit' name='activate'>Activate</button>";
                    } else {
                        // Button for deactivating
                        echo "<button class='change-dbtn' type='submit' name='deactivate'>Deactivate</button>";
                    }
                    echo "</form></td>";
                    echo "<td><button class='edit-btn'><a class='dlbn' href='update_medicine.php?id=" . $medicine['id'] . "'>Update</a></button></td>";
                    echo "<td><button class='dlt-btn'><a class='dlbn' href='delete_medicine.php?id=" . $medicine['id'] . "'>Delete</a></button></td>";
                    // echo "<td><input type='checkbox' name='medicine[]' value='" . $medicine['id'] . "'></td>"; // Add checkbox for selection
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No medicine added.</td></tr>";
            }
            ?>
            </table>
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div>
        </section>

        <section id="food-table" class="content-section table-container">
            <h2>Food Table</h2>
            <button id="showFormButtonfd">Add Food</button>
             <table border="1">
                
                <!-- <thead> -->
                    <tr class="trrt">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Units</th>
                        <th>Image1</th>
                        <th>Image2</th>
                        <th>Image3</th>
                        <th>Image4</th>
                        <th>Image5</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                <!-- </thead> -->
                <?php
            // Fetch food from the database for the current seller
            $sql_food = "SELECT * FROM food WHERE User_Type='$seller' ORDER BY id DESC";
            $result_food = mysqli_query($conn, $sql_food);

            // Display food added by the seller
            if ($result_food && mysqli_num_rows($result_food) > 0) {
                while ($food = mysqli_fetch_assoc($result_food)) {
                    echo "<tr>";
                    echo "<td>" . $food['id'] . "</td>";
                    echo "<td>" . $food['food_name'] . "</td>";
                    echo "<td>" . $food['food_for_pet'] . "</td>";
                    echo "<td>" . $food['food_price'] . "</td>";
                    echo "<td>" . $food['food_unit'] . "</td>";

                    // echo "<td><img src='upload/" . $food['food_image'] . "' alt='Food Image'></td>";

                    echo "<td>";
                    if (!empty($food['image1'])) {
                    echo "<img src='upload/" . $food['image1'] . "' alt='Food Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";
                    
                    echo "<td>";
                    if (!empty($food['image2'])) {
                    echo "<img src='upload/" . $food['image2'] . "' alt='Food Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($food['image3'])) {
                    echo "<img src='upload/" . $food['image3'] . "' alt='Food Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($food['image4'])) {
                    echo "<img src='upload/" . $food['image4'] . "' alt='Food Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";

                    echo "<td>";
                    if (!empty($food['image5'])) {
                    echo "<img src='upload/" . $food['image5'] . "' alt='Food Image'>";
                    } else {
                        echo "No image available";
                    }
                    echo "</td>";
                    
                    echo "<td>" . $food['status'] . "</td>";
                    echo " <td><form method='post' action='update_status_food.php'>";
                    echo "<input type='hidden' name='food_id' value='" . $food['id'] . "'>";
                    echo "<input type='hidden' name='current_status' value='" . $food['status'] . "'>";
                    // Button for activating
                    if ($food['status'] == 'Deactivate') {
                        echo "<button class='change-abtn' type='submit' name='activate'>Activate</button>";
                    } else {
                        // Button for deactivating
                        echo "<button class='change-dbtn' type='submit' name='deactivate'>Deactivate</button>";
                    }
                    echo "</form></td>";
                    echo "<td><button class='edit-btn'><a class='dlbn' href='update_food.php?id=" . $food['id'] . "'>Update</a></button></td>";
                    echo "<td><button class='dlt-btn'><a class='dlbn' href='delete_food.php?id=" . $food['id'] . "'>Delete</a></button></td>";
                    // echo "<td><input type='checkbox' name='food[]' value='" . $food['id'] . "'></td>"; // Add checkbox for selection
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No food added.</td></tr>";
            }
            ?>
            </table>
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div>
        </section>
        
        <section id="petbooking" class="content-section table-container">
            <h2>Pet Booking List</h2>

            <table border="1">
                    <tr class="trrt">
                    <th>Booking ID</th>
                    <th>Booking Date</th>
                    <th>Pet ID</th>
                    <th>Pet Name</th>
                    <th>Pet Category</th>
                    <th>Pet Breed</th>
                    <th>Pet Age</th>
                    <th>Pet Price</th>
                    <th>Pet Image</th>
                    <th>User Name</th>
                    <th>User Phone</th>
                    <th>User Email</th>
                    <th>User Address</th>
                    <th>User Pincode</th>
                    </tr>
                    <?php
$sql = "SELECT * FROM pet_booking where User_Type ='$seller' AND status ='approved' ORDER BY id DESC";
$result = $conn->query($sql);
?> 
<?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["booking_date"] . "</td>";
                        echo "<td>" . $row["product_id"] . "</td>";
                        echo "<td>" . $row["pet_name"] . "</td>";
                        echo "<td>" . $row["pet_category"] . "</td>";
                        echo "<td>" . $row["pet_breed"] . "</td>";
                        echo "<td>" . $row["pet_age"] . "</td>";
                        echo "<td>" . $row["pet_price"] . "</td>";
                        echo "<td>";
                        echo "<img height='100px' width='100px' class='imgs' src='upload/" . ($row['pet_image'] ) . "' alt='Product Image'>";
                        echo "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["pincode"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found</td></tr>";
                }
                ?>
            </table>
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div>
        </section>

        <section id="order" class="content-section table-container">

            <h2>Orders</h2>
            <table border="1">
                    <tr class="trrt">
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Product Category</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Quantity</th>

                    <th>Price</th>
                    <th>Order Status</th>
                    <th>Action</th>
                    <!-- <th>status</th> -->
                  
                    </tr>
                    <?php
// include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["order_id"]) && isset($_POST["order_status"])) {
        $order_id = $_POST["order_id"];
        $order_status = $_POST["order_status"];

        // Update order status in the database
        $sql = "UPDATE orders SET order_status = '$order_status' WHERE order_id = $order_id";
        if ($conn->query($sql) === TRUE) {
            // echo "Order status updated successfully";
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    }else {
        echo "Some form fields are missing!";
    }
}

$sql = "SELECT * FROM orders where User_Type='$seller' AND status ='approved' ORDER BY order_id DESC";
$result = $conn->query($sql);
?> 
<?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["order_id"] . "</td>";
                        echo "<td>" . $row["order_date"] . "</td>";
                        echo "<td>" . $row["product_category"] . "</td>";
                        echo "<td>" . $row["product_id"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td>";
                        echo "<img height='100px' width='100px' class='imgs' src='upload/" . ($row['image'] ) . "' alt='Product Image'>";
                        echo "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
                        echo "<select class='' name='order_status' style='border:1px solid #c50035;'>";
                        echo "<option value='pending' " . ($row["order_status"] == "Pending" ? "selected" : "") . ">Pending</option>";
                        echo "<option value='packed' " . ($row["order_status"] == "Packed" ? "selected" : "") . ">Packed</option>";
                        echo "<option value='dispatched' " . ($row["order_status"] == "Dispatched" ? "selected" : "") . ">Dispatched</option>";
                        // echo "<option value='out_for_delivery' " . ($row["order_status"] == "Out for Delivery" ? "selected" : "") . ">Out for Delivery</option>";
                        // echo "<option value='received' " . ($row["order_status"] == "Received" ? "selected" : "") . ">Received</option>";
                        echo "<option value='cancelled' " . ($row["order_status"] == "Cancelled" ? "selected" : "") . ">Cancelled</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td>";
                        echo "<input type='submit' class='btn btn-primary mt-2' value='Update' style='font-size:10px; padding: 4px 7x;'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found</td></tr>";
                }
                ?>
            </table>
            <div class="container">
            <button class="prev-btn">Previous</button>
               <span class="pagination-info"></span>
               <button class="next-btn">Next</button>
               <div class="table-numbers"></div> 
               <input type="number" class="page-input" placeholder="Enter Page Number" autocomplete="off">
               <button class="search-btn">Search</button><br><br>
            </div> 
        </section>
    </main>
                

    <div id="popupForm">
        <div class="form-container">
            <h2>Add Pet</h2>
            <button id="closeFormButton">Close</button>
            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-column">
                        <label for="pet-name">Pet Name</label>
                        <input type="text" id="pet-name" name="pet_name">
                    </div>

                    <div class="form-column">
                        <label for="pet-category">Pet Category</label>
                        <!-- <input type="text" id="pet_category" name="pet_category"> -->
                        <select class="se" name="pet_category" id="pet_category" required>
                        <option value="">Select</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Bird">Bird</option>
                        <option value="Fish">Fish</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="pet-breed">Pet Breed</label>
                        <!-- <input type="text" id="pet-breed" name="pet_breed"> -->
                        <select class="se" name="pet_breed" id="pet_breed" required>
                                <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-column">
                        <label for="pet-age">Pet Age</label>
                        <!-- <input type="text" id="pet-age" name="pet_age"> -->
                        <select class="se" name="pet_age" id="pet-age" required>
                        <option value="">Select</option>
                        <option value="Puppy">Puppy</option>
                        <option value="Kitten">Kitten</option>
                        <option value="Bunny">Bunny</option>
                        <option value="Hatchling">Hatchling</option>
                        <option value="Young Adulthood">Young Adulthood</option>
                        <option value="Junior">Junior</option>
                        <option value="Juvenile">Juvenile</option>
                        <option value="Adulthood">Adulthood</option>
                        <option value="Prime">Prime</option>
                        <option value="Mature">Mature</option>
                        <option value="Senior">Senior</option>                        
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="pet-price">Price</label>
                        <input type="text" id="pet-price" name="pet_price">
                    </div>
                    <div class="form-column">
                        <label for="pet-about">Pet Description</label>
                        <input type="text" id="pet-about" name="pet_about">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="pet-color">Pet Image 1</label>
                        <input type="file" id="pet-image" name="pet_image">
                    </div>
                    <div class="form-column">
                        <label for="pet-color">Pet Image 2</label>
                        <input type="file" id="pet-image" name="pet_image2">
                    </div>
                    <!-- <div class="form-column">
                        <label for="pet-color">Image</label>
                        <input type="file" id="pet-image" name="pet-image">
                    </div>
                    <div class="form-column">
                        <label for="pet-color">Image</label>
                        <input type="file" id="pet-image" name="pet-image">
                    </div>
                    <div class="form-column">
                        <label for="pet-color">Image</label>
                        <input type="file" id="pet-image" name="pet-image">
                    </div> -->
                </div>
                <button type="submit" name="add_pet">Add Pet</button>
            </form>
        </div>
    </div>    

    <div id="popupForm1">
        <div class="form-container">
            <h2>Add Accessories</h2>
            <button id="closeFormButton1">Close</button>
            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-column">
                    <label>Accessory Name</label>
                    <input type="text" name="accessory_name" required>
                    </div>

                    <div class="form-column">
                    <label>Accessories Category</label>
                        <select class="se" name="acc_category" id="" required>
                        <option value="">Select</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Bird">Bird</option>
                        <option value="Fish">Fish</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Accessory Type</label>
                        <select class="se" name="acc_type" id="" required>
                        <option value="">Select</option>
                        <option value="Collars">Collars</option>
                        <option value="Chain">Chain</option>
                        <option value="Muzzle">Muzzle</option>
                        <option value="Bed">Bed</option>
                        <option value="Cage">Cage</option>
                        <option value="Aquriam">Aquriam</option>
                        </select>
                    </div>
                    <div class="form-column">
                    <label>Accessory Stock</label>
                    <input type="text" name="acc_stock" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Accessory Price</label>
                    <input type="text" name="accessory_price" required>
                    </div>
                    <div class="form-column">
                    <label>Accessory Description</label>
                    <input type="text" name="about_accessories" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Accessory Image1</label>
                    <input type="file" name="accessory_image" required>
                    </div>
                    <div class="form-column">
                    <label>Accessory Image2</label>
                    <input type="file" name="accessory_image2">
                    </div>
                    <div class="form-column">
                    <label>Accessory Image3</label>
                    <input type="file" name="accessory_image3">
                    </div>
                    <div class="form-column">
                    <label>Accessory Image4</label>
                    <input type="file" name="accessory_image4">
                    </div>
                    <div class="form-column">
                    <label>Accessory Image5</label>
                    <input type="file" name="accessory_image5">
                    </div>
                </div>
                <button type="submit" name="add_accessory">Add Accessories</button>
            </form>
        </div>
    </div>

    <div id="popupForm2">
        <div class="form-container">
            <h2>Add Medicine</h2>
            <button id="closeFormButton2">Close</button>
            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-column">
                    <label>Medicine Name</label>
                    <input type="text" name="medicine_name" required>
                    </div>

                    <div class="form-column">
                    <label>Medicine for pet</label>
                        <select class="se" name="medicine_pet" id="" required>
                        <option value="">Select</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Bird">Bird</option>
                        <option value="Fish">Fish</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Medicine Unit</label>
                    <input type="text" name="medicine_unit" required>
                    </div>
                    <div class="form-column">
                    <label>Medicine Price</label>
                    <input type="text" name="medicine_price" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Medicine Stock</label>
                    <input type="text" name="medicine_stock" required>
                    </div>
                    <div class="form-column">
                    <label>Medicine Description</label>
                    <input type="text" name="medi_desc" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Medicine Image1</label>
                    <input type="file" name="medicine_image" required>
                    </div>
                    <div class="form-column">
                    <label>Medicine Image2</label>
                    <input type="file" name="medicine_image2">
                    </div>
                    <div class="form-column">
                    <label>Medicine Image3</label>
                    <input type="file" name="medicine_image3">
                    </div>
                    <div class="form-column">
                    <label>Medicine Image4</label>
                    <input type="file" name="medicine_image4">
                    </div>
                    <div class="form-column">
                    <label>Medicine Image5</label>
                    <input type="file" name="medicine_image5">
                    </div>
                </div>
                <button type="submit" name="add_medicine">Add Medicine</button>
            </form>
        </div>
    </div>


    <div id="popupFormfd">
        <div class="form-container">
            <h2>Add Food</h2>
            <button id="closeFormButton3">Close</button>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-column">
                    
                    <label>Food Name</label>
                    <input type="text" name="food_name" required>
                    </div>
                    <div class="form-column">
                    <label>Food for pet</label>
                        <select class="se" name="food_for_pet" id="" required>
                        <option value="">Select</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Bird">Bird</option>
                        <option value="Fish">Fish</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Food Unit</label>
                    <input type="text" name="food_unit" required>
                    </div>
                    <div class="form-column">
                    <label>Food Price</label>
                    <input type="text" name="food_price" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Food Stock</label>
                    <input type="text" name="food_stock" required>
                    </div>
                    <div class="form-column">
                    <label>Food Description</label>
                    <input type="text" name="food_desc" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                    <label>Food Image1</label>
                    <input type="file" name="food_image" required>
                    </div>
                    <div class="form-column">
                    <label>Food Image2</label>
                    <input type="file" name="food_image2">
                    </div>
                    <div class="form-column">
                    <label>Food Image3</label>
                    <input type="file" name="food_image3">
                    </div>
                    <div class="form-column">
                    <label>Food Image4</label>
                    <input type="file" name="food_image4">
                    </div>
                    <div class="form-column">
                    <label>Food Image5</label>
                    <input type="file" name="food_image5">
                    </div>
                </div>
                <button type="submit" name="add_food">Add Food</button>
            </form>
        </div>
    </div>
    
</body>
<script src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>