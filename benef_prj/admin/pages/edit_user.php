<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Check if the username already exists (except for the current user ID)
    $stmt = $connection->prepare("SELECT * FROM system_users WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $username, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'User with the same username already exists!',
                showConfirmButton: true,
            });
        </script>
        <?php
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the user record in the database
        $stmt = $connection->prepare("UPDATE system_users SET name = ?, username = ?, password = ?, user_role = ? WHERE id = ?");
        $stmt->bind_param("sssii", $name, $username, $hashedPassword, $role, $userId);
        if ($stmt->execute()) {
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User updated successfully.',
                    showConfirmButton: true,
                }).then(() => {
                    window.location.href = '?page=users';
                });
            </script>
            <?php
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    // Close connection
    $stmt->close();
    $connection->close();
} else {
    // Check if user ID is provided in the link parameter
    if (isset($_GET['user_id'])) {
        // Fetch the user record from the database based on the provided user ID
        $userId = $_GET['user_id'];
        $stmt = $connection->prepare("SELECT * FROM system_users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $name = $user['name'];
            $username = $user['username'];
            $role = $user['user_role'];
        }
    }
}
?>

<div class="max-w-md bg-white rounded p-6">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>
    <form action="" method="post">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
        </div>
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
            <input type="password" id="password" name="password" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
        </div>
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
            <select id="role" name="role" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                <option value="">Select Role</option>
                <option value="1" <?php echo isset($role) && $role == 1 ? 'selected' : ''; ?>>Admin</option>
                <option value="2" <?php echo isset($role) && $role == 2 ? 'selected' : ''; ?>>User</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update User</button>
        </div>
    </form>
</div>
