<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $stmt = $connection->prepare("SELECT * FROM system_users WHERE username = ?");
    $stmt->bind_param("s", $username);
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
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("INSERT INTO system_users (name, username, password, user_role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $username, $hashedPassword, $role);
        if ($stmt->execute()) {
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'New user added successfully',
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
}
?>



    <div class="max-w-md bg-white rounded p-6">
        <h1 class="text-2xl font-bold mb-4">Add New User</h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                <input type="text" id="username" name="username" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input type="password" id="password" name="password" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                <select id="role" name="role" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add User</button>
            </div>
        </form>
    </div>
