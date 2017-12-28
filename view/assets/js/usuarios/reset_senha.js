$( document ).ready(function() {
  $( "#submit" ).click(function() {
    
    if ($("#senha").val() == '') {
        alert('Informar a sua nova senha');
        $("#senha").focus();
        return false;
    }

    if ($("#senha2").val() == '') {
        alert('Informar a senha para confirmação');
        $("#senha2").focus();
        return false;
    }

    if ($("#senha").val() != $("#senha2").val()) {
        alert('As senhas não são identicas, favor verificar');
        $("#senha").focus();
        return false;
    }
    return true;
  });

});