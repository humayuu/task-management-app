<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Task Management System</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon.ico">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./vendor/chartist/css/chartist.min.css">
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="./vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <style>
        /* Override theme styles for form inputs */
        .form-control,
        .form-control:focus,
        .form-control:disabled,
        .form-control[readonly] {
            color: #212529 !important;
            /* Bootstrap's default dark text */
            background-color: #fff;
        }

        /* Select dropdown */
        .form-control select,
        select.form-control,
        .default-select {
            color: #212529 !important;
        }

        select.form-control option {
            color: #212529;
            background-color: #fff;
        }

        /* Placeholder text */
        .form-control::placeholder {
            color: #6c757d;
            /* Bootstrap muted color */
            opacity: 1;
        }

        .form-control:-ms-input-placeholder {
            color: #6c757d;
        }

        .form-control::-ms-input-placeholder {
            color: #6c757d;
        }

        /* Custom file input */
        .custom-file-label {
            color: #495057;
            background-color: #fff;
        }

        .custom-file-label::after {
            color: #495057;
            background-color: #e9ecef;
        }

        /* Input autofill override */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus {
            -webkit-text-fill-color: #212529 !important;
            -webkit-box-shadow: 0 0 0px 1000px #fff inset;
        }

        .f-size {
            font-size: 3rem;
        }
    </style>
</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header d-flex justify-content-between align-items-center">
            <a href="index.html" class="brand-logo d-flex justify-content-center align-items-center">
                <?php if (!empty($_SESSION['userImage'])): ?>
                    <img src="./uploads/<?= $_SESSION['userImage'] ?>"
                        width="100"
                        class="rounded-circle"
                        alt="User Logo" />
                <?php else: ?>
                    <img src="./uploads/default_avatar.png"
                        width="100"
                        class="rounded-circle"
                        alt="User Logo" />
                <?php endif; ?>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="./dashboard.php" aria-expanded="false">
                            <i class="flaticon-381-home"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <?php if ($_SESSION['userRole'] == 'admin'): ?>

                        <li>
                            <a href="all_user.php">
                                <i class="flaticon-381-user"></i>
                                <span class="nav-text">Manage Users</span>
                            </a>
                        </li>

                        <li>
                            <a class="ai-icon" href="create_task.php" aria-expanded="false">
                                <i class="flaticon-381-add"></i>
                                <span class="nav-text">Create Task</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li>
                        <a class="ai-icon" href="./all_task.php" aria-expanded="false">
                            <i class="flaticon-381-list-1"></i>
                            <span class="nav-text"><?= $_SESSION['userRole'] == 'admin' ? 'All Task' : 'My Task' ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="ai-icon" href="./profile_detail.php" aria-expanded="false">
                            <i class="flaticon-381-user-7"></i>
                            <span class="nav-text">Profile Detail</span>
                        </a>
                    </li>

                    <li>
                        <a href="./logout.php" aria-expanded="false">
                            <i class="flaticon-381-exit-1"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->