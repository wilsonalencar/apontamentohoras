var id = $("#id").val();
if (id > 0) {
   getDataPilar(id);
}
function getDataPilar(id)
{
   $.ajax({
        url : 'pilares.php',
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
            $("#centro_custos").val(d.data.centro_custos);
            $("#centro_custos").attr("readonly", "true");
            $("#status").val(d.data.status);
            $("#nome").val(d.data.nome);
        }
    });
}

$( document ).ready(function() {
  $( "#submit" ).click(function() {
    
    if ($("#centro_custos").val() == '') {
        alert('Informar o código do pilar');
        $("#centro_custos").focus();
        return false;
    }

    if ($("#nome").val() == '') {
        alert('Informar o nome do pilar');
        $("#nome").focus();
        return false;
    }

    if ($("#status").val() == '') {
        alert('Informar o status do pilar');
        $("#status").focus();
        return false;
    }
    return true;
  });

});
