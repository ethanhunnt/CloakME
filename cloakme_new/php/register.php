<?php
require_once 'db.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo "Registration successful. <a href='../login/login.html'>Login</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
