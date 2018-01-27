<?php
	require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                 Funcionarios
            </h1>
					<ol class="breadcrumb">
					  <li><a href="#">Cadastros Básicos</a></li>
					  <li><a href="#">Funcionários</a></li>
					  <li class="active">Cadastro de Funcionários</li>
					</ol> 
									
		  </div>
		
         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">
                <div class="card-action">
                    Cadastro de Funcionários
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

                    <form class="col s12" action="funcionarios.php" method="post" name="cad_funcionarios" id="cad_funcionarios" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col s8">
                        <label for="nome">Nome</label>
                          <input id="nome" type="text" name="nome" maxlength="255" class="validate">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                        <label for="apelido">Apelido</label>
                          <input type="text" id="apelido" name="apelido" class="validate" maxlength="20">
                        </div>

                        <div class="col s4">
                        <label for="data_nascimento">Data de nascimento</label>
                          <input type="date" id="data_nascimento" name="data_nascimento" class="validate" maxlength="8">
                        </div>


                      </div>
                      
                      <div class="row">
                        
                        <div class="col s2">
                            <label for="id_tipocontratacao">Tipo de Contratações</label>
                            <select id="id_tipocontratacao" name="id_tipocontratacao" class="form-control input-sm">
                              <option value="">Selecione</option>
                                <?php $contratacao->montaSelect(); ?>
                            </select>
                        </div>

                        <div class="col s3">
                            <label for="id_perfilprofissional">Perfil Profissional</label>
                            <select id="id_perfilprofissional" name="id_perfilprofissional" class="form-control input-sm">
                              <option value="">Selecione</option>
                                <?php $perfilprofissional->montaSelect(); ?>
                            </select> 
                        </div>

                        <div class="col s3">
                            <label for="id_responsabilidade">Responsabilidade</label>
                            <select id="id_responsabilidade" name="id_responsabilidade" class="form-control input-sm">
                              <option value="">Selecione</option>
                                <?php $responsabilidade->montaSelect(); ?>
                            </select> 
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                        <label for="rg">RG</label>
                          <input type="text" id="rg" name="rg" class="validate" maxlength="12">
                        </div>

                        <div class="col s4">
                        <label for="cpf">CPF</label>
                          <input type="text" onkeypress="mask(this,val_cpf)" id="cpf" name="cpf" class="validate" maxlength="14">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s6">
                        <label for="endereco">Endereço</label>
                          <input type="text" id="endereco" name="endereco" class="validate" maxlength="255">
                        </div>

                        <div class="col s2">
                        <label for="valor_taxa">Valor Taxa</label>
                          <input type="text" id="valor_taxa" name="valor_taxa" onkeypress="moeda(this)" placeholder="R$" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s8">
                        <label for="complemento">Complemento</label>
                          <input type="text" id="complemento" name="complemento" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                            <label for="cod_municipio">Municipio</label>
                            <select id="cod_municipio" name="cod_municipio" class="form-control input-sm">
                              <option value="" disabled selected>Cidade</option>
                              <?php $municipio->montaSelect($row['cod_municipio']); ?>
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                        <label for="cep">CEP</label>
                          <input type="text" id="cep" onkeypress="mask(this,val_cep)" name="cep" class="validate" maxlength="9">
                        </div>
                        <div class="col s4">
                        <label for="telefone">Telefone</label>
                          <input type="text" onkeypress="mask(this,val_tel)" id="telefone" name="telefone" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s8">
                        <label for="email">Email</label>
                          <input type="text" id="email" name="email" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">                        
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="<?php echo $funcionario::STATUS_SISTEMA_ATIVO ?>">Ativo</option>
                            <option value="<?php echo $funcionario::STATUS_SISTEMA_INATIVO ?>">Inativo</option>
                          </select>
                        </div>
                        
                      </div>

                      <div class="row">                        
                        <div class="col s3">
                           <?php 
                              if (!empty($funcionario->id)) { 

                                 $pasta = app::path.'files/curriculo_funcionario';
                                 if (is_dir($pasta)) {
                                    $diretorio = dir($pasta);
                                    while($arquivo = $diretorio -> read()){
                                       if ($funcionario->id == preg_replace("/[^0-9]/", "", $arquivo)) {
                                          echo "<a href='".app::dominio.'files/curriculo_funcionario/'.$arquivo."' target='_blank'>Visualizar Currículo </a>";
                                          echo "<input type='hidden' name='file' id='file' value='".$pasta.'/'.$arquivo."'>";
                                          echo "<input type='hidden' name='excluir_anexo' id='excluir_anexo' value='0'>";
                                          echo " -- <a href='#' onclick='excluir_anexo();'>Excluir </a>";
                                       }
                                    }
                                 }
                              } 
                           ?><br>
                           <label for="Status">Currículo</label>
                          <input type="file" id="curriculo" name="curriculo" class="validate">
                        </div>
                        
                      </div>
                      
                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                      </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $funcionario->id; ?>">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <a href="<?php echo app::dominio ?>consulta_funcionarios.php"  class="waves-effect waves-light btn">Voltar</a>
                        </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" id="btnSubmit" class="waves-effect waves-light btn">
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
<script src="<?php echo app::dominio; ?>view/assets/js/funcionarios/funcionario.js"></script>
