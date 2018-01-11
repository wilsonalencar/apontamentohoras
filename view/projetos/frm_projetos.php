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
                                  <li class="tab col s3"><a href="#test2">Despesas</a></li>
                                  <li class="tab col s3"><a href="#test4">Fluxo Financeiro</a></li>
                              </ul>
                            </div>
                            <div class="clearBoth"><br/></div>
                            
                                <div id="test1" class="col s12">
                                    <form class="col s12" action="projetos.php" method="post" name="cad_projetos">
                                      <div class="row">
                                        <div class="col s9">
                                            <label for="id_cliente">Cliente</label>
                                            <select id="id_cliente" name="id_cliente" class="form-control input-sm">
                                              <option value="">Cliente</option>
                                              <?php $cliente->montaSelect($row['id']); ?>
                                            </select>
                                        </div>
                                      </div>    
                                      
                                    <div class="row">
                                        <div class="col s5">
                                            <label for="id_proposta">Proposta</label>
                                            <select id="id_proposta" name="id_proposta" class="form-control input-sm">
                                              <option value="">Proposta</option>
                                                <?php $proposta->montaSelect($row['id']); ?>
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
                                                <?php $pilar->montaSelect($row['id']); ?>
                                            </select>
                                        </div>    
                                        <div class="col s4">
                                        <label for="Status">Status</label>
                                          <select id="status" name="status" class="form-control input-sm">
                                            <option value="">Status</option>
                                                <?php $statusProj->montaSelect($row['id']); ?>
                                          </select>
                                        </div>
                                    </div>
                                    <br />

                                        <div class="row">
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
                                                                        <a href="#" style="color : #fff;">+</a>
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
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Jan / 2018</td>
                                                                    <td>R$ 1.000,00</td>
                                                                    <td>R$ 2.000,00</td>
                                                                    <td><a href="#">X</a></td>
                                                                </tr>
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
                                                                    <td>Teste_jpg.pdfaspmaps</td>
                                                                    <td><a href="#">X</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>    
                                            </div>


                                        </div>


                                        <div class="row">
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
                                                                        <a href="#" style="color : #fff;">+</a>
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
                                                                <tr>
                                                                    <td>Filho de Deus</td>
                                                                    <td>Jesus</td>
                                                                    <td>30 moedas de prata</td>
                                                                    <td>Jan / 2018</td>
                                                                    <td>120.00</td>
                                                                    <td>10.00</td>
                                                                    <td><a href="#">X</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s1">
                                            </div>
                                            <input type="hidden" id="usuarioID" name="usuarioID" value="<?php echo $projeto->id; ?>">
                                            <input type="hidden" id="action" name="action" value="1">
                                            <div class="col s7"></div>
                                            <div>
                                                <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                


                                <div id="test2" class="col s12">
                                    <p>Lorem ipsum dolor sit am1231et, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                </div>



                                <div id="test4" class="col s12">
                                    <p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    </p>
                                </div>


                      </div>

                  <div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
      </div>

  
<?php
  require_once(app::path.'/view/footer.php');
?>
<script src="<?php echo app::dominio; ?>view/assets/js/usuarios/usuario.js"></script>