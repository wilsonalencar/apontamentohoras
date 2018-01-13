
var id = $("#id").val();
if (id > 0) {
   getDataProposta(id);
}
function getDataProposta(id)
{
   $.ajax({
        url : 'propostas.php',
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
            $("#codigo").val(d.data.codigo);
            $("#codigo").attr("readonly", "true");
            $("#status").val(d.data.status);
            $("#nome").val(d.data.nome);
        }
    });
}

$( document ).ready(function() {
  $( "#submit" ).click(function() {
    
    if ($("#codigo").val() == '') {
        alert('Informar o código do proposta');
        $("#codigo").focus();
        return false;
    }

    if ($("#nome").val() == '') {
        alert('Informar o nome do proposta');
        $("#nome").focus();
        return false;
    }

    if ($("#status").val() == '') {
        alert('Informar o status do proposta');
        $("#status").focus();
        return false;
    }
    return true;
  });

});
