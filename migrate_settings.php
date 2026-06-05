<?php
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Check if columns exist
    $stmt = $db->query("SHOW COLUMNS FROM setting_koperasi LIKE 'bunga_jangka_pendek'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE setting_koperasi ADD COLUMN bunga_jangka_pendek DECIMAL(5,2) DEFAULT 1.00");
        echo "Added column: bunga_jangka_pendek\n";
    } else {
        echo "Column bunga_jangka_pendek already exists\n";
    }

    $stmt2 = $db->query("SHOW COLUMNS FROM setting_koperasi LIKE 'bunga_jangka_panjang'");
    if ($stmt2->rowCount() == 0) {
        $db->exec("ALTER TABLE setting_koperasi ADD COLUMN bunga_jangka_panjang DECIMAL(5,2) DEFAULT 0.60");
        echo "Added column: bunga_jangka_panjang\n";
    } else {
        echo "Column bunga_jangka_panjang already exists\n";
    }
    
    // Update the existing row if it's 0 or null
    $db->exec("UPDATE setting_koperasi SET bunga_jangka_pendek = 1.00 WHERE bunga_jangka_pendek IS NULL OR bunga_jangka_pendek = 0");
    $db->exec("UPDATE setting_koperasi SET bunga_jangka_panjang = 0.60 WHERE bunga_jangka_panjang IS NULL OR bunga_jangka_panjang = 0");
    
    echo "Database settings updated successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
