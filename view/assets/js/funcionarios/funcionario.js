var id = $("#id").val();
if (id > 0) {
   getDataFuncionario(id);
}


function excluir_anexo()
{
  if (!confirm('Tem certeza que deseja excluir esse anexo?')) {
    return false;
  }

   $("#excluir_anexo").val(1);
   document.getElementById('cad_funcionarios').submit();
}

function excluir_foto()
{
  if (!confirm('Tem certeza que deseja excluir essa foto?')) {
    return false;
  }

   $("#excluir_foto").val(1);
   document.getElementById('cad_funcionarios').submit();
}

function getDataFuncionario(id)
{
   $.ajax({
        url : 'funcionarios.php',
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
            $("#nome").val(d.data.nome);
            $("#apelido").val(d.data.apelido);
            $("#data_nascimento").val(d.data.data_nascimento);
            $("#id_tipocontratacao").val(d.data.id_tipocontratacao);
            if (d.data.id_tipocontratacao == 3) {
                document.getElementById("divRazaoSocial").style.display = "block";
            } else{
                 document.getElementById("divRazaoSocial").style.display = "none";
            }

            $("#id_perfilprofissional").val(d.data.id_perfilprofissional);
            $("#id_responsabilidade").val(d.data.id_responsabilidade);
            $("#rg").val(d.data.rg);
            $("#cpf").val(d.data.cpf);
            $("#endereco").val(d.data.endereco);
            $("#razao_social").val(d.data.Razao_social);            
            $("#complemento").val(d.data.complemento);
            $("#cod_municipio").val(d.data.cod_municipio);
            $("#cep").val(d.data.cep);
            $("#telefone").val(d.data.telefone);
            $("#valor_taxa").val(d.data.valor_taxa);
            $("#email").val(d.data.email);
            $("#status").val(d.data.status);
            $("#emailParticular").val(d.data.emailParticular);
        }
    });
}

$( document ).ready(function() {

  $( "#btnSubmit" ).click(function() {
    
    if ($("#nome").val() == '') {
        alert('Informar o nome do funcionário');
        $("#nome").focus();
        return false;
    }

    if ($("#apelido").val() == '') {
        alert('Informar o apelido do funcionário');
        $("#apelido").focus();
        return false;
    }

    if ($("#id_tipocontratacao").val() == '') {
        alert('Informar o tipo de contratação do funcionário');
        $("#id_tipocontratacao").focus();
        return false;
    }

    if ($("#id_perfilprofissional").val() == '') {
        alert('Informar o perfil profissional do funcionário');
        $("#id_perfilprofissional").focus();
        return false;
    }

    if ($("#id_responsabilidade").val() == '') {
        alert('Informar a responsabilidade do funcionário');
        $("#id_responsabilidade").focus();
        return false;
    }

    if ($("#rg").val() == '') {
        alert('Informar o RG do funcionário');
        $("#rg").focus();
        return false;
    }

    if ($("#cpf").val() == '') {
        alert('Informar o CPF do funcionário');
        $("#cpf").focus();
        return false;
    }

    if ($("#endereco").val() == '') {
        alert('Informar o endereço do funcionário');
        $("#endereco").focus();
        return false;
    }

    if ($("#valor_taxa").val() == '') {
        alert('Informar o valor da taxa do funcionário');
        $("#valor_taxa").focus();
        return false;
    }

    if ($("#cod_municipio").val() == '') {
        alert('Informar o município do funcionário');
        $("#cod_municipio").focus();
        return false;
    }

    if ($("#cep").val() == '') {
        alert('Informar o CEP do funcionário');
        $("#cep").focus();
        return false;
    }

    if ($("#email").val() == '') {
        alert('Informar o EMAIL do funcionário');
        $("#email").focus();
        return false;
    }

    return true;
  });

});
