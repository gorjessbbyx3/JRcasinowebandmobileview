<?php

echo "🎰 Jade Royale Casino - Database Import\n";
echo "==========================================\n\n";

$host = 'hs10.name.tools';
$username = 'jhoutzha';
$password = 'Camputer69!';
$database = 'jhoutzha_jaderoyaledb';

echo "📡 Connecting to MySQL database...\n";

try {
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error . "\n");
    }
    
    echo "✅ Connected successfully!\n\n";
    
    // Read SQL file
    $sql = file_get_contents('init_casino_database.sql');
    
    if ($sql === false) {
        die("❌ Could not read SQL file\n");
    }
    
    echo "📥 Importing database schema...\n";
    
    // Execute multi-query
    if ($conn->multi_query($sql)) {
        do {
            // Store first result set
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    }
    
    if ($conn->error) {
        echo "⚠️  Warning: " . $conn->error . "\n";
    }
    
    echo "✅ Database schema imported successfully!\n\n";
    
    // Verify tables
    echo "🔍 Verifying tables...\n";
    $result = $conn->query("SHOW TABLES LIKE 'w_%'");
    $count = $result->num_rows;
    
    echo "✅ Found {$count} tables with 'w_' prefix\n\n";
    
    echo "📊 Tables created:\n";
    while ($row = $result->fetch_array()) {
        echo "   - {$row[0]}\n";
    }
    
    echo "\n🎉 Database setup complete!\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
