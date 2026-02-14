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

$table = 'users_tbl';
$rows = "*";
$join = null;
$where = "NOT user_role = 'admin'";
$order = 'id DESC';
$limit = null;
$offset = null;

$users = $database->all($table, $rows, $join, $where, $order, $limit, $offset);

if (empty($_SESSION['success'])) {
    $_SESSION['success'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issSubmitted'])) {
    // Verify CSRF Token
    if (!hash_equals($_SESSION['__csrf'], $_POST['__csrf'])) {
        $database->errors[] = "Invalid CSRF Token";
        header('Location: ' . basename(__FILE__));
        exit;
    }

    $table = 'task_tbl';
    $redirect = './create_task.php';
    $title = htmlspecialchars($_POST['title']);
    $dueDate = htmlspecialchars($_POST['due_date']);
    $description = htmlspecialchars($_POST['description']);
    $assignTo = htmlspecialchars($_POST['user_id']);
    $status = 'pending';

    // Validation
    $taskValidate = $database->validate([
        'title' => $title,
        'description' => $description,
        'due_date' => $dueDate,
        'user_id' => $assignTo,
        'status' => $status,
    ]);
    $params = [
        'title' => $title,
        'description' => $description,
        'due_date' => $dueDate,
        'user_id' => $assignTo,
        'status' => $status,
    ];

    if ($taskValidate) {
        $_SESSION['success'][] = "Task Created Successfully";
        $database->store($table, $params, $redirect);
    }
}

$message = $_SESSION['success'] ?? [];
$_SESSION['success'] = [];



require './header.php';

?>


<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item">Task</li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Task</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-user-plus mr-2"></i>Create New Task
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="basic-form">
                            <?php if ($database->getErrors()): ?>
                                <?php foreach ($database->getErrors() as $error): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($error) ?>
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($message)): ?>
                                <?php foreach ($message as $msg): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($msg) ?>
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                <input type="hidden" name="__csrf" value="<?= htmlspecialchars($_SESSION['__csrf']) ?>">
                                <!-- Task Information -->
                                <div class="mb-4 pb-3 border-bottom">
                                    <h5 class="text-primary mb-3">
                                        <i class="fa fa-tasks mr-2"></i>Task Details
                                    </h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="title" class="font-weight-bold">
                                                Title <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="title"
                                                name="title" placeholder="Enter task title">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="due_date" class="font-weight-bold">
                                                Due Date <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control form-control-lg" id="due_date"
                                                name="due_date" min="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description" class="font-weight-bold">
                                                Description <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control form-control-lg" id="description"
                                                name="description" rows="3" placeholder="Enter task description"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Assign to <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="user" name="user_id">
                                                <option value="">Select user...</option>
                                                <?php foreach ($users as $user): ?>
                                                    <option class="text-primary"
                                                        value="<?= htmlspecialchars($user['id']) ?>">
                                                        <?= htmlspecialchars($user['user_fullname']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="form-row mt-5">
                                    <div class="form-group col-md-12 text-center text-md-left">
                                        <button type="submit" name="issSubmitted" class="btn btn-primary btn-lg px-5">
                                            <i class="fa fa-check mr-2"></i>Create Task
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary btn-lg px-4 ml-2">
                                            <i class="fa fa-undo mr-2"></i>Reset
                                        </button>
                                        <a href="all_user.php" class="btn btn-outline-danger btn-lg px-4 ml-2">
                                            <i class="fa fa-times mr-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
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

<?php require './footer.php'; ?>