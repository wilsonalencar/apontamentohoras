﻿<?php
	require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                 Projetos
            </h1>
					<ol class="breadcrumb">
					  <li><a href="#">Cadastros Básicos</a></li>
					  <li><a href="#">Projetos</a></li>
					  <li class="active">Cadastro de Projetos</li>
					</ol> 
									
		  </div>
		
         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">
                <div class="card-action">
                    Cadastro de Projetos
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

                    <form class="col s12" action="projetos.php" method="post" name="cad_projetos">
                      <div class="row">
                        <div class="col s3">
                        <label for="codigo">Código</label>
                          <input id="codigo" type="text" name="codigo" maxlength="7" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="nome">Nome</label>
                          <input type="text" id="nome" name="nome" class="validate" maxlength="255">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="<?php echo $projeto::STATUS_SISTEMA_ATIVO ?>">Ativo</option>
                            <option value="<?php echo $projeto::STATUS_SISTEMA_INATIVO ?>">Inativo</option>
                          </select>
                        </div>
                      </div>
                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $projeto->id; ?>">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <a href="<?php echo app::dominio; ?>consulta_projetos.php"  class="waves-effect waves-light btn">Voltar</a>
                        </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                        </div>
                      </div>
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
<script src="<?php echo app::dominio; ?>view/assets/js/projetos/projeto.js"></script>