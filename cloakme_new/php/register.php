<?php
require_once 'db.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$plain_password = isset($_POST['password']) ? $_POST['password'] : null;

if (!$email || !$plain_password) {
    die("Error: Email or password missing.");
}

$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$stmt = $conn->prepare("INSERT INTO users (email, password, role, ip_address, user_agent) VALUES (?, ?, 'user', ?, ?)");
$stmt->bind_param("ssss", $email, $hashed_password, $ip_address, $user_agent);

if ($stmt->execute()) {
    echo "Registration successful. <a href='../login/login.html'>Login</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
