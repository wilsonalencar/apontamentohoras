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
          <li><a href="#">Cadastros Básicos</a></li>
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
                            if (!empty($projeto->array['dados'])) {
                             foreach($projeto->array['dados'] as $id_func => $dados) {
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
                                <?php $projeto->montaSelectB($projeto->id); ?>
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
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Horas por Projetos',
                header: 'Horas por Projetos'
             },
         ]
    });  
</script>