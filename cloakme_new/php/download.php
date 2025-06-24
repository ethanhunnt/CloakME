<?php
include("crypto_config.php");

$filename = $_GET['file'] ?? '';
$filepath = "../vault/" . basename($filename);

if (!empty($filename) && file_exists($filepath)) {
    $encrypted_data = file_get_contents($filepath);
    $decrypted_data = openssl_decrypt($encrypted_data, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, ENCRYPTION_IV);

    if ($decrypted_data === false) {
        echo "❌ Failed to decrypt file.";
        exit;
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=\"" . basename($filepath) . "\"");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($decrypted_data));
    echo $decrypted_data;
    exit;
} else {
    echo "File not found or filename missing.";
}
?>
