<html>

<head>
<link rel="stylesheet" type="text/css" href="bank.css">
    <title>Transfer Money</title>

</head>
<body>

    <h1>Transfer Money</h1>
    <form method="POST" action="transfer.php">
        <label for="sender">Sender Name :</label>
        <select name="sender_name" id="sender">
            <?php
                include 'db_connection.php';
                $query = "SELECT  name FROM customers";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                }
            ?>
        </select>
        <br>
        <label for="receiver">Receiver Name:</label>
        <select name="recipient_name" id="recipient_name">
            <?php
                mysqli_data_seek($result, 0); 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                }
                mysqli_free_result($result); 
                mysqli_close($connection);
            ?>
        </select>
        <br>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" min="0" step="any" required>
        <br><br>
        <button type="submit">Transfer</button>
    </form>
</body>
</html>
