<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
            <form action="auth.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    Login
                </button>
            </form>
            <p class="mt-4 text-center">
                Don't have an account? <a href="register.php" class="text-blue-500">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
