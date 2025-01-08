<?php
// Include your database connection file
include_once "db.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $medicine_id = $_POST['medicine_id'];
    $medicine_name = $_POST['medicine_name'];
    $medicine_for_pet = $_POST['medicine_for_pet']; // Assuming this column exists in your table
    $medicine_price = $_POST['medicine_price'];
    $medicine_stock = $_POST['medicine_stock'];
    $medicine_desc = $_POST['medi_desc'];
    $medicine_unit = $_POST['medicine_unit'];

    // Check if a new image is uploaded
    // if ($_FILES['image']['size'] > 0) {
    //     $image = $_FILES['image']['name'];
    //     $image_tmp = $_FILES['image']['tmp_name'];

    //     // Move uploaded file to a permanent location
    //     move_uploaded_file($image_tmp, "upload/$image");

    //     // Update the medicine image field in the database
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
    if (isset($_POST['remove_image']) && $_POST['remove_image'] == 'medicine_image') {
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

    
    $sql_update_medicine = "UPDATE medicine SET medicine_name='$medicine_name', medicine_pet='$medicine_for_pet', medicine_price='$medicine_price', medi_stock='$medicine_stock', medi_desc='$medicine_desc', image1='$image', image2='$image2', image3='$image3', image4='$image4', image5='$image5', medicine_unit='$medicine_unit' WHERE id='$medicine_id'";
    if (mysqli_query($conn, $sql_update_medicine)) {
        header("Location: seller_panelf.php");
        exit(); // Ensure that no further code execution happens after the redirection
    } else {
        echo "Error updating medicine details: " . mysqli_error($conn);
    }
}

// Retrieve the medicine details based on the provided ID
if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];

    // Fetch the medicine details from the database
    $sql_fetch_medicine = "SELECT * FROM medicine WHERE id='$medicine_id'";
    $result_fetch_medicine = mysqli_query($conn, $sql_fetch_medicine);
    $medicine = mysqli_fetch_assoc($result_fetch_medicine);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine Details</title>
    <link rel="stylesheet" href="css/update_medicine.css">
</head>
<body>
    <h2>Update Medicine Details</h2>
    <form method="POST" action="#" enctype="multipart/form-data">
        <input type="hidden" name="medicine_id" value="<?php echo $medicine['id']; ?>">
        <label for="medicine_name">Medicine Name:</label><br>
        <input type="text" id="medicine_name" name="medicine_name" value="<?php echo $medicine['medicine_name']; ?>"><br>
        <label for="medicine_for_pet">Medicine For Pet:</label><br>
        <input type="text" id="medicine_for_pet" name="medicine_for_pet" value="<?php echo $medicine['medicine_pet']; ?>"><br>
        <label for="medicine_price">Price:</label><br>
        <input type="text" id="medicine_price" name="medicine_price" value="<?php echo $medicine['medicine_price']; ?>"><br>
        <label for="medicine_stock">Medicine Stock</label><br>
        <input type="number" id="medicine_stock" name="medicine_stock" value="<?php echo $medicine['medi_stock']; ?>"><br>
        <label for="medicine_unit">Medicine Unit</label><br>
        <input type="text" id="medicine_unit" name="medicine_unit" value="<?php echo $medicine['medicine_unit']; ?>"><br>
        <label for="medicine_description">Medicine Description</label><br>
        <input type="text" id="medicine_desc" name="medi_desc" value="<?php echo $medicine['medi_desc']; ?>"><br><br>
        
        
        <?php if (!empty($medicine['image1'])): ?>
            <img src="upload/<?php echo $medicine['image1']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image" value="<?php echo $medicine['image1']; ?>">
            <label for="new_image">Choose New Image:</label><br>
            <input type="file" id="new_image" name="image"><br><br>
            <button type="submit" name="remove_image" value="image">Remove Image</button><br>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image">Choose Image:</label><br>
            <input type="file" id="new_image" name="image"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($medicine['image2'])): ?>
            <img src="upload/<?php echo $medicine['image2']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $medicine['image2']; ?>">
            <label for="new_image2">Choose New Image:</label><br>
            <input type="file" id="new_image2" name="image_2"><br><br>
            <button type="submit" name="remove_image" value="image2">Remove Image</button><br>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image2">Choose Image:</label><br>
            <input type="file" id="new_image2" name="image_2"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($medicine['image3'])): ?>
            <img src="upload/<?php echo $medicine['image3']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image3" value="<?php echo $medicine['image3']; ?>">
            <label for="new_image3">Choose New Image:</label><br>
            <input type="file" id="new_image3" name="image_3"><br><br>
            <button type="submit" name="remove_image" value="image3">Remove Image</button><br>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image3">Choose Image:</label><br>
            <input type="file" id="new_image3" name="image_3"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($medicine['image4'])): ?>
            <img src="upload/<?php echo $medicine['image4']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image2" value="<?php echo $medicine['image4']; ?>">
            <label for="new_image4">Choose New Image:</label><br>
            <input type="file" id="new_image4" name="image_4"><br><br>
            <button type="submit" name="remove_image" value="image4">Remove Image</button><br>
        <?php else: ?>
            <p>No image selected</p>
            <label for="new_image4">Choose Image:</label><br>
            <input type="file" id="new_image4" name="image_4"><br><br>
        <?php endif; ?>
        
        <br>

        <?php if (!empty($medicine['image5'])): ?>
            <img src="upload/<?php echo $medicine['image5']; ?>" alt="Image"><br>
            <input type="hidden" name="existing_image5" value="<?php echo $medicine['image5']; ?>">
            <label for="new_image5">Choose New Image:</label><br>
            <input type="file" id="new_image5" name="image_5"><br><br>
            <button type="submit" name="remove_image" value="image5">Remove Image</button><br>
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
