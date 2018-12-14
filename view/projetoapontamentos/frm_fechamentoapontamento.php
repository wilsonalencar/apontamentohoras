<?php
	require_once(app::path.'view/header.php');
?>
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                Fechar Apontamentos
            </h1>
					<ol class="breadcrumb">
					  <li><a href="#">Projetos</a></li>
					  <li class="active">Fechar Apontamento</li>
					</ol> 									
		  </div>

         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">
                <div class="card-action">
                    Fechamento de Apontamentos
                </div>
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
                    <form class="col s12" action="fechamentoapontamentos.php" method="post" name="fechamentoapontamentos">
                      <div class="row">
                        
                        <?php  if (!empty($msg)) {
                          if ($msg == 'Fechamento Apontamento já realizado para o Período, deseja executar novamente? Se sim, clique novamente no botão calcular') {
                            echo "<input type='hidden' name='create_request' value=1>";
                          }
                        } ?>
                        
                        <div class="col s1">
                          <label for="periodo_libera">Período</label>
                          <input type="text" id="periodo" name="periodo" value="<?php echo $fechamentoapontamento->periodo; ?>" class="validate" maxlength="7">
                        </div>
                      </div>
                      <br />
                      <div class="row">
                          <input type="hidden" id="action" name="action" value="1">
                          <div class="input-field col s1">
                              <button type="submit" class="btn btn-success" > Calcular</button>
                          </div>
                      </div>
                    </form>

                	<div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
      </div>
      <form action="fechamentoapontamentos.php" method="post" id="form_busca">
        <input type="hidden" name="periodo" id="periodo_b">
        <input type="hidden" name="action" value="2">
      </form>
	
<?php
	require_once(app::path.'/view/footer.php');
?>