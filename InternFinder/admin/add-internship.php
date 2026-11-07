<?php
require_once __DIR__.'/../includes/functions.php';admin_only();$pageTitle='Add internship';$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();$fields=['title','company','category','description','required_skills','responsibilities','eligibility','location','work_mode','duration','deadline'];$d=[];foreach($fields as $f)$d[$f]=trim($_POST[$f]??'');
$stipend=max(0,(float)($_POST['stipend']??0));$paid=isset($_POST['is_paid'])?1:0;
foreach(['title','company','category','description','location','duration','deadline'] as $f)if($d[$f]==='')$errors[]="Please enter ".str_replace('_',' ',$f).".";
if(!in_array($d['work_mode'],['Remote','On-site','Hybrid'],true))$errors[]='Select a valid work mode.';
$date=DateTime::createFromFormat('Y-m-d',$d['deadline']);if(!$date||$date->format('Y-m-d')!==$d['deadline'])$errors[]='Enter a valid deadline.';
if(!$errors){$s=$pdo->prepare("INSERT INTO internships(title,company,category,description,required_skills,responsibilities,eligibility,location,work_mode,duration,stipend,is_paid,deadline,created_by) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");$ordered=[]; foreach(['title','company','category','description','required_skills','responsibilities','eligibility','location','work_mode','duration'] as $f) $ordered[]=$d[$f]; $s->execute([...$ordered,$stipend,$paid,$d['deadline'],$_SESSION['admin_id']]);flash('success','Internship added successfully.');redirect('manage-internships.php');}}
include __DIR__.'/../includes/header.php'; ?>
<h1 class="page-title">Add new internship</h1><?php foreach($errors as $er): ?><div class="alert alert-danger"><?= e($er) ?></div><?php endforeach; ?>
<div class="form-card"><form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="row g-3">
<?php foreach(['title'=>'Internship title','company'=>'Company name','category'=>'Category','location'=>'Location','duration'=>'Duration','deadline'=>'Application deadline'] as $name=>$label): ?><div class="col-md-6"><label class="form-label"><?= e($label) ?></label><input class="form-control" name="<?= e($name) ?>" <?= $name==='deadline'?'type="date"':' ' ?> required value="<?= e($_POST[$name]??'') ?>"></div><?php endforeach; ?>
<div class="col-md-6"><label class="form-label">Work mode</label><select class="form-select" name="work_mode"><option>Remote</option><option>On-site</option><option>Hybrid</option></select></div><div class="col-md-6"><label class="form-label">Monthly stipend (₹)</label><input type="number" min="0" step="0.01" class="form-control" name="stipend" value="0"></div>
<div class="col-12 form-check ms-2"><input type="checkbox" class="form-check-input" name="is_paid" id="paid" checked><label for="paid" class="form-check-label">Paid internship</label></div>
<?php foreach(['description'=>'Complete description','required_skills'=>'Required skills','responsibilities'=>'Responsibilities','eligibility'=>'Eligibility criteria'] as $name=>$label): ?><div class="col-12"><label class="form-label"><?= e($label) ?></label><textarea class="form-control" rows="3" name="<?= e($name) ?>" required><?= e($_POST[$name]??'') ?></textarea></div><?php endforeach; ?>
<div class="col-12"><button class="btn btn-primary">Save internship</button><a class="btn btn-outline-secondary" href="manage-internships.php">Cancel</a></div></div></form></div>
<?php include __DIR__.'/../includes/footer.php'; ?>
