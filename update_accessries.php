<?php
// Include your database connection file
include_once "db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $accessories_id = $_POST['accessories_id'];
    $accessories_name = $_POST['accessories_name']; 
    $acc_category = $_POST['acc_category']; 
    $acc_type = $_POST['acc_type']; 
    $acc_stock = $_POST['acc_stock']; 
    $accessories_price = $_POST['accessories_price'];
    $about_accessories = $_POST['about_accessories'];
    
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
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'image') {
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

    // Update the accessories details in the database
    $sql_update_accessories = "UPDATE accessories SET name='$accessories_name', acc_category='$acc_category', acc_type='$acc_type', stock='$acc_stock', price='$accessories_price', about_accessories='$about_accessories', image1='$image', image2='$image2', image3='$image3', image4='$image4', image5='$image5' WHERE id='$accessories_id'";
    if (mysqli_query($conn, $sql_update_accessories)) {
        header("Location: seller_panelf.php");
        exit(); // Ensure that no further code execution happens after the redirection
    } else {
        echo "Error updating accessories details: " . mysqli_error($conn);
    }
}

// Retrieve the accessories details based on the provided ID
if (isset($_GET['id'])) {
    $accessories_id = $_GET['id'];

    // Fetch the accessories details from the database
    $sql_fetch_accessories = "SELECT * FROM accessories WHERE id='$accessories_id'";
    $result_fetch_accessories = mysqli_query($conn, $sql_fetch_accessories);
    $accessories = mysqli_fetch_assoc($result_fetch_accessories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Accessories Details</title>
    <link rel="stylesheet" href="css/update_accessries.css">
</head>
<body>
    <form method="POST" action="#" enctype="multipart/form-data">
    <h2>Update Accessories Details</h2>
        <input type="hidden" name="accessories_id" value="<?php echo $accessories['id']; ?>">

        <label for="accessories_name">Accessories Name:</label><br>
        <input type="text" id="acc_name" name="accessories_name" value="<?php echo $accessories['name']; ?>"><br>
        <label  for="accessories_category">Accessories Category</label><br>
        <select class="" name="acc_category" id="acc_cate">
        <option value="Dog" <?php if ($accessories['acc_category'] === 'Dog') echo 'selected'; ?>>DOG</option>
        <option value="Cat" <?php if ($accessories['acc_category'] === 'Cat') echo 'selected'; ?>>Cat</option>
        <option value="Dog&Cat" <?php if ($accessories['acc_category'] === 'Dog&Cat') echo 'selected'; ?>>DOG & Cat</option>
        <option value="Rabit" <?php if ($accessories['acc_category'] === 'Rabit') echo 'selected'; ?>>Rabit</option>
        <option value="Bird" <?php if ($accessories['acc_category'] === 'Bird') echo 'selected'; ?>>Bird</option>
        <option value="Fish" <?php if ($accessories['acc_category'] === 'Fish') echo 'selected'; ?>>Fish</option>
        </select><br>

        <label for="accessories_type">Accessories Type:</label><br>
        <select class="" name="acc_type" id="acc_cate">
        <option value="Collars" <?php if ($accessories['acc_type'] === 'Collars') echo 'selected'; ?>>Collars</option>
        <option value="Chain" <?php if ($accessories['acc_type'] === 'Chain') echo 'selected'; ?>>Chain</option>
        <option value="Muzzle" <?php if ($accessories['acc_type'] === 'Muzzle') echo 'selected'; ?>>Muzzle</option>
        <option value="Bed" <?php if ($accessories['acc_type'] === 'Bed') echo 'selected'; ?>>Bed</option>
        <option value="Cage" <?php if ($accessories['acc_type'] === 'Cage') echo 'selected'; ?>>Cage</option>
        <option value="Aquarium" <?php if ($accessories['acc_type'] === 'Aquarium') echo 'selected'; ?>>Aquarium</option>
        </select><br>
        <label for="accessories_stock">Accessories Stock:</label><br>
        <input type="number" id="access_stock" name="acc_stock" value="<?php echo $accessories['stock']; ?>"><br>
        <label for="accessories_price">Price:</label><br>
        <input type="text" id="accessories_price" name="accessories_price" value="<?php echo $accessories['price']; ?>"><br>
        <label for="accessories_about">About</label><br>
        <input type="text" id="about_acc" name="about_accessories" value="<?php echo $accessories['about_accessories']; ?>"><br><br>
        
        <?php if (!empty($accessories['image1'])): ?>
            <img src="upload/<?php echo $accessories['image1']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image" value="<?php echo $accessories['image1']; ?>">
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

        <?php if (!empty($accessories['image2'])): ?>
            <img src="upload/<?php echo $accessories['image2']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $accessories['image2']; ?>">
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

        <?php if (!empty($accessories['image3'])): ?>
            <img src="upload/<?php echo $accessories['image3']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image3" value="<?php echo $accessories['image3']; ?>">
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

        <?php if (!empty($accessories['image4'])): ?>
            <img src="upload/<?php echo $accessories['image4']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $accessories['image4']; ?>">
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

        <?php if (!empty($accessories['image5'])): ?>
            <img src="upload/<?php echo $accessories['image5']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image5" value="<?php echo $accessories['image5']; ?>">
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
