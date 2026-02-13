<?php
session_start();
require './config.php';
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: index.php');
    exit;
}


$table = 'users_tbl';
$rows = '*';
$join = null;
$where = null;
$order = 'id DESC';
$limit = 5;

$pageNo = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($pageNo - 1) * $limit;


$users = $database->all(
    $table,
    $rows,
    $join,
    $where,
    $order,
    $limit,
    $offset
);

$sl = 1;


require './header.php';
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">All User</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="card-body">
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p class="m-1"><strong><?= $_GET['message'] ?></strong></p>
                        <button type="button" class="close m-2" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <?php if ($users): ?>
                        <table class="table table-responsive-md">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th style="width:120px;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td><strong><?= htmlspecialchars($user['user_fullname']) ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center"><img src="images/avatar/1.jpg"
                                                    class="rounded-lg mr-2" width="24" alt=""> <span class="w-space-no">Dr.
                                                    <?= htmlspecialchars($user['user_email']) ?></span></div>
                                        </td>
                                        <td class="text-info"><?= strtoupper(htmlspecialchars($user['user_role'])) ?></td>
                                        <?php
                                        if (empty($user['profile_image'])) {
                                            $img = './uploads/profile_image/default.png';
                                        } else {
                                            $img = "./uploads/profile_image/" . $user['profile_image'];
                                        }
                                        ?>
                                        <td><img width="100" src="<?= $img ?>" alt="image">
                                        </td>
                                        <?php
                                        $icon = ($user['user_status'] == 'active') ? 'thumbs-up' : 'thumbs-down';
                                        $class = ($user['user_status'] == 'active') ? 'primary' : 'black';
                                        ?>

                                        <td>
                                            <div class="d-flex align-items-center"><i
                                                    class="fa fa-circle text-<?= $class ?> mr-1"></i>
                                                <?= strtoupper(htmlspecialchars($user['user_status'])) ?>
                                            </div>
                                        </td>


                                        <?php if ($user['user_role'] !== 'admin'): ?>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="user_status.php?id=<?= htmlspecialchars($user['id']) ?>"
                                                        class="btn btn-<?= $class ?> shadow sharp mr-1"><i
                                                            class="fa fa-<?= $icon ?>"></i></a>
                                                    <a href="edit_user.php?id=<?= htmlspecialchars($user['id']) ?>"
                                                        class="btn btn-secondary text-white shadow sharp mr-1"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="delete_user.php?id=<?= htmlspecialchars($user['id']) ?>"
                                                        onclick=" return confirm('Are you sure?')"
                                                        class="btn btn-danger shadow sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        <?php endif; ?>
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

<?php require './footer.php'; ?>