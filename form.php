
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Collect form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$number = $_POST['number'];
$message = $_POST['message'];

// Create a new MySQLi connection
$conn = new mysqli('localhost', 'root', '', 'form');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, email, number, message) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("sssds", $firstName, $lastName, $email, $number, $message);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to the HTML form or another page with a success query parameter
    header("Location: index.html?status=success");
    echo "Registration successful";
    exit(); // Ensure no further code is executed after the redirect
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
