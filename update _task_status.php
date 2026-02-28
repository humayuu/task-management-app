<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true || $_SESSION['userRole'] == 'admin') {
    header('Location: index.php');
    exit;
}



$id = isset($_GET['id']);
$table = 'task_tbl';
$rows = '*';
$join = null;
$where = "id = '$id'";
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
                        <div class="basic-form">
                            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                <input type="hidden" name="">
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
                                                Due Date <span class="text-danger">*</span>
                                            </label>
                                            <p><?= htmlspecialchars($task['title']) ?></p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="assign_to" class="font-weight-bold">
                                                Description <span class="text-danger">*</span>
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
                                            <select class="form-control form-control-lg" id="user" name="user_id">
                                                <option disabled selected value="">Select ...</option>
                                                <option value="">In Progress</option>
                                                <option value="">Complete</option>
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