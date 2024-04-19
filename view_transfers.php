<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bank.css">
    <title>View Transfer Data</title>
</head>
<body>
    <h1>Transfer History </h1>
    <?php
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "customer_db"; 
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT sender_name, recipient_name, amount, timestamp FROM transfers ORDER BY timestamp DESC";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Sender Name</th><th>Recipient Name</th><th>Amount</th><th>Timestamp</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['sender_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['recipient_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
            echo '<td>' . htmlspecialchars($row['timestamp']) . '</td>';
            echo '</tr>';
        } 
        echo '</table>';
    } else {
        echo "<p>No transfer data available.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
