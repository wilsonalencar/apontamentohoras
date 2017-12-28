<?php
	require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                 Resetando Senha
            </h1>
					<ol class="breadcrumb">
					  <li class="active">Reset na Senha</li>
					</ol> 
		  </div>
		
         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">

                <div class="card-content">
                                  <?php
                      if (!empty($msg)) { 

                        if ($success) {
                            echo "<div class='alert alert-success'>
                                    <strong>Sucesso !</strong> $msg
                                  </div>";
                          }

                          if (!$success) {
                            echo "<div class='alert alert-danger'>
                                    <strong>ERRO !</strong> $msg
                                  </div>";

                          }                           
                        }
                     ?> 
                    <form class="col s12" action="reset_senha.php" method="post" name="reset">
                      <div class="row">
                        <div class="col s3">
                        <label for="senha">Senha</label>
                          <input id="senha" type="password" name="senha" maxlength="255" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3">
                        <label for="nome">Repetir a Senha</label>
                          <input type="password" id="senha2" name="senha2" class="validate" maxlength="255">
                        </div>
                      </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                        </div>
                        <input type="hidden" name="action" value="1">
                      </form>

                	<div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
      </div>

	
<?php
	require_once(app::path.'/view/footer.php');
?>
<script src="<?php echo app::dominio; ?>view/assets/js/usuarios/reset_senha.js"></script>