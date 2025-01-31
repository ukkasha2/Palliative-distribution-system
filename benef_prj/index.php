<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Login to PalliativeCare System</title>
</head>
<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded shadow-md sm:w-96 w-full">
        <img src="https://via.placeholder.com/150" alt="PalliativeCare System Logo" class="mx-auto mb-4 rounded-full w-20 h-20">
        <p class="text-center text-lg font-semibold mb-4">PalliativeCare System</p>

        <form action="login.php" method="POST">
            <div class="mb-4 relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-user text-gray-500"></i>
                </span>
                <input type="text" name="username" placeholder="Username" class="w-full pl-10 pr-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6 relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-lock text-gray-500"></i>
                </span>
                <input type="password" name="password" placeholder="Password" class="w-full pl-10 pr-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <a href="admin" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                Login
            </a>
        </form>
    </div>

</body>
</html>