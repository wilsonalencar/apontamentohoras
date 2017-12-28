<?php
    require_once('model/contratacao.php');
    $contratacao = new contratacao;
    $contratacao->lista();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Consulta de Contratações.
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Cadastros Básicos</a></li>
          <li><a href="#">Contratações</a></li>
          <li class="active">Busca de Contratações</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Busca de Contratações
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
                            <div class="table-responsive">
                                <form action="contratacoes.php" method="post" id="contratacao_edit">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nome</th>
                                                <th>Status</th>
                                                <th>Alterar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if (!empty($contratacao->array)) {
                                            foreach($contratacao->array as $row){ ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo $row['codigo']; ?></td>
                                                    <td><?php echo $row['nome']; ?></td>
                                                    <td><?php echo $row['status']; ?></td>
                                                    <td>
                                                        <i onclick="edita(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">mode_edit</i>
                                                        <i onclick="exclui(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                        </td>
                                                    </tr>
                                            <?php  } } ?>
                                       </tbody>
                                    </table>
                                <input type="hidden" value="0" name="id" id="id">
                                <input type="hidden" value="0" name="action" id="action">
                                </form>
                            </div>  
                        </div>
                    </div>
<?php
    require_once(app::path.'view/footer.php');
?>
<script>
$(document).ready(function () {
    $('#dataTables-example').dataTable();
});

function edita(id) {
    if (id > 0) {
        document.getElementById('id').value = id;
        document.getElementById('contratacao_edit').submit();
    }
}

function exclui(id) {
    var r = confirm("Certeza que quer excluir este registro?");
    if (r != true) {
        return false;
    } 
    if (id > 0) {
        document.getElementById('id').value = id;
        document.getElementById('action').value = "3";
        document.getElementById('contratacao_edit').submit();
    }   
}

</script>