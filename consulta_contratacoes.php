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
                            <div class="table-responsive">
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
                                        <?php foreach($contratacao->array as $row){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['codigo']; ?></td>
                                                <td><?php echo $row['nome']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td>E/D</td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
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
</script>