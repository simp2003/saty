<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "databaseliyema";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully<br>";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted<br>"; // Debugging line

    // Get form data and sanitize it
    $name = $conn->real_escape_string(trim($_POST['name']));
    $surname = $conn->real_escape_string(trim($_POST['surname']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $cellphone = $conn->real_escape_string(trim($_POST['cellphone']));
    $service_type = $conn->real_escape_string(trim($_POST['ServiceType']));
    $nail_type = $conn->real_escape_string(trim($_POST['NailType']));
    $nail_shape = $conn->real_escape_string(trim($_POST['NailShape']));
    $nail_colour = $conn->real_escape_string(trim($_POST['NailColour']));
    $extras = $conn->real_escape_string(trim($_POST['Extras']));

    // Validate required fields
    if (empty($name) || empty($surname) || empty($email) || empty($cellphone)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='homepage.html';</script>";
        exit;
    }

    
    // Prepare SQL statement to insert data
    $sql = "INSERT INTO client_booking (name, surname, email, cellphone, service_type, nail_type, nail_shape, nail_colour, extras) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssss", $name, $surname, $email, $cellphone, $service_type, $nail_type, $nail_shape, $nail_colour, $extras);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Booking saved successfully!'); window.location.href='homepage.html';</script>";
    } else {
        echo "<script>alert('Execution error: " . $stmt->error . "'); window.location.href='homepage.html';</script>";
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . ' - Execution error: ' . $stmt->error . PHP_EOL, FILE_APPEND);
    }
// Debugging the data being inserted
echo "Name: $name, Surname: $surname, Email: $email, Cellphone: $cellphone, ServiceType: $service_type, NailType: $nail_type, NailShape: $nail_shape, NailColour: $nail_colour, Extras: $extras<br>";

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ddafd2;
            color: #070707;
            display: flex;
            flex-direction: column;
        }

        body {
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 60px; /* Adjust to account for footer */
            flex: 1;
            width: 100%;
        }

        .Booking-container {
            background-color: rgba(179, 0, 110, 0.8);
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            max-width: 100%;
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: auto;
        }

        .Booking-container label,
        .Booking-container input,
        .Booking-container select {
            grid-column: span 2;
        }

        .Booking-container input,
        .Booking-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            grid-column: span 2;
        }

        .Booking-container button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            background-color: #000000;
        }

        .Booking-container button:hover {
            background-color: rgba(179, 0, 110, 0.8);
        }

        .Booking-container a.cancel-button {
            width: 48%;
            padding: 10px;
            background-color: #ff4b5c;
            color: white;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .Booking-container a.cancel-button:hover {
            background-color: #d43f50;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        @media (max-width: 600px) {
            .Booking-container {
                width: 70%;
            }
        }
    </style>
</head>
<body>

    <!-- Main Content Section -->
    <div class="main-content">
        <div class="Booking-container">
            <h2>Book</h2>
            <form id="Bookingsform" action="" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" required>
                
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Surname" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email@example.com" required>

                <label for="cellphone">Cellphone</label>
                <input type="text" id="cellphone" name="cellphone" placeholder="+27 12 345 6789" required>

                <label for="ServiceType">Service Type</label>
                <select name="ServiceType" id="ServiceType" required>
                    <option value="" disabled selected>Select Service</option>
                    <option value="Pedicure">Pedicure</option>
                    <option value="Manicure">Manicure</option>
                    <option value="Nail Removal">Nail Removal</option>
                </select>

                <label for="NailType">Nail Type</label>
                <select name="NailType" id="NailType" required>
                    <option value="" disabled selected>Select Nails</option>
                    <option value="Acrylic">Acrylic</option>
                    <option value="Gel">Gel</option>
                </select>

                <label for="NailShape">Nail Shape</label>
                <select name="NailShape" id="NailShape" required>
                    <option value="" disabled selected>Select Shape</option>
                    <option value="Oval">Oval</option>
                    <option value="Rounded">Rounded</option>
                    <option value="Almond">Almond</option>
                    <option value="Stiletto">Stiletto</option>
                    <option value="Ballerina">Ballerina</option>
                    <option value="Square">Square</option>
                </select>

                <label for="NailColour">Nail Colour</label>
                <select name="NailColour" id="NailColour" required>
                    <option value="" disabled selected>Select Colour</option>
                    <option value="White">White</option>
                    <option value="Black">Black</option>
                    <option value="Pink">Pink</option>
                    <option value="Brown">Brown</option>
                    <option value="Purple">Purple</option>
                    <option value="Blue">Blue</option>
                    <option value="Orange">Orange</option>
                </select>

                <label for="Extras">Extras</label>
                <select name="Extras" id="Extras">
                    <option value="" disabled selected>Select Extras</option>
                    <option value="Diamond">Diamond</option>
                    <option value="Glitter">Glitter</option>
                    <option value="Shimmer Powder">Shimmer Powder</option>
                    <option value="Curls">Curls</option>
                    <option value="Nail Stickers">Nail Stickers</option>
                    <option value="Nail Stencils">Nail Stencils</option>
                </select>

                <div class="button-container">
                    <button type="submit">Book</button>
                    <a href="homepage.html" class="cancel-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 SATY Information. All rights reserved.</p>
    </footer>

</body>
</html>
