<?php
// Assuming you have established the database connection and sanitized the input parameters
include_once 'db.php';

// Check if ID parameter is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $pet_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete query
    $sql_delete_pet = "DELETE FROM pets WHERE id = $pet_id";

    // Execute the delete query
    if(mysqli_query($conn, $sql_delete_pet)) {
        // Redirect back to the page where the pets are listed
        header("Location: seller_panelf.php");
        exit();
    } else {
        echo "Error deleting pet: " . mysqli_error($conn);
    }
} else {
    echo "Pet ID not provided.";
}
?>
