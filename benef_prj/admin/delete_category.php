<?php
// Include database connection file
include '../includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is for deletion
    if (isset($_POST['delete_id'])) {

        // Escape user input for security
        $delete_id = $connection->real_escape_string($_POST['delete_id']);

        // SQL to delete record
        $sql = "DELETE FROM tbl_categories WHERE id = '$delete_id'";

        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $connection->error;
        }

        // Close connection
        $connection->close();

        exit; // Stop further execution
    }
}
?>