<?php
	require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
		  <div class="header"> 
            <h1 class="page-header">
                 Apontamentos
            </h1>
					<ol class="breadcrumb">
					  <li><a href="#">Cadastros Básicos</a></li>
					  <li><a href="#">Apontamentos</a></li>
					  <li class="active">Liberar Apontamento</li>
					</ol> 									
		  </div>

         <div id="page-inner"> 
    		 <div class="row">
    		 <div class="col-lg-12">
    		 <div class="card">
                <div class="card-action">
                    Liberação de Apontamentos
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
                    <form class="col s12" action="projetoapontamentos.php" method="post" name="projetoapontamentos">
                      <div class="row">
                        <div class="col s1">

                          <label for="periodo_libera">Período</label>
                          <input type="text" id="periodo_libera" name="periodo_libera" value="<?php if (!empty($projetoapontamento->periodo_libera)) {
                            echo $projetoapontamento->periodo_libera; } ?>" onchange="carregaFunc()" class="validate" maxlength="7">
                        </div>
                      </div>
                      <div class="row">
                        <label for="libera">Liberar ?</label>
                          <p>
                            <input class="with-gap" name="libera" value="<?php echo funcionalidadeConst::LIBERA_TRUE ?>" type="radio" id="test3" <?php if ($projetoapontamento->libera == funcionalidadeConst::LIBERA_TRUE): ?>
                              checked
                            <?php endif ?>/>
                            <label for="test3">Sim </label>
                          
                            <input class="with-gap" name="libera" value="<?php echo funcionalidadeConst::LIBERA_FALSE ?>" type="radio" id="test2" <?php if ($projetoapontamento->libera == funcionalidadeConst::LIBERA_FALSE): ?>
                              checked
                            <?php endif ?> />
                            <label for="test2">Não </label>
                          </p>
                      </div>
                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $projetoapontamento->id; ?>">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s1">
                            <button type="submit" class="btn btn-success" > Salvar</button>
                        </div>
                      </div>
                    </form>

                	<div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
      </div>
      <form action="projetoapontamentos.php" method="post" id="form_busca">
        <input type="hidden" name="periodo_libera" id="periodo_libera_b">
        <input type="hidden" name="action" value="2">
      </form>
	
<?php
	require_once(app::path.'/view/footer.php');
?>
<script type="text/javascript">
  function carregaFunc(){
    var periodo_libera = document.getElementById("periodo_libera").value;
    if (periodo_libera != '') {
        document.getElementById('periodo_libera_b').value = periodo_libera;
    }
    document.getElementById('form_busca').submit();
} 
</script>
<script src="<?php echo app::dominio; ?>view/assets/js/projetoapontamento/liberaapontamento.js"></script>