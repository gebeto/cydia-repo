<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'TableModel.php';

$tables = array(
	new TableModel('repo_info', array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`title` VARCHAR(64) NOT NULL',
		'`description` varchar(256) NOT NULL',
		'`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
	), array(
		'id' => 1,
		'title' => 'Dan repo',
		'description' => 'Daniel repository'
	)),
	new TableModel('repo_users', array(
		'`id` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)',
		'`name` VARCHAR(50) NOT NULL',
		'`udid` VARCHAR(40) NOT NULL',
		'`blocked` TINYINT(1) NOT NULL DEFAULT 0'
	), array(
		'name' => 'Slavik Nychkalo',
		'udid' => '6e74d6351e6e38cfced813c9f0e38aa3d8174834'
	)),
	new TableModel('repo_sections', array(
		'`id` INT NOT NULL AUTO_INCREMENT',
		'`name` VARCHAR(20) NOT NULL',
		'PRIMARY KEY (`id`)'
	), array(
		'name' => 'Themes'
	)),
	new TableModel('repo_tweaks', array(
		'`id` INT NOT NULL AUTO_INCREMENT',
		'`name` VARCHAR(32) NOT NULL',
		'`bundle_id` VARCHAR(32) NOT NULL',
		'`description` VARCHAR(256) NOT NULL',
		'`version` VARCHAR(11) NOT NULL',
		'`author` VARCHAR(64) NOT NULL DEFAULT "Author"',
		'`section` VARCHAR(64) NOT NULL DEFAULT 1',
		'`paid` TINYINT(1) NOT NULL DEFAULT 0',
		'`downloads` INT NOT NULL DEFAULT 0',
		'PRIMARY KEY (`id`)',
		'UNIQUE `tweak_unique` (`name`)'
	), array(
		'name' => 'test',
		'bundle_id' => 'com.jbtweak.test1',
		'description' => 'desc',
		'version' => '1.0'
	)),
	new TableModel('repo_purchases', array(
		'`id` INT NOT NULL AUTO_INCREMENT',
		'`user_id` INT NOT NULL',
		'`tweak_id` INT NOT NULL',
		'`purchase_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
		'PRIMARY KEY (`id`)'
	), array(
		'user_id' => 1,
		'tweak_id' => 1,
	)),
);

if (isset($_POST['create'], $_POST['index'])) {
	echo 'CREATE: ' . $_POST['index'];
	$tables[$_POST['index']]->create();
} elseif (isset($_POST['remove'], $_POST['index'])) {
	echo 'REMOVE: ' . $_POST['index'];
	$tables[$_POST['index']]->remove();
} elseif (isset($_POST['recreate'], $_POST['index'])) {
	echo 'RECREATE: ' . $_POST['index'];
	$tables[$_POST['index']]->recreate();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DB manager</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">DB Manager</a>
			</div>
		</div>
	</nav>

	<div class="container">
	<?php foreach ($tables as $key => $table): ?>
			<div class="col-md-4 col-sm-4 text-center">
				<div class="form-group">
					<form class="btn-group-vertical" method="POST">
						<span class="btn btn-default"><?=$table->name?></span>
						<?php if (!$table->is_initialized()): ?>
							<button type="submit" class="btn btn-primary" name="create">create</button>
						<?php endif ?>
						<button type="submit" class="btn btn-primary" name="remove">remove</button>
						<button type="submit" class="btn btn-primary" name="recreate">recreate</button>
						<input type="hidden" name="index" value="<?=$key?>">
					</form>
				</div>
			</div>
	<?php endforeach ?>
	</div>

	<script type="text/javascript">
		// var forms = document.forms;

		// function formAjax(e) {
		// 	console.log(e, e.currentTarget);
		// 	var fd = new FormData(e.currentTarget);

		// 	fetch('methods', {body: fd})
		// 		.then(res => res.text)
		// 		.then(console.log)
		// 		.catch(console.error);

		// 	e.preventDefault();
		// 	e.stopPropagation();
		// }
		// for (var i = 0; i < forms.length; i++) {
		// 	forms[i].addEventListener('submit', formAjax);
		// 	console.log(forms[i]);
		// }
	</script>
</body>
</html>