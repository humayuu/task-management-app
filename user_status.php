<?php
require './config.php';

$id = $_GET['id'];
$table = 'users_tbl';
$rows = "*";
$join = null;
$where = "id = $id";
$order = null;
$limit = null;
$offset = null;

$user = $database->find($table, $rows, $join, $where, $order, $limit, $offset);

$status = $user['user_status'];

$newStatus = ($status == 'active') ? 'inactive' : 'active';


$params = [
    'user_status' => $newStatus
];
$redirect = './all_user.php?success=1&message=User Status Updated Successfully!';

$database->update($table, $params, $where, $redirect);
