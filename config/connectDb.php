<?php
$envFile = fopen("../.env", "r");

if ($envFile) {
    while (($line = fgets($envFile)) !== false) {
        list($key, $value) = explode('=', $line);
        putenv(trim($key) . '=' . trim($value));
    }

    fclose($envFile);
} else {
    die(".env file not found.");
}


$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//  echo "Connected successfully"; 

// phpinfo();
?>