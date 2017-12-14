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
                        <div class="input-field col s3">
                        <i class="material-icons prefix">list</i>
                          <input id="codigo" type="text" name="codigo" class="validate">
                          <label for="codigo">Código</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                        <i class="material-icons prefix">perm_identity</i>
                          <input type="text" id="nome" name="nome" class="validate">
                          <label for="nome">Nome</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">
                        <i class="material-icons prefix">navigation</i>
                          <input type="text" id="cnpj" name="cnpj" class="validate">
                          <label for="cnpj">CNPJ</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                        <i class="material-icons prefix">navigation</i>
                          <input type="text" id="endereco" name="endereco" class="validate">
                          <label for="endereco">Endereço</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                        <i class="material-icons prefix">navigation</i>
                          <input type="text" id="complemento" name="complemento" class="validate">
                          <label for="complemento">Complemento</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">
                            <select id="cod_municipio" name="cod_municipio" class="form-control input-sm">
                              <option value="" disabled selected>Cidade</option>
                              <option value="SP">São Paulo</option>
                              <option value="RJ">Rio de Janeiro</option>
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">
                          <i class="material-icons prefix">navigation</i>
                          <input type="text" id="cep" name="cep" class="validate">
                          <label for="cep">CEP</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">  
                        <i class="material-icons prefix">phone</i>
                          <input type="text" id="telefone" name="telefone" class="validate">
                          <label for="telefone">Telefone</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                        <i class="material-icons prefix">mail</i>
                          <input type="text" id="email" name="email" class="validate">
                          <label for="email">Email</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                          <input type="text" id="contato" name="contato" class="validate">
                          <label for="contato">Contato</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="" disabled selected>Status (Ativo)</option>
                            <option value="A">Ativo</option>
                            <option value="I">Inativo</option>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="id" name="id" value="6">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <input type="submit" name="Voltar" value="Voltar" class="waves-effect waves-light btn">
                        </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" class="waves-effect waves-light btn">
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

<script>
var id = <?= $cliente->id; ?>;
if (id > 0) {
   getDataCliente(id);
}

function getDataCliente(id)
{
   $.ajax({
        url : 'clientes.php',
        type: 'post',
        dataType: 'JSON',
        data:
        {
            'action':2,
            'id':id
        },
        success: function(d)
        {
            if (!d.success) {
               alert(d.msg);
               return false;
            }

            $("#id").val(d.data.id);
            $("#codigo").val(d.data.codigo);
            $("#complemento").val(d.data.complemento);
            $("#contato").val(d.data.contato);
            $("#email").val(d.data.email);
            $("#endereco").val(d.data.endereco);
            $("#status").val(d.data.status);
            $("#nome").val(d.data.nome);
            $("#telefone").val(d.data.telefone);
            $("#cod_municipio").val(d.data.cod_municipio);
            $("#cnpj").val(d.data.cnpj);
            $("#cep").val(d.data.cep);
        }
    });
}
</script>