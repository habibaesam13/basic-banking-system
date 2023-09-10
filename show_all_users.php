<?php
require_once("DB_connection.php");
$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/all_users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Banking System - All Users</title>
</head>

<body>
    <?php if ($result->num_rows < 1) { ?>
        <div class="msg-container">
            <p>Sorry, No Users Found</p>
            <button><a href="add_user.php">Add User</a></button>
        </div>
    <?php } else { ?>
        <table>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Balance</th>
                <th>Transactions</th>
                <th>Transfer</th>
                <th>Deposit</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $row["user_Id"]; ?>
                    </td>
                    <td>
                        <?php echo $row["first_name"]; ?>
                    </td>
                    <td>
                        <?php echo $row["last_name"]; ?>
                    </td>
                    <td>
                        <?php echo $row["email"]; ?>
                    </td>
                    <td>
                        <?php echo $row["phone_number"]; ?>
                    </td>
                    <td>
                        <?php echo $row["balance"]; ?>
                    </td>
                    <td>
                        <button><a href="user_transactions.php?id=<?php echo $row["user_Id"]; ?>">View</a></button>
                    </td>
                    <td>
                        <button id="send"><a href="transfer.php?id=<?php echo $row["user_Id"]; ?>">Send</a></button>
                    </td>
                    <td>
                        <button><a href="deposit.php?id=<?php echo $row["user_Id"]; ?>">Deposit</a></button>
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