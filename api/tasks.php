<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
        $stmt->execute([$_SESSION['user_id']]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, due_date, category_id, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['category_id'],
            $_SESSION['user_id']
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ?, category_id = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['status'],
            $data['category_id'],
            $data['id'],
            $_SESSION['user_id']
        ]);
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $_SESSION['user_id']]);
        echo json_encode(['success' => true]);
        break;
}
?>
