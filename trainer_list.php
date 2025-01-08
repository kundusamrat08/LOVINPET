<?php
session_start();

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "pet_adoption");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set
    if (isset($_POST['doctor_id']) && isset($_POST['patient_name']) && isset($_POST['patient_email']) && isset($_POST['patient_phone']) && isset($_POST['card_number']) && isset($_POST['expiry_date']) && isset($_POST['cvv'])) {
        // Sanitize form inputs to prevent SQL injection
        $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
        $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
        $patient_email = mysqli_real_escape_string($conn, $_POST['patient_email']);
        $patient_phone = mysqli_real_escape_string($conn, $_POST['patient_phone']);
        $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
        $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
        $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);

        // Fetch the doctor's fees from the database based on the selected doctor_id
        $query = "SELECT fees FROM trainer WHERE id = '$doctor_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $payment = $row['fees']; // Get doctor's fees from the database
            $status = 'Not Approve'; // Assuming the column name is 'status'
            $paid = 'Paid'; // Mark the appointment as paid

            // Insert appointment details into the database
            $query = "INSERT INTO trainer_booking (trainer_id, client_name, clinet_email, client_phone, payment_amount, status, paid, card_number, expiry_date, cvv) 
                      VALUES ('$doctor_id', '$patient_name', '$patient_email', '$patient_phone', '$payment', '$status', '$paid', '$card_number', '$expiry_date', '$cvv')";
            mysqli_query($conn, $query);

            // Fetch doctor information from the database based on doctor_id
            $doctorQuery = "SELECT * FROM trainer WHERE id = '$doctor_id'";
            $doctorResult = mysqli_query($conn, $doctorQuery);

            if ($doctorResult && mysqli_num_rows($doctorResult) > 0) {
                $doctorInfo = mysqli_fetch_assoc($doctorResult);
                $doctorName = $doctorInfo['Trainer_name'];
                $doctorEmail = $doctorInfo['Trainer_email'];
                $doctorNumber = $doctorInfo['Trainer_number'];
            } else {
                $doctorName = "N/A";
                $doctorEmail = "N/A";
                $doctorNumber = "N/A";
            }

            // Send email notification using PHPMailer
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Specify SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'lovinpet.service@gmail.com'; // SMTP username
            $mail->Password = 'fdxh xhjw hikr eznn'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

            $mail->setFrom('lovinpet.service@gmail.com', 'Lovinpet');
            $mail->addAddress($patient_email, $patient_name); // Add patient's email address as recipient
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Appointment Confirmation';
            // Email body with doctor information included
            $mail->Body = "Your Appointment has been successfully booked.<br><br>Trainer's Information:<br>Name: $doctorName<br>Email: $doctorEmail<br>Phone: $doctorNumber<br><br>Trainer Will Contact You Soon.";


            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                // echo 'Message has been sent';
            }

            // Redirect to a thank you page or display a success message
            // header("Location: trainer_list.php");
            include('temp/nav.php');
            echo "<div style='text-align: center;'><p><br><br><br><br><h1>Trainer's Appointment Booked Sucessfully,</h1><br>Check Your Mail!<br><a href='index.php'>Shop More!</a><br><br><br><br><br><br></p></div>";
            include('temp/footer.php');
            exit();
        } else {
            echo "Error: Unable to fetch doctor's fees.";
        }
    } else {
        echo "Error: Missing form data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reset default browser styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f7f7f7;
            color: #333; /* Dark gray color */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;

            padding: 20px;
            overflow-x: hidden;
        }

        .doctor-card {
            background-color: #fff;
            border: 1px solid;
            border-radius: 24px;
            box-shadow: 0 4px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            max-height: 200px;
            padding: 20px;
            position: relative;
            /* display:flex; */
            gap:25px;
            background-image: url(https://d1oco4z2z1fhwp.cloudfront.net/templates/default/6791/bg_pet.png);
        }

        .doctor-card h3 {

            margin-bottom: 10px;
            color: #c50035;
            font-weight: bold;
        }

        .doctor-card p {
            margin-bottom: 10px;
        }

        .book-appointment-btn {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background-color: #c50035; /* Green color */
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            border-radius: 69px;
        }

        .book-appointment-btn:hover {
            background-color: #45a049; /* Darker green color */
        }

        #bookingForm {
            display: none;
            margin-top: 20px;
            margin-bottom: 55px;
            position: relative;
            background-color: #f7f7f7; /* Light gray background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-left: 114px;
            width: 85%;
        }

        #bookingForm h3 {
            margin-bottom: 20px;
            text-align: center;
            color: #4CAF50; /* Green color */
        }

        #closeFormBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #6c757d; /* Dark gray color */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        #closeFormBtn:hover {
            background-color: #5a6268; /* Darker gray color */
        }

        #appointmentForm label {
            display: block;
            margin-bottom: 8px;
            color: #333; /* Dark gray color */
        }

        #appointmentForm input[type="text"],
        #appointmentForm input[type="email"],
        #appointmentForm input[type="number"],
        #appointmentForm input[type="password"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #appointmentForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        #appointmentForm input[type="submit"]:hover {
            background-color: #45a049; /* Darker green color */
        }
        .doctor-info{
            position: relative;
    top: -130px;
    left: 202px;
        }

        #dateSelectors {
            display: none;
        }
    </style>
</head>
<body>
<?php
include('temp/nav.php');
?>
<div class="container">
    <h2>Trainers & Groomers</h2>
    <?php
    $sql = "SELECT * FROM trainer where status = 'Approved'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="doctor-card">
            <img width="150" height="150" src="upload/<?php echo $row['photo']; ?>" alt="Logo" style="border: 1px solid #c50035; border-radius:10px;">
            <div class="doctor-info">
                
                <h3><?php echo $row['Trainer_name']; ?></h3>
                <p><b>Location: </b><span class="city"><?php echo $row['city']; ?></span></p>
                <p><b>Fees: </b>₹<span class="fees"><?php echo $row['fees']; ?></span></p>
            </div>
                <button class="book-appointment-btn" data-doctor-id="<?php echo $row['id']; ?>">Hire Now!</button>
            </div>
            <?php
        }
    } else {
        echo "0 results";
    }
    ?>
</div>

<div id="bookingForm">
    <h3>Hire Trainer!</h3>
    <button id="closeFormBtn" class="btn btn-secondary">Close</button> <!-- Form closing button -->
    <form method="post" id="appointmentForm" autocomplete="off">
        <input type="hidden" name="doctor_id" id="doctor_id">
        <label for="patient_name">Your Name:</label>
        <input type="text" name="patient_name" id="patient_name" required><br>
        <label for="patient_email">Your Email:</label>
        <input type="email" name="patient_email" id="patient_email" required><br>
        <label for="patient_phone">Your Phone:</label>
        <input type="number" name="patient_phone" id="patient_phone" required><br>
        <label for="card_number">Card Number:</label>

        <input type="text" name="card_number" id="card_number" required><br>

        <!-- <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY" required><br> -->

        <label for="expiry_date">Expiry Date (MM/YY):</label>
        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY" readonly required onclick="showDateSelectors()">

    <div id="dateSelectors">
        <label for="month">Month:</label>
        <select id="month" required>
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

        <label for="year">Year:</label>
        <select id="year" required>
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

        <label for="cvv">CVV:</label>
        <input type="password" name="cvv" id="cvv" required><br>
        <!-- Hidden input field for doctor fees -->
        <input type="hidden" name="payment" id="payment">
        <!-- Display doctor fees -->
        <label for="display_payment">Fees:</label>
        <input type="text" id="display_payment" readonly><br>
        <!-- Display payment status -->
        <input type="hidden" id="display_payment_status" value="Not Paid" readonly><br>
        <input type="submit" value="Pay Now" class="btn btn-primary">
    </form>
</div>
<!-- Bootstrap JS (Optional, only if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var bookAppointmentBtns = document.querySelectorAll('.book-appointment-btn');
        var bookingForm = document.getElementById('bookingForm');
        var doctorIdInput = document.getElementById('doctor_id');
        var displayPaymentInput = document.getElementById('display_payment');
        var displayPaymentStatusInput = document.getElementById('display_payment_status');
        var appointmentForm = document.getElementById('appointmentForm');
        var closeFormBtn = document.getElementById('closeFormBtn'); // Get the close button element

        // Show booking form and set doctor_id when "Book Appointment" button is clicked
        bookAppointmentBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var doctorId = this.getAttribute('data-doctor-id');
                doctorIdInput.value = doctorId;
                bookingForm.style.display = 'block';
                // Set doctor's fees in the payment input field
                displayPaymentInput.value = this.parentElement.querySelector('.fees').textContent;
            });
        });

        // Close the booking form when the close button is clicked
        closeFormBtn.addEventListener('click', function () {
            bookingForm.style.display = 'none';
        });

        // Form submission handling
        appointmentForm.addEventListener('submit', function (event) {
            event.preventDefault();
            // Update payment status to 'Paid'
            displayPaymentStatusInput.value = 'Paid';
            // You can add validation if needed before submitting the form
            this.submit();
        });
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
    

        document.getElementById('cvv').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 1+2 digits
            if (value.length > 3) {
                event.target.value = value.slice(0, 3);
            }
        });
        document.getElementById('patient_phone').addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-numeric characters
            event.target.value = value.replace(/\D/g, '');
            // Enforce a maximum length of 10 digits
            if (value.length > 3) {
                event.target.value = value.slice(0, 10);
            }
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
</script>

<?php
include('temp/footer.php');
?>
</body>
</html>
