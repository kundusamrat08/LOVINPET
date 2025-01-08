<?php
include('db.php');

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if order_id and order_status are set
    if (isset($_POST["order_id"]) && isset($_POST["order_status"])) {
        $order_id = $_POST["order_id"];
        $order_status = $_POST["order_status"];

        // Update order status in the database
        $sql = "UPDATE orders SET order_status = '$order_status' WHERE order_id = $order_id";
        if ($conn->query($sql) === TRUE) {
            echo "Order status updated successfully";
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    }
    // Check if the cancel button is clicked
    if(isset($_POST['cancel_order'])) {
        $cancel_order_id = $_POST['cancel_order'];
        $cancel_sql = "UPDATE orders SET order_status = 'Cancelled' WHERE order_id = $cancel_order_id";
        if ($conn->query($cancel_sql) === TRUE) {
            // echo "Order cancelled successfully";
        } else {
            echo "Error cancelling order: " . $conn->error;
        }
    }
}
// Fetch orders from the database
$sql = "SELECT * FROM `orders` where email = '$email' ORDER BY order_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table th{
            text-align: center;
        }
        .cc{
            text-align: center;
        }
    </style>
</head>
<body>
<?php
include('temp/nav.php');
?>
    <div class="container">
        <h2 class="mt-4">Your Orders</h2>
        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <!-- <th>Order Status</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='cc'>" . $row["order_id"] . "</td>";
                        echo "<td class='cc'>" . $row["product_name"] . "</td>";
                        echo "<td class='cc'>";
                        echo "<img height='100px' width='100px' class='imgs' src='upload/" . ($row['image'] ) . "' alt='Product Image'>";
                        echo "</td>";
                        echo "<td class='cc'>" . $row["order_date"] . "</td>";
                        echo "<td class='cc'>" . $row["quantity"] . "</td>";
                        echo "<td class='cc'>" . $row["price"] . "</td>";
                        echo "<td class='cc'>" . $row["payment_status"] . "</td>";
                        echo "<td class='cc'>" . $row["order_status"] . "</td>";
                        echo "<td class='cc'>";
                        // echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        // echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
                        // echo "<select class='form-control' name='order_status'>";
                        // echo "<option value='pending' " . ($row["order_status"] == "pending" ? "selected" : "") . ">Pending</option>";
                        // echo "<option value='packed' " . ($row["order_status"] == "packed" ? "selected" : "") . ">Packed</option>";
                        // echo "<option value='dispatched' " . ($row["order_status"] == "dispatched" ? "selected" : "") . ">Dispatched</option>";
                        // echo "<option value='out_for_delivery' " . ($row["order_status"] == "out_for_delivery" ? "selected" : "") . ">Out for Delivery</option>";
                        // echo "<option value='received' " . ($row["order_status"] == "received" ? "selected" : "") . ">Received</option>";
                        // echo "<option value='cancelled' " . ($row["order_status"] == "cancelled" ? "selected" : "") . ">Cancelled</option>";
                        // echo "</select>";
                        // echo "</td>";
                        // echo "<td>";
                        // echo "<input type='submit' class='btn btn-danger mt-2' value='Cancel'>";
                        // echo "</form>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='cancel_order' value='" . $row["order_id"] . "'>";
                        echo "<input type='submit' class='btn btn-danger mt-2' value='Cancel'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
include('temp/footer.php');
?>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

