
var id = $("#id").val();
if (id > 0) {
   getDataProposta(id);
}
function getDataProposta(id)
{
   $.ajax({
        url : 'projetos.php',
        type: 'post',
        dataType: 'JSON',
        data:
        {
            'action':2,
            'id':id
        },
        success: function(d)
        {
            if (!d.success) {
               alert(d.msg);
               return false;
            }
            $("#id").val(d.data.id);
            $("#id_cliente").val(d.data.id_cliente);
            $("#id_proposta").val(d.data.id_proposta);
            $("#id_pilar").val(d.data.id_pilar);
            $("#data_inicio").val(d.data.Data_inicio);
            $("#data_fim").val(d.data.Data_fim);
            $("#Cliente_reembolsa").val(d.data.Cliente_reembolsa);
            $("#status").val(d.data.id_status);
            if (d.data.id != 0) {
                document.getElementById('rowFatAnexos').style.display = 'block';
                document.getElementById('rowRecursos').style.display = 'block';
                document.getElementById('divDespesas').classList.remove('disabled');
                document.getElementById('divFluxoFin').classList.remove('disabled');
            }
        }
    });
}

$( document ).ready(function() {
  $( "#submit" ).click(function() {
    
    if ($("#id_cliente").val() == '') {
        alert('Informar qual o cliente.');
        $("#id_cliente").focus();
        return false;
    }

    if ($("#id_proposta").val() == '') {
        alert('Informar qual a proposta.');
        $("#id_proposta").focus();
        return false;
    }
    
    if ($("#data_inicio").val() == '') {
        alert('Informar a data inicial do projeto');
        $("#data_inicio").focus();
        return false;
    }

    if ($("#id_pilar").val() == '') {
        alert('Informar qual o pilar.');
        $("#id_pilar").focus();
        return false;
    }

    if ($("#status").val() == '') {
        alert('Informar o status do projeto.');
        $("#status").focus();
        return false;
    }
    return true;
  });

});