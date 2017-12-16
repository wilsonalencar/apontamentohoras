<?php
	require_once(app::path.'view/header.php');
?>

<body>
	<?php
	if (!empty($msg)) {
		if (!$success) {
			echo $msg;
		}
	}
	?>
	<div id="page-inner"> 
    	<div class="row">
    		<div class="col-lg-3">
    			<div class="card">
    				<div class="card-content">
						<form action="login.php" name="login" method="post">	
							<div class="row">
				                <div class="col s11">
				                <label for="login">Login</label>
				             	   <input type="text" name="login" maxlength="255" class="validate">
				                </div>
				            </div>
				            <div class="row">
				                <div class="col s11">
				                <label for="senha">Senha</label>
				             	   <input type="password" name="senha" maxlength="255" class="validate">
				                </div>
				            </div>
				            <div class="row">
								<div class="col s1">
					               <input type="submit" name="login" value="Logar" id="submit" class="waves-effect waves-light btn">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
	require_once(app::path.'view/footer.php');
?>