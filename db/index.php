<?php
include_once 'auth.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'TABLES.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DB manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<?php foreach ($TABLES as $key => $table): ?>
			<form class="col-md-3 col-sm-4 text-center" method="POST" action="api.php">
				<input type="hidden" name="index" value="<?=$key?>">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td>
								<strong class="h3">
									<?=$table->name?>
								</strong>
							</td>
						</tr>
						<tr>
							<td>
								<?php if (!$table->is_initialized()): ?>
									<button type="submit" class="btn btn-success form-control" name="create">CREATE</button>
								<?php endif ?>
							</td>
						</tr>
						<tr>
							<td>
								<button type="submit" class="btn btn-danger form-control" name="remove">DROP</button>
							</td>
						</tr>
						<tr>
							<td>
								<button type="submit" class="btn btn-primary form-control" name="recreate">reCREATE</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
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