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

// For task
$table = 'task_tbl';
$id = isset($_GET['id']) ?? '';
$rows = "*";
$join = null;
$where = "id = " . $id;
$order = null;
$limit = null;
$offset = null;
$task = $database->find($table, $rows, $join, $where, $order, $limit, $offset);


// For user
$users = $database->all('users_tbl', "*", null, null, 'id DESC', null, null);




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
    $redirect = './all_task.php';
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
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Task</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-user-plus mr-2"></i>Edit Task
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="basic-form">
                            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                <input type="hidden" name="__csrf" value="<?= htmlspecialchars($_SESSION['__csrf']) ?>">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">
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
                                                name="title" placeholder="Enter task title" value="<?= $task['title'] ?>">
                                        </div>
                                        <?php
                                        $formatted_date = date('Y-m-d', strtotime($task['due_date']));
                                        ?>
                                        <div class="form-group col-md-6">
                                            <label for="due_date" class="font-weight-bold"> Due Date <span class="text-danger">*</span> </label>
                                            <input type="date" class="form-control form-control-lg" id="due_date" name="due_date" value="<?= $formatted_date ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="description" class="font-weight-bold">
                                                Description <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control form-control-lg" id="description"
                                                name="description" rows="3" placeholder="Enter task description"><?= $task['description'] ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Assign to <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="user" name="user_id">
                                                <option value="">Select user...</option>
                                                <?php foreach ($users as $user): ?>
                                                    <option class="text-primary" value="<?= htmlspecialchars($user['id']) ?>" <?= ($task['user_id'] == $user['id']) ? 'selected' : null  ?>> <?= htmlspecialchars($user['user_fullname']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="form-row mt-5">
                                    <div class="form-group col-md-12 text-center text-md-left">
                                        <button type="submit" name="issSubmitted" class="btn btn-primary btn-lg px-5">
                                            <i class="fa fa-check mr-2"></i>Save Changes
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary btn-lg px-4 ml-2">
                                            <i class="fa fa-undo mr-2"></i>Reset
                                        </button>
                                        <a href="all_task.php" class="btn btn-outline-danger btn-lg px-4 ml-2">
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