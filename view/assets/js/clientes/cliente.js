
var id = $("#id").val();
if (id > 0) {
   getDataCliente(id);
}


function getDataCliente(id)
{
   $.ajax({
        url : 'clientes.php',
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
            $("#complemento").val(d.data.complemento);
            $("#contato").val(d.data.contato);
            $("#email").val(d.data.email);
            $("#endereco").val(d.data.endereco);
            $("#status").val(d.data.status);
            $("#nome").val(d.data.nome);
            $("#telefone").val(d.data.telefone);
            $("#cod_municipio").val(d.data.cod_municipio);
            $("#cnpj").val(d.data.cnpj);
            $("#cep").val(d.data.cep);
        }
    });
}

$( document ).ready(function() {

  $( "#submit" ).click(function() {
    
    if ($("#codigo").val() == '') {
        alert('Informar o código do cliente');
        $("#codigo").focus();
        return false;
    }

    if ($("#nome").val() == '') {
        alert('Informar o nome do cliente');
        $("#nome").focus();
        return false;
    }

    if ($("#cnpj").val() == '') {
        alert('Informar o cnpj do cliente');
        $("#cnpj").focus();
        return false;
    } 

    if ($("#cnpj").val().length < 18 ) {
        alert('Informar o cnpj do cliente corretamente.');
        $("#cnpj").focus();
        return false;
    }

    if ($("#endereco").val() == '') {
        alert('Informar o endereco do cliente.');
        $("#endereco").focus();
        return false;
    }

    if ($("#cidade").val() == '') {
        alert('Informar a cidade do cliente.');
        $("#cidade").focus();
        return false;
    }

    if ($("#cep").val() == '') {
        alert('Informar o cep do cliente.');
        $("#cep").focus();
        return false;
    }
    return true;
  });

});
