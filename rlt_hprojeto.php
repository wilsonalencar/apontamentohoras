<?php
    require_once('model/projeto.php');
    $projeto = new projeto;
    $projeto->id = $projeto->getRequest('id', 0);
    $projeto->data_busca_ini = $projeto->getRequest('data_busca_ini', 0);
    $projeto->data_busca_fim = $projeto->getRequest('data_busca_fim', 0);
    $projeto->relatorioFunc();
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Horas por projetos
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Relatórios</a></li>
          <li class="active">Horas por projetos</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-action">
                 Selecione um método para geração de relatório.
            </div>
            <div class="card-content">
                <a href="#" data-toggle="modal" data-target="#ModalPesquisa">Filtrar geração de relatórios</a><br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="display:none">
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
                            if (!empty($projeto->array['dados'])) {
                             foreach($projeto->array['dados'] as $id_func => $dados) {
                                   foreach ($dados as $key => $value_fim) { 
                                      if (is_array($value_fim)) { ?>

                                    <tr class="odd gradeX">
                                        <td><?php echo $value_fim['nomepilar']; ?></td>
                                        <td style="width: 30%"><?php echo $value_fim['projeto1']; ?> - <?php echo $value_fim['projeto2']; ?></td>
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
                                  <th><?php echo $projeto->array['valorTotalGeral']; ?></th> 
                                </tr>
                                <?php } ?>
                           </tbody>
                        </table>
                </div>  
            </div>
                  <!-- Modal de Pesquisa -->
            <div id="ModalPesquisa" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Filtros</h4>
                </div>

                <form class="col s12" action="rlt_hprojeto.php" method="post" name="projeto">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col s4">
                        <label for="id_funcionario">Projeto</label><br />
                        <select id="id_funcionario" name="id" class="form-control input-sm">
                            <option value="">Projeto</option>
                                <?php $projeto->montaSelect($projeto->id); ?>
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                            Data Início
                            <input type="date" name="data_busca_ini" class="validate" value="<?php if (!empty($projeto->data_busca_ini)) {
                              echo $projeto->data_busca_ini;
                            } ?>" maxlength="8">
                        </div>
                        <div class="col s4">
                            Data Fim
                            <input type="date" name="data_busca_fim" class="validate" value="<?php if (!empty($projeto->data_busca_fim)) {
                              echo $projeto->data_busca_fim;
                            }?>" maxlength="8">
                        </div>
                      </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">OK</button>
                        <div class="col s1"></div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </form>    
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
        "bSort": false,
        paging: false,
        dom: '<B>',
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
                customize: function ( doc ) {
                    doc.content.splice( 0, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'left',
                        image: 'data:image/jpeg;base64,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'
                    } );
                },
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Horas por Projetos',
                header: 'Horas por Projetos'
             },
         ]
    });  
</script>