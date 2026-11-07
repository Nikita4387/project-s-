<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header("Location: $url"); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function csrf_check(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
            http_response_code(419); exit('Invalid or expired form token. Please go back and try again.');
        }
    }
}
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type'=>$type, 'message'=>$message]; }
function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-'.e($f['type']).' alert-dismissible fade show" role="alert">'.e($f['message']).'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
function student_only(): void { if (empty($_SESSION['student_id'])) { flash('warning','Please log in to continue.'); redirect('/InternFinder/student/login.php'); } }
function admin_only(): void { if (empty($_SESSION['admin_id'])) { flash('warning','Administrator login required.'); redirect('/InternFinder/admin/login.php'); } }
function money_label($amount, $paid): string {
    if (!$paid || (float)$amount <= 0) return 'Unpaid';
    return '₹'.number_format((float)$amount, 0).' / month';
}
function active_internship_sql(): string { return "is_open = 1 AND deadline >= CURDATE()"; }
