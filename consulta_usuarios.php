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
                            <form action="usuarios.php" method="post" id="usuarios_edit">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Perfil</th>
                                            <th>Alterar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($usuario->array)) {
                                         foreach($usuario->array as $row){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['nome']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['id_perfilusuario']; ?></td>
                                                <td>
                                                    <i onclick="edita(this.id)" id="<?php echo $row['usuarioID']; ?>" class="material-icons">mode_edit</i>
                                                    <i onclick="exclui(this.id)" id="<?php echo $row['usuarioID']; ?>" class="material-icons">delete</i>
                                                    </td>
                                                </tr>
                                            <?php } }?>
                                       </tbody>
                                    </table>
                                <input type="hidden" value="0" name="usuarioID" id="id">
                                <input type="hidden" value="0" name="action" id="action">
                                </form>
                            </div>  
                        </div>
                    </div>
<?php
    require_once(app::path.'view/footer.php');
?>
<script>
$('#dataTables-example').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        dom: '<B>frtip',
        buttons: [
             {
                extend: 'copyHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2]
                }
             },
             {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2]
                }
             },
             {
                extend: 'csvHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2]
                }
             },
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2]
                }
             },
         ]
    });  

function edita(id) {
    if (id > 0) {
        document.getElementById('id').value = id;
        document.getElementById('usuarios_edit').submit();
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
        document.getElementById('usuarios_edit').submit();
    }   
}

</script>