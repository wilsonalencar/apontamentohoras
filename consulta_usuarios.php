<?php
    require_once('model/usuario.php');
    $usuario = new usuario;
    $usuario->lista();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Consulta de Usuários.
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Usuários</a></li>
          <li class="active">Busca de Usuários</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Busca de Usuários
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Data de Nascimento</th>
                                            <th>Alterar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($usuario->array as $row){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['nome']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['data_nascimento']; ?></td>
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