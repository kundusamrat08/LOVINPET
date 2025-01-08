<?php
// update_status.php

$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted to activate or deactivate
    if (isset($_POST['activate']) || isset($_POST['deactivate'])) {
        $pet_id = $_POST['pet_id'];
        $current_status = $_POST['current_status'];
        
        // Determine the new status based on the button clicked
        $new_status = ($current_status == 'Deactivate') ? 'Activate' : 'Deactivate';
        
        // Update the status in the database
        $sql_update_status = "UPDATE pets SET status='$new_status' WHERE id='$pet_id'";
        if (mysqli_query($conn, $sql_update_status)) {
            // Redirect to homepage after updating status
            header("Location: seller_panel.php");
            exit;
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    }
}
?>

