<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<?php
	if (!empty($msg)) {
		if (!$success) {
			echo $msg;
		}
	}
	?>
	<form action="login.php" name="login" method="post">
		<input type="text" name="login" maxlength="100">
		<input type="password" name="senha" maxlength="100">
		<input type="submit" value="Logar" maxlength="100">
	</form>
</body>
</html>