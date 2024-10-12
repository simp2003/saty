<?php
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
}

// Fetch data from the client_bookings table
$sql = "SELECT * FROM client_booking";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4b6d0;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f4b6d0;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px; /* Add margin for spacing */
        }

        .back-button:hover {
            background-color: #b3006e;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Client Booking List</h1>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Cellphone</th>
                <th>Service Type</th>
                <th>Nail Type</th>
                <th>Nail Shape</th>
                <th>Nail Colour</th>
                <th>Extras</th>
              </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['surname']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['cellphone']) . "</td>
                    <td>" . htmlspecialchars($row['service_type']) . "</td>
                    <td>" . htmlspecialchars($row['nail_type']) . "</td>
                    <td>" . htmlspecialchars($row['nail_shape']) . "</td>
                    <td>" . htmlspecialchars($row['nail_colour']) . "</td>
                    <td>" . htmlspecialchars($row['extras']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No bookings found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <a href="homepage.html" class="back-button">Back to Homepage</a>
</div>

</body>
</html>
