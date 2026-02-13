<?php
require './config.php';

$id = isset($_GET['id']);
$table = 'task_tbl';
$where = "id = $id";
$redirect = './all_task.php';

$database->delete($table, $where, $redirect);
