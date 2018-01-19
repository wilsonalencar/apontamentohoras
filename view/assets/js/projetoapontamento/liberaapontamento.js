
var id = $("#id").val();
if (id > 0) {
   getDataProposta(id);
}
function getDataProposta(id)
{
   $.ajax({
        url : 'projetoapontamentos.php',
        type: 'get',
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
            $("#periodo_libera").val(d.data.periodo_libera);
            if(d.data.libera == 'S'){
                $("#test3").attr('checked', 'checked');
            }else {
                $("#test2").attr('checked', 'checked');
            } 
        }
    });
}

$( document ).ready(function() {
  $( "#submit_form" ).click(function() {
    if ($("#periodo_libera").val() == '') {
        alert('Informar o período de liberação');
        $("#periodo_libera").focus();
        return false;
    }

    if ($("#libera").val() == '') {
        alert('Informar se vai ser liberado.');
        $("#libera").focus();
        return false;
    }

    return true;
  });

});
