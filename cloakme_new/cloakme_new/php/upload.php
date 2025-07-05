<?php
include("crypto_config.php");

$target_dir = "../vault/";

if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        die("Failed to create vault directory.");
    }
}

if (isset($_FILES['vault_file'])) {
    $filename = basename($_FILES['vault_file']['name']);
    $target_file = $target_dir . $filename;

    $file_data = file_get_contents($_FILES['vault_file']['tmp_name']);
    $encrypted_data = openssl_encrypt($file_data, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, ENCRYPTION_IV);

    if (file_put_contents($target_file, $encrypted_data) !== false) {
        header("Location: ../dashboard/securevault.php?upload=success");
        exit;
    } else {
        echo "❌ Failed to write encrypted file.";
    }
} else {
    echo "⚠️ No file selected.";
}
?>
