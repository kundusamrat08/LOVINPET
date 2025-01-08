<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

if (isset($_POST['remove_from_cart'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $cart_id = $_POST['cart_id'];

        // Retrieve user ID based on the session email
        $sql_user = "SELECT user_id FROM users WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
        $result_user = mysqli_query($conn, $sql_user);

        if ($result_user && mysqli_num_rows($result_user) == 1) {
            $row_user = mysqli_fetch_assoc($result_user);
            $user_id = $row_user['user_id'];

            // Check if the item exists in the user's cart
            $sql_check_cart_item = "SELECT * FROM cart WHERE user_id='$user_id' AND id='$cart_id'";
            $result_check_cart_item = mysqli_query($conn, $sql_check_cart_item);

            if ($result_check_cart_item && mysqli_num_rows($result_check_cart_item) == 1) {
                // Item exists, remove it from the cart
                $sql_remove_from_cart = "DELETE FROM cart WHERE user_id='$user_id' AND id='$cart_id'";
                if (mysqli_query($conn, $sql_remove_from_cart)) {
                    // echo "Item removed from cart successfully.";
                    header("Location: my_cart.php");

                } else {
                    echo "Error removing item from cart: " . mysqli_error($conn);
                }
            } else {
                echo "Item not found in your cart.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }
}

mysqli_close($conn);
?>
