<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Apontamento de horas
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Apontamento de horas</a></li>
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
                                                <select id="id_projeto_busca" onchange="addParam()" name="id_projeto" class="form-control input-sm">
                                                  <option value="">Projetos</option>
                                                    <?php $projeto->montaSelect($apontamento->id_projeto); ?>
                                                </select>
                                            </div>    
                                            <div class="col s1"></div>
                                            <div class="col s4">
                                                <?php if ($_SESSION['id_perfilusuario'] == '1') { ?>
                                                <label for="id_funcionario_busca">Funcionario: </label> 
                                                        <select id="id_funcionario_busca" onchange="addParam()" name="id_funcionario_busca" class="form-control input-sm">
                                                            <option value="">Funcionario</option>
                                                            <?php $funcionario->montaSelect($apontamento->id_funcionario); ?>
                                                        </select>
                                                <?php } else { ?>
                                                        <?php $profissional = $funcionario->findFuncionario(); ?>
                                                        <p><b> Profissional : </b></p>
                                                        <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                        <input type="hidden" name="id_funcionario_busca" value="<?php echo $profissional['id']; ?>">
                                                <?php }?>
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                    <div  class="col s12">
                                        <div class="table-responsive">
                                        <?php
                                            $apontamento->lista($apontamento->id_projeto);
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
                                                            <a href="#" data-toggle="modal" id="add_button" data-target="#ModalHoras" style="color : #fff; display: none;  ">+</a>
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
                                                    if (!empty($apontamento->array)) {
                                                    foreach($apontamento->array as $row){ 

                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $row['Data_apontamento']; ?></td>
                                                            <td><?php echo $row['Qtd_hrs_real']; ?></td>
                                                            <td><?php echo $row['observacao']; ?></td>
                                                            <td><?php echo $row['Aprovado']; ?></td>
                                                            <td>
                                                            <i onclick="excluiApot(this.id, <?php echo $row['id_funcionario']; ?>, <?php echo $row['id_projeto']; ?>)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
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
                                        <input type="hidden" id="action" name="action" value="1">
                                    </div>

                                    </form>
                                </div>
                     
                                <!-- Modal de despesas -->
                                <div id="ModalHoras" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Gerenciamento de horas</h4>
                                    </div>

                                    <form class="col s12" id="apontamentos" action="apontamentos.php" method="post" name="cad_apontamentos">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col s4">
                                            <label for="id_projeto">Código do Projeto</label><br />
                                              <?php echo $apontamento->id_projeto; ?>
                                              <input type="hidden" name="id_projeto_ap" value="<?php echo $apontamento->id_projeto; ?>">
                                            </div>
                                            <?php
                                            $apontamento->carregaPendencia($apontamento->id_projeto);
                                            ?>
                                            <div class="col s4">
                                            <label for="nome">Cliente</label><br />
                                                <p class="cliente"><?php echo $apontamento->cliente; ?></p>
                                                <input type="hidden" name="id_cliente" value="<?php echo $apontamento->id_cliente; ?>">
                                            </div>

                                            <div class="col s4">
                                            <label for="proposta">Proposta</label><br />
                                              <p class="proposta"><?php echo $apontamento->proposta; ?></p>
                                              <input type="hidden" name="id_proposta" value="<?php echo $apontamento->id_proposta; ?>">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s3">
                                            <label for="Data_apontamento">Data Apontamento</label>
                                                <input type="date" id="Data_apontamento" name="Data_apontamento" class="validate" maxlength="8">
                                            </div>
                                            <div class="col s1"></div>
                                            <div class="col s4">
                                            <label for="Qtd_hrs_real">Quantidade de horas</label>
                                              <input type="text" id="Qtd_hrs_real" name="Qtd_hrs_real" class="validate" maxlength="7">
                                            </div>
                                          </div>
                                            <div class="row">
                                                <div class="col s8">
                                                <label for="observacao">Observação</label>
                                                  <input type="text" id="observacao" name="observacao" class="validate" maxlength="255">
                                                </div>
                                            </div>
                          
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="id_funcionario_ap" value="<?php echo $apontamento->id_funcionario; ?>">
                                        <input type="hidden" name="action" value="1">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>
                            </div>


        <div class="clearBoth"></div>
        <form action="apontamentos.php" method="post" id="form_busca">
            <input type="hidden" name="id_projeto_ap" id="id_projeto_ap">
            <input type="hidden" name="id_funcionario_ap" id="id_funcionario_ap">
            <input type="hidden" name="action" value="2">
        </form>
        <form action="apontamentos.php" method="post" id="form_apontamentohoras">
            <input type="hidden" name="funcionar_projeto_concat" id="funcionar_projeto_concat">
            <input type="hidden" name="id" id="idApont">
            <input type="hidden" name="action" id="action" value="3">
        </form>
    </div>

  
<?php
require_once(app::path.'/view/footer.php');
?>

<script>


$(document).ready(function(){
    if ($('#id_funcionario_busca').val() > 0 && $('#id_projeto_busca').val() > 0){
        $("#add_button").css("display", "block");
    }
});


function addParam(){
    var id_projeto = document.getElementById("id_projeto_busca").value;
    var id_funcionario = document.getElementById("id_funcionario_busca").value;
    if (id_projeto > 0) {
        document.getElementById('id_projeto_ap').value = id_projeto;
    }
    if (id_funcionario > 0) {
        document.getElementById('id_funcionario_ap').value = id_funcionario;
    }
    document.getElementById('form_busca').submit();
}
function excluiApot(idApont, idFuncionario, idProjeto) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (idApont > 0) {    
        document.getElementById('idApont').value = idApont;
        document.getElementById('funcionar_projeto_concat').value = idFuncionario+'-'+idProjeto;
        document.getElementById('form_apontamentohoras').submit();
    }   
}
</script>