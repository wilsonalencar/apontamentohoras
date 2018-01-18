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
                                  <li class="tab col s3"><a class="active" href="#test1">Dados</a></li>
                                  <li class="tab col s3 disabled" id="divDespesas"><a href="#despesa">Despesas</a></li>
                                  <li class="tab col s3 disabled" id="divFluxoFin"><a href="#fluxoFin">Fluxo Financeiro</a></li>
                              </ul>
                            </div>

                            <div class="clearBoth">
                                <br/>
                            </div>
                            
                                <div id="test1" class="col s12">
                                    <form class="col s12" action="projetos.php" method="post" name="cad_projetos" id="cad_projetos">

                                      <div class="row">
                                        <div class="col s6">
                                            <label for="id_cliente">Cliente</label>
                                            <select id="id_cliente" name="id_cliente" class="form-control input-sm">
                                              <option value="">Cliente</option>
                                              <?php $cliente->montaSelect(); ?>
                                            </select>
                                        </div>
                                        <div class="col s1"></div>
                                         <div class="col s3">
                                            <label for="Cliente_reembolsa">Cliente reembolsa ? </label><br>
                                              <p>
                                                <input class="with-gap" name="Cliente_reembolsa" value="S" type="radio" id="cliente_s"/>
                                                <label for="cliente_s">Sim </label>
                                              
                                                <input class="with-gap" name="Cliente_reembolsa" value="N" checked type="radio" id="cliente_n" />
                                                <label for="cliente_n">Não </label>
                                              </p>
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
                                                                    </th>
                                                                    <th align="center">
                                                                        <a href="#" data-toggle="modal" data-target="#ModalFaturas" style="color : #fff;">+</a>
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
                                                                        foreach($projetoprevisaofat->array as $row){ ?>
                                                                            <tr class="odd gradeX">
                                                                                <td><?php echo $row['Num_parcela']; ?></td>
                                                                                <td><?php echo $row['mes_previsao_fat']; ?></td>
                                                                                <td>R$ <?php echo $row['Vlr_parcela_cimp']; ?></td>
                                                                                <td>R$ <?php echo $row['Vlr_parcela_simp']; ?></td>
                                                                                <td>
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
                                                                        <a href="#" style="color: #fff;">+</a>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Ainda não funciona</td>
                                                                    <td><a href="#">X</a></td>
                                                                </tr>
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
                                                                    </th>
                                                                    <th align="center">
                                                                        <a href="#" data-toggle="modal" data-target="#ModalRecursos" style="color : #fff;">+</a>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th>Perfil</th>
                                                                    <th>Profissional</th>
                                                                    <th>Taxa Compra</th>
                                                                    <th>Mês / Ano</th>
                                                                    <th>Horas Estimadas</th>
                                                                    <th>Horas Realizadas</th>
                                                                    <td></td>
                                                                </tr>
                                                                <?php
                                                                if (!empty($projetorecursos->array)) {
                                                                foreach($projetorecursos->array as $row){ ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?php echo $row['nomePerfil']; ?></td>
                                                                        <td><?php echo $row['nomeFuncionario']; ?></td>
                                                                        <td>R$ <?php echo $row['Vlr_taxa_compra']; ?></td>
                                                                        <td><?php echo $row['mes_alocacao']; ?></td>
                                                                        <td><?php echo $row['Qtd_hrs_estimada']; ?></td>
                                                                        <td>0</td>
                                                                        <td>
                                                                        <i onclick="excluiRec(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                                        </td>
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
                                            <div>
                                                <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                                            </div>
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
                                            <div class="col s6">
                                            <label for="num_parcela">Parcela</label>
                                              <input type="text" id="Num_parcela" name="Num_parcela" class="validate" maxlength="3">
                                            </div>

                                            <div class="col s6">
                                            <label for="Vlr_parcela_cimp">Valor Com impostos R$</label>
                                              <input type="text" onkeypress="moeda(this)" id="Vlr_parcela_cimp" name="Vlr_parcela_cimp" class="validate" maxlength="255">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col s6">
                                            <label for="mes_previsao_fat">Mês / Ano</label>
                                              <input type="text" id="mes_previsao_fat" name="mes_previsao_fat" class="validate" maxlength="7">
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
                                            <div class="col s4">
                                                <label for="id_funcionario">Profissional</label>
                                                <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                                  <option value="">Selecione</option>
                                                    <?php $funcionario->montaSelect(); ?>
                                                </select> 
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
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                            <div class="col s1"></div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </form>    
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
                                            <div class="col s2">
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
                                                        <td><?php echo $row['Vlr_unit']; ?></td>
                                                        <td><?php echo $row['Vlr_total']; ?></td>
                                                        <td><?php echo $row['Aprovado']; ?></td>
                                                        <td>
                                                        <i onclick="excluiDesp(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div id="fluxoFin" class="col s12">
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
                                            <div class="col s2">
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
    </div>

  
<?php
  require_once(app::path.'/view/footer.php');
?>

<script>
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