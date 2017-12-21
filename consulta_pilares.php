<?php
    require_once('model/pilar.php');
    $pilar = new pilar;
    $pilar->lista();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Consulta de Pilares.
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Cadastros Básicos</a></li>
          <li><a href="#">Pilares</a></li>
          <li class="active">Busca de Pilare</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Busca de Pilares
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <form action="pilares.php" method="post" id="pilar_edit">
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
                                            if (!empty($pilar->array)) {
                                                foreach($pilar->array as $row){ ?>
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
        document.getElementById('pilar_edit').submit();
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
        document.getElementById('pilar_edit').submit();
    }   
}

</script>