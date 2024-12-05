document.addEventListener('DOMContentLoaded', function() {
    loadTasks();
    loadCategories();

    // Add Task Button Click
    document.getElementById('add-task').addEventListener('click', () => {
        showTaskModal();
    });
});

async function loadTasks() {
    const response = await fetch('api/tasks.php');
    const tasks = await response.json();
    
    const taskList = document.getElementById('task-list');
    taskList.innerHTML = tasks.map(task => `
        <div class="task-item p-4 border-b ${task.status === 'completed' ? 'bg-gray-100' : ''}">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold ${task.status === 'completed' ? 'line-through' : ''}">${task.title}</h3>
                    <p class="text-sm text-gray-600">${task.description}</p>
                    <p class="text-sm text-gray-500">Due: ${task.due_date}</p>
                </div>
                <div>
                    <button onclick="toggleTaskStatus(${task.id})" class="text-blue-500">
                        ${task.status === 'completed' ? 'Mark Incomplete' : 'Mark Complete'}
                    </button>
                    <button onclick="editTask(${task.id})" class="text-yellow-500 ml-2">Edit</button>
                    <button onclick="deleteTask(${task.id})" class="text-red-500 ml-2">Delete</button>
                </div>
            </div>
        </div>
    `).join('');
}

async function toggleTaskStatus(taskId) {
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
}

async function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        const response = await fetch(`api/tasks.php?id=${taskId}`, {
            method: 'DELETE'
        });
        
        if (response.ok) {
            loadTasks();
        }
    }
}

function showTaskModal(taskData = null) {
    const modal = document.getElementById('task-modal');
    modal.innerHTML = `
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">${taskData ? 'Edit Task' : 'Add Task'}</h2>
            <form id="task-form">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" class="w-full border p-2 rounded" 
                           value="${taskData ? taskData.title : ''}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Description</label>
                    <textarea name="description" class="w-full border p-2 rounded">${taskData ? taskData.description : ''}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Due Date</label>
                    <input type="date" name="due_date" class="w-full border p-2 rounded" 
                           value="${taskData ? taskData.due_date : ''}" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeTaskModal()" 
                            class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    `;
    modal.classList.remove('hidden');
}

function closeTaskModal() {
    document.getElementById('task-modal').classList.add('hidden');
}
