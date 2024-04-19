<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "customer_db";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_name = $_POST['sender_name'];
    $recipient_name = $_POST['recipient_name'];
    $amount = $_POST['amount'];
    if ($sender_name === $recipient_name) {
        echo "Sender and receiver cannot be the same.";
    } 
    elseif ($amount <= 0) {
        echo "Amount must be greater than zero.";
    } 
    else {
        $sql = "SELECT current_balance FROM customers WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sender_name);
        $stmt->execute();
        $stmt->bind_result($sender_balance);
        $stmt->fetch();
        $stmt->close();
        if ($sender_balance < $amount) {
            echo "Sender does not have enough balance to transfer the specified amount.";
        } else {
            $sql = "INSERT INTO transfers (sender_name, recipient_name, amount)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssd", $sender_name, $recipient_name, $amount);
            if ($stmt->execute()) {
                echo "Money transfer successful!";
                $new_sender_balance = $sender_balance - $amount;
                $sql = "UPDATE customers SET current_balance = ? WHERE name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ds", $new_sender_balance, $sender_name);
                $stmt->execute();
                $sql = "UPDATE customers SET current_balance = current_balance + ? WHERE name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ds", $amount, $recipient_name);
                $stmt->execute();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="bank.css">
</head>
<body>
<div class="text">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_name = $_POST['sender_name'];
    $recipient_name = $_POST['recipient_name'];
    $amount = $_POST['amount'];
    echo "<h2>Transaction Details:</h2>";
    echo "<p><strong>Sender Name:</strong> " . $sender_name . "</p>";
    echo "<p><strong>Recipient Name:</strong> " . $recipient_name . "</p>";
    echo "<p><strong>Amount:</strong> $" . $amount . "</p>";
}?>
</div>
<div class="text-overlay">
        <br>
          <a href="view_transfers.php">Transfer History </a>         
         
         </div>
</body>
</html>

