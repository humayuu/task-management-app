<?php
session_start();
require './config.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: index.php');
    exit;
}

$usersCount = 0;
$taskCount = 0;

$user = $database->all('users_tbl', '*', null, null, null, null, null);
$usersCount = count($user);

// Admin Check
if (isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'admin') {
    // ALl Task
    $allTask = $database->all('task_tbl', '*', null, null, null, null, null);
    $allTaskCount =  count($allTask);

    // Over Due
    $overDueTask = $database->all('task_tbl', '*', null, "status = 'overdue'", null, null, null);
    $overDueTaskCount =  count($overDueTask);

    // Pending
    $pendingTask = $database->all('task_tbl', '*', null, "status = 'pending'", null, null, null);
    $pendingTaskCount =  count($pendingTask);


    // In Progress
    $inProgressTask = $database->all('task_tbl', '*', null, "status = 'in_progress'", null, null, null);
    $inProgressTaskCount =  count($inProgressTask);


    // Complete
    $completeTask = $database->all('task_tbl', '*', null, "status = 'complete'", null, null, null);
    $completeTaskCount =  count($completeTask);
} else {
    $userId = $_SESSION['userId'];
    $table = 'task_tbl';
    $rows = '*';
    $join = null;
    $where = "user_id = " . $userId;
    $order = null;
    $limit = null;
    $offset = null;

    // ALl Task
    $allTask = $database->all($table, $rows, $join, $where, $order, $limit, $offset);
    $allTaskCount =  count($allTask);

    // Over Due
    $overDueTask = $database->all('task_tbl', '*', null, "user_id = '$userId' AND status = 'overdue'", null, null, null);
    $overDueTaskCount =  count($overDueTask);

    // Pending
    $pendingTask = $database->all('task_tbl', '*', null, "user_id = '$userId' AND status = 'pending'", null, null, null);
    $pendingTaskCount =  count($pendingTask);


    // In Progress
    $inProgressTask = $database->all('task_tbl', '*', null, "user_id = '$userId' AND status = 'in_progress'", null, null, null);
    $inProgressTaskCount =  count($inProgressTask);


    // Complete
    $completeTask = $database->all('task_tbl', '*', null, "user_id = '$userId' AND status = 'complete'", null, null, null);
    $completeTaskCount =  count($completeTask);
}

require './header.php';
?>
<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="row ml-1">

        <?php if ($_SESSION['userRole'] == 'admin'): ?>
            <!-- Users -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fs-34 text-black font-w600"><?= $usersCount ?></h2>
                            <span>Users</span>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-primary f-size"></i>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- All Task -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-34 text-black font-w600"><?= $allTaskCount ?></h2>
                        <span>All Task</span>
                    </div>
                    <i class="bi bi-list-task fs-1 text-dark f-size"></i>
                </div>
            </div>
        </div>

        <!-- Overdue -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-34 text-black font-w600"><?= $overDueTaskCount ?></h2>
                        <span>Overdue</span>
                    </div>
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger f-size"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-34 text-black font-w600"><?= $pendingTaskCount ?></h2>
                        <span>Pending</span>
                    </div>
                    <i class="bi bi-hourglass-split fs-1 text-warning f-size"></i>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-1 text-black font-w600"><?= $inProgressTaskCount ?></h2>
                        <span>In Progress</span>
                    </div>
                    <i class="bi bi-arrow-repeat fs-1 text-info f-size"></i>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fs-34 text-black font-w600"><?= $completeTaskCount ?></h2>
                        <span>Completed</span>
                    </div>
                    <i class="bi bi-check-circle-fill fs-1 text-success f-size"></i>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
<?php require './footer.php' ?>