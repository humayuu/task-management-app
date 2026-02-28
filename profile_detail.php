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
$rows = '*';
$join = null;
$where = 'id = ' . $_SESSION['userId'];
$order = null;
$limit = null;
$offset = null;

$user = $database->find($table, $rows, $join, $where, $order, $limit, $offset);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issSubmitted'])) {
    // Verify CSRF Token
    if (!hash_equals($_SESSION['__csrf'], $_POST['__csrf'])) {
        $database->errors[] = "Invalid CSRF Token";
        header('Location: ' . basename(__FILE__));
        exit;
    }

    $id = $_SESSION['userId'];
    $where = "id = $id";
    $redirect = './profile_detail.php?success=1&message=Profile Detail Updated Successfully!';
    $name = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $uploadDir = '/uploads/';

    $userValidate = $database->validate([
        'user_fullname' => $name,
        'user_email' => $email,
    ]);

    if ($userValidate) {
        // Image Upload
        $image = $database->file('profileImage', $uploadDir) ?? null;

        $params = [
            'user_fullname' => $name,
            'user_email' => $email,
            'profile_image' => $image,
        ];
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-10 col-lg-11 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary">
                        <h4 class="card-title text-white mb-0">
                            <i class="fa fa-user-plus mr-2"></i>Profile Detail
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($database->getErrors()): ?>
                            <?php foreach ($database->getErrors() as $error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($error) ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="m-1"><strong><?= $_GET['message'] ?></strong></p>
                                <button type="button" class="close m-2" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>
                        <div class="basic-form">
                            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                                enctype="multipart/form-data">
                                <input type="hidden" name="__csrf" value="<?= htmlspecialchars($_SESSION['__csrf']) ?>">
                                <!-- Personal Information -->
                                <div class="mb-4 pb-3 border-bottom">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fullname" class="font-weight-bold">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="fullname"
                                                name="fullname" placeholder="Enter full name"
                                                value="<?= htmlspecialchars($user['user_fullname']) ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="font-weight-bold">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control form-control-lg" id="email"
                                                name="email" placeholder="Enter email address"
                                                value="<?= htmlspecialchars($user['user_email']) ?>">
                                        </div>
                                        <div class="form-group mt-3 col-md-6">
                                            <label for="confirmPassword" class="font-weight-bold">
                                                Profile Image <span class="text-danger">*</span>
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="profileImage" class="custom-file-input">
                                                <label class="custom-file-label">Choose file</label>
                                                <?php if (!empty($user['userImage'])): ?>
                                                    <img src="./uploads/<?= $user['userImage'] ?>" width="100"
                                                        alt="" />
                                                <?php else: ?>
                                                    <img class="img-fluid mt-2" style="width:100px; height:90px;"
                                                        src="./uploads/default_avatar.png" alt="">
                                                <?php endif; ?>
                                            </div>
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