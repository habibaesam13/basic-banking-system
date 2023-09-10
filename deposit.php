<?php
session_start();
$userId = "";
$current_balance = "";
require_once("DB_connection.php");
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT balance FROM `users` WHERE `user_id`='$userId'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $current_balance = $row['balance'];
    }

    if (isset($_POST['deposit'])) {
        if (!empty($_POST['amount'])) {
            if (preg_match('/^[0-9]+$/', $_POST["amount"]) && $_POST["amount"] > 0) {
                $current_balance += $_POST["amount"];
                $sql = "UPDATE users SET balance='$current_balance' WHERE user_id='$userId'; ";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success'] = "Deposit Done Successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }


            } else {
                $_SESSION['error'] = "Enter Valid Amount";
            }

        } else {
            $_SESSION['error'] = "Deposit Amount Is Requierd";
        }
    }


} else {
    $_SESSION['error'] = "User Id Is Undefined";
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/transfer.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System - Deposit </title>
</head>

<body>
    <div class="container">
        <p>Welcom to Deposit with <span id="logo-p1">Finta</span><span id="logo-p2">nce</span></p>
        <p>Your Balance Is:<span>
                <?php echo $current_balance ?>
            </span>
        </p>
        <form action="" method="post">
            <label for="amount">Deposit Amount</label><br>
            <input name="amount" id="amount" type="text"><br>
            <input type="submit" value="Deposit" class="deposit depos-btn" name="deposit" id="">
            <button type="submit" class="back-btn depos-btn"><a
                    href="transfer.php?id=<?php echo $userId; ?>">Back</a></button>
        </form>
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