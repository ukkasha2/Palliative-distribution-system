<?php
include "../includes/connection.php";

// Fetch users from system_users table
$sql = "SELECT * FROM system_users";
$result = $connection->query($sql);

$users = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close connection
$connection->close();

// Encode users array into JSON format
echo json_encode($users);
?>
