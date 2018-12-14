<?php
    require_once('model/funcionario.php');
    require_once('model/fechamentoapontamento.php');
    require_once('model/apontamento.php');
    
    $funcionario = new funcionario;
    $apontamento = new apontamento;
    $fechamentoapontamento = new fechamentoapontamento;
    
    $fechamentoapontamento->periodo_busca = $fechamentoapontamento->getRequest('periodo_busca', '');
    $fechamentoapontamento->id_funcionario = $fechamentoapontamento->getRequest('id_funcionario', 0);
    
    $apontamento->listaFolgas($fechamentoapontamento->periodo_busca, $fechamentoapontamento->id_funcionario);
    $apontamento->listaBanco($fechamentoapontamento->periodo_busca, $fechamentoapontamento->id_funcionario);
    $fechamentoapontamento->getFrontTimes();

    require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Banco de Horas por Recurso
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Relatórios</a></li>
          <li class="active">Banco de Horas por Recurso</li>
        </ol> 
                        
</div>
<div id="page-inner"> 
<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="row">
              <div class="col-md-12">
                <div class="card-action">
                      <div class="col-md-3">
                         <?php if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) { ?>
                          <label for="id_funcionario_busca">Funcionário: </label> 
                                  <select id="id_funcionario_busca" onchange="alterar_periodo()" name="id_funcionario_busca" class="form-control input-sm">
                                      <option value="">Funcionário</option>
                                      <?php 
                                          $funcionario->montaSelect($fechamentoapontamento->id_funcionario); 
                                      ?>
                                  </select>
                          <?php } else { ?>
                                  <?php 
                                      $profissional = $funcionario->findFuncionario();
                                      $id_funcionario = $profissional['id']; 
                                  ?>
                                  <p><?php echo $profissional['nome'] ?>  /  <?php echo $profissional['email'] ?></p>
                                  <input type="hidden" name="id_funcionario_busca" id="id_funcionario_busca" value="<?php echo $profissional['id']; ?>">
                          <?php }?>
                      </div>
                      <div class="col-md-3"></div>
                      <div class="col-md-2">
                        <label for="id_funcionario_busca">Período: </label> 
                          <input type="text" id="periodo_busca_form" name="periodo_busca_form" onchange="alterar_periodo()" value="<?php echo $fechamentoapontamento->periodo_busca; ?>" class="validate" maxlength="7">
                      </div>
                      <div class="col-md-2"></div>
                      <div class="col-md-2">
                        <br>
                        Saldo Inicial: <?php echo $fechamentoapontamento->frontTimes['saldo_inicial']; ?><br>
                        Horas Banco: <?php echo $fechamentoapontamento->frontTimes['horas_banco']; ?> <br>
                        Folgas: <?php echo $fechamentoapontamento->frontTimes['folgas']; ?><br>
                        Saldo Final: <?php echo $fechamentoapontamento->frontTimes['saldo_final']; ?>  
                      </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="test1" class="col s12">
                    <div  class="col s12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTables-example" style="font-size: 14px">
                                <thead>
                                    <tr style="display: none">
                                      <th> Relatório </th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background: #b2bec3;">
                                        <th align="left">
                                            <p> Banco de Horas - Projeto </p>
                                        </th>
                                        <th align="center">Data</th>
                                        <th>Entrada 1</th>
                                        <th>Saída 1</th>
                                        <th>Entrada 2</th>
                                        <th>Saída 2</th>
                                        <th>Qtd. Horas</th>
                                    </tr>
                                    <?php
                                    if (!empty($apontamento->arrayBanco)) {
                                    foreach($apontamento->arrayBanco as $row){  ?>
                                        <tr class="odd gradeX">
                                            <td style="width: 50%"><?php echo $row['nome_projeto']; ?></td>
                                            <td><?php echo $row['Data_apontamento']; ?></td>
                                            <td><?php echo $row['Entrada_1']; ?></td>
                                            <td><?php echo $row['Saida_1']; ?></td>
                                            <td><?php echo $row['Entrada_2']; ?></td>
                                            <td><?php echo $row['Saida_2']; ?></td>
                                            <td><?php echo str_replace('.', ',', $row['Qtd_hrs_real']); ?></td>
                                        </tr>
                                    <?php } }?>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td>&nbsp;</td>
                                    </tr>
                                
                                    <tr style="background: #b2bec3;">
                                        <th align="left">
                                            <p> Apontamento Folgas - Projeto </p>
                                        </th>
                                        <th>Data</th>
                                        <th>Entrada 1</th>
                                        <th>Saída 1</th>
                                        <th>Entrada 2</th>
                                        <th>Saída 2</th>
                                        <th>Qtd. Horas</th>
                                    </tr>
                                    <?php
                                    if (!empty($apontamento->arrayFolga)) {
                                    foreach($apontamento->arrayFolga as $row){  ?>
                                        <tr class="odd gradeX">
                                            <td style="width: 50%"><?php echo $row['nome_projeto']; ?></td>
                                            <td><?php echo $row['Data_apontamento']; ?></td>
                                            <td><?php echo $row['Entrada_1']; ?></td>
                                            <td><?php echo $row['Saida_1']; ?></td>
                                            <td><?php echo $row['Entrada_2']; ?></td>
                                            <td><?php echo $row['Saida_2']; ?></td>
                                            <td><?php echo str_replace('.', ',', $row['Qtd_hrs_real']); ?></td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                          <br>
                          <br>
                          <br>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>


<form action="rlt_bancohorasrecurso.php" method="post" id="form_busca">
    <input type="hidden" name="id_funcionario" id="id_funcionario_ap">
    <input type="hidden" name="periodo_busca" id="periodo_busca">
</form>

<?php
    require_once(app::path.'view/footer.php');
?>
<script>
  var logo = 'data:image/jpeg;base64,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';


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
                "autoWidth": true,
                customize: function ( doc ) {
                  doc.pageMargins = [30,60,20,30];
                  doc.defaultStyle.fontSize = 8;
                  doc.styles.tableHeader.fontSize = 9;
                      doc['header']=(function() {
                      return {
                        columns: [
                          {
                            alignment: 'right',
                            image: logo,
                            width: 60
                          },
                          {
                            alignment: 'center',
                            text: 'Banco Horas Por Recurso',
                            fontSize: 15,
                            margin: [10,0]  
                          }
                        ],
                        margin: 20  
                      }
                    });
                },
                title:'',
                pageSize: 'A4'
             },
         ]
    });  


function alterar_periodo()
{
    document.getElementById('periodo_busca').value = document.getElementById('periodo_busca_form').value;

    var id_funcionario = document.getElementById("id_funcionario_busca").value;
    if (id_funcionario > 0) {
        document.getElementById('id_funcionario_ap').value = id_funcionario;
    }
    document.getElementById('form_busca').submit();
}

</script>