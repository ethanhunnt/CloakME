<?php
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

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
