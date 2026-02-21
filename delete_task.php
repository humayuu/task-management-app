<?php
require './config.php';

$id = $_GET['id'];
$table = 'task_tbl';
$where = "id = $id";
$redirect = './all_task.php?success=1&message=Task Deleted Successfully!';

$database->delete($table, $where, $redirect);
