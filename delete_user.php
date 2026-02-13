<?php
require './config.php';

$id = $_GET['id'];
$table = 'users_tbl';
$where = "id = $id";
$redirect = './all_user.php?success=1&message=User Deleted Successfully!';

$database->delete($table, $where, $redirect);
