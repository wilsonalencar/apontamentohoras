<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Apontamento
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Apontamento</a></li>
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
                        <div class="col-md-12 col-sm-12">
                           <div class="col-sm-12">
                              <ul class="tabs">
                                  <li class="tab col s3"><a class="active" href="#test1">Horas</a></li>
                                  <li class="tab col s3 disabled" id="divDespesas"><a href="#despesa">Despesas</a></li>
                              </ul>
                            </div>

                            <div class="clearBoth">
                                <br/>
                            </div>
                            
                                <div id="test1" class="col s12">
                                    <form class="col s12" action="apontamentos.php" method="post" name="cad_apontamentos" id="cad_apontamentos">
                                        <div class="row">
                                            <div class="col s4">
                                                <label for="id_projeto">Projetos : </label>
                                                <select id="id_projeto" name="id_projeto" class="form-control input-sm">
                                                  <option value="">Projetos</option>
                                                    <?php $projeto->montaSelect(); ?>
                                                </select>
                                            </div>    
                                            <div class="col s1"></div>
                                            <div class="col s4">
                                                <?php if ($_SESSION['id_perfilusuario'] == '1') { ?>
                                                <label for="id_funcionario">Funcionario: </label> 
                                                        <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                            <option value="">Funcionario</option>
                                                            <?php $funcionario->montaSelect(); ?>
                                                        </select>
                                                <?php } else { ?>
                                                        <?php $profissional = $funcionario->findFuncionario(); ?>
                                                        <p><b> Profissional : </b></p>
                                                        <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                        <input type="hidden" name="id_funcionario" value="<?php echo $profissional['id']; ?>">
                                                <?php }?>
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    <div  class="col s12">
                                        <div class="table-responsive">
                                        <?php
                                            $projetodespesas->lista($apontamento->id_projeto);
                                        ?>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> Apontamento das horas </p>
                                                        </th>
                                                        <th align="center">
                                                        </th>
                                                        <th align="center">
                                                        </th>
                                                        <th></th>
                                                        <th align="center">
                                                            <a href="#" data-toggle="modal" data-target="#ModalHoras" style="color : #fff;">+</a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Qtd. Horas</th>
                                                        <th>Observação</th>
                                                        <th>Status</th>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    if (!empty($projetodespesas->array)) {
                                                    foreach($projetodespesas->array as $row){ ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $row['Data_despesa']; ?></td>
                                                            <td><?php echo $row['NomeFuncionario']; ?></td>
                                                            <td><?php echo $row['NomeDespesa']; ?></td>
                                                            <td><?php echo $row['Num_doc']; ?></td>
                                                            <td>
                                                            <i onclick="excluiDesp(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                            </td>
                                                        </tr>
                                                    <?php } }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s1">
                                        </div>
                                        <input type="hidden" id="id" name="id" value="<?php echo $apontamento->id; ?>">
                                        <input type="hidden" id="action" name="action" value="1">
                                        <div class="col s5"></div>
                                        <div>
                                            <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                                        </div>
                                    </div>

                                    </form>
                                </div>
                     
                                <!-- Modal de despesas -->
                                <div id="ModalHoras" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Gerenciamento de Despesas</h4>
                                    </div>

                                    <form class="col s12" id="projetodespesas" action="projetodespesas.php" method="post" name="projetodespesas">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col s4">
                                            <label for="id_projeto">Código do Projeto</label><br />
                                              <?php echo $projeto->id; ?>
                                              <input type="hidden" name="id_projeto" value="<?php echo $projeto->id; ?>">
                                            </div>
                                            
                                            <div class="col s4">
                                            <label for="nome">Cliente</label><br />
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></p>
                                                <input type="hidden" name="id_cliente" value="<?php echo $projeto->id_cliente; ?>">
                                            </div>

                                            <div class="col s4">
                                            <label for="proposta">Proposta</label><br />
                                              <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                              <input type="hidden" name="id_proposta" value="<?php echo $projeto->id_proposta; ?>">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s3">
                                            <label for="Data_despesa">Data da Despesa</label>
                                                <input type="date" id="Data_despesa" name="Data_despesa" class="validate" maxlength="8">
                                            </div>
                                            <div class="col s1"></div>
                                            <div class="col s2">
                                                <label for="id_tipodespesa">Tipo da Despesa</label>
                                                <select id="id_tipodespesa" name="id_tipodespesa" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $tipodespesa->montaSelect(); ?>
                                                </select> 
                                            </div>
                                            <div class="col s3">
                                                <label for="id_funcionario">Profissional</label>
                                                <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $funcionario->montaSelect(); ?>
                                                </select> 
                                            </div>
                                          </div>
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="Num_doc">Nº Doc</label>
                                                  <input type="text" id="Num_doc" name="Num_doc" class="validate" maxlength="7">
                                                </div>
                                                <div class="col s1"></div>
                                                <div class="col s4">
                                                <label for="Vlr_unit">Valor Unitário R$ :</label>
                                                  <input type="text" onkeypress="moeda(this)" id="Vlr_unit" name="Vlr_unit" class="validate" maxlength="255">
                                                </div>
                                            </div>
                          
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="Qtd_despesa">Quantidade</label>
                                                  <input type="text" id="Qtd_despesa" name="Qtd_despesa" class="validate" maxlength="7">
                                                </div>
                                                <div class="col s1"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="1">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>
                            </div>


        <div class="clearBoth"></div>
        <form action="projetodespesas.php" method="post" id="form_projetodespesas">
            <input type="hidden" name="idDesp" id="idDesp">
            <input type="hidden" name="action" id="action" value="3">
            <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $apontamento->id_projeto; ?>">
        </form>
    </div>

  
<?php
  require_once(app::path.'/view/footer.php');
?>

<script>

function excluiDesp(idDesp) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (idDesp > 0) {
        document.getElementById('idDesp').value = idDesp;
        document.getElementById('form_projetodespesas').submit();
    }   
}

</script>