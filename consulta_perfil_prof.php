<?php
    require_once('model/perfilprof.php');
    $perfilprof = new perfilprof;
    $perfilprof->lista();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Consulta de Perfis Profissionais.
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Cadastros Básicos</a></li>
          <li><a href="#">Perfil Profissional</a></li>
          <li class="active">Busca de Perfis Prof.</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Busca de Perfis
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <form action="perfil_prof.php" method="post" id="perfil_edit">
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
                                        if (!empty($perfilprof->array)) {
                                            foreach($perfilprof->array as $row){ ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo $row['codigo']; ?></td>
                                                    <td><?php echo $row['nome']; ?></td>
                                                    <td><?php echo $row['status']; ?></td>
                                                    <td>
                                                        <i onclick="edita(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">mode_edit</i>
                                                        <i onclick="exclui(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">delete</i>
                                                        </td>
                                                    </tr>
                                            <?php } } ?>
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
        document.getElementById('perfil_edit').submit();
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
        document.getElementById('perfil_edit').submit();
    }   
}

</script>