<?php
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO subscribers (email, ip_address, user_agent) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $email, $ip_address, $user_agent);


    if ($stmt->execute()) {
        echo "success";
    } else {
        if ($conn->errno === 1062) {
            echo "duplicate"; // Email already exists
        } else {
            echo "error";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error";
}
?>
