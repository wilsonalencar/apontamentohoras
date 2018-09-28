<?php
    require_once('model/projeto.php');
    require_once('model/pilar.php');
    require_once('model/cliente.php');
    require_once('model/statusProj.php');
    
    $statusProj       = new statusProj;
    $projeto          = new projeto;
    $cliente          = new cliente;
    $pilar            = new pilar;


    $msg    =  $projeto->getRequest('msg', ''); 
    $success = $projeto->getRequest('success', ''); 

    $projeto->id = $projeto->getRequest('id', 0);

    $farol = $projeto->getRequest('farol', 1);

    $projeto->farol = $projeto->getRequest('farol', 1);
    $projeto->tipofarol = $projeto->getRequest('tipofarol', 1);
    $projeto->statusID = $projeto->getRequest('statusID', 0);
    $projeto->id_cliente = $projeto->getRequest('id_cliente', 0);
    $projeto->id_pilar = $projeto->getRequest('id_pilar', 0);

    $projeto->relatorioAcompanhamento();
    require_once(app::path.'view/header.php');
?>
<style type="text/css">
  .circulo{
    color:#fff;
    width:24px;
    height:24px;
    line-height:24px;
    vertical-align:middle;
    text-align:center;
    font-size:1px;
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;
  }
</style>
<div id="page-wrapper">
<div class="header"> 
            <h1 class="page-header">
                Acompanhamento de Projetos
            </h1>
            <ol class="breadcrumb">
          <li><a href="#">Relatórios</a></li>
          <li class="active">Acompanhamento de Projetos</li>
        </ol> 
                        
</div>
<div id="page-inner"> 

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-action">
                 Listagem do acompanhamento dos projetos.
            </div>
            <div class="card-content" style="font-size: 11px">
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
                <a href="#" data-toggle="modal" data-target="#ModalPesquisa">Filtrar relatório</a><br><br>
                <a href="#" data-toggle="modal" style="display:none;" id="openmodal" data-target="#ModalEquipe"></a>
                <a href="#" data-toggle="modal" style="display:none;" id="openmodalObs" data-target="#ModalObs"></a>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Fechado</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Escopo</th>
                                <th>GP</th>
                                <th>Início Proj.</th>
                                <th>Término</th>
                                <th>Valor Venda Total</th>
                                <th>CM1% VD</th>
                                <th>CM1 Mês</th>  
                                <th>CM1 YTD</th>
                                <th>CM1 EAC</th>
                                <th>Farol Mês</th>
                                <th>Farol YTD</th>
                                <th>Farol EAC</th>
                                <th>Detalhes</th>
                                <th>Equipe</th>
                                <th>Obs</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (!empty($projeto->array)) {
                             foreach($projeto->array as $id_func => $dados) { 
                              if ($dados['CM1_Mes'] < 20) {
                                $corCM = 'red';
                              } elseif ($dados['CM1_Mes'] >= 20 && $dados['CM1_Mes'] <= 29) {
                                $corCM = 'yellow';
                              } elseif ($dados['CM1_Mes'] >= 30) {
                                $corCM = 'green';
                              } 
                              

                              if ($dados['CM1_YTD'] < 20) {
                                $corY = 'red';
                              } elseif ($dados['CM1_YTD'] >= 20 && $dados['CM1_YTD'] <= 29) {
                                $corY = 'yellow';
                              } elseif ($dados['CM1_YTD'] >= 30) {
                                $corY = 'green';
                              }

                              if ($dados['CM1_EAC'] < 20) {
                                $corE = 'red';
                              } elseif ($dados['CM1_EAC'] >= 20 && $dados['CM1_EAC'] <= 29) {
                                $corE = 'yellow';
                              } elseif ($dados['CM1_EAC'] >= 30) {
                                $corE = 'green';
                              }

                              ?>
                                  <tr class="odd gradeX">
                                      <td><?php echo $dados['status'] ?></td>
                                      <td><?php echo $dados['fechado'] ?></td>
                                      <td><?php echo $dados['cliente'] ?></td>
                                      <td><?php echo $dados['tipo'] ?></td>
                                      <td><?php echo $dados['escopo'] ?></td>
                                      <td><?php echo $dados['gp'] ?></td>
                                      <td><?php echo $dados['inicio'] ?></td>
                                      <td><?php echo $dados['termino_previsto'] ?></td>
                                      <td>R$<?php echo $dados['valor_venda_total'] ?></td>
                                      <td><?php echo $dados['CM1%_Venda'] ?>%</td>
                                      <td><?php echo $dados['CM1_Mes'] ?>%</td>
                                      <td><?php echo $dados['CM1_YTD'] ?>%</td>
                                      <td><?php echo $dados['CM1_EAC'] ?>%</td>
                                      <td><div class="circulo" style="background:<?php echo $corCM;?>;"></div></td>
                                      <td><div class="circulo" style="background:<?php echo $corY;?>;"></div></td>
                                      <td><div class="circulo" style="background:<?php echo $corE;?>;"></div></td>
                                      <td align="center"><a href="<?php echo app::dominio; ?>projetos.php?id=<?php echo $dados['id']?>&view=true&statusID=<?php echo $projeto->statusID?>&id_pilar=<?php echo $projeto->id_pilar ?>&id_cliente=<?php echo $projeto->id_cliente?>&farol=<?php echo $projeto->farol ?>&tipofarol=<?php echo $projeto->tipofarol ?>"><i class="fa fa-expand"></i></a></td>
                                      <?php if (!empty($dados['equipe'])) {
                                        $dados['equipe'] = str_replace(',', '-', $dados['equipe']);
                                      }  ?>
                                      <td><a onclick="EquipeModal('<?php echo $dados['equipe'];?>')"><i class="fa fa-expand"></i></a></td>
                                      
                                      <td><a onclick="ObsModal('<?php echo $dados['id'];?>')"><i class="fa fa-expand"></i></a></td>
                                  </tr>

                                <?php } } ?>
                        </tbody>
                    </table>
                </div>  
            </div>
            <div id="ModalEquipe" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Equipe</h4>
                </div>

                <div class="modal-content">
                    <p class="equipe" id="equipe"></p> 
                </div>   

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button> 
                </div>    
            </div>

            <div id="ModalObs" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Observações</h4>
                </div>

                <form name="observacao" action="observacoes.php" method="post">
                <div class="modal-content" style="height: 100%; margin-left: 10px">
                    <div id="obsContent">
                              
                    </div>
                    <!-- pula linha -->
                    <hr>
                    <!-- pula linha -->
                    
                    <div>
                      <div class="row">
                        <div class="col s10">
                        <label for="Observacao">Nova Observação</label>
                          <textarea rows="6" cols="50" name="observacao" id="observacao" style="height: 100%"></textarea>
                        </div>
                      </div>
                    </div>
                
                </div>    
                <div class="modal-footer">
                    <input type="hidden" name="id_projeto" id="id_projeto">
                    <input type="hidden" name="action" value="1">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <input type="submit" name="Inserir" class="btn btn-success">
                </div>
                </form>
            </div>

                  <!-- Modal de Pesquisa -->
            <div id="ModalPesquisa" class="modal fade" >
                <div class="modal-header">
                    <h4 class="modal-title">Filtros</h4>
                </div>

                <form class="col s12" action="acompanhamento_projetos.php" method="post" name="projeto">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="statusID" class="form-control input-sm">
                            <option value="">Todos</option>
                                <?php $statusProj->montaSelect(); ?>
                          </select>
                        </div>
                        <div class="col s3">
                        <label for="tipofarol">Cor do Farol</label>
                          <select id="tipofarol" name="tipofarol" class="form-control input-sm">
                            <option value="1">Todos</option>
                            <option value="2">Vermelho</option>
                            <option value="3">Amarelo</option>
                            <option value="4">Verde</option>
                          </select>
                        </div>
                        <div class="col s3">
                        <label for="id_cliente">Cliente</label>
                        <select id="id_cliente" name="id_cliente" class="form-control input-sm">
                          <option value="">Cliente</option>
                          <?php $cliente->montaSelect(); ?>
                        </select>
                        </div>
                        <div class="col s3">
                        <label for="id_pilar">Pilar</label>
                        <select id="id_pilar" name="id_pilar" class="form-control input-sm">
                          <option value="">Pilar</option>
                          <?php $pilar->montaSelect(); ?>
                        </select>
                        </div>
                      </div>
                      <div class="row" style="display: block">
                        <div class="col s4">
                          <label>Farol</label><br>
                            <p>
                              <input class="with-gap" name="farol" value="1" type="radio" id="test3" <?php echo ( $farol == 1 ? "checked" : "" ); ?> />
                              <label for="test3">Todos </label>
                            
                              <input class="with-gap" name="farol" value="2" type="radio" id="test4" <?php echo ( $farol == 2 ? "checked" : "" ); ?> />
                              <label for="test4">MÊS </label>

                              <input class="with-gap" name="farol" value="3" type="radio" id="test5" <?php echo ( $farol == 3 ? "checked" : "" ); ?> />
                              <label for="test5">YTD </label>

                              <input class="with-gap" name="farol" value="4" type="radio" id="test6" <?php echo ( $farol == 4 ? "checked" : "" ); ?> />
                              <label for="test6">EAC </label>
                            </p>
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
  window.onload = function(){
    document.getElementById("sideNav").click();
  }

    function EquipeModal(string){
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      string = string.replace("-", "<br>");
      $("#equipe").html(string);
      if(string == '') {
        $("#equipe").html('Esta equipe está vazia');
      }

      $("#openmodal").click();
    }


    function ObsModal(id){
      $("#id_projeto").val(id);
      
      $.ajax({
          url : "<?php echo app::dominio; ?>observacoes.php",
          type: 'post',
          dataType: 'HTML',
          data: {"action": 2, "id_projeto": id},
          success: function(d){
              $('#obsContent').html(d);
          }
      });

      $("#openmodalObs").click();
    }

    var logo = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQIAdgB2AAD/4gJASUNDX1BST0ZJTEUAAQEAAAIwQURCRQIQAABtbnRyUkdCIFhZWiAHzwAGAAMAAAAAAABhY3NwQVBQTAAAAABub25lAAAAAAAAAAAAAAAAAAAAAAAA9tYAAQAAAADTLUFEQkUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAApjcHJ0AAAA/AAAADJkZXNjAAABMAAAAGt3dHB0AAABnAAAABRia3B0AAABsAAAABRyVFJDAAABxAAAAA5nVFJDAAAB1AAAAA5iVFJDAAAB5AAAAA5yWFlaAAAB9AAAABRnWFlaAAACCAAAABRiWFlaAAACHAAAABR0ZXh0AAAAAENvcHlyaWdodCAxOTk5IEFkb2JlIFN5c3RlbXMgSW5jb3Jwb3JhdGVkAAAAZGVzYwAAAAAAAAARQWRvYmUgUkdCICgxOTk4KQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWFlaIAAAAAAAAPNRAAEAAAABFsxYWVogAAAAAAAAAAAAAAAAAAAAAGN1cnYAAAAAAAAAAQIzAABjdXJ2AAAAAAAAAAECMwAAY3VydgAAAAAAAAABAjMAAFhZWiAAAAAAAACcGAAAT6UAAAT8WFlaIAAAAAAAADSNAACgLAAAD5VYWVogAAAAAAAAJjEAABAvAAC+nP/bAEMAAwICAgICAwICAgMDAwMEBgQEBAQECAYGBQYJCAoKCQgJCQoMDwwKCw4LCQkNEQ0ODxAQERAKDBITEhATDxAQEP/bAEMBAwMDBAMECAQECBALCQsQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEP/AABEIABoAYwMBEQACEQEDEQH/xAAeAAACAgICAwAAAAAAAAAAAAAHCAQGAwUCCQABCv/EADoQAAIBAwIFAgQCCAUFAAAAAAECAwQFBgcRAAgSEyEJMRQiQVEyYRUWGCMzcYGRFyQlJzdSoaOx1P/EABwBAQACAgMBAAAAAAAAAAAAAAAEBgMFAgcIAf/EADcRAAIABAQBBwkJAAAAAAAAAAABAgMEEQUSITEGBxMUFVJxoRcyQVFhgZKx0SJDU1WRk9Lh8P/aAAwDAQACEQMRAD8AH3Kjy5YTzAfrL+uWpf6qCy/CmAnsH4ju9zq/isvt0D239/P04omHUUutzc5Hlt/vSer+M+Kazhrmeh0/O57330ta2ye9/AYE+nJogAT+0og2+pFDsP8Ay8bPqOn/ABfl9SjeVPGfy+/x/wASR6bd2vdh1E1N08TKJLviVgiMkFQJOqlMkdS8Szx+SEEkas2wPkKD52345YE4oZsyUneFfUw8q8qRPoKPEIpeSdHuvTZw3aei816a7PvItd6st6y7K7vY+X3lby3UO22iUo1wpZZWeROoqsphggkMSPsSvW25H0B3Asx0eETRHnb1/wBT80mxrKuTHMsQoo7RX3BbhWJWCNpoIGkig/eUyL1SsAg877t4B9uAKAPUi5pNhv6e2fgkb/wq/wD+PgCDdPVc1OwFqW56v8luZ4vYp5lgatnnngIY+dk+IpkR22BIXqXfb3HABK1G9Rqzaa6p6dW29YCG0w1Nt9Fc7RmguRXognADmWnMeytDIyCRevcIwb8uAHPikVow6uGVgCpU7gj7/nwApGR8+tN+1jJy04FgcF+pLHE8+U5HJczDBaIoIzLWP0CNusQp0qfmG8h6B54AElP6r2Z5/e7nBoHyiZnnVntsvbaugkmZyp36GkjggkEXUBuFZyduAOV59TTmJxO2z5FmPIRm9qs1CvdraypkrIYoIx7szvSdKgfc+OAC9gHqYcq+aYfbMnvGXy41XV0bNUWquTrmpZFdlKlk3Vhuu4I91IOw9gAk/KVhnLDlpyf9o3JIbT8L8L+ie5c3pO51dzu/hHzbbJ/Lf8+KLhsqjmZulO21tbHqzjav4iouZ6hl575s32VFba2/vGGbRr0w9v8AkqkA/LJJiR/Tp42fRsI7fiULr3lDvpTv9tFa5DL2KDNNacGxC5TVuFiz19dQPKvzOI5Wip5SdgQWhbyNhvt7eOPmBRZaibLl+b/engZ+VaRzuE0VZVwpVGiiS9sN4l3KLYk+iXGn+EuosgUB2yOlUsPBIFINh/3P9+LQdEj8ar5XW4Fphl+cW6nSpqsesVfdIIZdykkkEDyKrbediVG/5b8AdZ3Ldq7zS8yuGXDUG/8AqGYvprUJdZaJbHWWm2CREVEcSBZChCHrIX8X4D54Ar/O3ZNXKHQC6VGZ8/8AjGq1uW4UIONUVtt0UtQ5mHTIGgdnHR+I7DYgHfgA8w8s1NzP+mLp1i1DTRnKbLjUF2xuZtgRWIH3gLfRJk3jP03KMfwjgAZaL+pQmBck99seX1n+7GBquM2ajrNxNWdYZKaodW8t8OqOsv5wpv5kHAF+5LOWO7accoWo+ruY0VRU6gaq4vda12nBapioZKWV4Izv57kzN3n+p64wfK8AVf0hda9HsD0OynFM11FxzHb0cmeu+HulwipHlpnpYVR1MhHWA0bg7b7H323HADY8wHM1y7RaIZ4kmtOFVbVGN3Gmipqa9U9RLPLJTOiRpGjFnZmZQAB9eAPn/oMNyi6UkddbseuVTTyA9EsNM7I2x2OxA28EEfzHAHd5ZOVrkRySwU+U2bHbjNbqurNGji53FGSURiQhkLBlARlbcj2YffjSScLw+ogzy4brvZ2diPHnGGEzuj1c1QxW7MD9LW6Xsa7ywQ8jvJ5UXOps8OEXVqilWRm/1evCOY+nuKjdezsvWu4Htv8Az2y9SUfZ8WQfKfxK/v18EH0CTpVpZoJpVarjj2nOMpbaW82tLhcahzNJJNSSI/R3ZpCXA6e5sv08nbc8TKajk0ialQ2KzjXEWJ8QzIZmITc+XZaJL12SsveRdBdH9DOW3G5bVpBi14s1vye6xd2OoNXUO9T2gqMe8SyJ0D3/AA/fzxKNKFbJK6xQUcdsyKJJqW8M1AYJITLHMGjcurjbbo7ayFt/HSDvwApGd+nPyE41C2RZFphXU0dZUiKKnt91uUhklcFhHDBE5Y/KrNso2CqT7DjHMmwyleIl0VDOr5jlyFqld3aSS9bbslq0u9mCh9NvkDuQo5LfglZOtwjppaZ48huPTKk6O8TA9z2ZY3P9PPHKGJRpRQ7MwTpMdPMilTVaKFtNeprRoZbBH0708wvHcIwy21VqslCxsNpojBN1r2dwV+fdmA6WJYnzsT545GMCeZclPJVmWp941EynTbvX74mS7XJxV1kVFUTxFHmYxI4ikO7KZFA8ljuD83ADE1mZ4vaOzTT1XbVqhqJFSFiqOoXcHYeAA6+fbzwAs2acgnIzmN5v2UXXSKamlpWmqa97ZU19JSs6se720iYRkg77qgGx+nAGoh9OHkBpb1UWx9P6r4y27NUwTX647Iva7u7bybFejc7g7eCPcEcAMHhlHoxp/i9uw/D8SpbJZrZF26OhSzyKIkJLb+UJJYsWJJJJYk+SeAKfRW23UWhGmyUdvpoFhs9FVxiKJVCT/Bo3dGw8P1Et1Dzud9+I1ErU8u3ZRuMfmRzcVqYo22+cjWuuiidv0JbVtbDqJqDHDVzRrRWmtnplWQgQSMtOWdP+lifcjyeJJpydj4EmS0kDjqjkwShDofKsO3N7j68AYtLrhX3LC7JUXGtqKqVcniQPPIzsFFONhuTvsPtwBA5tJZIsZsrxSMjCtUgqdiD3oB/6J/vwB5zq11batEaq7Wusno66julHJTVNPIY5YWLMhZHXYqSjMpIPsxHsTxr8Tbhp8y3ui68AS4J2NQypqUUMUMV09U9L6rZ6pPvSZlsH+V1A09ttL+5ozj1Axp4/lj3SlqAh6R4+UEgfbfxxMlaQJexFXxKJxVs2KLVuKL5sk5zLLHhtvgSV1jmySqEiBiFcCrYgEfXY+eMhCOLyySamZ9QSSM9NBZK6SKFjvGjvFSl2VfYFvqR7/XgDV4+73HBrLdLg5qq1K+qqVqZj1yrMJ6dRIHPkMB4Db77cAerrdLmlx1YokuNStPS2ivlghEzBInZt2ZV32Un6keTwBur2iPq7CHQN3ae6xvuN+pP0dSHpP3G5J2+/AAMmRLiy1lwRamokjj65Zh1u2ygDdj5PgAcAf//Z';

$('#dataTables-example').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        "bSort": false,
        paging: true,
        dom: '<"centerBtn"B>rtip',
        buttons: [
             {
                extend: 'excelHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                }
             },
             {
                extend: 'csvHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                }
             },
             {
                extend: 'pdfHtml5',
                exportOptions: {
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
                "autoWidth": true,
                customize: function ( doc ) {
                  doc.pageMargins = [30,60,20,30];
                  doc.defaultStyle.fontSize = 7;
                  doc.styles.tableHeader.fontSize = 10;
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
                            text: 'Projetos',
                            fontSize: 15,
                            margin: [10,0]
                          }
                        ],
                        margin: 20  
                      }
                    });
                },
                title:'',
                orientation: 'landscape',
                pageSize: 'A4'
             },
         ]
    });  
</script>