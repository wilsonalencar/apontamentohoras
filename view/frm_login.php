<?php
	require_once(app::path.'view/header.php');
?>

<body>
	<div id="page-inner">
    	<div class="row" style="margin-top: 10%;">
    		<div class="col-lg-4">
			</div>
    		<div class="col-lg-4">
    			<div class="card" >
    				<div class="card-content" >
    				<?php	
						if (!empty($msg)) { 
						  if (!$success) {
						    echo "<div class='alert alert-danger'>
						            <strong>ERRO !</strong> $msg
						          </div>";
						  }                           
						}
						?>
						<form action="login.php" name="login" method="post">
						<div class="row">
							<div class="col s3"></div>
								<div class="col s3">
									<img src="<?php echo app::dominio; ?>view/assets/img/logo-login.png">	
								</div>
							<div class="col s3"></div>
						</div>
							<div class="row">
				                <div class="col s12">
				                <label for="login">Login</label>
				             	   <input type="text" name="login" maxlength="255" class="validate">
				                </div>
				            </div>
				            <div class="row">
				                <div class="col s12">
				                <label for="senha">Senha</label>
				             	   <input type="password" name="senha" maxlength="255" class="validate">
				                </div>
				            </div>
				            <div class="row">
				            	<div class="col s5"></div>
								<div class="col s1">
					               <input type="submit" name="btn" value="Logar" id="submit" class="waves-effect waves-light btn">
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
			</div>
		</div>
	</div>

<?php
	require_once(app::path.'view/footer.php');
?>