<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Projetos
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Projetos</a></li>
            <li><a href="#">Cadastro de Projetos</a></li>
          </ol> 
                  
      </div>

    <a href="#" data-toggle="modal" style="display:none;" id="openmodal" data-target="#Modal"></a>
    <a href="#" data-toggle="modal" style="display:none;" id="openmodaledition" data-target="#ModalRecursosEdicao"></a>
    
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
                                  <li class="tab col s3"><a href="#test1">Dados</a></li>
                                  <li class="tab col s3 disabled" id="divDespesas"><a href="#despesa">Despesas</a></li>
                                  <li class="tab col s3 disabled" id="divFluxoFin"><a href="#precificacao">Precificação</a></li>
                                  <!-- <li class="tab col s3 disabled" id="divFluxoFin"><a href="#fluxoFin">Fluxo Financeiro</a></li> -->
                              </ul>
                            </div>

                            <div class="clearBoth">
                                <br/>
                            </div>
                            
                                <div id="test1" class="col s10">
                                    <form class="col s12" action="projetos.php" method="post" name="cad_projetos" id="cad_projetos">
                                      <div class="row">
                                        <div class="col s6">
                                            <label for="id_cliente">Cliente</label>
                                            <select id="id_cliente" name="id_cliente" class="form-control input-sm">
                                              <option value="">Cliente</option>
                                              <?php $cliente->montaSelect(); ?>
                                            </select>
                                        </div>
                                         <div class="col s3">
                                            <label>Listar ?</label><br>
                                            <input type="radio" checked id="listar_s" name="listar" value="S"/>
                                            <label for="listar_s">Sim</label>
                                            <input type="radio" id="listar_n" name="listar" value="N" />
                                            <label for="listar_n">Não</label>
                                        </div>
                                        <div class="col s3">
                                            <label>Controle de Folgas ?</label><br>
                                            <input type="radio" id="controle_folg_s" name="controle_folga" value="S"/>
                                            <label for="controle_folg_s">Sim</label>
                                            <input type="radio" checked id="controle_folg_n" name="controle_folga" value="N" />
                                            <label for="controle_folg_n">Não</label>
                                        </div>
                                     </div>    

                                      
                                    <div class="row">
                                        <div class="col s5">
                                            <label for="id_proposta">Proposta</label>
                                            <select id="id_proposta" name="id_proposta" class="form-control input-sm">
                                              <option value="">Proposta</option>
                                                <?php $proposta->montaSelect(); ?>
                                            </select>
                                        </div>

                                        <div class="col s2">
                                            Início
                                            <input type="date" id="data_inicio" name="data_inicio" class="validate" maxlength="8">
                                        </div>
                                        <div class="col s2">
                                            Conclusão
                                            <input type="date" id="data_fim" name="data_fim" class="validate" maxlength="8">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s5">
                                            <label for="id_pilar">Pilar</label>
                                            <select id="id_pilar" name="id_pilar" class="form-control input-sm">
                                              <option value="">Pilar</option>
                                                <?php $pilar->montaSelect(); ?>
                                            </select>
                                        </div>    
                                        <div class="col s4">
                                        <label for="Status">Status</label>
                                          <select id="status" name="status" class="form-control input-sm">
                                            <option value="">Status</option>
                                                <?php $statusProj->montaSelect(); ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s5">
                                            <label for="id_gerente">Gerente do Projeto</label>
                                            <select id="id_gerente" name="id_gerente" class="form-control input-sm">
                                              <option value="">Gerente</option>
                                              <?php $funcionario->montaSelectGerente(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />

                                        <div class="row" style="display:none" id="rowFatAnexos">
                                            <?php
                                                $projetoprevisaofat->lista($projeto->id);
                                            ?>
                                            <div class="col-md-5">
                                                <div class="card">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr style="background: #c0392b;">
                                                                    <th align="left">
                                                                    <p style="color : #fff;"> Faturas </p>
                                                                    </th>
                                                                    <th align="center">
                                                                    </th>
                                                                    <th align="center">
                                                                    </th>
                                                                    <th align="center">
                                                                    </th>
                                                                    <th align="center">
                                                                    <?php if (@!$_GET['view']) { ?>
                                                                        <a href="#" data-toggle="modal" data-target="#ModalFaturas" style="color : #fff;">+</a>
                                                                    <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th>Parcela</th>
                                                                    <th>Mês / Ano</th>
                                                                    <th>Valor C/ Impostos</th>
                                                                    <th>Valor S/ Impostos</th>
                                                                    <th></th>
                                                                </tr>
                                                                <?php
                                                                    if (!empty($projetoprevisaofat->array)) {
                                                                        foreach($projetoprevisaofat->array as $row){
                                                                            ?>
                                                                            <tr class="odd gradeX">
                                                                                <td><?php echo $row['Num_parcela']; ?></td>
                                                                                <td><?php echo $row['mes_previsao_fat']; ?></td>
                                                                                <td>R$ <?php echo $row['Vlr_parcela_cimp']; ?></td>
                                                                                <td>R$ <?php echo $row['Vlr_parcela_simp']; ?></td>
                                                                                <td width="20%">
                                                                                <i onclick="EditModalF('<?php echo $row['id']; ?>','<?php echo $row['Num_parcela']; ?>','<?php echo $row['mes_previsao_fat']; ?>','<?php echo $row['Vlr_parcela_cimp']; ?>','<?php echo $row['Vlr_parcela_simp']; ?>')" class="material-icons">edit</i>

                                                                                    <i onclick="excluiFat(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                                                </td>
                                                                            </tr>
                                                                <?php } }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr style="background: #c0392b;">
                                                                    <th align="left">
                                                                      <p style="color : #fff;"> Anexos </p>
                                                                    </th>
                                                                    <th>
                                                                    <?php if (@!$_GET['view']) { ?>
                                                                        <a href="#" data-toggle="modal" data-target="#ModalAnexos" style="color: #fff;">+</a>
                                                                    <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th>Arquivo</th>
                                                                    <th></th>
                                                                </tr>
                                                                <?php
                                                                    if (!empty($projeto->id)) {

                                                                        $pasta = app::path.'files/projetos/'.$projeto->id;
                                                                            if (is_dir($pasta)) {

                                                                                $diretorio = dir($pasta);
                                                                                 while($arquivo = $diretorio -> read()){ 
                                                                                    if ($arquivo != '.' && $arquivo != '..') {
                                                                                    ?>
                                                                                    <tr class="odd gradeX">
                                                                                        <td><?php echo "<a href='".app::dominio.'files/projetos/'.$projeto->id.'/'.$arquivo."' target='_blank'>".$arquivo." </a>"; ?></td>
                                                                                        <td>
                                                                                            <i onclick="excluir_anexo('<?php echo app::path.'files/projetos/'.$projeto->id.'/'.$arquivo ?>')" id="anexo_file" class="material-icons">delete</i>
                                                                                        </td>
                                                                                    </tr>
                                                                <?php               }
                                                                                }
                                                                            } 
                                                                        }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>    
                                            </div>


                                        </div>


                                        <div class="row" style="display:none" id="rowRecursos">
                                        <?php
                                        $projetorecursos->lista($projeto->id);
                                        ?>
                                            <div class="col-md-9">
                                                <div class="card">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr style="background: #c0392b;">
                                                                    <th align="left">
                                                                        <p style="color : #fff;"> Recursos </p>
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
                                                                    <?php if (@!$_GET['view']) { ?>
                                                                        <a href="#" data-toggle="modal" data-target="#ModalRecursos" style="color : #fff;">+</a>
                                                                    <?php } ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th>Perfil</th>
                                                                    <th>Taxa Compra</th>
                                                                    <th>Taxa Venda</th>
                                                                    <th>Mês / Ano</th>
                                                                    <th>Horas Estimadas</th>
                                                                    <td></td>
                                                                </tr>
                                                                <?php
                                                                if (!empty($projetorecursos->array)) {
                                                                foreach($projetorecursos->array as $row){ ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?php echo $row['nomePerfil']; ?></td>
                                                                        <td>R$ <?php echo $row['Vlr_taxa_compra']; ?></td>
                                                                        <td>R$ <?php echo $row['Vlr_taxa_venda']; ?></td>
                                                                        <td><?php echo $row['mes_alocacao']; ?></td>
                                                                        <td><?php echo $row['Qtd_hrs_estimada']; ?></td>
                                                                        <td> <i onclick="EditModal('<?php echo $row['id']; ?>','<?php echo $row['mes_alocacao']; ?>','<?php echo $row['id_perfilprofissional']; ?>','<?php echo $row['Qtd_hrs_estimada']; ?>','<?php echo $row['Vlr_taxa_compra']; ?>','<?php echo $row['Vlr_taxa_venda']; ?>')" class="material-icons">edit</i> <i onclick="excluiRec(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i> </td>
                                                                    </tr>
                                                                <?php } }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s1">
                                            </div>
                                            <input type="hidden" id="id" name="id" value="<?php echo $projeto->id; ?>">
                                            <input type="hidden" id="action" name="action" value="1">
                                            <div class="col s7"></div>
                                            <?php if (@!$_GET['view']) { ?>
                                            <div>
                                                <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                                            </div>
                                            <?php } else { ?>
                                                <a class="waves-effect waves-light btn" href="<?php echo app::dominio; ?>acompanhamento_projetos.php?statusID=<?php echo $_GET['statusID']?>&id_pilar=<?php echo $_GET['id_pilar']?>&id_cliente=<?php echo $_GET['id_cliente']?>&farol=<?php echo $_GET['farol']?>&tipofarol=<?php echo $_GET['tipofarol']?>">Voltar</a>
                                            <?php    } ?>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Modal de Faturas -->
                                <div id="ModalFaturas" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Previsão de Faturamento</h4>
                                    </div>

                                    <form class="col s12" id="projetoprevisaofats" action="projetoprevisaofats.php" method="post" name="projetoprevisaofats">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col s4">
                                            <label for="id_projeto">Código do Projeto</label><br />
                                              <?php echo $projeto->id; ?>
                                              <input type="hidden" name="id_projeto" value="<?php echo $projeto->id; ?>">
                                            </div>
                                            
                                            <div class="col s4">
                                            <label for="nome">Cliente</label><br />
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></label>
                                                <input type="hidden" name="id_cliente" value="<?php echo $projeto->id_cliente; ?>">
                                            </div>

                                            <div class="col s4">
                                            <label for="proposta">Proposta</label><br />
                                            <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                              <input type="hidden" name="id_proposta" value="<?php echo $projeto->id_proposta; ?>">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s2">
                                            <label for="num_parcela">Parcela</label>
                                              <input type="text" id="Num_parcela" readonly="true" name="Num_parcela" value="<?php echo $projetoprevisaofat->getParcela($projeto->id); ?>" maxlength="3">
                                            </div>

                                            <div class="col s6">
                                            <label for="Vlr_parcela_cimp">Valor Com impostos R$</label>
                                              <input type="text" onkeypress="moeda(this)" id="Vlr_parcela_cimp" name="Vlr_parcela_cimp" class="validate" maxlength="255">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s2">
                                            <label for="mes_previsao_fat">Mês / Ano</label>
                                              <input type="text" id="mes_previsao_fat" name="mes_previsao_fat" class="validate" maxlength="7">
                                            </div>
                                            <div class="col s6">
                                                <label for="Vlr_parcela_cimp">Valor Sem impostos R$</label>
                                                  <input type="text" readonly="true" id="vl_parcela_simp" maxlength="255">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="1">
                                            <?php if (@!$_GET['view']) { ?>
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <?php } ?>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>

                                <!-- Modal de Faturas -->
                                <div id="Modal" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edição de Faturamento</h4>
                                    </div>

                                    <form class="col s12" id="projetoprevisaofats" action="projetoprevisaofats.php" method="post" name="projetoprevisaofats">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col s4">
                                            <label for="id_projeto">Código do Projeto</label><br />
                                              <?php echo $projeto->id; ?>
                                              <input type="hidden" name="id_projeto" value="<?php echo $projeto->id; ?>">
                                            </div>
                                            
                                            <div class="col s4">
                                            <label for="nome">Cliente</label><br />
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></label>
                                                <input type="hidden" name="id_cliente" value="<?php echo $projeto->id_cliente; ?>">
                                            </div>

                                            <div class="col s4">
                                            <label for="proposta">Proposta</label><br />
                                            <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                              <input type="hidden" name="id_proposta" value="<?php echo $projeto->id_proposta; ?>">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s2">
                                            <label for="num_parcela">Parcela</label>
                                              <input type="text" id="Num_parcela_e" readonly="true" name="Num_parcela" maxlength="3">
                                            </div>

                                            <div class="col s6">
                                            <label for="Vlr_parcela_cimp_e">Valor Com impostos R$</label>
                                              <input type="text" onkeypress="moeda(this)" id="Vlr_parcela_cimp_e" name="Vlr_parcela_cimp" class="validate" maxlength="255">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s2">
                                            <label for="mes_previsao_fat_e">Mês / Ano</label>
                                              <input type="text" id="mes_previsao_fat_e" name="mes_previsao_fat" class="validate" maxlength="7">
                                            </div>
                                            <div class="col s6">
                                                <label for="Vlr_parcela_cimp">Valor Sem impostos R$</label>
                                                  <input type="text" readonly="true" id="vl_parcela_simp_e" maxlength="255">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="modal-footer">
                                        <input type="hidden" name="idFat" id="id_edit_fatura">
                                        <input type="hidden" name="action" value="1">
                                            <?php if (@!$_GET['view']) { ?>
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <?php } ?>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>


                                <!-- Modal de Recursos -->
                                <div id="ModalRecursos" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Gerenciamento de Recursos</h4>
                                    </div>

                                    <form class="col s12" id="projetorecursos" action="projetorecursos.php" method="post" name="projetorecursos">
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
                                            <div class="col s4">
                                                <label for="id_perfilprofissional">Perfil Profissional</label>
                                                <select id="id_perfilprofissional" name="id_perfilprofissional" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $perfilprofissional->montaSelect(); ?>
                                                </select> 
                                            </div>
                                            <div class="col s1"></div>
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="vlr_taxa_venda">Taxa Venda R$</label>
                                                  <input type="text" onkeypress="moeda(this)" id="vlr_taxa_venda" name="vlr_taxa_venda" class="validate" maxlength="255">
                                                </div>
                                            </div>
                                          </div>
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="vlr_taxa_compra">Taxa Compra R$</label>
                                                  <input type="text" onkeypress="moeda(this)" id="vlr_taxa_compra" name="vlr_taxa_compra" class="validate" maxlength="255">
                                                </div>
                                                <div class="col s1"></div>
                                                <div class="col s4">
                                                <label for="mes_alocacao">Mês / Ano</label>
                                                  <input type="text" id="mes_alocacao" name="mes_alocacao" class="validate" maxlength="7">
                                                </div>
                                            </div>
                          
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="qtd_hrs_estimada">Horas Estimadas</label>
                                                  <input type="text" id="qtd_hrs_estimada" name="qtd_hrs_estimada" class="validate" maxlength="7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="1">
                                        <?php if (@!$_GET['view']) { ?>
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                        <?php } ?>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>

                                <!-- Modal de Recursos -->
                                <div id="ModalRecursosEdicao" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edição de Recursos</h4>
                                    </div>

                                    <form class="col s12" id="projetorecursos" action="projetorecursos.php" method="post" name="projetorecursos">
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
                                            <div class="col s4">
                                                <label for="id_perfilprofissional_e">Perfil Profissional</label>
                                                <select id="id_perfilprofissional_e" name="id_perfilprofissional" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $perfilprofissional->montaSelect(); ?>
                                                </select> 
                                            </div>
                                            <div class="col s1"></div>
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="vlr_taxa_venda">Taxa Venda R$</label>
                                                  <input type="text" onkeypress="moeda(this)" id="vlr_taxa_venda_e" name="vlr_taxa_venda" class="validate" maxlength="255">
                                                </div>
                                            </div>
                                          </div>
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="vlr_taxa_compra">Taxa Compra R$</label>
                                                  <input type="text" onkeypress="moeda(this)" id="vlr_taxa_compra_e" name="vlr_taxa_compra" class="validate" maxlength="255">
                                                </div>
                                                <div class="col s1"></div>
                                                <div class="col s4">
                                                <label for="mes_alocacao">Mês / Ano</label>
                                                  <input type="text" id="mes_alocacao_e" name="mes_alocacao" class="validate" maxlength="7">
                                                </div>
                                            </div>
                          
                                            <div class="row">
                                                <div class="col s4">
                                                <label for="qtd_hrs_estimada">Horas Estimadas</label>
                                                  <input type="text" id="qtd_hrs_estimada_e" name="qtd_hrs_estimada" class="validate" maxlength="7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="1">
                                        <input type="hidden" name="idRec" id="id_edit">
                                        <?php if (@!$_GET['view']) { ?>
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                        <?php } ?>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>

                                
                                <!-- Modal de anexos -->
                                <div id="ModalAnexos" class="modal fade" >
                                    <div class="modal-header">
                                        <h4 class="modal-title">Anexo de Projetos</h4>
                                    </div>

                                    <form class="col s12" id="anexoprojetos" action="projetos.php" method="post" name="anexoprojetos" enctype="multipart/form-data">
                                        <div class="modal-body">
                                             <div class="row">
                                                <div class="col s4">
                                                    <label for="id_projeto">Código do Projeto</label><br />
                                                    <input type="file" id="anexo" name="anexo" class="validate">
                                                    <input type="hidden" name="id" value="<?php echo $projeto->id; ?>">
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="3">
                                        <?php if (@!$_GET['view']) { ?>
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                        <?php }?>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div>

                                <!-- Modal de despesas -->
                                <!-- <div id="ModalDespesas" class="modal fade" >
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
                                            <div class="col s4">
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
                                                    <?php $funcionario->montaSelect(0, $projeto->id); ?>
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
                                                  <input type="number" id="Qtd_despesa" name="Qtd_despesa" class="validate" maxlength="7">
                                                </div>

                                                <div class="col s1"></div>
                                                <div class="col s4">
                                                <label for="Vlr_unit">Valor Total R$ :</label>
                                                  <input type="text" readonly="true" id="vlr_total_qtd" maxlength="255">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <input type="hidden" name="action" value="1">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
                                </div> -->

                                <div id="despesa" class="col s12">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Código do Projeto : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p><?php echo $projeto->id; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Cliente : </b></p>
                                            </div>
                                            <div class="col s6">
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Proposta : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Pilar : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="pilar"><?php echo $projeto->id_pilar; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                    <?php
                                        $projetodespesas->lista($projeto->id);
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
                                                <tr>
                                                    <form class="col s12" id="projetodespesas" action="projetodespesas.php" method="post" name="projetodespesas">
                                                    <input type="hidden" name="id_projeto" value="<?php echo $projeto->id; ?>">
                                                    <input type="hidden" name="id_cliente" value="<?php echo $projeto->id_cliente ?>">
                                                    <input type="hidden" name="id_proposta" value="<?php echo $projeto->id_proposta; ?>">

                                                    <!-- inicio form -->

                                                    <td>
                                                        <input type="date" id="Data_despesa" name="Data_despesa" class="validate" maxlength="8">
                                                    </td>
                                                    <td width="20%"><select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $funcionario->montaSelect(0, $projeto->id); ?>
                                                </select>
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
                                                    <td width="5%">
                                                        <input type="number" id="Qtd_despesa" name="Qtd_despesa" class="validate" maxlength="7">
                                                    </td>
                                                    <td width="10%">
                                                        <input type="text" onkeypress="moeda(this)" id="Vlr_unit" name="Vlr_unit" class="validate" maxlength="255">
                                                    </td>
                                                    <td width="10%">
                                                        <input type="text" id="vl_total_qtd" readonly="true" maxlength="255">
                                                    </td>
                                                    <td>
                                                    <input type="hidden" name="action" value="1">
                                                        Não Aprovado
                                                    </td>
                                                    <td>
                                                    <?php if (@!$_GET['view']) { ?>
                                                        <button type="submit" class="btn btn-success" id="buttonDespesas" style="display:block" onclick="escondedespesas()">+</button>
                                                    <?php }?>
                                                    </td>
                                                    </form>
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
                                                        <td>R$ <?php echo $row['Vlr_unit']; ?></td>
                                                        <td>R$ <?php echo $row['Vlr_total']; ?></td>
                                                        <td><?php echo $row['Aprovado']; ?></td>
                                                        <td>
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
                                <!-- <div id="fluxoFin" class="col s12">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Código do Projeto : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p><?php echo $projeto->id; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Cliente : </b></p>
                                            </div>
                                            <div class="col s6">
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Proposta : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Pilar : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="pilar"><?php echo $projeto->id_pilar; ?></p>
                                            </div>
                                        </div>
                                        

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> MES ATUAL <?php echo $financeiro['1']['mes_atual']; ?> </p>
                                                        </th>
                                                        <th align="left">
                                                            <p style="color : #fff;"> VALORES </p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA COM IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['1']['vlr_parcela_cimp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['1']['vlr_parcela_simp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA LIQUIDO</td>
                                                        <td>R$ <?php echo $financeiro['1']['valor_venda_l']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CUSTO DO PROJETO (CUSTO + DESP. NAO REEMB.)</td>
                                                        <td>R$ <?php echo $financeiro['1']['custo_projeto']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM PERCENTUAL</td>
                                                        <td><?php echo $financeiro['1']['margem_projeto']; ?> %</td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM VALORES (VLR VENDA SEM IMPOSTOS - CUSTO PROJ - CF)</td>
                                                        <td>R$ <?php echo $financeiro['1']['margem_projeto_liquido']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div><br /><br /></div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> VTD - (ACUMULADOS DOS MESES ATÉ MES ATUAL)  </p>
                                                        </th>
                                                        <th align="left">
                                                            <p style="color : #fff;"> VALORES </p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA COM IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['2']['vlr_parcela_cimp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['2']['vlr_parcela_simp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA LIQUIDO</td>
                                                        <td>R$ <?php echo $financeiro['2']['valor_venda_l']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CUSTO DO PROJETO (CUSTO + DESP. NAO REEMB.)</td>
                                                        <td>R$ <?php echo $financeiro['2']['custo_projeto']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM PERCENTUAL</td>
                                                        <td><?php echo $financeiro['2']['margem_projeto']; ?> %</td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM VALORES (VLR VENDA SEM IMPOSTOS - CUSTO PROJ - CF)</td>
                                                        <td>R$ <?php echo $financeiro['2']['margem_projeto_liquido']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div><br /><br /></div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> EAC </p>
                                                        </th>
                                                        <th align="left">
                                                            <p style="color : #fff;"> VALORES </p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA COM IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['3']['vlr_parcela_cimp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE IMPOSTOS</td>
                                                        <td>R$ <?php echo $financeiro['3']['vlr_parcela_simp']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>VALOR DE VENDA LIQUIDO</td>
                                                        <td>R$ <?php echo $financeiro['3']['valor_venda_l']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CUSTO DO PROJETO (CUSTO + DESP. NAO REEMB.)</td>
                                                        <td>R$ <?php echo $financeiro['3']['custo_projeto'];?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM PERCENTUAL</td>
                                                        <td><?php echo $financeiro['3']['margem_projeto']; ?> %</td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>MARGEM PROJETO EM VALORES (VLR VENDA SEM IMPOSTOS - CUSTO PROJ - CF)</td>
                                                        <td>R$ <?php echo $financeiro['3']['margem_projeto_liquido']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>



                                    </div>
                                </div> -->
                                <div id="precificacao">
                                     <div class="card-content">
                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Código do Projeto : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p><?php echo $projeto->id; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Cliente : </b></p>
                                            </div>
                                            <div class="col s6">
                                                <p class="cliente"><?php echo $projeto->id_cliente; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Proposta : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="proposta"><?php echo $projeto->id_proposta; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col s2">
                                                <p><b>Pilar : </b></p>
                                            </div>
                                            <div class="col s2">
                                                <p class="pilar"><?php echo $projeto->id_pilar; ?></p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="background: #c0392b;">
                                                        <th align="left">
                                                            <p style="color : #fff;"> P & L </p>
                                                        </th>
                                                        <th align="left">
                                                            <p style="color : #fff;"> TOTAL </p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd gradeX">
                                                        <td>RECEITA BRUTA</td>
                                                        <td>R$ <?php echo $precificacao['receita_bruta']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>RECEITA LÍQUIDA</td>
                                                        <td>R$ <?php echo $precificacao['receita_liquida']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CUSTOS DIRETOS</td>
                                                        <td>R$ <?php echo $precificacao['custos_direto']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CM1</td>
                                                        <td>R$ <?php echo $precificacao['CM1']; ?></td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <td>CM1%</td>
                                                        <td><?php echo $precificacao['CM1%']; ?> %</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                        </div>
                  <div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
        <form action="projetoprevisaofats.php" method="post" id="form_projetofaturas">
            <input type="hidden" name="idFat" id="idFat">
            <input type="hidden" name="action" id="action" value="3">
            <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $projeto->id; ?>">
        </form>

        <form action="projetorecursos.php" method="post" id="form_projetorecursos">
            <input type="hidden" name="idRec" id="idRec">
            <input type="hidden" name="action" id="action" value="3">
            <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $projeto->id; ?>">
        </form>

        <form action="projetodespesas.php" method="post" id="form_projetodespesas">
            <input type="hidden" name="idDesp" id="idDesp">
            <input type="hidden" name="action" id="action" value="3">
            <input type="hidden" name="id_projeto" id="id_projeto" value="<?php echo $projeto->id; ?>">
        </form>

        <form action="projetos.php" method="post" id="form_projeto_anexos">
            <input type="hidden" name="file" id="file">
            <input type="hidden" name="action" id="action" value="4">
            
            <input type="hidden" name="id" id="id" value="<?php echo $projeto->id; ?>">

        </form>
    </div>

  
<?php
  require_once(app::path.'/view/footer.php');
?>

<script>

function EditModal(id, mes_alocacao, perfilprofissional, qtd_hrs_estimada, vlr_taxa_compra, vlr_taxa_venda){
    $("#mes_alocacao_e").val(mes_alocacao);
    $("#id_perfilprofissional_e").val(perfilprofissional);
    $("#qtd_hrs_estimada_e").val(qtd_hrs_estimada);
    $("#vlr_taxa_compra_e").val(vlr_taxa_compra);
    $("#vlr_taxa_venda_e").val(vlr_taxa_venda);
    $("#id_edit").val(id);
    $("#openmodaledition").click();   
}

function EditModalF(id, parcela, mes, valor_c_imposto, valor_s_imposto){
    $("#Num_parcela_e").val(parcela);
    $("#mes_previsao_fat_e").val(mes);
    $("#Vlr_parcela_cimp_e").val(valor_c_imposto);
    $("#vl_parcela_simp_e").val(valor_s_imposto);
    $("#id_edit_fatura").val(id);
    $("#openmodal").click();   
}


$( document ).ready(function() {

    $( "#Vlr_parcela_cimp" ).blur(function() {
        var money = document.getElementById('Vlr_parcela_cimp').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * 0.9185;
        money = number_format(money, 2, ',', '.');
        $("#vl_parcela_simp").val(money);
        // alert(money);
    });        

    $( "#Vlr_parcela_cimp_e" ).blur(function() {
        var money = document.getElementById('Vlr_parcela_cimp_e').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * 0.9185;
        money = number_format(money, 2, ',', '.');
        $("#vl_parcela_simp_e").val(money);
        // alert(money);
    });        

    $( "#Qtd_despesa" ).blur(function() {

        var money = document.getElementById('Vlr_unit').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * document.getElementById('Qtd_despesa').value;
        money = number_format(money, 2, ',', '.');
        $("#vlr_total_qtd").val(money);
        // alert(money);

    });
    
});
$( "#Vlr_unit" ).blur(function() {
        var money = document.getElementById('Vlr_unit').value.replace( '.', '' );
        money = money.replace( ',', '.' );
        money = money * document.getElementById('Qtd_despesa').value;
        money = number_format(money, 2, ',', '.');
        $("#vl_total_qtd").val(money);
    }); 

function escondedespesas(){
    $("#buttonDespesas").css("display", "none");
}

function excluir_anexo(file)
{
  if (!confirm('Tem certeza que deseja excluir esse anexo?')) {
    return false;
  }
   $("#file").val(file);
   document.getElementById('form_projeto_anexos').submit();
}

function excluiFat(idFat) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (idFat > 0) {
        document.getElementById('idFat').value = idFat;
        document.getElementById('form_projetofaturas').submit();
    }   
}

function excluiRec(idRec) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (idRec > 0) {
        document.getElementById('idRec').value = idRec;
        document.getElementById('form_projetorecursos').submit();
    }   
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

</script>
<script src="<?php echo app::dominio; ?>view/assets/js/projetos/projeto.js"></script>