<?php
// Database connection details
$servername = "localhost";
$username = "pham75_group-project-shopping-carts"; // Replace with a user that has admin privileges
$password = "kJ84nt8MrgJNhbHWgbXs"; // Replace with the correct password
$dbname = "pham75_group-project-shopping-carts";
$user_to_grant = "pham75_group-project-shopping-carts"; // The user you want to grant privileges to
$user_password = "kJ84nt8MrgJNhbHWgbXs"; // The password for the user

try {
    // Create connection
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
    $conn->exec($sql);
    echo "Database created successfully<br>";

    // SQL to grant privileges
    $sql = "GRANT ALL PRIVILEGES ON `$dbname`.* TO '$user_to_grant'@'localhost' IDENTIFIED BY '$user_password'";
    $conn->exec($sql);
    echo "Privileges granted successfully<br>";

    // Flush privileges to ensure they are applied
    $sql = "FLUSH PRIVILEGES";
    $conn->exec($sql);
    echo "Privileges flushed successfully<br>";

    // Connect to the newly created database to proceed with further operations
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $user_to_grant, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example: Creating a table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS `cart_items` (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_number INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL
    )";
    $conn->exec($sql);
    echo "Table cart_items created successfully<br>";

    // Example: Insert data into the table (this part of your existing code)
    if (isset($_POST['data'])) {
        // Get the JSON data
        $jsonData = $_POST['data'];

        // Decode the JSON data to a PHP array
        $carts = json_decode($jsonData, true);

        // Check if the JSON decoding was successful
        if ($carts !== null) {
            // Track order number
            $order_number = 0;

            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO `cart_items` (order_number, product_id, quantity) VALUES (:order_number, :product_id, :quantity)");

            // Process each cart item
            foreach ($carts as $cart) {
                $product_id = $cart['product_id'];
                $quantity = $cart['quantity'];
                $order_number++;

                // Bind parameters and execute the statement
                $stmt->bindParam(':order_number', $order_number);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->execute();

                echo "Order Number: " . $order_number . " - Product ID: " . $product_id . " Quantity: " . $quantity . "\n";
            }
        } else {
            echo "Failed to decode JSON";
        }
    } else {
        echo "No data received";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
