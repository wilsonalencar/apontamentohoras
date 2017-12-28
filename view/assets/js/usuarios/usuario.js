
var id = $("#usuarioID").val();
if (id > 0) {
   getDataUsuario(id);
}

function getDataUsuario(id)
{
   $.ajax({
        url : 'usuarios.php',
        type: 'post',
        dataType: 'JSON',
        data:
        {
            'action':2,
            'usuarioID':id
        },
        success: function(d)
        {
            if (!d.success) {
               alert(d.msg);
               return false;
            }
            $("#usuarioID").val(d.data.usuarioID);
            $("#nome").val(d.data.nome);
            $("#email").val(d.data.email);
            $("#id_perfilusuario").val(d.data.id_perfilusuario);
            $("#id_responsabilidade").val(d.data.id_responsabilidade);
            $("#status").val(d.data.status);
        }
    });
}

$( document ).ready(function() {
  $( "#submit" ).click(function() {
    
    if ($("#nome").val() == '') {
        alert('Informar o nome do Usuario');
        $("#nome").focus();
        return false;
    }

    if ($("#email").val() == '') {
        alert('Informar o email do usuário');
        $("#email").focus();
        return false;
    }

    if ($("#id_responsabilidade").val() == '') {
        alert('Informar a responsabilidade do Usuario');
        $("#id_responsabilidade").focus();
        return false;
    }

    if ($("#id_perfilusuario").val() == '') {
        alert('Informar o perfil do Usuario');
        $("#id_perfilusuario").focus();
        return false;
    }

    if ($("#senha").val() == '') {
        alert('Informar a senha do usuário');
        $("#senha").focus();
        return false;
    }
    return true;
  });

});
