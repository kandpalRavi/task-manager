<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Welcome, <?php echo $_SESSION['username']; ?></h1>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        <!-- Add Task Form -->
        <div class="mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Add New Task</h2>
            <form id="taskForm" class="space-y-4">
                <div>
                    <label class="block mb-1">Task Title</label>
                    <input type="text" name="title" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full border p-2 rounded" rows="3"></textarea>
                </div>
                <div>
                    <label class="block mb-1">Due Date</label>
                    <input type="date" name="due_date" class="w-full border p-2 rounded" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Task</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Your Tasks</h2>
            <div id="taskList" class="space-y-4">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', loadTasks);

        document.getElementById('taskForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const task = {
                title: formData.get('title'),
                description: formData.get('description'),
                due_date: formData.get('due_date')
            };

            try {
                const response = await fetch('api/tasks.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(task)
                });

                if (response.ok) {
                    e.target.reset();
                    loadTasks();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        async function loadTasks() {
            try {
                const response = await fetch('api/tasks.php');
                const tasks = await response.json();
                const taskList = document.getElementById('taskList');
                
                taskList.innerHTML = tasks.map(task => `
                    <div class="border p-4 rounded ${task.status === 'completed' ? 'bg-gray-50' : ''}">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold ${task.status === 'completed' ? 'line-through' : ''}">${task.title}</h3>
                                <p class="text-sm text-gray-600">${task.description}</p>
                                <p class="text-sm text-gray-500">Due: ${task.due_date}</p>
                            </div>
                            <div class="space-x-2">
                                <button onclick="toggleStatus(${task.id})" class="text-blue-500">
                                    ${task.status === 'completed' ? 'Mark Incomplete' : 'Mark Complete'}
                                </button>
                                <button onclick="deleteTask(${task.id})" class="text-red-500">Delete</button>
                            </div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function toggleStatus(taskId) {
            try {
                const response = await fetch(`api/tasks.php`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: taskId,
                        status: 'completed'
                    })
                });

                if (response.ok) {
                    loadTasks();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
        async function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task?')) {
                try {
                    const response = await fetch(`api/tasks.php?id=${taskId}`, {
                        method: 'DELETE'
                    });

                    if (response.ok) {
                        loadTasks();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        }
    </script>
</body>
</html>
