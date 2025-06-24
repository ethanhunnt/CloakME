<?php
$filename = $_GET['file'] ?? '';
$filepath = "../vault/" . basename($filename);

if (!empty($filename) && file_exists($filepath)) {
    if (unlink($filepath)) {
        echo "✅ File deleted: " . htmlspecialchars($filename);
    } else {
        echo "❌ Failed to delete file.";
    }
} else {
    echo "File not found.";
}
?>
