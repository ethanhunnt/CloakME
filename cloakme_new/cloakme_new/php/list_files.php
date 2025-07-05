<?php
$vault_path = "../vault/";
$files = scandir($vault_path);

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "<div>";
        echo htmlspecialchars($file) . " ";
        echo "<a href='../php/download.php?file=" . urlencode($file) . "' target='_blank'>Download</a>";
        echo " | <a href='../php/delete.php?file=" . urlencode($file) . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
        echo "</div>";
    }
}
?>
