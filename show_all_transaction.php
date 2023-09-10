<?php
require_once("DB_connection.php");
$sql = "SELECT
    t.transaction_id,
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
    t.receiver_id = receiver.user_id;

";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/all_users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System - History</title>
</head>

<body>
    <?php if ($result->num_rows < 1) { ?>
        <div class="msg-container">
            <p>Sorry, No Users Found</p>
            <button><a href="add_user.php">Add User</a></button>
        </div>
    <?php } else { ?>
        </p>
        </div>
        <table>
            <tr>
                <th>Id</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Transaction Amount</th>
                <th>Send At</th>
                <th>Transaction Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $row["transaction_id"]; ?>
                    </td>
                    <td>
                        <?php echo $row["sender_first_name"] . "" . $row["sender_last_name"]; ?>
                    </td>
                    <td>
                        <?php echo $row["receiver_first_name"] . "" . $row["receiver_last_name"]; ?>
                    </td>
                    <td>
                        <?php echo $row["transaction_amount"]; ?>
                    </td>
                    <td>
                        <?php echo $row["send_at"]; ?>
                    </td>
                    <td id="transaction_status">
                        <?php echo $row["transaction_status"]; ?>
                    </td>
                </tr>
            <?php }
            $conn->close();
    } ?>

        </td>
        <tr>
    </table>

</body>

</html>