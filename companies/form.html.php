<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php htmlout($pageTitle); ?></title>
	</head>
	<body>
		<h1><?php htmlout($pageTitle); ?></h1>
		<form action="?<?php htmlout($action); ?>" method="post">
			<div>
				<label for="companyname">Company Name: </label> 
				<input type="text" name="companyname" id="companyname" value="<?php htmlout($companyname); ?>">
			</div>
			<div>
				<label for="web">Web: </label> 
				<input type="text" name="web" id="web" value="<?php htmlout($web); ?>">
			</div>
			<div>
				<label for="countryname">Country Name: </label> 
				<select name = "countryname" id="countryname">
					<option value="">Select one</option>
					<?php foreach ($countries as $country): ?>
						<option value="<?php htmlout($country['id']); ?>"
							<?php
								if ($country['id'] == $countryid){
									echo ' selected';
								}
							?>>
							<?php 
								htmlout($country['name']); 
							?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<input type="hidden" name="id" value="<?php htmlout($id); ?>">
				<input type="submit" value="<?php htmlout($button); ?>">
			</div>
		</form>
	</body>
</html>