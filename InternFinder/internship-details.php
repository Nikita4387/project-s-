<?php
require_once __DIR__.'/includes/functions.php'; $id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$st=$pdo->prepare("SELECT * FROM internships WHERE id=?"); $st->execute([$id?:0]); $i=$st->fetch();
if(!$i){http_response_code(404);$pageTitle='Not found';include __DIR__.'/includes/header.php';echo '<div class="empty-state">Internship not found. <a href="/InternFinder/internships.php">Browse listings</a></div>';include __DIR__.'/includes/footer.php';exit;}
$pageTitle=$i['title'];include __DIR__.'/includes/header.php';
?>
<a href="/InternFinder/internships.php" class="small text-decoration-none">← Back to internships</a><div class="detail-panel mt-3"><span class="badge-soft"><?= e($i['category']) ?></span><h1 class="mt-3"><?= e($i['title']) ?></h1><h5 class="text-muted"><?= e($i['company']) ?></h5>
<div class="row g-3 my-4"><?php foreach(['Location'=>$i['location'].' · '.$i['work_mode'],'Duration'=>$i['duration'],'Stipend'=>money_label($i['stipend'],$i['is_paid']),'Deadline'=>date('d M Y',strtotime($i['deadline']))] as $k=>$v): ?><div class="col-6 col-md-3"><div class="metric"><small><?= e($k) ?></small><strong><?= e($v) ?></strong></div></div><?php endforeach; ?></div>
<h5>About this internship</h5><p><?= nl2br(e($i['description'])) ?></p><h5>Required skills</h5><p><?= nl2br(e($i['required_skills'])) ?></p><h5>Responsibilities</h5><p><?= nl2br(e($i['responsibilities'])) ?></p><h5>Eligibility criteria</h5><p><?= nl2br(e($i['eligibility'])) ?></p>
<?php if((int)$i['is_open']===1 && $i['deadline']>=date('Y-m-d')): ?><a class="btn btn-primary btn-lg" href="/InternFinder/student/apply.php?id=<?= (int)$i['id'] ?>">Apply now</a><?php else: ?><span class="badge bg-secondary">Applications closed</span><?php endif; ?>
</div><?php include __DIR__.'/includes/footer.php'; ?>
