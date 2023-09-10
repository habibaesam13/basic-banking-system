<?php
session_start();
$userId = "";
require_once("DB_connection.php");
// Initialize variables for error message and transaction status
$transaction_stat = "";

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $_SESSION['sender_id'] = $userId;
    $sql = "SELECT balance FROM `users` WHERE `user_id`='$userId'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $_SESSION['current_balance'] = $row['balance'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    // Handle form submission
    if (!empty($_POST["amount"])) {
        if ($_POST["amount"] > 50) {

            if (preg_match('/^[0-9]+$/', $_POST["amount"])) {
                $transform_amount = $_POST["amount"];
                $receiverId = $_POST["receiver"]; // Capture the selected receiver ID

                $sql = "SELECT balance FROM `users` WHERE `user_id`='$receiverId'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['receiver_balance'] = $row['balance'];
                }

                if ($transform_amount > $_SESSION['current_balance'] || $transform_amount < 50) {
                    $transaction_stat = "not completed";
                    $_SESSION['error'] = "Transform Amount Must Be More Than 50 ";
                } else {
                    // Calculate new balances
                    $sender_current_balance = $_SESSION['current_balance'];
                    $new_sender_balance = $sender_current_balance - $transform_amount;
                    $receiver_new_balance = $_SESSION['receiver_balance'] + $transform_amount;

                    // Use mysqli_multi_query to execute multiple update statements
                    $sql = "UPDATE users SET balance='$new_sender_balance' WHERE user_id='$userId'; ";
                    $sql .= "UPDATE users SET balance='$receiver_new_balance' WHERE user_id='$receiverId';";

                    // Execute the queries
                    if ($conn->multi_query($sql) === TRUE) {
                        // Consume results to avoid "Commands out of sync" error
                        while ($conn->more_results() && $conn->next_result()) {
                            $conn->store_result();
                        }
                        $transaction_stat = "completed";
                    } else {
                        $transaction_stat = "not completed";
                    }
                    // Insert transaction record into the database

                    $sql = "INSERT INTO `transaction` (sender_id, receiver_id, transaction_amount, send_at, transaction_status)
                    VALUES ('$userId', '$receiverId', '$transform_amount', NOW(), '$transaction_stat')";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['success'] = "Transaction Done Successfully";
                    } else {
                        $_SESSION['error'] = "Receiver Id not defined ";
                    }
                }


            }
        } else {
            $_SESSION['error'] = "Transfer Amount Must Be More Than 50";
        }
    } else {
        $_SESSION['error'] = "All Fields Are Required";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/transfer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System - Transfer </title>
</head>

<body>
    <div class="container">
        <p>Welcom to transfer with <span id="logo-p1">Finta</span><span id="logo-p2">nce</span></p>
        <p>Your Balance Is:<span>
                <?php echo $_SESSION['current_balance']; ?>
            </span>
        </p>
        <?php if ($_SESSION['current_balance'] == 0) { ?>
            <p id="balance_not_enough"> Sorry You Can not Transfer any Money Your Balance Not Enough</p>
            <button type="submit" name="deposit-money" class="depos-btn"><a
                    href="deposit.php?id=<?php echo $userId; ?>">Deposit</a></button>
        <?php } else { ?>
            <form action="" method="post">
                <label for="amount">Transfer Amount</label><br>
                <input name="amount" id="amount" type="text"><br>
                <label for="receiver">Receiver</label><br>
                <select id="receiver" name="receiver"><br>
                    <?php
                    $sql = "SELECT user_id, first_name, last_name FROM users WHERE user_id <>'$userId'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['user_id']; ?>">
                            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                        </option>
                    <?php } ?>
                </select><br>
                <input type="submit" value="Send" class="btn" name="send">
                <button id="back"><a href="show_all_users.php">Back</a></button>
            </form>
        <?php } ?>
        <span class="session-error">
            <?php if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            } ?>
        </span>
        <span class="session-success">
            <?php if (isset($_SESSION['success'])) {
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            }
            ?>
        </span>
    </div>
</body>

</html>