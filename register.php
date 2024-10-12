<?php
// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "databaseliyema";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $name = mysqli_real_escape_string($conn, $_POST['name']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $surname = mysqli_real_escape_string($conn, $_POST['surname']); 
    $cellphone = mysqli_real_escape_string($conn, $_POST['cellphone']); 
    // Not hashed

    // Query to insert the new user (with plain text password)
    $sql = "INSERT INTO persons (name, surname, email, cellphone, username, password) VALUES ('$name','$surname','$email','$cellphone','$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'index.php'; // Redirect to login page
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('IMG-20240911-WA0008.jpg');
            background-size: cover;
            background-position: center center;
            margin: 0;
            color: #000000;
        }

        .register-container {
            background-color: rgba(179, 0, 110, 0.8);
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1;
        }

        .register-container h2 {
            margin-top: 0;
            font-size: 24px;
        }

        .register-container label {
            display: block;
            margin-bottom: 10px;
        }

        .register-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .register-container button, .register-container a {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: #fcfcfc;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .register-container button {
            background-color: #000000;
        }

        .register-container button:hover {
            background-color: rgba(179, 0, 110, 0.8);
        }

        .register-container a.cancel-button {
            background-color: #000000;
            color: white;
        }

        .register-container a.cancel-button:hover {
            background-color: #d43f50;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 600px) {
            .register-container {
                width: 90%;
                top: 10px;
                left: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>
        <form id="registerForm" method="POST" action="" onsubmit="return validateForm(event);">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name" required>

            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" placeholder="Surname" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email@example.com" required>

            <label for="cellphone">Cellphone</label>
            <input type="text" id="cellphone" name="cellphone" placeholder="+27 12 345 6789" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="***************" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="***************" required>

            <div class="button-group">
                <button type="submit">Register</button>
                <a href="index.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent form submission

            const name = document.getElementById('name').value;
            const surname = document.getElementById('surname').value;
            const email = document.getElementById('email').value;
            const cellphone = document.getElementById('cellphone').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Validate email format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            // Validate cellphone format (either +27123456789 or 0769982929)
            const cellphonePattern = /^(?:\+27\s\d{2}\s\d{3}\s\d{4}|0\d{9})$/;
            if (!cellphonePattern.test(cellphone)) {
                alert('Please enter a valid cellphone number (e.g., +27123456789 or 0769982929).');
                return false;
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }

            // If all validations pass, submit the form
            alert('Registration successful! Redirecting to login page...');
            document.getElementById('registerForm').submit(); // Submit the form
        }
    </script>
</body>
</html>
