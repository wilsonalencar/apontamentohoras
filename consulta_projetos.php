<?php
    require_once('model/projeto.php');
    $projeto = new projeto;
    $projeto->lista_consulta();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Consulta de projetos.
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Projetos</a></li>
          <li class="active">Busca de projetos</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Busca de projetos
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
                            <form action="projetos.php" method="get" id="projetos_edit">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Cód. Projeto</th>
                                            <th>Pilar</th>
                                            <th>Cód. Proposta</th>
                                            <th>Cliente</th>
                                            <th>Status</th>
                                            <th>Listar</th>
                                            <th>Alterar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($projeto->array)) {
                                         foreach($projeto->array as $row){ ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['pilar']; ?></td>
                                                <td><?php echo $row['codigo']; ?></td>
                                                <td><?php echo $row['nome']; ?></td>
                                                <td><?php echo $row['descricao']; ?></td>
                                                <td><?php echo $row['listar']; ?></td>
                                                <td>
                                                    <i onclick="edita(this.id)" id="<?php echo $row['id']; ?>" class="material-icons">mode_edit</i>
                                                    </td>
                                                </tr>
                                            <?php } } ?>
                                       </tbody>
                                    </table>
                                <input type="hidden" value="0" name="id" id="id">
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
                   columns: [ 0, 1, 2, 3, 4, 5]
                }
             },
             {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5]
                }
             },
             {
                extend: 'csvHtml5',
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5]
                }
             },
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5]
                }
             },
         ]
    });  

function edita(id) {
    if (id > 0) {
        document.getElementById('id').value = id;
        document.getElementById('projetos_edit').submit();
    }
}

</script>