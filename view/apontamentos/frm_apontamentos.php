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
                                  <li class="tab col s3" id="divDespesas"><a href="#despesa">Despesas</a></li>
                              </ul>
                              <br>
                                  <div class="row">
                                    <div class="col s4">
                                        <label for="id_projeto">Projetos : </label>
                                        <select id="id_projeto_busca" onchange="addParam()" name="id_projeto" class="form-control input-sm">
                                          <option value="">Projetos</option>
                                            <?php $projeto->montaSelect($apontamento->id_projeto, $apontamento->id_projeto); ?>
                                        </select>
                                    </div>    
                                    <div class="col s1"></div>
                                    <div class="col s4">
                                        <?php if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                        <label for="id_funcionario_busca">Funcionario: </label> 
                                                <select id="id_funcionario_busca" onchange="addParam()" name="id_funcionario_busca" class="form-control input-sm">
                                                    <option value="">Funcionario</option>
                                                    <?php $funcionario->montaSelect($apontamento->id_funcionario, $apontamento->id_projeto); ?>
                                                </select>
                                        <?php } else { ?>
                                                <?php $profissional = $funcionario->findFuncionario(); ?>
                                                <p><b> Profissional : </b></p>
                                                <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                <input type="hidden" name="id_funcionario_busca" id="id_funcionario_busca" value="<?php echo $profissional['id']; ?>">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>

                            
                                <div id="test1" class="col s12">
                                    <form class="col s12" action="apontamentos.php" method="post" name="cad_apontamentos" id="cad_apontamentos">
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
                                                            <?php if ($row['Aprovado'] != 'Aprovado') { ?>
                                                            <i onclick="excluiApot(this.id, <?php echo $row['id_funcionario']; ?>, <?php echo $row['id_projeto']; ?>)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                            <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <div class="row">
                                        <div class="input-field col s1">
                                        </div>
                                        <input type="hidden" id="action" name="action" value="1">
                                    </div>
                                    </div>
                                    </form>
                                </div>  
                                
                                <!-- Modal de Despesas -->
                                <div id="despesa" class="col s12">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Código do Projeto : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p><?php echo $apontamento->id_projeto; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                            $apontamento->carregaPendencia($apontamento->id_projeto);
                                        ?>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Cliente Reembolsa : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <?php if ($apontamento->Cliente_reembolsa == 'S'){ ?>
                                                    <p> Sim </p>
                                                 <?php } else {?>
                                                    <p> Não </p>
                                                 <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                    <?php
                                        $projetodespesas->lista_Apont($apontamento->id_projeto, $apontamento->id_funcionario);
                                    ?>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr style="background: #c0392b;">
                                                    <th align="left">
                                                        <p style="color : #fff;"> Despesas do projeto </p>
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                        <a href="#" data-toggle="modal" data-target="#ModalDespesas" style="color : #fff;">+</a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Profissional</th>
                                                    <th>Despesa</th>
                                                    <th>Num. Doc.</th>
                                                    <th>Qtd.</th>
                                                    <th>Vlr. Unit.</th>
                                                    <th>Vlr. Total</th>
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
                                                        <td><?php echo $row['Qtd_despesa']; ?></td>
                                                        <td>R$<?php echo $row['Vlr_unit']; ?></td>
                                                        <td>R$<?php echo $row['Vlr_total']; ?></td>
                                                        <td><?php echo $row['Aprovado']; ?></td>
                                                        <td>
                                                        <?php if ($row['Aprovado'] != 'Aprovado') { ?>
                                                            <i onclick="excluiDesp(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Modal de despesas -->
                                <div id="ModalDespesas" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Gerenciamento de Despesas</h4>
                                    </div>

                                    <form class="col s12" id="projetodespesas" action="projetodespesas.php" method="post" name="projetodespesas">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col s4">
                                            <label for="id_projeto">Código do Projeto</label><br />
                                              <?php echo $apontamento->id_projeto; ?>
                                              <input type="hidden" name="id_projeto" value="<?php echo $apontamento->id_projeto; ?>">
                                            </div>
                                            
                                            <div class="col s4">
                                            <label for="nome">Cliente</label><br />
                                                <p class="cliente"><?php echo $apontamento->cliente; ?></p>
                                                <input type="hidden" name="id_cliente" value="<?php echo $apontamento->id_cliente ?>">
                                            </div>

                                            <div class="col s4">
                                            <label for="proposta">Proposta</label><br />
                                              <p class="proposta"><?php echo $apontamento->proposta; ?></p>
                                              <input type="hidden" name="id_proposta" value="<?php echo $apontamento->id_proposta; ?>">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s3">
                                            <label for="Data_despesa">Data da Despesa</label>
                                                <input type="date" id="Data_despesa" name="Data_despesa" class="validate" maxlength="8">
                                            </div>
                                            <div class="col s1"></div>
                                            <div class="col s4">
                                                <label for="id_tipodespesa">Tipo da Despesa</label>
                                                <select id="id_tipodespesa" name="id_tipodespesa" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $tipodespesa->montaSelect(); ?>
                                                </select> 
                                            </div>


                                            <div class="col s3">
                                            <?php if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                                <label for="id_funcionario">Profissional</label>
                                                <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $funcionario->montaSelect($apontamento->id_funcionario, $apontamento->id_projeto); ?>
                                                </select> 
                                            <?php } else { ?>
                                                    <?php $profissional = $funcionario->findFuncionario(); ?>
                                                    <p><b> Profissional : </b></p>
                                                    <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                    <input type="hidden" name="id_funcionario" value="<?php echo $profissional['id']; ?>">
                                            <?php }?>
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
                                                  <input type="number" id="Qtd_despesa" name="Qtd_despesa" class="validate" maxlength="7">
                                                </div>
                                                <div class="col s1"></div>

                                                <div class="col s4">
                                                <label for="Vlr_unit">Valor Total R$ :</label>
                                                  <input type="text" id="vl_total_qtd" readonly="true" maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="5">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>

                                <!-- Modal de apontamento -->
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
                                              <input type="number" id="Qtd_hrs_real" name="Qtd_hrs_real" class="validate" maxlength="7">
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
        <form action="projetodespesas.php" method="post" id="form_projetodespesas">
            <input type="hidden" name="idDesp" id="idDesp">
            <input type="hidden" name="id_projeto" value="<?php echo $apontamento->id_projeto; ?>">
            <input type="hidden" name="id_funcionario" value="<?php echo $apontamento->id_funcionario; ?>">
            <input type="hidden" name="action" id="action" value="4">
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

    $( "#Qtd_despesa" ).blur(function() {
        var money = document.getElementById('Vlr_unit').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * document.getElementById('Qtd_despesa').value;
        money = number_format(money, 2, ',', '.');
        $("#vl_total_qtd").val(money);
    }); 
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