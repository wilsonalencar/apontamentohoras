<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Bravo - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo app::dominio; ?>view/assets/css/main.css">
</head>
<body>
<div class="container">
  <div class="top">
    <img src="<?php echo app::dominio; ?>view/assets/img/logo.png" class="img img-responsive logo-login center-block"/>
    <p>Gestão de projetos</p>
  </div>
  	<form action="login.php" name="login" method="post">
		<div id="login-box">
			<div class="logo">
				<h1 class="logo-caption"><span class="tweak"></span>Login</h1>
			</div>

			<div class="controls">
			<?php	
				if (!empty($msg)) { 
				 if (!$success) {
				   echo "<div class='alert alert-danger'>
				           <strong>ERRO !</strong> $msg
				         </div>";
				 }                           
				}
				?>
				<input type="text" name="login" placeholder="Usuário" class="form-control" />
				<input type="password" name="senha" placeholder="Senha" class="form-control user" />
				<button type="submit" class="btn btn-default btn-block btn-custom">Entrar</button>
			</div>
		</div>
	</form>
</div>
<div id="particles-js"></div>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>-->
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="<?php echo app::dominio; ?>view/assets/js/main.js"></script>
</body>
</html>
