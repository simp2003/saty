<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email, date, and time from the form
    $recipientEmail = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $datetime = $_POST['datetime'];

    // Validate email
    if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else {
        // Create the message
        $message = "Thanks for booking with SATY! Make sure you keep the time provided above: " . date("F j, Y, g:i a", strtotime($datetime));
        $subject = "Booking Confirmation - SATY Nails";
        
        // Set headers
        $headers = "From: zondinick2@gmail.com\r\n"; // Sender email
        $headers .= "Reply-To: zondinick2@gmail.com\r\n"; // Sender email

        // Send the email
        if (mail($recipientEmail, $subject, $message, $headers)) {
            // If email sent successfully, show popup and redirect
            echo "<script>
                    alert('Email sent successfully!');
                    window.location.href = 'home2.html';
                  </script>";
        } else {
            // If email fails to send, show an alert
            echo "<script>alert(' confirmation email sent.');
            window.location.href = 'home2.html'; // Redirect to admin page</script>";
        }
        exit; // Stop script execution after redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Response</title>
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
        .response-container {
            background-color: rgba(179, 0, 110, 0.8);
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            margin-top: 70px;
        }
        .response-container h2 {
            margin-top: 0;
            font-size: 24px;
        }
        .response-container label {
            display: block;
            margin-bottom: 18px;
        }
        .response-container input, .response-container button {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .response-container button {
            background-color: #000000;
            color: #fff;
            cursor: pointer;
        }
        .response-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    
    <div class="response-container">
        <h2>Booking Confirmation</h2>
        <form id="bookingForm" method="POST" action="">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>

            <label for="datetime">Select Date and Time</label>
            <input type="datetime-local" id="datetime" name="datetime" required>

            <button type="submit">Send Confirmation</button>
        </form>
    </div>

</body>
</html>
