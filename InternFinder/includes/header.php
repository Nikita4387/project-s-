<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'InternFinder';
$base = '/InternFinder';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | InternFinder</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="<?= $base ?>/assets/css/style.css" rel="stylesheet">
</head><body>
<nav class="navbar navbar-expand-lg navbar-dark site-nav">
<div class="container"><a class="navbar-brand fw-bold" href="<?= $base ?>/index.php"><i class="fa-solid fa-compass me-2"></i>InternFinder</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="mainNav"><ul class="navbar-nav ms-auto align-items-lg-center">
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/index.php">Home</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/internships.php">Internships</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/about.php">About</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/contact.php">Contact</a></li>
<?php if (!empty($_SESSION['student_id'])): ?>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/student/dashboard.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/student/my-applications.php">My Applications</a></li>
<li class="nav-item"><a class="btn btn-light btn-sm ms-lg-2" href="<?= $base ?>/student/logout.php">Logout</a></li>
<?php elseif (!empty($_SESSION['admin_id'])): ?>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/admin/dashboard.php">Admin Panel</a></li>
<li class="nav-item"><a class="btn btn-light btn-sm ms-lg-2" href="<?= $base ?>/admin/logout.php">Logout</a></li>
<?php else: ?>
<li class="nav-item"><a class="nav-link" href="<?= $base ?>/student/login.php">Login</a></li>
<li class="nav-item"><a class="btn btn-primary btn-sm ms-lg-2" href="<?= $base ?>/student/register.php">Register</a></li>
<li class="nav-item">
    <a class="btn btn-warning btn-sm ms-lg-2"
       href="<?= $base ?>/admin/login.php">
       Admin Login
    </a>
</li>
<?php endif; ?>
</ul></div></div></nav>
<main class="container py-4"><?php show_flash(); ?>
