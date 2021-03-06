<?php
    require_once('model/apontamento.php');
    require_once('model/projeto.php');
    require_once('model/funcionario.php');

    $apontamento = new apontamento;
    $funcionario = new funcionario;

    $action = $apontamento->getRequest('action', 0);
    if ($action == 4) {
      echo $funcionario->montaSelect(0, 0, 0, true);
      exit;
    }
    $datasbusca = false;
    $dataIni = '';
    $dataFim = '';
    $funcionariodados = 0;
    $apontamento->id_funcionario = $apontamento->getRequest('id_funcionario', 0);
    $apontamento->data_busca_ini = $apontamento->getRequest('data_busca_ini', 0);
    $apontamento->data_busca_fim = $apontamento->getRequest('data_busca_fim', 0);
    $apontamento->relatorioFunc();
    

    if (!empty($apontamento->data_busca_ini) && !empty($apontamento->data_busca_fim)) {
      $timestamp = strtotime($apontamento->data_busca_ini);
      $dataIni = date("d/m/Y", $timestamp);
      
      $timestamp = strtotime($apontamento->data_busca_fim);
      $dataFim = date("d/m/Y", $timestamp);
      $datasbusca = true;
    }
    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Relatório de apontamentos
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Relatórios</a></li>
          <li class="active">Apontamento</li>
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
                <a href="#" data-toggle="modal" data-target="#ModalPesquisa">Selecione o Filtro</a><br><br>
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="display:none;" >
                        <thead>
                            <tr>
                                <th>Data Apontamento</th>
                                <th>Entrada 1</th>
                                <th>Saída 1</th>
                                <th>Entrada 2</th>
                                <th>Saída 2</th>
                                <th>Horas Trabalhadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($apontamento->array['dados'])) {
                             foreach($apontamento->array['dados'] as $id_func => $dados) {
                              $count = count($dados) + 5;

                              while ($count > 27) {
                                $count = $count - 27;
                              }
                                    foreach ($dados as $key => $value_fim) { 
                                      if (is_array($value_fim)) { 

                                        $funcionariodados = $value_fim['id_funcionario'] .' - '. $value_fim['Razao_social'];
                                        if (empty($value_fim['Razao_social'])) {
                                          $funcionariodados = $value_fim['nome'];
                                        }

                                        ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $value_fim['data_apontamento']; ?></td>
                                        <td><?php echo str_replace('.', ',', $value_fim['Entrada_1']); ?></td>
                                        <td><?php echo str_replace('.', ',', $value_fim['Saida_1']); ?></td>
                                        <td><?php echo str_replace('.', ',', $value_fim['Entrada_2']); ?></td>
                                        <td><?php echo str_replace('.', ',', $value_fim['Saida_2']); ?></td>
                                        <td><?php echo str_replace('.', ',', $value_fim['Qtd_hrs_real']); ?></td>
                                    </tr>
                                <?php } }?>

                                  <tr> 
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>Total:</th>
                                    <th><?php echo str_replace('.', ',', $dados['Qtd_hrs_real']); ?></th> 
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th></th>
                                    <th>&nbsp;</th> 
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th></th>
                                    <th>&nbsp;</th> 
                                  </tr>
                                 <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <th align="left"></th>
                                   <th align="left">________________________________</th>
                                 </tr>
                                 <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <th></th>
                                   <th align="left"><?php echo $funcionariodados; ?></th>
                                 </tr>
                                  
                                <?php
                                while ($count <= 27) {
                                  $count++;
                                  echo "<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th></th>
                                    <th>&nbsp;</th> 
                                  </tr>";
                                } } } ?>
                           </tbody>
                        </table>
                </div>  
            </div>
                  <!-- Modal de Pesquisa -->
            <div id="ModalPesquisa" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Filtros</h4>
                </div>

                <form class="col s12" action="rlt_apontamento.php" method="post" name="projeto">
                    <div class="modal-body">
                      <div class="row">
                          
                          <div class="col s4">
                          <label for="id_funcionario">Funcionario</label><br />
                            <select id="id_funcionario" name="id_funcionario" class="form-control input-sm id_funcionario_class">
                                <option value="">Funcionario</option>
                                    <?php $funcionario->montaSelect($apontamento->id_funcionario); ?>
                            </select>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col s4">
                            Data Início
                            <input type="date" name="data_busca_ini" class="validate" value="<?php if (!empty($apontamento->data_busca_ini)) {
                              echo $apontamento->data_busca_ini;
                            } ?>" maxlength="8">
                        </div>
                        <div class="col s4">
                            Data Fim
                            <input type="date" name="data_busca_fim" class="validate" value="<?php if (!empty($apontamento->data_busca_fim)) {
                              echo $apontamento->data_busca_fim;
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
        buttons: [
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [0, 1, 2, 3, 4, 5]
                },
                "autoWidth": true,
                customize: function ( doc ) {
                  doc.pageMargins = [80,80,20,40];
                  doc.defaultStyle.fontSize = 9;
                  doc.styles.tableHeader.fontSize = 11;
                  doc.styles.tableBodyEven.alignment = 'center';
                  doc.styles.tableBodyOdd.alignment = 'center';
                      doc['header']=(function() {
                      return {
                        columns: [
                          {
                            alignment: 'left',
                            image: logo,
                            width: 80
                          },
                          {
                            alignment: 'right',
                            italics: true,
                            text: 'Relatório <?php if ($datasbusca) { ?> \n Período : <?php echo $dataIni; ?> à <?php echo $dataFim; ?> <?php } ?>',
                            fontSize: 12,
                            margin: [10,0]
                          },
                          {
                            alignment: 'right',
                            fontSize: 12,
                            text: 'Apontamentos'
                          }
                        ],
                        margin: 20  
                      }
                    });
                },
                title: '',
                pageSize: 'A4'
             }
         ]
    });  


</script>