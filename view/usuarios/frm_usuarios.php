<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Usuários
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Usuários</a></li>
            <li><a href="#">Cadastro de usuários</a></li>
          </ol> 
                  
      </div>
    
         <div id="page-inner"> 
         <div class="row">
         <div class="col-lg-12">
         <div class="card">
                <div class="card-action">
                    Cadastro de Usuários
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

                    <form class="col s12" action="usuarios.php" method="post" name="cad_usuarios">
                      <div class="row">
                        <div class="col s6">
                        <label for="nome">Nome</label>
                          <input type="text" id="nome" name="nome" class="validate" maxlength="255">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="email">Email</label>
                          <input type="text" id="email" name="email" class="validate" maxlength="255">
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col s3">
                            <label for="id_perfilusuario">Perfil</label>
                            <select id="id_perfilusuario" name="id_perfilusuario" class="form-control input-sm">
                              <option value="" disabled selected>Perfil</option>
                              <?php $usuario->montaSelect($row['id']); ?>
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s3">
                            <label for="id_responsabilidade">Responsabilidade</label>
                            <select id="id_responsabilidade" name="id_responsabilidade" class="form-control input-sm">
                              <option value="">Responsabilidades</option>
                                <?php $responsabilidade->montaSelect($row['id']); ?>
                            </select>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col s3">
                        <label for="senha">Senha</label>
                          <input type="password" id="senha" name="senha" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row">
                        <label for="senha">Resetar Senha</label><br>
                          <p>
                            <input class="with-gap" name="reset_senha" value="S" checked type="radio" id="test3"  />
                            <label for="test3">Sim </label>
                          
                            <input class="with-gap" name="reset_senha" value="N" type="radio" id="test2" />
                            <label for="test2">Não </label>
                          </p>
                      </div>

                      <div class="row">
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="" disabled selected>Status (Ativo)</option>
                            <option value="A">Ativo</option>
                            <option value="I">Inativo</option>
                          </select>
                        </div>
                      </div>

                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="usuarioID" name="usuarioID" value="<?php echo $usuario->usuarioID; ?>">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <input type="reset" name="Limpar" value="Limpar" class="waves-effect waves-light btn">
                        </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
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
<script src="<?php echo app::dominio; ?>view/assets/js/usuarios/usuario.js"></script>