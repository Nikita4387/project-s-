<?php
require_once __DIR__.'/../includes/functions.php'; if(!empty($_SESSION['student_id'])) redirect('dashboard.php'); $pageTitle='Student registration'; $errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();$name=trim($_POST['name']??'');$email=strtolower(trim($_POST['email']??''));$phone=trim($_POST['phone']??'');$college=trim($_POST['college']??'');$course=trim($_POST['course']??'');$pw=$_POST['password']??'';$confirm=$_POST['confirm_password']??'';
if($name===''||strlen($name)>120)$errors[]='Enter your full name.';if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Enter a valid email.';if(!preg_match('/^[0-9+\-\s]{10,16}$/',$phone))$errors[]='Enter a valid phone number.';if($college===''||$course==='')$errors[]='College and course are required.';if(strlen($pw)<8)$errors[]='Password must be at least 8 characters.';if($pw!==$confirm)$errors[]='Passwords do not match.';
if(!$errors){$s=$pdo->prepare("SELECT id FROM students WHERE email=?");$s->execute([$email]);if($s->fetch())$errors[]='This email is already registered.';}
if(!$errors){$s=$pdo->prepare("INSERT INTO students(name,email,phone,college,course,password_hash) VALUES(?,?,?,?,?,?)");$s->execute([$name,$email,$phone,$college,$course,password_hash($pw,PASSWORD_DEFAULT)]);flash('success','Registration successful. Please log in.');redirect('login.php');}}
include __DIR__.'/../includes/header.php'; ?>
<h1 class="page-title">Create student account</h1><div class="form-card narrow"><?php foreach($errors as $er): ?><div class="alert alert-danger"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" class="needs-validation" novalidate><?= '<input type="hidden" name="csrf_token" value="'.e(csrf_token()).'">' ?>
<div class="mb-3"><label class="form-label">Full name</label><input required maxlength="120" class="form-control" name="name" value="<?= e($_POST['name']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Email address</label><input required type="email" class="form-control" name="email" value="<?= e($_POST['email']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Phone number</label><input required class="form-control" name="phone" value="<?= e($_POST['phone']??'') ?>"></div>
<div class="mb-3"><label class="form-label">College name</label><input required class="form-control" name="college" value="<?= e($_POST['college']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Course / Branch</label><input required class="form-control" name="course" value="<?= e($_POST['course']??'') ?>"></div>
<div class="mb-3"><label class="form-label">Password (minimum 8 characters)</label><input required minlength="8" type="password" class="form-control" name="password"></div>
<div class="mb-3"><label class="form-label">Confirm password</label><input required type="password" class="form-control" name="confirm_password"></div>
<button class="btn btn-primary w-100">Register</button></form><p class="text-center mt-3 mb-0">Already registered? <a href="login.php">Login</a></p></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
