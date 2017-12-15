<?php
	require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                 Clientes
            </h1>
					<ol class="breadcrumb">
					  <li><a href="#">Cadastros Básicos</a></li>
					  <li><a href="#">Clientes</a></li>
					  <li class="active">Cadastro de Clientes</li>
					</ol> 
									
		  </div>
		
         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">
                <div class="card-action">
                    Cadastro de clientes
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

                    <form class="col s12" action="clientes.php" method="post" name="cad_cliente">
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
                        <label for="cnpj">CNPJ</label>
                          <input type="text" id="cnpj" name="cnpj" maxlength="18" onkeypress="mask(this,val_cnpj)" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="endereco">Endereço</label>
                          <input type="text" id="endereco" name="endereco" class="validate" maxlength="255">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <label for="complemento">Complemento</label>
                          <input type="text" id="complemento" name="complemento" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s3">
                            <label for="cod_municipio">Municipio</label>
                            <select id="cod_municipio" name="cod_municipio" class="form-control input-sm">
                              <option value="" disabled selected>Cidade</option>
                              <?php $municipio->montaSelect($row['cod_municipio']); ?>
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3">
                          <label for="telefone">CEP</label>
                          <input type="text" id="cep" name="cep" onkeypress="mask(this,val_cep)" maxlength="9" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3">  
                        <label for="telefone">Telefone</label>
                          <input type="text" id="telefone" name="telefone" maxlength="15" onkeypress="mask(this,val_tel)" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="email">Email</label>
                          <input type="text" maxlength="255" id="email" name="email" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="contato">Contato</label>
                          <input type="text" id="contato" maxlength="255" name="contato" class="validate">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="" disabled selected>Status (Ativo)</option>
                            <option value="A">Ativo</option>
                            <option value="I">Inativo</option>
                          </select>
                        </div>
                      </div>
                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $cliente->id; ?>">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <input type="submit" name="Voltar" value="Voltar" class="waves-effect waves-light btn">
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

<script src="<?php echo app::dominio; ?>view/assets/js/clientes/cliente.js"></script>