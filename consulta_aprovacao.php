<?php
  require_once(app::path.'view/header.php');
?>
<?php
$apontamento->lista_aprovacao();
$projetodespesa->lista_aprovacao();
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Aprovações 
            </h1>
            <ol class="breadcrumb">
          <li class="active">Aprovações</li>
        </ol> 
                        
</div>
<div id="page-inner"> 
  <div class="row">
      <div class="col-md-12">
            <div class="card">
                <div class="card-action">
                     Aprovações   --- <a href="#" data-toggle="modal" data-target="#ModalPesquisa">Filtros</a>
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
                     <div class="col-md-12 col-sm-12">
                     <div class="col-sm-12">
                        <ul class="tabs">
                            <li class="tab col s3"><a href="#horas">Horas</a></li>
                            <li class="tab col s3"><a href="#despesa">Despesas</a></li>
                            <li class="col s3">Horas Pendentes à Aprovação :<b> <?php echo $apontamento->array['horastotais']; ?></b> <br /> Horas Aprovadas :<b> <?php echo $apontamento->array['horasaprovadas']; ?></b></li>
                        </ul>
                      </div>
                     <a href="#" data-toggle="modal" style="display:none;" id="openmodalObs" data-target="#ModalObservacao"></a>

                      <div class="clearBoth">
                          <br/>
                      </div>
                    <!-- div de horas -->
                    <div id="horas" class="col s12">
                    <?php
                      unset($apontamento->array['horastotais']);
                      unset($apontamento->array['horasaprovadas']);
                      if (!empty($apontamento->array)) {
                    ?>
                    <form class="col s12" action="libera_apontamento.php" method="post" id="libera_apontamento">
                        <div>
                          <div class="col s8"></div>
                          <div class="col s1"></div>
                          <div class="col s1"></div>
                          <div class="col s2">
                          <b> Aprovação de horas em grupo </b> <br/> 
                          <input class="with-gap" name="aprova_geral_horas" value="2" type="radio" id="lala2" />
                          <label for="lala2">Não </label>

                          <input class="with-gap" name="aprova_geral_horas" value="1" type="radio" id="lala3" />
                          <label for="lala3">Sim </label>
                          </div>
                        </div>
                        <div class="table-responsive col s12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Projeto</th>
                                            <th>Profissional</th>
                                            <th>Data</th>
                                            <th>Qtde. Horas</th>
                                            <th>Tipo Horas</th>
                                            <th>Atividade</th>
                                            <th>Chamado</th>
                                            <th>Motivo</th>
                                            <th>Aprovação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($apontamento->array as $row){
                                         ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['id_projeto']; ?> -- <?php echo $row['nomeCliente']; ?> -- <?php echo $row['id_proposta']; ?></td>
                                                <td><?php echo $row['funcionarioNome']; ?></td>
                                                <td><?php echo $row['Data_apontamento']; ?></td>
                                                <td><?php echo $row['Qtd_hrs']; ?></td>
                                                <td><?php echo $row['tipo_horas']; ?></td>
                                                <td><?php echo $row['atividade']; ?></td>
                                                <td><?php echo $row['chamado']; ?></td>
                                                <td><input type="text" name="Motivo[<?php echo $row['id']; ?>]"></td>
                                                <td>
                                                <p>
                                                  <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="S" type="radio" id="test3[<?php echo $row['id']; ?>]"  />
                                                  <label for="test3[<?php echo $row['id'];?>]">Sim </label>

                                                  <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="N" checked type="radio" id="test1[<?php echo $row['id']; ?>]" />
                                                  <label for="test1[<?php echo $row['id'];?>]">Pendente </label>
                                                
                                                  <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="R" type="radio" id="test2[<?php echo $row['id']; ?>]" />
                                                  <label for="test2[<?php echo $row['id'];?>]">Não </label>
                                                </p>
                                                </td>
                                            </tr>
                                        <?php }?>
                                   </tbody>
                                </table>
                            <input type="hidden" name="id_projeto" value="<?php echo $apontamento->id_projeto; ?>">
                            <input type="hidden" name="id_funcionario" value="<?php echo $apontamento->id_funcionario; ?>">
                            <input type="hidden" value="1" name="action" id="action">
                            <button type="submit" class="btn btn-success" > Salvar</button>
                        </div>  
                    </form>
                            <?php } ?>
                    </div>


                    <!-- div de despesas -->
                    <div id="despesa" class="col s12">
                    <?php
                    if (!empty($projetodespesa->array)) {
                    ?>
                      <form action="libera_apontamento.php" method="post" id="libera_apontamento">
                        <div class="col s8"></div>
                        <div class="col s1"></div>
                        <div class="col s1"></div>
                        <div class="col s2">
                        <b> Aprovação das despesas Em grupo </b> <br/> 
                        <input class="with-gap" name="aprova_geral_despesas" value="2" type="radio" id="lala4" />
                        <label for="lala4">Não </label>

                        <input class="with-gap" name="aprova_geral_despesas" value="1" type="radio" id="lala5" />
                        <label for="lala5">Sim </label>
                        </div>
                        <div class="table-responsive col s12">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Projeto</th>
                                                <th>Profissional</th>
                                                <th>Data</th>
                                                <th>Nº Doc</th>
                                                <th>Tipo Despesa</th>
                                                <th>Qtd. Despesa</th>
                                                <th>Valor Unit.</th>
                                                <th>Valor Total</th>
                                                <th>Reembolso</th>
                                                <th>Observação</th>
                                                <th>Comprovante</th>
                                                <th>Motivo</th>
                                                <th>Aprovação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            foreach($projetodespesa->array as $row){ ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo $row['id_projeto']; ?> -- <?php echo $row['nomeCliente']; ?> -- <?php echo $row['id_proposta']; ?></td>
                                                    <td><?php echo $row['funcionarioNome']; ?></td>
                                                    <td><?php echo $row['Data_despesa']; ?></td>
                                                    <td><?php echo $row['Num_doc']; ?></td>
                                                    <td><?php echo $row['descricao']; ?></td>
                                                    <td><?php echo $row['Qtd_despesa']; ?></td>
                                                    <td>R$<?php echo $row['Vlr_unit']; ?></td>
                                                    <td>R$<?php echo $row['Vlr_total']; ?></td>
                                                    <td><?php echo $row['reembolso']; ?></td>
                                                    <td>
                                                    <?php if (!empty($row['observacao'])) { ?>
                                                        <a onclick="ObservacaoModal('<?php echo $row['observacao'];?>')">Observação</a>
                                                    <?php } ?>
                                                    </td>
                                                    <td>
                                                      <?php 
                                                        if (!empty($row['id'])) { 

                                                           $pasta = app::path.'files/comprovantes';
                                                           if (is_dir($pasta)) {
                                                              $diretorio = dir($pasta);

                                                              $arquivo = $row['id'];

                                                              if (is_file('files/comprovantes/'.$arquivo.'.pdf')) {
                                                                $arquivo .= '.pdf';
                                                                echo "<a href='".app::dominio.'files/comprovantes/'.$arquivo."' target='_blank'>Visualizar</a>";
                                                              }
                                                              if (is_file('files/comprovantes/'.$arquivo.'.doc')) {
                                                                $arquivo .= '.doc';
                                                                echo "<a href='".app::dominio.'files/comprovantes/'.$arquivo."'>Visualizar</a>";
                                                              }
                                                           }
                                                        } 
                                                     ?>
                                                    </td>
                                                    <td><input type="text" name="Motivo[<?php echo $row['id']; ?>]"></td>
                                                    <td>
                                                    <p>
                                                      <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="S" type="radio" id="test3[<?php echo $row['id']; ?>]"  />
                                                      <label for="test3[<?php echo $row['id'];?>]">Sim </label>

                                                      <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="N" checked type="radio" id="test1[<?php echo $row['id']; ?>]" />
                                                      <label for="test1[<?php echo $row['id'];?>]">Pendente </label>
                                                    
                                                      <input class="with-gap" name="Aprova[<?php echo $row['id']; ?>]" value="R" type="radio" id="test2[<?php echo $row['id']; ?>]" />
                                                      <label for="test2[<?php echo $row['id'];?>]">Não </label>
                                                    </p>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                       </tbody>
                                    </table>
                                <input type="hidden" name="id_projeto" value="<?php echo $apontamento->id_projeto; ?>">
                                <input type="hidden" name="id_funcionario" value="<?php echo $apontamento->id_funcionario; ?>">
                                <input type="hidden" value="3" name="action" id="action">
                                <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                    <?php } ?>
                    </div>
                </div>
                <div id="ModalObservacao" class="modal" style="height: 20%">
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

                <div class="clearBoth"></div>
            <!-- Modal de Pesquisa -->
            <div id="ModalPesquisa" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Filtros</h4>
                </div>

                <form class="col s12" id="libera_apontamento" action="libera_apontamento.php" method="get" name="libera_apontamento">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col s4">
                        <label for="id_projeto">Projeto</label><br />
                          <select id="id_projeto" name="id_projeto" class="form-control input-sm id_projeto_class">
                              <option value="">Projetos</option>
                                <?php $projeto->montaSelect($apontamento->id_projeto, true); ?>
                            </select>
                        </div>
                        
                        <div class="col s4">
                        <label for="id_funcionario">Profissional</label><br />
                        <select id="id_funcionario" name="id_funcionario" class="form-control input-sm id_funcionario_class">
                            <option value="">Profissional</option>
                                <?php $funcionario->montaSelect($apontamento->id_funcionario, $apontamento->id_projeto); ?>
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                            Data Início
                            <input type="date" name="data_busca_ini" class="validate" value="<?php if (!empty($apontamento->data_busca_ini)) {
                              echo $apontamento->data_busca_ini;
                            } ?>" maxlength="8">
                        </div>
                        <div class="col s4">
                            Data Fim
                            <input type="date" name="data_busca_fim" class="validate" value="<?php if (!empty($apontamento->data_busca_fim)) {
                              echo $apontamento->data_busca_fim;
                            }?>" maxlength="8">
                        </div>
                      </div>

                    <div class="modal-footer">
                    <input type="hidden" name="action" value="2">
                        <button type="submit" class="btn btn-success">Pesquisar</button>
                        <div class="col s1"></div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </form>    
            </div>




<?php
    require_once(app::path.'view/footer.php');
?>
<script>

function ObservacaoModal(string){
  $("#observacaotxt").html(string);
  $("#openmodalObs").click();
}


window.onload = function(){
document.getElementById("sideNav").click();
}

  $( document ).ready(function() {
    $( ".id_projeto_class" ).change(function() {
        $.ajax({
            url : "<?php echo app::dominio; ?>libera_apontamento.php",
            type: 'post',
            dataType: 'HTML',
            data: {"action": 4, "id_projeto": $(this).val()},
            success: function(d){
                $('.id_funcionario_class').html(d);
            }
        });
    });
});
</script>