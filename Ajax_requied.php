<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "customer_Info";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO customers (full_name, email, phone, address, comment, product_name, company, color, size, variant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $fullName, $email, $phone, $address, $comment, $productName, $company, $color, $size, $variant);

// Set parameters and execute
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$comment = $_POST['comment'];
$productName = $_POST['productName'];
$company = $_POST['company'];
$color = $_POST['color'];
$size = $_POST['size'];
$variant = $_POST['variant'];

if ($stmt->execute()) {
    $order_id = $conn->insert_id;
    echo json_encode(['status' => 'success', 'order_id' => $order_id]);
} else {
    echo json_encode(['status' => 'error', 'message' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>