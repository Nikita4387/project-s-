<?php
require_once __DIR__.'/includes/functions.php';
$pageTitle='Find internships';
$featured=$pdo->query("SELECT * FROM internships WHERE ".active_internship_sql()." ORDER BY created_at DESC LIMIT 3")->fetchAll();
include __DIR__.'/includes/header.php';
?>
<section class="hero rounded-4 p-4 p-lg-5 mb-5"><div class="row align-items-center"><div class="col-lg-8">
<span class="eyebrow">YOUR CAREER STARTS HERE</span><h1 class="display-5 fw-bold mt-3">Find Your Next Internship Opportunity</h1>
<p class="lead mt-3">Discover internships, build practical skills, and take the next step toward your career.</p>
<form class="row g-2 mt-4" action="/InternFinder/internships.php" method="get"><div class="col-md-8"><input class="form-control form-control-lg" name="q" placeholder="Search role, company or skill"></div><div class="col-md-4"><button class="btn btn-primary btn-lg w-100"><i class="fa fa-search me-2"></i>Find internships</button></div></form>
<a class="btn btn-outline-primary mt-3" href="/InternFinder/internships.php">Browse all internships</a></div><div class="col-lg-4 text-center d-none d-lg-block"><div class="hero-icon"><i class="fa-solid fa-laptop-code"></i></div></div></div></section>
<div class="section-heading"><div><span class="eyebrow">EXPLORE</span><h2>Recently added internships</h2></div><a href="/InternFinder/internships.php">View all <i class="fa fa-arrow-right"></i></a></div>
<div class="row g-4"><?php foreach($featured as $i): ?><div class="col-md-4"><?php include __DIR__.'/includes/internship-card.php'; ?></div><?php endforeach; ?>
<?php if (!$featured): ?><p>No open internships yet. Please check back soon.</p><?php endif; ?></div>
<section class="mt-5"><div class="section-heading"><div><span class="eyebrow">SIMPLE PROCESS</span><h2>How it works</h2></div></div><div class="row g-3">
<?php foreach([['1','Create an account','Register with your student details.'],['2','Explore opportunities','Search and filter internships that match your interests.'],['3','Apply and track','Submit applications and follow their status.']] as $step): ?><div class="col-md-4"><div class="info-card"><span class="step"><?= e($step[0]) ?></span><h5><?= e($step[1]) ?></h5><p class="text-muted mb-0"><?= e($step[2]) ?></p></div></div><?php endforeach; ?></div></section>
<section class="cta-panel mt-5"><h2>Start building your future today.</h2><p class="mb-3">One profile. New opportunities. A stronger career start.</p><a class="btn btn-light" href="/InternFinder/student/register.php">Join InternFinder</a></section>
<?php include __DIR__.'/includes/footer.php'; ?>
