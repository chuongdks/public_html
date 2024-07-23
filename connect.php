<?php

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];


$servername = "localhost";
$username = "zhou4o_comp3340_group";
$password = "w4CscNr2Va8KsjCW46un";
$dbname = "zhou4o_comp3340_group";

try {
   
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    $stmt = $conn->prepare("INSERT INTO messages (fullname, email, phone, message) VALUES (:fullname, :email, :phone, :message)");

   
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo "Message sent successfully...";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;

?>
