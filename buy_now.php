<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Retrieve user ID based on the session email
    $sql_user = "SELECT user_id FROM users WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
    $result_user = mysqli_query($conn, $sql_user);

    if ($result_user && mysqli_num_rows($result_user) == 1) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['user_id'];

        // Retrieve products from cart for the user
        $sql_cart = "SELECT * FROM cart WHERE user_id='$user_id' AND buy_now='bn'";
        $result_cart = mysqli_query($conn, $sql_cart);

        if ($result_cart && mysqli_num_rows($result_cart) > 0) {
            if (isset($_POST['place_order'])) {
                // Initialize an array to store the product IDs and quantities
                $order_data = [];

                foreach ($_POST['quantity'] as $product_id => $quantity) {
                    // Ensure the quantity is a positive integer
                    $quantity = (int)$quantity;
                    if ($quantity <= 0) {
                        continue; // Skip invalid quantities
                    }

                    // Validate product ID
                    $product_id = (int)$product_id;
                    if ($product_id <= 0) {
                        continue; // Skip invalid product IDs
                    }

                    // Add product ID and quantity to the order data array
                    $order_data[$product_id] = $quantity;
                }

                if (empty($order_data)) {
                    // No valid quantities provided, redirect with error message
                    header("Location: my_cart.php?error=invalid_quantity");
                    exit();
                }

                // Check if payment option is selected
                if (!isset($_POST['payment_option'])) {
                    // Payment option not selected, redirect with error message
                    header("Location: my_cart.php?error=no_payment_option");
                    exit();
                }

                // Get payment option
                $payment_option = $_POST['payment_option'];

                // Address fields
                $phone = "";
                $address = "";
                $city = "";
                $state = "";
                $postal_code = "";

                // Initialize payment status
                $payment_status = "Not Paid"; // Default to non Paid

                if ($payment_option === "cash_on_delivery") {
                    // For cash on delivery, payment status remains non Paid
                } elseif ($payment_option === "online_payment") {
                    // For online payment, set payment status to paid
                    $payment_status = "Paid";
                }

                // Validate and sanitize address fields if required
                if ($payment_option === "cash_on_delivery" || $payment_option === "online_payment") {
                    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : "";
                    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : "";
                    $city = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : "";
                    $state = isset($_POST['state']) ? mysqli_real_escape_string($conn, $_POST['state']) : "";
                    $postal_code = isset($_POST['postal_code']) ? mysqli_real_escape_string($conn, $_POST['postal_code']) : "";
                }

                // Process the order data and update product stock
                foreach ($order_data as $product_id => $quantity) {
                    // Fetch product details from cart
                    $sql_product_details = "SELECT * FROM cart WHERE user_id='$user_id' AND id='$product_id'";
                    $result_product_details = mysqli_query($conn, $sql_product_details);

                    if ($result_product_details && mysqli_num_rows($result_product_details) == 1) {
                        $row_product = mysqli_fetch_assoc($result_product_details);

                        $produ_id = $row_product['product_id'];
                        $product_category = $row_product['product_category'];
                        $product_name = $row_product['product_name'];
                        $image = $row_product['image'];
                        $pricePerItem = $row_product['price'];
                        $user_type = $row_product['User_Type']; // Fetch user type from cart
                        $user_name = $row_product['user_name']; 
                        $user_email = $row_product['email']; 

                        // Calculate total price
                        $totalPrice = $quantity * $pricePerItem;

                        // Retrieve card details
                        $card_number = isset($_POST['card_number']) ? mysqli_real_escape_string($conn, $_POST['card_number']) : "";
                        $expiry_date = isset($_POST['expiry_date']) ? mysqli_real_escape_string($conn, $_POST['expiry_date']) : "";
                        $cvv = isset($_POST['cvv']) ? mysqli_real_escape_string($conn, $_POST['cvv']) : "";

                        // Update product stock
                        // $sql_update_stock = "UPDATE accessories SET stock = stock - $quantity WHERE id = $product_id";
                        // mysqli_query($conn, $sql_update_stock);

                        // Insert product into orders table with payment status, address, and other details
                        $sql_insert_order = "INSERT INTO orders (user_id, product_id, product_category, product_name, image, payment_status, price, quantity, address, city, state, postal_code, card_number, expiry_date, cvv,User_Type,user_name, email, phone,status) 
                            VALUES ('$user_id', '$produ_id','$product_category','$product_name', '$image', '$payment_status', '$totalPrice', '$quantity', '$address', '$city', '$state', '$postal_code', '$card_number', '$expiry_date', '$cvv','$user_type',' $user_name', '$user_email', '$phone','Not-Approve')";
                        mysqli_query($conn, $sql_insert_order);

                        // Remove product from cart
                        $sql_remove_from_cart = "DELETE FROM cart WHERE user_id='$user_id' AND id='$product_id'";
                        mysqli_query($conn, $sql_remove_from_cart);
                    }
                }

                // Redirect after placing order
                header("Location: order_track.php");
                exit();
            }

            // Delete product from cart if delete button is clicked
            if (isset($_POST['delete_product'])) {
                $delete_product_id = $_POST['delete_product_id'];

                // Delete product from cart
                $sql_delete_from_cart = "DELETE FROM cart WHERE user_id='$user_id' AND id='$delete_product_id'";
                mysqli_query($conn, $sql_delete_from_cart);

                // Redirect to refresh the cart display
                header("Location: accessories_product_display.php");
                exit();
            }
            ?>

            <!-- HTML for cart display and order placement -->
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Buy Now</title>
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="temp/nav.css">
                <style>
                    /* Additional Styles */
                    #online_payment_form {
                        margin-top: 20px;
                    }
                    .container{
                        margin-bottom: 55px;
                    }
                    table th{
                        text-align: center;
                    }
                    .cc{    
                        text-align: center;
                    }

                    #dateSelectors {
                        display: none;
                    }
                </style>
            </head>
            <body>
               <?php
                include('temp/bn_nav.php');
               ?>

        
                <div class="container">
                    <h2 class="mt-5 mb-4">Buy Now</h2>
                    <?php if (isset($_GET['error']) && $_GET['error'] === "insufficient_stock"): ?>
                        <div class="alert alert-danger" role="alert">
                            Insufficient stock to fulfill the order.
                        </div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Product Type</th>
                                        <th>Product Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row_cart = mysqli_fetch_assoc($result_cart)) : ?>
                                        <tr>
                                            <td class="cc"><?php echo $row_cart['product_name']; ?></td>
                                            <td class="cc"><img src="upload/<?php echo $row_cart['image']; ?>" alt="Product Image" class="img-thumbnail" width="100" height="100"></td>
                                            <td class="cc"><?php echo $row_cart['acc_type']; ?></td>
                                            <td class="price-per-item cc">₹<?php echo $row_cart['price']; ?></td>
                                            <td class="cc">
                                                <input type="number" name="quantity[<?php echo $row_cart['id']; ?>]" class="quantity" min="1" max="10" value="1" onchange="updatePrice(this)">
                                            </td>
                                            <td class="total-price cc">₹<?php echo $row_cart['price']; ?></td>
                                            <td class="cc">
                                                <form method="post" action="">
                                                    <input type="hidden" name="delete_product_id" value="<?php echo $row_cart['id']; ?>">
                                                    <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Payment options and address fields -->
                        <div class="form-group">
                            <label><input type="radio" name="payment_option" value="cash_on_delivery" checked>Cash on Delivery</label>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="payment_option" value="online_payment">Online Payment</label>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                 <label for="phone">Phone Number:</label>
                                 <input type="number" id="phone" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="state">State:</label>
                                <input type="text" id="state" name="state" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                 <label for="city">City:</label>
                                 <input type="text" id="city" name="city" class="form-control">
                                </div>
                            </div>        
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="postal_code">Postal Code:</label>
                                    <input type="text" id="postal_code" name="postal_code" class="form-control">
                                    </div>
                                </div>        
                        </div>

                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" id="address" name="address" class="form-control">
                                    </div>
                                </div>
                        </div>

<!-- Online payment fields in grid view -->
                    <div id="online_payment_form" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_number">Card Number:</label>
                                 <input type="text" id="card_number" name="card_number" class="form-control">
                                </div>
                            </div>
                         <div class="col-md-3">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date:</label>
                                 <!-- <input type="text" id="expiry_date" name="expiry_date" class="form-control"> -->
                                 <input type="text" name="expiry_date" id="expiry_date" class="form-control" placeholder="MM/YY" readonly onclick="showDateSelectors()">
                                </div>
                                <div id="dateSelectors">
        <label for="month">Month:</label>
        <select id="month" class="form-control">
            <option value="" disabled selected>Select month</option>
            <option value="01">January (01)</option>
            <option value="02">February (02)</option>
            <option value="03">March (03)</option>
            <option value="04">April (04)</option>
            <option value="05">May (05)</option>
            <option value="06">June (06)</option>
            <option value="07">July (07)</option>
            <option value="08">August (08)</option>
            <option value="09">September (09)</option>
            <option value="10">October (10)</option>
            <option value="11">November (11)</option>
            <option value="12">December (12)</option>
        </select>
        <br>    
        <label for="year">Year:</label>
        <select id="year" class="form-control">
            <option value="" disabled selected>Select year</option>
            <!-- Years from 2024 to current year -->
            <script>
                const currentYear = new Date().getFullYear();
                for (let i = currentYear; i <= currentYear+6; i++) {
                    document.write('<option value="' + i.toString().slice(-2) + '">' + i + '</option>');
                }
            </script>
        </select>
    </div>                
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="cvv">CVV:</label>
                                 <input type="password" id="cvv" name="cvv" class="form-control">
                                </div>
                         </div>
                            </div>
                            </div>


                        <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
                <!-- Bootstrap JS -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <script>
                    $(document).ready(function () {
                        // Update total price when quantity changes
                        $('.quantity').change(function () {
                            const quantity = parseInt($(this).val());
                            const pricePerItem = parseFloat($(this).closest('tr').find('.price-per-item').text().substring(1));
                            const totalPriceElement = $(this).closest('tr').find('.total-price');
                            const totalPrice = (quantity * pricePerItem).toFixed(2); // Ensure two decimal places
                            if (!isNaN(totalPrice)) {
                                totalPriceElement.text("₹" + totalPrice);
                            } else {
                                totalPriceElement.text("Invalid Price");
                            }
                        });

                        // Show/hide online payment fields based on selected option
                        $('input[name="payment_option"]').change(function () {
                            if ($(this).val() == "online_payment") {
                                $('#online_payment_form').show();
                            } else {
                                $('#online_payment_form').hide();
                            }
                        });
                    });

                    

                    document.getElementById('phone').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 10) {
                event.target.value = value.slice(0, 10);
            }
        });

        document.getElementById('postal_code').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 6) {
                event.target.value = value.slice(0, 6);
            }
        });

        document.getElementById('card_number').addEventListener('input', function(event) {
            const input = event.target;
            let value = input.value.replace(/\D/g, ''); // Remove all non-digit characters

            // Limit to 12 digits
            if (value.length > 16) {
                value = value.slice(0, 16);
            }

            // Add spaces after every 4 digits
            const formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';

            input.value = formattedValue;
        });



        function showDateSelectors() {
        document.getElementById('dateSelectors').style.display = 'block';
    }

    document.getElementById('month').addEventListener('change', updateExpiryDate);
    document.getElementById('year').addEventListener('change', updateExpiryDate);

    function updateExpiryDate() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        if (month && year) {
            document.getElementById('expiry_date').value = month + '/' + year;
            document.getElementById('dateSelectors').style.display = 'none'; // Hide selectors after selection
        }
    }


        document.getElementById('cvv').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 3) {
                event.target.value = value.slice(0, 3);
            }
        });

            

</script>
<?php
include('temp/footer.php');
?>
            </body>
            </html>

            <?php
        } else {
            // Cart is empty, redirect to product display page
            header("Location: accessories_product_display.php");
            exit();
        }
    } else {
        // User not found, display error message or redirect as needed
        echo "<p>User not found.</p>";
    }
} else {
    // User not logged in, display error message or redirect as needed
    // echo "<p>User not logged in.</p>";
        // header("Location: login.php");
        include('temp/nav.php');
    // echo "<p><br><br><br><br><h1>Your Cart is Empty!</h1><br><a href='index.php'>Shop Now!</a><br><br><br><br><br><br></p>";

    echo "<div style='text-align: center;'><p><br><br><br><br><h1>Please Login to Buy This Product!</h1><br><a href='login.php'>Login Now!</a><br><br><br><br><br><br></p></div>";

    include('temp/footer.php');
}

mysqli_close($conn);
?>
