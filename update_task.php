<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: index.php');
    exit;
}

// Generate CSRF Token
if (empty($_SESSION['__csrf'])) {
    $_SESSION['__csrf'] = bin2hex(random_bytes(32));
}

// Update Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issSubmitted'])) {
    // Verify CSRF Token
    if (!hash_equals($_SESSION['__csrf'], $_POST['__csrf'])) {
        $database->errors[] = 'Invalid CSRF token';
        header('Location: ') . basename(__FILE__);
        exit;
    }

    $id = $_POST['id'];
    $table = 'task_tbl';
    $where = "id = $id";
    $redirect = './all_task.php?success=1&message=Task Updated Successfully!';
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $dueDate = htmlspecialchars($_POST['due_date']);
    $user = htmlspecialchars($_POST['user_id']);

    $userValidate = $database->validate([
        'title' => $title,
        'description' => $description,
        'due_date' => $dueDate,
        'user_id' => $user,
    ]);

    $params = [
        'title' => $title,
        'description' => $description,
        'due_date' => $dueDate,
        'user_id' => $user,
    ];


    if ($userValidate) {
        $database->update($table, $params, $where, $redirect);
    }
}
