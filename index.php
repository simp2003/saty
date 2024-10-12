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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Special case for admin with specific password
    if ($username === 'admin' && $password === 'Admin@1') {
        echo "<script>
                alert('Admin login successful! Redirecting to admin dashboard...');
                window.location.href = 'home2.html'; // Redirect to admin page
              </script>";
    } else {
        // Query to check if username exists in the database
        $sql = "SELECT * FROM persons WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Check if the provided password matches the one in the database
            if ($password == $row['password']) {
                echo "<script>
                        alert('Login successful! Redirecting...');
                        window.location.href = 'homepage.html'; // Redirect to home page
                      </script>";
            } else {
                echo "<script>
                        alert('Invalid password!');
                        window.location.href = 'index.php'; // Redirect back to login
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Invalid username!');
                    window.location.href = 'index.php'; // Redirect back to login
                  </script>";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('IMG-20240911-WA0008.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #f2f2f2;
        }
        header {
            width: 100%;
            background-color: rgba(179, 0, 110, 0.8);
            color: #000;
            text-align: left;
            padding: 15px 0;
            position: absolute;
            top: 0;
            left: 0;
            border-bottom: 2px solid #fff;
        }
        .register-container {
            background-color: rgba(179, 0, 110, 0.8);
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            margin-top: 70px;
        }
        .register-container h2 {
            margin-top: 0;
            font-size: 24px;
        }
        .register-container label {
            display: block;
            margin-bottom: 18px;
        }
        .register-container input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .register-container button, .register-container .login-button, .register-button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-right: 4%;
        }
        .register-container button {
            background-color: #000000;
        }
        .register-container button:hover {
            background-color: #218838;
        }
        .register-container .login-button {
            background-color: #000000;
            text-align: center;
            text-decoration: none;
        }
        .register-container .register-button {
            background-color: #000000;
            text-align: center;
            text-decoration: none;
        }
        .register-container .login-button:hover {
            background-color: #db3ac6;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    
    <header>
        <h1>SATY Nails</h1>
    </header>

    <div class="register-container">
        <h2>Login</h2>
        <form id="loginForm" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="***************" required>

            <div class="button-group">
                <button type="submit" class="login-button">Login</button>
                <a href="register.php" class="register-button">Register</a>
            </div>
        </form>
    </div>

</body>
</html>
