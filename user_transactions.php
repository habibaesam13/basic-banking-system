<?php
$userId = $fName = $lName = "";
require_once("DB_connection.php");
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "SELECT first_name,last_name FROM `users` WHERE `user_id`='$userId'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $fName = $row["first_name"];
        $lName = $row['last_name'];
    }

    $sql = "SELECT
    sender.first_name AS sender_first_name,
    sender.last_name AS sender_last_name,
    receiver.first_name AS receiver_first_name,
    receiver.last_name AS receiver_last_name,
    t.transaction_amount,
    t.send_at,
    t.transaction_status
    FROM
        transaction AS t
    JOIN
        users AS sender
    ON
        t.sender_id = sender.user_id
    JOIN
        users AS receiver
    ON
        t.receiver_id = receiver.user_id
    WHERE
        sender.user_id = '$userId' OR receiver.user_id = '$userId';
    ";
    $result = $conn->query($sql);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/user_history.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $fName . " " . $lName . " History" ?>
    </title>
</head>

<body>
    <div class="container">
        <p>Welcome
            <span>
                <?php echo $fName . " " . $lName ?>
            </span>
        </p>


        <div class="result">
            <?php if ($result->num_rows == 0) { ?>
                <p id="noRes">You Do Not Make Any Transactions Before</p>
                <button id="back-b1"><a href="transfer.php?id=<?php echo $userId; ?>">Send</a></button>
                <button id="back-b1"><a href="show_all_users.php">Back</a></button>
            <?php } else { ?>
                <p class="sub-head">That is your History</p>
                <table>
                    <tr>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Transaction Amount</th>
                        <th>Send at</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php echo $row["sender_first_name"] . " " . $row["sender_last_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["receiver_first_name"] . " " . $row["receiver_last_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["transaction_amount"]; ?>
                            </td>
                            <td>
                                <?php echo $row["send_at"]; ?>
                            </td>
                            <td>
                                <?php echo $row["transaction_status"]; ?>
                            </td>
                            <td>
                                <button id="back"><a href="show_all_users.php">Back</a></button>
                            </td>
                        </tr>
                    <?php }
                    $conn->close();
            } ?>

                </td>
                <tr>
            </table>

        </div>
    </div>
</body>

</html>