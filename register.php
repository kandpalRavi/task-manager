<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
            <form action="register_process.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
                    Register
                </button>
            </form>
            <p class="mt-4 text-center">
                Already have an account? <a href="login.php" class="text-blue-500">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
