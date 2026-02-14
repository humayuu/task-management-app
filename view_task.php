<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: index.php');
    exit;
}


$id = isset($_GET['id']);
$table = 'task_tbl';
$rows = '*';
$join = null;
$where = "id = " . $id;
$order = null;
$limit = null;
$offset = null;

$task = $database->find($table, $rows, $join, $where, $order, $limit, $offset);



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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">View Task</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-user-plus mr-2"></i>View Task
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="basic-form">
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
                                            name="title" placeholder="Enter task title" readonly disabled value="<?= htmlspecialchars($task['title']) ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="due_date" class="font-weight-bold">
                                            Due Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control form-control-lg" id="due_date"
                                            name="due_date" readonly disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description" class="font-weight-bold">
                                            Description <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control form-control-lg" id="description"
                                            name="description" rows="3" placeholder="Enter task description" readonly disabled></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="assign_to" class="font-weight-bold">
                                            Assign to <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="due_date"
                                            name="due_date" readonly disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <div class="form-row mt-5">
                                <div class="form-group col-md-12 text-center text-md-left">
                                    <a href="./all_task.php" class="btn btn-outline-primary btn-lg px-5">
                                        <i class="fa fa-arrow-left mr-2"></i>Back
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