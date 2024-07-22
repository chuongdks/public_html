<?php
session_start(); // Start the session for the order_number

// Database connection details
$servername = "localhost";
$username = "pham75_group-project-shopping-carts"; // Replace with a user that has privileges
$password = "kJ84nt8MrgJNhbHWgbXs"; // Replace with the correct password
$dbname = "pham75_group-project-shopping-carts";
$order_number = 0;

try {
    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the data parameter is set
    if (isset($_POST['data'])) 
    {
        // Get the JSON data
        $jsonData = $_POST['data'];

        // Decode the JSON data to a PHP array by setting the 2nd parameter to TRUE
        $carts = json_decode($jsonData, true);

        // Check if the JSON decoding was successful
        if ($carts !== null) 
        {
            // Initialize order_number in session if not set
            if (!isset($_SESSION['order_number'])) {
                $_SESSION['order_number'] = 0;
            }

            // Increment order_number
            $_SESSION['order_number']++;

            // Get the current order number
            $order_number = $_SESSION['order_number'];
            
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO `cart-items` (order_number, product_id, quantity) VALUES (:order_number, :product_id, :quantity)");

            // Process each cart item
            foreach ($carts as $cart) 
            {
                $product_id = $cart['product_id'];
                $quantity = $cart['quantity'];

                // Bind parameters and execute the statement
                $stmt->bindParam(':order_number', $order_number);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->execute();

                echo "Order Number: " . $order_number . " - Product ID: " . $product_id . " Quantity: " . $quantity . "\n"; // Nothing to do with database, send info back to JS consolse
            }
        } 
        else 
        {
            echo "Failed to decode JSON";
        }
    } 
    else 
    {
        echo "No data received";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
