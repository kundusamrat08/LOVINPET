<?php
// Include your database connection file
include_once "db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $food_id = $_POST['food_id'];
    $food_name = $_POST['food_name'];
    $food_for_pet = $_POST['food_for_pet'];
    $food_unit = $_POST['food_unit'];
    $food_price = $_POST['food_price'];
    $food_stock = $_POST['food_stock'];
    $food_desc = $_POST['food_desc'];

    // Check if a new image is uploaded
    // if ($_FILES['image']['size'] > 0) {
    //     $image = $_FILES['image']['name'];
    //     $image_tmp = $_FILES['image']['tmp_name'];

    //     // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image");

    //     // Update the food image field in the database
    // } else {
    //     // No new image uploaded, retain the existing image
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

    if ($_FILES['image_3']['size'] > 0) {
        $image3 = $_FILES['image_3']['name'];
        $image_tmp = $_FILES['image_3']['tmp_name'];

        // Move uploaded file to a permanent location
        move_uploaded_file($image_tmp, "upload/$image3");
    } else {
        // No new image uploaded, retain the existing image
        $image3 = $_POST['existing_image3'];
    }

    if ($_FILES['image_4']['size'] > 0) {
        $image4 = $_FILES['image_4']['name'];
        $image_tmp = $_FILES['image_4']['tmp_name'];

        // Move uploaded file to a permanent location
        move_uploaded_file($image_tmp, "upload/$image4");
    } else {
        // No new image uploaded, retain the existing image
        $image4 = $_POST['existing_image4'];
    }

    if ($_FILES['image_5']['size'] > 0) {
        $image5 = $_FILES['image_5']['name'];
        $image_tmp = $_FILES['image_5']['tmp_name'];

        // Move uploaded file to a permanent location
        move_uploaded_file($image_tmp, "upload/$image5");
    } else {
        // No new image uploaded, retain the existing image
        $image5 = $_POST['existing_image5'];
    }
    // Check if the user wants to remove the first image
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image1') {
        // Remove the first image
        $image = '';
    }

    // Check if the user wants to remove the second image
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image2') {
        // Remove the second image
        $image2 = '';
    }

    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image3') {
        // Remove the second image
        $image3 = '';
    }

    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image4') {
        // Remove the second image
        $image4 = '';
    }

    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image5') {
        // Remove the second image
        $image5 = '';
    }

    $sql_update_food = "UPDATE food SET food_name='$food_name', food_for_pet='$food_for_pet', food_unit='$food_unit', food_price='$food_price', food_stock='$food_stock', food_description='$food_desc', image1='$image', image2='$image2', image3='$image3', image4='$image4', image5='$image5' WHERE id='$food_id'";
    if (mysqli_query($conn, $sql_update_food)) {
        header("Location: seller_panelf.php");
        exit(); // Ensure that no further code execution happens after the redirection
    } else {
        echo "Error updating food details: " . mysqli_error($conn);
    }
}

// Retrieve the food details based on the provided ID
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];

    // Fetch the food details from the database
    $sql_fetch_food = "SELECT * FROM food WHERE id='$food_id'";
    $result_fetch_food = mysqli_query($conn, $sql_fetch_food);
    $food = mysqli_fetch_assoc($result_fetch_food);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Food Details</title>
    <link rel="stylesheet" href="css/update_food.css">
</head>
<body>
    <form method="POST" action="#" enctype="multipart/form-data">
        <h2>Update Food Details</h2>
        <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
        <label for="food_name">Food Name:</label><br>
        <input type="text" id="food_name" name="food_name" value="<?php echo $food['food_name']; ?>"><br>
        <label for="food_for_pet">Food For pet</label><br>
        <select class="" name="food_for_pet" id="ffpt">
        <option value="Dog" <?php if ($food['food_for_pet'] === 'Dog') echo 'selected'; ?>>DOG</option>
        <option value="Cat" <?php if ($food['food_for_pet'] === 'Cat') echo 'selected'; ?>>Cat</option>
        <option value="Dog&Cat" <?php if ($food['food_for_pet'] === 'Dog&Cat') echo 'selected'; ?>>DOG & Cat</option>
        <option value="Rabit" <?php if ($food['food_for_pet'] === 'Rabit') echo 'selected'; ?>>Rabit</option>
        <option value="Bird" <?php if ($food['food_for_pet'] === 'Bird') echo 'selected'; ?>>Bird</option>
        <option value="Fish" <?php if ($food['food_for_pet'] === 'Fish') echo 'selected'; ?>>Fish</option>
        </select><br>
        <label for="food_name">Food Unit:</label><br>
        <input type="text" id="fo_unit" name="food_unit" value="<?php echo $food['food_unit']; ?>"><br>
        <label for="price">Price:</label><br>
        <input type="text" id="fo_price" name="food_price" value="<?php echo $food['food_price']; ?>"><br>
        <label for="food_stock">Food Stock:</label><br>
        <input type="number" id="fo_stock" name="food_stock" value="<?php echo $food['food_stock']; ?>"><br>
        <label for="food_description">Food Description:</label><br>
        <input type="text" id="fo_desc" name="food_desc" value="<?php echo $food['food_description']; ?>"><br><br>
        
        
        <?php if (!empty($food['image1'])): ?>
            <img src="upload/<?php echo $food['image1']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image" value="<?php echo $food['image1']; ?>">
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

        <?php if (!empty($food['image2'])): ?>
            <img src="upload/<?php echo $food['image2']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $food['image2']; ?>">
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

        <?php if (!empty($food['image3'])): ?>
            <img src="upload/<?php echo $food['image3']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image3" value="<?php echo $food['image3']; ?>">
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

        <?php if (!empty($food['image4'])): ?>
            <img src="upload/<?php echo $food['image4']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $food['image4']; ?>">
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

        <?php if (!empty($food['image5'])): ?>
            <img src="upload/<?php echo $food['image5']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image5" value="<?php echo $food['image5']; ?>">
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
        
        <br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>

<?php
}
?>
