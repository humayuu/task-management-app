<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: index.php');
    exit;
}


$table = 'task_tbl';
$rows = "*";
$join  = "LEFT JOIN users_tbl ON task_tbl.user_id = users_tbl.id";
$where = null;

if (isset($_GET['filter'])) {
    if ($_GET['filter'] === 'pending_task') {
        $where = "status = 'pending'";
        $pendingActive = "text-primary";
    } elseif ($_GET['filter'] === 'overdue_task') {
        $where = "status = 'overdue'";
        $overDueActive = "text-primary";
    }
} else {
    $defaultClass = 'text-primary';
}

$order = 'task_tbl.id DESC';
$limit = 10;

$pageNo = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($pageNo - 1) * $limit;

$sl = 1;
$tasks = $database->all($table, $rows, $join, $where, $order, $limit, $offset);

require './header.php';

?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <!-- Primary Navigation Breadcrumb -->
            <nav aria-label="Primary navigation breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Task</li>
                </ol>
            </nav>

            <!-- Task Filter Tabs -->
            <nav aria-label="Task filters" class="mt-4">
                <ol class="breadcrumb breadcrumb-tabs justify-content-center mb-0">
                    <li class="breadcrumb-item ">
                        <a href="./all_task.php" class="<?= $defaultClass ?>" aria-current="page">All Tasks</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="<?= $pendingActive ?>" href="./all_task.php?filter=pending_task">Pending</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="<?= $overDueActive ?>" href="./all_task.php?filter=overdue_task">Overdue</a>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- row -->
        <div class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <?php if ($tasks): ?>
                        <table class="table table-responsive-md">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td><?= htmlspecialchars($task['title']) ?></td>
                                        <td><?= substr(htmlspecialchars($task['description']), 0, 20) ?>....</td>
                                        <td><?php
                                            $source = htmlspecialchars($task['due_date']);
                                            $date = new DateTime($source);
                                            echo $date->format('d/m/y');

                                            ?></td>
                                        <td>
                                            <span class="text-primary">
                                                <i class="bi bi-person-fill me-1"></i>
                                                <?= htmlspecialchars($task['user_fullname']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-info">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                <?= strtoupper(htmlspecialchars($task['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_task.php?id=<?= htmlspecialchars($task['id']) ?>"
                                                class="btn btn-primary shadow sharp"><i class="fa fa-pencil"></i></a>

                                            <a href="delete_task.php?id=<?= $task['id'] ?>"
                                                onclick=" return confirm('Are you sure?')"
                                                class="btn btn-danger shadow sharp"><i class="fa fa-trash"></i></a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            <?php $database->paginate($table, $pageNo, $limit) ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No Record Found!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require './footer.php' ?>