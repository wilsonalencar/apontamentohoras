<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Liberar Projetos
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Cadastros Básicos</a></li>
            <li><a href="#">Projetos</a></li>
            <li class="active">Liberar Projeto</li>
          </ol> 
      </div>
    
         <div id="page-inner"> 
         <div class="row">
         <div class="col-lg-12">
         <div class="card">
                <div class="card-action">
                    Liberar Projeto
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

                    <form class="col s12" action="liberar_projetos.php" method="post" name="cad_time">
                      <div class="row">
                        <div class="col s3">
                       <label for="id_projeto">Projetos : </label>
                          <select id="id_projeto" onchange="addParam()" name="id_projeto" class="form-control input-sm">
                            <option value="">Projetos</option>
                              <?php $projeto->montaSelect($liberaprojetos->id_projeto); ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="id_funcionario">Funcionario: </label> 
                            <select id="id_funcionario" name="id_funcionario" class="form-control input-sm">
                                <option value="">Funcionario</option>
                                <?php $funcionario->montaSelect($liberaprojetos->id_funcionario); ?>
                            </select>
                        </div>
                        <br>    
                        <input type="submit" name="salvar" value="Adicionar" id="submit" class="waves-effect waves-light btn">
                      </div>
                    <input type="hidden" id="action" name="action" value="1">
                    </form>

                  <div class="table-responsive col s6">
                    <form action="liberar_projetos.php" method="post" id="projetorecurso_edit">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Equipe do Projeto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($lista)) {
                                foreach($lista as $row){ ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['nome']; ?></td>
                                        <td>
                                        <i onclick="exclui(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                        </td>
                                    </tr>
                                <?php } }?>
                           </tbody>
                        </table>
                        <input type="hidden" name="id_projeto_D" value="<?php echo $liberaprojetos->id_projeto; ?>">
                        <input type="hidden" id="id" name="id" value="0">
                        <input type="hidden" id="action" name="action" value="3">
                    </form>
                  </div>

                  <div class="clearBoth"></div>
                  </div>

                  </div>
                  </div>
            </div>
      </div>
      <form action="liberar_projetos.php" method="get" id="form_busca">
        <input type="hidden" name="id_projeto" id="id_projeto_ap">
      </form>

<?php
  require_once(app::path.'/view/footer.php');
?>
<script type="text/javascript">
function addParam(){
    var id_projeto = document.getElementById("id_projeto").value;

    if (id_projeto > 0) {
        document.getElementById('id_projeto_ap').value = id_projeto;
    }

    document.getElementById('form_busca').submit();
} 

function exclui(id) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (id > 0) {
        document.getElementById('id').value = id;
        document.getElementById('projetorecurso_edit').submit();
    }   
}

$(document).ready(function (){
    $('#dataTables-example').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        dom: '<"centerBtn"B>rtip',
        buttons: [

         ]
    });        
});
</script>