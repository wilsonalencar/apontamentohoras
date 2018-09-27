<?php
  require_once(app::path.'view/header.php');
?>
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Apontamentos
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Apontamentos</a></li>
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
                                  <li class="tab col s3"><a href="#test1">Horas</a></li>
                                  <li class="tab col s3 <?php if (empty($apontamento->id_funcionario)) {
                                      echo 'disabled';
                                  } ?>" id="divDespesas"><a href="#despesa">Despesas</a></li>
                              </ul>
                              <br>
                                  <div class="row">
                                    <div class="col s4">
                                        <?php if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                        <label for="id_funcionario_busca">Funcionario: </label> 
                                                <select id="id_funcionario_busca" onchange="alterar_periodo()" name="id_funcionario_busca" class="form-control input-sm">
                                                    <option value="">Funcionario</option>
                                                    <?php 
                                                        $funcionario->montaSelect($apontamento->id_funcionario, $apontamento->id_projeto); 
                                                    ?>
                                                </select>
                                        <?php } else { ?>
                                                <?php 
                                                    $profissional = $funcionario->findFuncionario();
                                                    $id_funcionario = $profissional['id']; 
                                                ?>
                                                <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                <input type="hidden" name="id_funcionario_busca" id="id_funcionario_busca" value="<?php echo $profissional['id']; ?>">
                                        <?php }?>
                                    </div>    
                                    <div class="col s1"></div>
                                    <div class="col s1">
                                        
                                    <label for="id_funcionario_busca">Período: </label> 
                                      <input type="text" id="periodo_busca_form" name="periodo_busca_form" onchange="alterar_periodo()" value="<?php echo $periodo_busca; ?>" class="validate" maxlength="7">
                                    </div>
                                    
                                    <?php
                                        $apontamento->lista($periodo_busca, $id_funcionario);
                                    ?>
                                    <div class="col s1"></div>
                                    <div class="col s4">
                                    <?php 
                                    $horasaprovadas = 0;
                                    $horaslancadas = 0;
                                    if (!empty($apontamento->array)) { 
                                        $horasaprovadas = $apontamento->array['horasaprovadas'];
                                        $horaslancadas = $apontamento->array['horaslancadas'];
                                    } ?>
                                        <label>Horas </label><br/>
                                        Aprovadas  : <?php echo $horasaprovadas; ?><br/>
                                        Lançadas : <?php echo $horaslancadas; ?>
                                        </div>
                                    
                                </div>
                            </div>

                                <a href="#" data-toggle="modal" style="display:none;" id="openmodal" data-target="#ModalMotivo"></a>
                                <a href="#" data-toggle="modal" style="display:none;" id="openmodalObs" data-target="#ModalObservacao"></a>
                                <a href="#" data-toggle="modal" style="display:none;" id="editmodalObs" data-target="#EditModalObservacao"></a>
                                <a href="#" data-toggle="modal" style="display:none;" id="openmodaledition" data-target="#ModalEdicao"></a>
                                <div id="test1" class="col s12">
                                    <form class="col s12" action="apontamentos.php" method="post" name="cad_apontamentos">
                                    <div  class="col s12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" style="font-size: 10px">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> Apontamentos </p>
                                                        </th>
                                                        <th align="center">
                                                        </th>
                                                        <th align="center">
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th align="center">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Projeto</th>
                                                        <th>Data</th>
                                                        <th>Entrada 1</th>
                                                        <th>Saída 1</th>
                                                        <th>Entrada 2</th>
                                                        <th>Saída 2</th>
                                                        <th>Qtd. Horas</th>
                                                        <th>Atividade</th>
                                                        <th>Chamado</th>
                                                        <th>Tipo de horas</th>
                                                        <th>Status</th>
                                                        <td></td>
                                                    </tr>
	                                                <tr class="odd gradeX" id="trFormHoras">
	                                                <form class="col s12" id="projetodespesas" action="projetodespesas.php" method="post" name="projetodespesas">
	                                                <input type="hidden" name="id_projeto_ap" value="<?php echo $apontamento->id_projeto; ?>">
	                                                <input type="hidden" name="id_cliente" value="<?php echo $apontamento->id_cliente ?>">
	                                                <input type="hidden" name="id_proposta" value="<?php echo $apontamento->id_proposta; ?>">
                                                        <td>
                                                            <select id="id_projeto_busca" onchange="addParam()" name="id_projeto" class="form-control">
                                                              <option value="">Selecione um Projeto</option>
                                                                <?php $projeto->montaSelect(0, false, $apontamento->id_funcionario); ?>
                                                            </select>
                                                        </td>
	                                                    <td>
	                                                        <input type="date" id="Data_apontamento" name="Data_apontamento" class="validate" maxlength="8">
	                                                    </td>
	                                                    <td>
	                                                        <input type="time" id="Entrada_1" name="Entrada_1" class="validate calculate" maxlength="5">
	                                                    </td>
	                                                    <td>
	                                                        <input type="time" id="Saida_1" name="Saida_1" class="validate calculate" maxlength="5">
	                                                    </td>
	                                                    <td>
	                                                        <input type="time" id="Entrada_2" name="Entrada_2" class="validate calculate" maxlength="5">
	                                                    </td> 
	                                                    <td>
	                                                        <input type="time" id="Saida_2" name="Saida_2" class="validate calculate" maxlength="5">
	                                                    </td>
	                                                    <td>
	                                                        <input type="number" id="Qtd_hrs_real_exibe" placeholder="00:00" readonly="true" class="validate" maxlength="2">
	                                                        <input type="hidden" id="Qtd_hrs_real" name="Qtd_hrs_real" class="validate">
	                                                    </td>
	                                                    <td style="width: 20%"> 
                                                            <input type="text" id="observacao" name="observacao" class="validate" maxlength="250">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="chamado" name="chamado" class="validate" maxlength="20">
                                                        </td>
                                                        <td>
                                                        <div>
                                                            <input type="radio" id="normal" name="tipo_horas" value="N" checked/>
                                                            <label for="normal">N</label>

                                                            <input type="radio" id="banco" name="tipo_horas" value="B" />
                                                            <label for="banco">B</label>
                                                        </div>
                                                        </td>
	                                                    <td>
	                                                        Não Aprovado
	                                                        <input type="hidden" name="id_funcionario_ap" value="<?php echo $id_funcionario; ?>">
	                                                        <input type="hidden" name="action" value="1">
	                                                    </td>
	                                                    <td><button type="submit" class="btn btn-success" style="display:none" id="buttonHoras" onclick="escondehoras()">+</button></td>
	                                                </form>
	                                                </tr>
                                                    <?php
                                                    if (!empty($apontamento->array)) {
                                                        unset($apontamento->array['horasaprovadas']);
                                                        unset($apontamento->array['horaslancadas']);
                                                    foreach($apontamento->array as $row){ 
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td style="width: 12%"><?php echo $row['nome_projeto']; ?></td>
                                                            <td><?php echo $row['Data_apontamento']; ?></td>
                                                            <td><?php echo $row['Entrada_1']; ?></td>
                                                            <td><?php echo $row['Saida_1']; ?></td>
                                                            <td><?php echo $row['Entrada_2']; ?></td>
                                                            <td><?php echo $row['Saida_2']; ?></td>
                                                            <td><?php echo $row['Qtd_hrs_real']; ?></td>
                                                            <td><?php echo $row['observacao']; ?></td>
                                                            <td><?php echo $row['chamado']; ?></td>
                                                            <td><?php
                                                            if ($row['tipo_horas'] == 'N') {
                                                                echo "Normais";
                                                            }
                                                            if ($row['tipo_horas'] == 'B') {
                                                                echo "Banco de Horas";
                                                            }
                                                            ?></td>
                                                            <td><?php echo $row['Aprovado']; ?></td>
                                                            <td style="width: 8%;">
                                                            <?php if ($row['Aprovado'] != 'Aprovado') { ?>
                                                                <a onclick="MotivosModal('<?php echo $row['motivo'];?>')">
                                                                    <i class="material-icons">expand</i>
                                                                </a>
                                                            <?php } ?>

                                                            <?php if ($row['Aprovado'] != 'Aprovado' || $_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                                            <i onclick="excluiApot(this.id, <?php echo $row['id_funcionario']; ?>, <?php echo $row['id_projeto']; ?>)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                            <?php } ?>

                                                            <?php if ($row['Aprovado'] != 'Aprovado') { 
                                                            $dataapontamento = str_replace('/', '-', $row['Data_apontamento']);
                                                            $dataapontamento = date('Y-m-d', strtotime($dataapontamento));
                                                            ?>
                                                            <i onclick="EditModal('<?php echo $row['id']; ?>','<?php echo $row['Entrada_1']; ?>','<?php echo $row['Saida_1']; ?>','<?php echo $row['Entrada_2']; ?>','<?php echo $row['Saida_2']; ?>','<?php echo $row['Qtd_hrs_real']; ?>','<?php echo $row['observacao']; ?>','<?php echo $row['chamado']; ?>','<?php echo $row['id_projeto']; ?>','<?php echo $row['tipo_horas']; ?>','<?php echo $dataapontamento; ?>')" class="material-icons">edit</i>
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
                                <?php
                                if (!empty($_GET['id_funcionario_ap'])) {
                                    $id_funcionario = $_GET['id_funcionario_ap'];
                                }
                                ?>
                                <!-- Modal de Despesas -->
                                <div id="despesa" class="col s12">
                                    <?php
                                        $apontamento->carregaPendencia($apontamento->id_projeto);
                                    ?>
                                    <div class="table-responsive">
                                    <?php
                                        $projetodespesas->lista_Apont($periodo_busca, $id_funcionario);
                                    ?>
                                        <table class="table table-hover" style="font-size: 12px">
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
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                    <th align="center">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Projeto</th>
                                                    <th>Data</th>
                                                    <th>Profissional</th>
                                                    <th>Despesa</th>
                                                    <th>Num. Doc.</th>
                                                    <th>Reembolso?</th>
                                                    <th>Qtd.</th>
                                                    <th>Vlr. Unit.</th>
                                                    <th>Vlr. Total</th>
                                                    <th>Observações</th>
                                                    <th>Status</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <form class="col s12" id="projetodespesas" action="projetodespesas.php" method="post" name="projetodespesas">
                                                    <input type="hidden" name="periodo_busca" value="<?php echo $periodo_busca; ?>">
                                                    <input type="hidden" name="funcionario" value="<?php echo $id_funcionario; ?>">
                                                    <td>
                                                        <select name="id_projeto" class="form-control">
                                                          <option value="">Selecione um Projeto</option>
                                                            <?php $projeto->montaSelect(0, false, $apontamento->id_funcionario); ?>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="date" id="Data_despesa" name="Data_despesa" class="validate" maxlength="8">
                                                    </td>

                                                    <td width="10%">
                                                         <?php if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                                            <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                              <option value="">Selecione</option>
                                                                <?php $funcionario->montaSelect($apontamento->id_funcionario, $apontamento->id_projeto); ?>
                                                            </select> 
                                                        <?php } else { ?>
                                                                <br />
                                                                <?php $profissional = $funcionario->findFuncionario(); ?>
                                                                <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                                                <input type="hidden" name="id_funcionario" value="<?php echo $profissional['id']; ?>">
                                                        <?php }?>
                                                    </td>
                                                    <td width="10%">
                                                        <select id="id_tipodespesa" name="id_tipodespesa" class="form-control input-sm">
                                                          <option value="">Selecione</option>
                                                            <?php $tipodespesa->montaSelect(); ?>
                                                        </select> 
                                                    </td>
                                                    <td>
                                                        <input type="text" id="Num_doc" name="Num_doc" class="validate" maxlength="7">
                                                    </td>
                                                    <td>
                                                        <input type="radio" checked id="reembolso_s" name="reembolso" value="S"/>
                                                        <label for="reembolso_s">Sim</label><br/>
                                                        <input type="radio" id="reembolso_n" name="reembolso" value="N" />
                                                        <label for="reembolso_n">Não</label>
                                                    </td>

                                                    <td width="5%">
                                                        <input type="number" id="Qtd_despesa" name="Qtd_despesa" class="validate" maxlength="7">
                                                    </td>
                                                    <td width="10%">
                                                        <input type="text" onkeypress="moeda(this)" id="Vlr_unit" name="Vlr_unit" class="validate" maxlength="255">
                                                    </td>
                                                    <td width="10%">
                                                        <input type="text" id="vl_total_qtd" readonly="true" maxlength="255">
                                                    </td>
                                                    <td width="10%">
                                                        <input type="text" name="observacao" id="observacao" maxlength="255">
                                                    </td>
                                                    <td>
                                                    <input type="hidden" name="action" value="5">
                                                        Não Aprovado
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-success" id="buttonDespesas" style="display:block" onclick="escondedespesas()">+</button>
                                                    </td>
                                                    </form>
                                                </tr>
                                                <?php
                                                if (!empty($projetodespesas->array)) {
                                                foreach($projetodespesas->array as $row){ ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['nome_projeto']; ?></td>
                                                        <td><?php echo $row['Data_despesa']; ?></td>
                                                        <td><?php echo $row['NomeFuncionario']; ?></td>
                                                        <td><?php echo $row['NomeDespesa']; ?></td>
                                                        <td><?php echo $row['Num_doc']; ?></td>
                                                        <td><?php
                                                            if ($row['reembolso'] == 'S') {
                                                                echo "Com Reembolso";
                                                            }
                                                            if ($row['reembolso'] == 'N') {
                                                                echo "Sem Reembolso";
                                                            }
                                                            ?></td>
                                                        <td><?php echo $row['Qtd_despesa']; ?></td>
                                                        <td>R$<?php echo $row['Vlr_unit']; ?></td>
                                                        <td>R$<?php echo $row['Vlr_total']; ?></td>
                                                        <td>
                                                        <?php if (!empty($row['observacao'])) { ?>
                                                            <a onclick="ObservacaoModal('<?php echo $row['observacao'];?>')">Exibir </a> / 
                                                        <?php } ?>
                                                        <a onclick="EditObservacaoModal('<?php echo $row['observacao'];?>','<?php echo $row['id'];?>')">Editar</a>
                                                        </td>
                                                        <td><?php echo $row['Aprovado']; ?></td>
                                                        <td style="width: 5%">
                                                        <?php if ($row['Aprovado'] != 'Aprovado') { ?>
                                                            <a onclick="MotivosModal('<?php echo $row['motivo'];?>')">
                                                                <i class="material-icons">expand</i>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if ($row['Aprovado'] != 'Aprovado' || $_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                                                            <i onclick="excluiDesp(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

        <div id="ModalMotivo" class="modal" style="height: 30%">
            <div class="modal-header">
                <h4 class="modal-title">Motivo</h4>
            </div>    
            <div class="modal-body">
                <p class="motivo" id="motivo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>            
            </div>
        </div>

        <div id="ModalObservacao" class="modal" style="height: 30%">
            <div class="modal-header">
                <h4 class="modal-title">Observacao</h4>
            </div>    
            <div class="modal-body">
                <p class="observacaotxt" id="observacaotxt"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>            
            </div>
        </div>
        
        <div id="EditModalObservacao" class="modal" style="height: 30%">
            <form action="projetodespesas.php" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edição</h4>
                </div>    
                <div class="modal-body">
                        <input type="text" name="observacao" class="form-control" id="observacaoinput">
                        <input type="hidden" name="idDesp" id="idobservacao">
                        <input type="hidden" name="action" value="6">
                        <input type="hidden" name="id_funcionario" value="<?php echo $apontamento->id_funcionario ?>">
                        <input type="hidden" name="id_projeto" value="<?php echo $apontamento->id_projeto ?>">
                        <input type="hidden" name="periodo_busca" value="<?php echo $periodo_busca; ?>">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success">            
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>            
                </div>
            </form>
        </div>

        <div id="ModalEdicao" class="modal fade" >
            <div class="modal-header">
                <h4 class="modal-title">Edição de Apontamento</h4>
            </div>
            <form action="apontamentos.php" method="post">
                <div class="modal-content">                        
                    <input type="hidden" id="id_edit" name="id">
                    <input type="hidden" name="action" value="1">

                    <div class="col s12">
                        <div class="col s6">
                            <label for="id_projeto">Projeto</label>
                            <select id="id_projeto_edit" name="id_projeto" class="form-control">
                              <option value="">Selecione um Projeto</option>
                                <?php $projeto->montaSelect(0, false, $apontamento->id_funcionario); ?>
                            </select>
                        </div>
                        <div class="col s6">
                            <label for="data_apontamento">Data Apontamento</label>
                            <input type="date" id="data_apontamento_e" name="Data_apontamento" class="validate" maxlength="8">
                        </div>
                    </div>
                    <br />
                    <div class="col s12">
                        <div class="col s6">
                            <label for="Entrada_1"> Entrada 1 </label>
                            <input type="time" id="Entrada_1_e" name="Entrada_1" class="validate calculate_e" maxlength="5">
                        </div>
                        <div class="col s6">
                            <label for="Saida_1"> Saída 1 </label>
                            <input type="time" id="Saida_1_e" name="Saida_1" class="validate calculate_e" maxlength="5">
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="col s6">
                            <label for="Entrada_2"> Entrada 2 </label>
                            <input type="time" id="Entrada_2_e" name="Entrada_2" class="validate calculate_e" maxlength="5">
                        </div>

                        <div class="col s6">
                            <label for="Saida_2"> Saída 2 </label>
                            <input type="time" id="Saida_2_e" name="Saida_2" class="validate calculate_e" maxlength="5">
                        </div>
                    </div>
            
                    <div class="col s12">
                        <div class="col s6">
                            <label for="Qtd_hrs_real">Total de horas </label>
                            <input type="number" id="Qtd_hrs_real_exibe_e" placeholder="00:00" readonly="true" class="validate" maxlength="2">
                            <input type="hidden" id="Qtd_hrs_real_e" name="Qtd_hrs_real" class="validate">
                        </div>
                        <div class="col s6">
                            <label>Tipo de horas</label><br>
                            <input type="radio" id="normal_e" name="tipo_horas" value="N"/>
                            <label for="normal_e">Normais</label><br/>
                            <input type="radio" id="banco_e" name="tipo_horas" value="B" />
                            <label for="banco_e">Banco</label>
                        </div>
                    </div>
                    
                        <label for="observacao">Atividade</label>
                        <input type="text" id="observacao_e" name="observacao" class="validate" maxlength="255">

                        <label for="chamado">Chamado</label>
                        <input type="text" id="chamado_e" name="chamado" class="validate" maxlength="20">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>            
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </form>
        </div>
        <div class="clearBoth"></div>
        <form action="apontamentos.php" method="post" id="form_busca">
            <input type="hidden" name="id_projeto_ap" id="id_projeto_ap">
            <input type="hidden" name="id_funcionario_ap" id="id_funcionario_ap">
            <input type="hidden" name="periodo_busca" id="periodo_busca">
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

window.onload = function(){
document.getElementById("sideNav").click();
}

function escondehoras(){
    $("#buttonHoras").css("display", "none");
}

function escondedespesas(){
    $("#buttonDespesas").css("display", "none");
}

$(document).ready(function(){
    if ($('#id_funcionario_busca').val() > 0 && $('#id_projeto_busca').val() > 0){
        $("#add_button").css("display", "block");
        $("#buttonHoras").css("display", "block");
        $("#buttonDespesas").css("display", "block");
    }

    $( "#Vlr_unit" ).blur(function() {
        var money = document.getElementById('Vlr_unit').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * document.getElementById('Qtd_despesa').value;
        money = number_format(money, 2, ',', '.');
        $("#vl_total_qtd").val(money);
    }); 


    $( ".calculate" ).blur(function() {
        Calcula();
    });

    $( ".calculate_e" ).blur(function() {
        Calcula_e();
    });

});

function Calcula()
{
        var time_entrada = document.getElementById('Entrada_1').value;
        var time_saida = document.getElementById('Saida_1').value;

        if (time_entrada != "" && time_saida != "") {

            var time_entrada = document.getElementById('Entrada_1').value;
            var time_saida = document.getElementById('Saida_1').value;
            if (time_saida == '00:00') {
                time_saida = '23:59';
                $("#Saida_1").val(time_saida);
            }

            s = time_entrada.split(':');
            e = time_saida.split(':');
            if (time_entrada != "" && time_saida != "") {
            min = e[1]-s[1];
            hour_carry = 0;
            if(min < 0){
                min += 60;
                hour_carry += 1;
            }
            hour = e[0]-s[0]-hour_carry;
            diff = hour + ":" + min;

            $("#Qtd_hrs_real").val(diff);
            $("#Qtd_hrs_real_exibe").attr('placeholder',timeToDecimal(diff));
            }
        }


        var time_entrada = document.getElementById('Entrada_2').value;
        var time_saida = document.getElementById('Saida_2').value;
        var time_atual = document.getElementById('Qtd_hrs_real').value;
        if (time_saida == '00:00') {
            time_saida = '23:59';
            $("#Saida_2").val(time_saida);
        }

        if (time_entrada != "" && time_saida != "" && time_atual) {
            s = time_entrada.split(':');
            e = time_saida.split(':');
            f = time_atual.split(':');

            min = e[1]-s[1];
            hour_carry = 0;

            if(min < 0){
                min += 60;
                hour_carry += 1;
            }
            min = parseFloat(f[1]) + parseFloat(min); 
            if (min >= 60) {
                min -= 60;
                hour_carry -= 1;
            }

            hour = e[0]-s[0]-hour_carry;
            hour = parseFloat(hour) + parseFloat(f[0]);

            diff = hour + ":" + min;
            $("#Qtd_hrs_real").val(diff);
            $("#Qtd_hrs_real_exibe").attr('placeholder',timeToDecimal(diff));
        }
}

function timeToDecimal(t) {
    var arr = t.split(':');
    var dec = parseInt((arr[1]/6)*10, 10);

    return parseFloat(parseInt(arr[0], 10) + '.' + (dec<10?'0':'') + dec);
}   

function Calcula_e()
{
        var time_entrada = document.getElementById('Entrada_1_e').value;
        var time_saida = document.getElementById('Saida_1_e').value;

        if (time_entrada != "" && time_saida != "") {

            var time_entrada = document.getElementById('Entrada_1_e').value;
            var time_saida = document.getElementById('Saida_1_e').value;
            if (time_saida == '00:00') {
                time_saida = '23:59';
                $("#Saida_1_e").val(time_saida);
            }

            s = time_entrada.split(':');
            e = time_saida.split(':');
            if (time_entrada != "" && time_saida != "") {
            min = e[1]-s[1];
            hour_carry = 0;
            if(min < 0){
                min += 60;
                hour_carry += 1;
            }
            hour = e[0]-s[0]-hour_carry;
            diff = hour + ":" + min;

            $("#Qtd_hrs_real_e").val(diff);
            $("#Qtd_hrs_real_exibe_e").attr('placeholder',timeToDecimal(diff));
            }
        }


        var time_entrada = document.getElementById('Entrada_2_e').value;
        var time_saida = document.getElementById('Saida_2_e').value;
        var time_atual = document.getElementById('Qtd_hrs_real_e').value;
        if (time_saida == '00:00') {
            time_saida = '23:59';
            $("#Saida_2_e").val(time_saida);
        }
        if (time_entrada != "" && time_saida != "" && time_atual) {
            s = time_entrada.split(':');
            e = time_saida.split(':');
            f = time_atual.split(':');

            min = e[1]-s[1];
            hour_carry = 0;

            if(min < 0){
                min += 60;
                hour_carry += 1;
            }
            min = parseFloat(f[1]) + parseFloat(min); 
            if (min >= 60) {
                min -= 60;
                hour_carry -= 1;
            }

            hour = e[0]-s[0]-hour_carry;
            hour = parseFloat(hour) + parseFloat(f[0]);

            diff = hour + ":" + min;
            $("#Qtd_hrs_real_e").val(diff);
            $("#Qtd_hrs_real_exibe_e").attr('placeholder',timeToDecimal(diff));
        }
}


function MotivosModal(string){
  $("#motivo").html(string);
  $("#openmodal").click();
}

function ObservacaoModal(string){
  $("#observacaotxt").html(string);
  $("#openmodalObs").click();
}

function EditObservacaoModal(string, id){
  $("#observacaoinput").val(string);
  $("#idobservacao").val(id);
  $("#editmodalObs").click();
}

function EditModal(id, entrada_1, saida_1, entrada_2, saida_2, Qtd_hrs_real, observacao, chamado, id_projeto, tipo_horas, data_apontamento){
    $("#Entrada_1_e").val(entrada_1);
    $("#Saida_1_e").val(saida_1);
    $("#Entrada_2_e").val(entrada_2);
    $("#Saida_2_e").val(saida_2);
    $("#Qtd_hrs_real_e").val(Qtd_hrs_real);
    $("#data_apontamento_e").val(data_apontamento);
    $("#Qtd_hrs_real_exibe_e").attr('placeholder',Qtd_hrs_real);
    $("#observacao_e").val(observacao);
    if (tipo_horas == 'N') {
        $("#normal_e").prop('checked', 'true');
    }
    if (tipo_horas == 'B') {
        $("#banco_e").prop('checked', 'true');
    }
    $("#chamado_e").val(chamado);
    $("#id_edit").val(id);
    $("#id_projeto_edit").val(id_projeto);
    $("#openmodaledition").click();   
}

function addParam(){
    $("#buttonHoras").css("display", "block");
}

function alterar_periodo()
{
    document.getElementById('periodo_busca').value = document.getElementById('periodo_busca_form').value;

    var id_funcionario = document.getElementById("id_funcionario_busca").value;
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