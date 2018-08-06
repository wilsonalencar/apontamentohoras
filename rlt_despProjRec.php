<?php
    require_once('model/projetodespesa.php');
    require_once('model/projeto.php');
    require_once('model/funcionario.php');

    $projetodespesa = new projetodespesa;
    $projeto = new projeto;
    $funcionario = new funcionario;
    $projetodespesa->id_funcionario = 0;

    $datasbusca = false;
    $uniqueSelected = false;
    $dataIni = '';
    $dataFim = '';
    $projetodados = 0;

    $projetodespesa->id_funcionario = $projetodespesa->getRequest('id_funcionario', 0);
    if (!empty($_SESSION['id_funcionario']) && in_array($_SESSION['id_perfilusuario'], array($funcConst::PERFIL_RECURSO, $funcConst::PERFIL_GERENTEPROJETOS))) {
      $uniqueSelected = true;
      $projetodespesa->id_funcionario = $_SESSION['id_funcionario'];
    }

    $action = $projetodespesa->getRequest('action', 0);
    if ($action == 4) {

      $funcionario->id_projeto = $funcionario->getRequest('id_projeto', '');
      echo $funcionario->montaSelect($projetodespesa->id_funcionario, $funcionario->id_projeto, 0, true, $uniqueSelected);
      exit;
    }

  
    $projetodespesa->id_projeto     = $projetodespesa->getRequest('id_projeto', 0);
    $projetodespesa->data_busca_ini = $projetodespesa->getRequest('data_busca_ini', 0);
    $projetodespesa->data_busca_fim = $projetodespesa->getRequest('data_busca_fim', 0);
    $projetodespesa->relatorioFunc();
    

    if (!empty($projetodespesa->data_busca_ini) && !empty($projetodespesa->data_busca_fim)) {
      $timestamp = strtotime($projetodespesa->data_busca_ini);
      $dataIni = date("d/m/Y", $timestamp);
      
      $timestamp = strtotime($projetodespesa->data_busca_fim);
      $dataFim = date("d/m/Y", $timestamp);
      $datasbusca = true;
    }
    

    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Despesas por Projeto e Recurso
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Relatórios</a></li>
          <li class="active">Despesas por projetos e recursos</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">  
    <div class="col-md-12">
        <div class="card">
            <div class="card-action">
                 Selecione um Projeto para geração do relatório.
            </div>
            <div class="card-content">
                <a href="#" data-toggle="modal" data-target="#ModalPesquisa">Selecione o Projeto</a><br><br>
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="display:none" >
                        <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Data da Despesa</th>
                                <th>Tipo Despesa</th>
                                <th>Reembolso</th>
                                <th>Nº Doc</th>
                                <th>Qtd.</th>
                                <th>Valor Unitário</th>
                                <th>Valor total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (!empty($projetodespesa->array['dados'])) {
                             foreach($projetodespesa->array['dados'] as $id_func => $dados) {

                                $projetodados = $dados['projeto'];
                                    foreach ($dados as $key => $value_fim) { 
                                      if (is_array($value_fim)) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $value_fim['nomefuncionario']; ?></td>
                                        <td><?php echo $value_fim['data_despesa']; ?></td>
                                        <td><?php echo $value_fim['tipodespesa']; ?></td>
                                        <td><?php echo $value_fim['reembolso']; ?></td>
                                        <td><?php echo $value_fim['documento']; ?></td>
                                        <td><?php echo $value_fim['quantidade']; ?></td>
                                        <td>R$ <?php echo number_format($value_fim['Vlr_Unit'], 2, ',', '.'); ?></td>
                                        <td>R$ <?php echo number_format($value_fim['Vlr_Total'], 2, ',', '.'); ?></td>
                                        <td><?php echo $value_fim['status']; ?></td>
                                    </tr>
                                <?php } }?>

                                  <tr> 
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>Valor total:</th>
                                    <th>R$ <?php echo number_format($dados['valorTotal'], 2, ',', '.'); ?></th> 
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th></th>
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
                                  <td></td>
                                  <th>Total Geral :</th>
                                  <th>R$ <?php echo $projetodespesa->array['valorTotalGeral']; ?></th> 
                                  <td></td>
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

                <form class="col s12" action="rlt_despProjRec.php" method="post" name="projeto">
                    <div class="modal-body">
                      <div class="row">
                          <div class="col s4">
                          <label for="id_projeto">Projeto</label><br />
                          <select id="id_projeto" name="id_projeto" class="form-control input-sm id_projeto_class">
                              <option value="">Projeto</option>
                                  <?php $projeto->montaSelect($projetodespesa->id_projeto, false, $_SESSION['id_funcionario']); ?>
                          </select>
                          </div>
                          <div class="col s4">
                          <label for="id_projeto">Funcionario</label><br />
                            <select id="id_funcionario" name="id_funcionario" class="form-control input-sm id_funcionario_class">
                                <option value="">Funcionario</option>
                                    <?php $funcionario->montaSelect($projetodespesa->id_funcionario, 0, 0, false, $uniqueSelected); ?>
                            </select>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                            Data Início
                            <input type="date" name="data_busca_ini" class="validate" value="<?php if (!empty($projetodespesa->data_busca_ini)) {
                              echo $projetodespesa->data_busca_ini;
                            } ?>" maxlength="8">
                        </div>
                        <div class="col s4">
                            Data Fim
                            <input type="date" name="data_busca_fim" class="validate" value="<?php if (!empty($projetodespesa->data_busca_fim)) {
                              echo $projetodespesa->data_busca_fim;
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
        var logo = 'data:image/jpeg;base64,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';
$('#dataTables-example').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        "bSort": false,
        paging: false,
        dom: '<B>',
        <?php if ($projetodespesa->id_projeto > 0) { ?>
        buttons: [
             {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
             },
             {
                extend: 'csvHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
             },
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                "autoWidth": true,
                customize: function ( doc ) {
                  doc.pageMargins = [30,60,20,30];
                  doc.defaultStyle.fontSize = 12;
                  doc.styles.tableHeader.fontSize = 13;
                      doc['header']=(function() {
                      return {
                        columns: [
                          {
                            alignment: 'left',
                            image: logo,
                            width: 60
                          },
                          {
                            alignment: 'right',
                            italics: true,
                            text: '<?php echo $projetodados; ?> \n <?php if ($datasbusca) { ?> Período : <?php echo $dataIni; ?> à <?php echo $dataFim; ?> <?php } ?>',
                            fontSize: 12,
                            margin: [10,0]
                          },
                          {
                            alignment: 'right',
                            fontSize: 12,
                            text: 'Despesas por Projeto e Recurso'
                          }
                        ],
                        margin: 20  
                      }
                    });
                },
                title: '',
                orientation: 'landscape',
                pageSize: 'A4'
             }
         ]
      <?php } ?>
    });  

$( document ).ready(function() {
    $( ".id_projeto_class" ).change(function() {
        $.ajax({
            url : "<?php echo app::dominio; ?>rlt_despProjRec.php",
            type: 'post',
            dataType: 'HTML',
            data: {"action": 4, "id_projeto": $(this).val()},
            success: function(d){
                $('.id_funcionario_class').html(d);
            }
        });
    });
});
</script>