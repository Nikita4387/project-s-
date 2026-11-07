<?php
require_once __DIR__.'/includes/functions.php'; $pageTitle='Browse internships';
$q=trim($_GET['q']??''); $category=trim($_GET['category']??''); $location=trim($_GET['location']??''); $paid=$_GET['paid']??'';
$sql="SELECT * FROM internships WHERE ".active_internship_sql(); $params=[];
if($q!==''){ $sql.=" AND (title LIKE ? OR company LIKE ? OR description LIKE ? OR required_skills LIKE ?)"; $v="%$q%"; array_push($params,$v,$v,$v,$v); }
if($category!==''){ $sql.=" AND category=?"; $params[]=$category; }
if($location!==''){ $sql.=" AND location LIKE ?"; $params[]="%$location%"; }
if($paid==='paid') $sql.=" AND is_paid=1"; elseif($paid==='unpaid') $sql.=" AND is_paid=0";
$sql.=" ORDER BY created_at DESC"; $st=$pdo->prepare($sql); $st->execute($params); $items=$st->fetchAll();
$categories=$pdo->query("SELECT DISTINCT category FROM internships ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
include __DIR__.'/includes/header.php';
?>
<h1 class="page-title">Explore internships</h1><p class="text-muted">Find an opportunity that matches your goals and skills.</p>
<form class="filter-panel row g-3 mb-4" method="get"><div class="col-md-4"><label class="form-label">Search</label><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Title, company or skill"></div>
<div class="col-md-3"><label class="form-label">Category</label><select class="form-select" name="category"><option value="">All categories</option><?php foreach($categories as $c): ?><option <?= $category===$c?'selected':'' ?> value="<?= e($c) ?>"><?= e($c) ?></option><?php endforeach; ?></select></div>
<div class="col-md-3"><label class="form-label">Location</label><input class="form-control" name="location" value="<?= e($location) ?>" placeholder="City or Remote"></div>
<div class="col-md-2"><label class="form-label">Stipend</label><select class="form-select" name="paid"><option value="">All</option><option value="paid" <?= $paid==='paid'?'selected':'' ?>>Paid</option><option value="unpaid" <?= $paid==='unpaid'?'selected':'' ?>>Unpaid</option></select></div>
<div class="col-12"><button class="btn btn-primary">Apply filters</button> <a class="btn btn-outline-secondary" href="/InternFinder/internships.php">Clear</a></div></form>
<div class="row g-4"><?php foreach($items as $i): ?><div class="col-md-6 col-lg-4"><?php include __DIR__.'/includes/internship-card.php'; ?></div><?php endforeach; ?><?php if(!$items): ?><div class="col-12"><div class="empty-state">No internships match your filters.</div></div><?php endif; ?></div>
<?php include __DIR__.'/includes/footer.php'; ?>
