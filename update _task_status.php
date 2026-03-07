<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true || $_SESSION['userRole'] == 'admin') {
    header('Location: index.php');
    exit;
}

// Generate CSRF Token
if (empty($_SESSION['__csrf'])) {
    $_SESSION['__csrf'] = bin2hex(random_bytes(32));
}



// Update Status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issSubmitted'])) {
    // Verify CSRF Token
    if (!hash_equals($_SESSION['__csrf'], $_POST['__csrf'])) {
        $database->errors[] = 'Invalid CSRF Token';
        header("Location: " . basename(__FILE__));
        exit;
    }

    $id = htmlspecialchars($_POST['id']);
    $status = htmlspecialchars($_POST['status']);

    $table = 'task_tbl';
    $params = [
        'status' => $status,
    ];
    $where = "id = '$id'";
    $redirect = 'all_task.php?success=1&message=Status Updated Successfully!';

    $database->update($table, $params, $where, $redirect);
}


$id = (int) $_GET['id'];
$userId = $_SESSION['userId'];
$where = "id = $id AND user_id = $userId";
$table = 'task_tbl';
$rows = '*';
$join = null;
$order = null;
$limit = null;
$Offset = null;

$task = $database->find($table, $rows, $join, $where, $order, $limit, $Offset);
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Task Status</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-user-plus mr-2"></i>Update Status
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="m-1"><strong><?= $_GET['message'] ?></strong></p>
                                <button type="button" class="close m-2" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>
                        <div class="basic-form">
                            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="__csrf" value="<?= htmlspecialchars($_SESSION['__csrf']) ?>">
                                <!-- Task Information -->
                                <div class="mb-4 pb-3 border-bottom">
                                    <h5 class="text-primary mb-3">
                                        <i class="fa fa-tasks mr-2"></i>Task Details
                                    </h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Title <span class="text-danger">*</span>
                                            </label>
                                            <p><?= htmlspecialchars($task['title']) ?></p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Description <span class="text-danger">*</span>
                                            </label>
                                            <p><?= htmlspecialchars($task['description']) ?></p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Due Date <span class="text-danger">*</span>
                                            </label>
                                            <p><?php
                                                $source = htmlspecialchars($task['due_date']);
                                                $date = new DateTime($source);
                                                echo $date->format('d/m/y');

                                                ?></p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control form-control-lg" id="status" name="status">
                                                <option disabled selected value="">Select ...</option>
                                                <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                                <option value="complete" <?= $task['status'] == 'complete' ? 'selected' : '' ?>>Complete</option>
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