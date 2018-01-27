<?php
    require_once('model/funcionario.php');
    $funcionario = new funcionario;
    $funcionario->relatorioFunc();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Horas por recursos
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Cadastros Básicos</a></li>
          <li><a href="#">Relatórios</a></li>
          <li class="active">Horas por recursos</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
    <!-- Advanced Tables -->
                    <div class="card">
                        <div class="card-action">
                             Selecione um método para geração de relatório.
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="display: none">
                                    <thead>
                                        <tr>
                                            <th>Pilar</th>
                                            <th>Projeto</th>
                                            <th>Recurso</th>
                                            <th>Atividade</th>
                                            <th>Data</th>
                                            <th>Horas</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if (!empty($funcionario->array['dados'])) {
                                         foreach($funcionario->array['dados'] as $id_func => $dados) {
                                               foreach ($dados as $key => $value_fim) { 
                                                  if (is_array($value_fim)) { ?>

                                                <tr class="odd gradeX">
                                                    <td><?php echo $value_fim['nomepilar']; ?></td>
                                                    <td><?php echo $value_fim['projeto1']; ?> - <?php echo $value_fim['projeto2']; ?></td>
                                                    <td><?php echo $value_fim['nomefuncionario']; ?></td>
                                                    <td><?php echo $value_fim['atividade']; ?></td>
                                                    <td><?php echo $value_fim['data_apont']; ?></td>
                                                    <td><?php echo $value_fim['qtd_hrs']; ?></td>
                                                    <td><?php echo $value_fim['status']; ?></td>
                                                </tr>

                                            <?php } }?>

                                              <tr> 
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th>Total horas:</th>
                                                <th><?php echo $dados['valorTotal']; ?></th> 
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th></th>
                                                <th>&nbsp;</th> 
                                              </tr>
                                            <?php } ?>
                                            <tr> 
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <th>Total Geral :</th>
                                              <th><?php echo $funcionario->array['valorTotalGeral']; ?></th> 
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
$('#dataTables-example').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        dom: '<B>',
        "bSort": false,
        paging: false,
        buttons: [
             {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
             },
             {
                extend: 'csvHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
             },
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6]
                },
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Horas por Recurso',
                header: 'Horas por Recurso'
             },
         ]
    });  
</script>