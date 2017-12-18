
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
            $("#data_nascimento").val(d.data.data_nascimento);
            $("#senha").val(d.data.senha);
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

    if ($("#data_nascimento").val() == '') {
        alert('Informar a data de nascimento do usuário');
        $("#data_nascimento").focus();
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
