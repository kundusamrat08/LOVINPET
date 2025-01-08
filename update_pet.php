<?php
// Include your database connection file
include_once "db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $pet_id = $_POST['pet_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];

    $price = $_POST['price'];
    $about_pet = $_POST['about_pet'];
    
    // Check if a new image is uploaded
    // if ($_FILES['image']['size'] > 0) {
    //     $image = $_FILES['image']['name'];
    //     $image_tmp = $_FILES['image']['tmp_name'];

        // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image");
    // } else {
        // No new image uploaded, retain the existing image
    //     $image = $_POST['existing_image'];
    // }



    // Check if a new image is uploaded
    if ($_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Move uploaded file to a permanent location
        move_uploaded_file($image_tmp, "upload/$image");
    } else {
        // No new image uploaded, retain the existing image
        $image = $_POST['existing_image'];
    }

    // Check if a new image is uploaded for image2
    if ($_FILES['image_2']['size'] > 0) {
        $image2 = $_FILES['image_2']['name'];
        $image_tmp = $_FILES['image_2']['tmp_name'];

        // Move uploaded file to a permanent location
        move_uploaded_file($image_tmp, "upload/$image2");
    } else {
        // No new image uploaded, retain the existing image
        $image2 = $_POST['existing_image2'];
    }

    // if ($_FILES['image_3']['size'] > 0) {
    //     $image3 = $_FILES['image_3']['name'];
    //     $image_tmp = $_FILES['image_3']['tmp_name'];

    //     // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image3");
    // } else {
    //     // No new image uploaded, retain the existing image
    //     $image3 = $_POST['existing_image3'];
    // }

    // if ($_FILES['image_4']['size'] > 0) {
    //     $image4 = $_FILES['image_4']['name'];
    //     $image_tmp = $_FILES['image_4']['tmp_name'];

    //     // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image4");
    // } else {
    //     // No new image uploaded, retain the existing image
    //     $image4 = $_POST['existing_image4'];
    // }

    // if ($_FILES['image_5']['size'] > 0) {
    //     $image5 = $_FILES['image_5']['name'];
    //     $image_tmp = $_FILES['image_5']['tmp_name'];

    //     // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image5");
    // } else {
    //     // No new image uploaded, retain the existing image
    //     $image5 = $_POST['existing_image5'];
    // }
    // Check if the user wants to remove the first image
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image') {
        // Remove the first image
        $image = '';
    }

    // Check if the user wants to remove the second image
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image2') {
        // Remove the second image
        $image2 = '';
    }

    // if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image3') {
    //     // Remove the second image
    //     $image3 = '';
    // }

    // if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image4') {
    //     // Remove the second image
    //     $image4 = '';
    // }

    // if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image5') {
    //     // Remove the second image
    //     $image5 = '';
    // }


    // Update the pet details in the database
    $sql_update_pet = "UPDATE pets SET name='$name', category='$category', breed='$breed', age='$age', price='$price', image='$image', image2='$image2', image3='$image3', image4='$image4', image5='$image5', about_pet='$about_pet' WHERE id='$pet_id'";
    if (mysqli_query($conn, $sql_update_pet)) {
        header("Location: seller_panelf.php");
    } else {
        echo "Error updating pet details: " . mysqli_error($conn);
    }
}

// Retrieve the pet details based on the provided ID
if (isset($_GET['id'])) {
    $pet_id = $_GET['id'];

    // Fetch the pet details from the database
    $sql_fetch_pet = "SELECT * FROM pets WHERE id='$pet_id'";
    $result_fetch_pet = mysqli_query($conn, $sql_fetch_pet);
    $pet = mysqli_fetch_assoc($result_fetch_pet);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pet Details</title>
    <link rel="stylesheet" href="css/update_pet.css">
</head>
<body>
    
    <!-- <form method="POST" action="update_pet.php" enctype="multipart/form-data"> -->
    <form method="POST" action="" enctype="multipart/form-data">
    <h2>Update Pet Details</h2>
        <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
        
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $pet['name']; ?>"><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo $pet['category']; ?>"><br>
        
        
        <label for="breed">Breed:</label><br>
        <input type="text" id="breed" name="breed" value="<?php echo $pet['breed']; ?>"><br>
        <label for="age">Age:</label><br>
        <input type="text" id="age" name="age" value="<?php echo $pet['age']; ?>"><br>
   
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $pet['price']; ?>"><br><br>
        <label for="about">Description</label><br>
        <input type="text" id="about" name="about_pet" value="<?php echo $pet['about_pet']; ?>"><br><br>
       


        <?php if (!empty($pet['image'])): ?>
            <img src="upload/<?php echo $pet['image']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image" value="<?php echo $pet['image']; ?>">
            <label for="new_image">Choose New Image:</label><br>
            <div class="cc">
            <input type="file" id="new_image" name="image"><br><br>
            <button type="submit" name="remove_image" value="image">Remove Image</button><br>
            </div>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image">Choose Image:</label><br>
            <input type="file" id="new_image" name="image"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($pet['image2'])): ?>
            <img src="upload/<?php echo $pet['image2']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $pet['image2']; ?>">
            <label for="new_image2">Choose New Image:</label><br>
            <div class="cc">
            <input type="file" id="new_image2" name="image_2"><br><br>
            <button type="submit" name="remove_image" value="image2">Remove Image</button><br>
            </div>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image2">Choose Image:</label><br>
            <input type="file" id="new_image2" name="image_2"><br><br>
        <?php endif; ?>
        
        <br>

        <!-- <?php if (!empty($pet['image3'])): ?>
            <img src="upload/<?php echo $pet['image3']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image3" value="<?php echo $pet['image3']; ?>">
            <label for="new_image3">Choose New Image:</label><br>
            <div class="cc">
            <input type="file" id="new_image3" name="image_3"><br><br>
            <button type="submit" name="remove_image" value="image3">Remove Image</button><br>
            </div>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image3">Choose Image:</label><br>
            <input type="file" id="new_image3" name="image_3"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($pet['image4'])): ?>
            <img src="upload/<?php echo $pet['image4']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $pet['image4']; ?>">
            <label for="new_image4">Choose New Image:</label><br>
            <div class="cc">
            <input type="file" id="new_image4" name="image_4"><br><br>
            <button type="submit" name="remove_image" value="image4">Remove Image</button><br>
            </div>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image4">Choose Image:</label><br>
            <input type="file" id="new_image4" name="image_4"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($pet['image5'])): ?>
            <img src="upload/<?php echo $pet['image5']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image5" value="<?php echo $pet['image5']; ?>">
            <label for="new_image5">Choose New Image:</label><br>
            <div class="cc">
            <input type="file" id="new_image5" name="image_5"><br><br>
            <button type="submit" name="remove_image" value="image5">Remove Image</button><br>
            </div>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image5">Choose Image:</label><br>
            <input type="file" id="new_image5" name="image_5"><br><br>
        <?php endif; ?>
        
        <br> -->
      

        <input type="submit" value="Update">
    </form>
</body>
</html>


<?php
}
?>
