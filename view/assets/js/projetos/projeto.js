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
            $(".cliente").html(d.data.ClienteNome);
            $(".proposta").html(d.data.PropostaNome);
            $(".pilar").html(d.data.PilarNome);
            $("#id_proposta").val(d.data.id_proposta);

            if (d.data.listar == 'S') {
                $("#listar_s").prop('checked', 'checked');
            } else {
                $("#listar_n").prop('checked', 'checked');
            }
            
            $("#id_pilar").val(d.data.id_pilar);
            $("#data_inicio").val(d.data.Data_inicio);
            $("#data_fim").val(d.data.Data_fim);
            $("#id_gerente").val(d.data.id_gerente);
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

    if ($("#id_gerente").val() == '') {
        alert('Informar o gerente do projeto.');
        $("#id_gerente").focus();
        return false;
    }

    return true;
  });

});
