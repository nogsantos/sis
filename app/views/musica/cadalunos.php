<?php
/**
 * Descrição: View Cadastro de Alunos escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");
require_once("../../models/musica/Matricula.php");
require_once("../../models/geral/Municipio.php");

$CODG_FORMULARIO = "cadalunos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

$oAluno = new Aluno();
$oMunicipio = new Municipio();
$oMatricula = new Matricula();

$numgAluno = $_GET["numgAluno"];
$numrAluno = $_GET["numrAluno"];
$bolRecibo = $_GET["recibo"];
/**
 * Descrição: Relatório de alunos cadastrados
 */
$vAlunos = $oAluno->consultarAlunos();if (Erro::isError())MostraErros();

/**
 * Descrição: seta dos dados do aluno por numg.
 */
if($numgAluno!=""):
   $oAluno->setarDados($numgAluno);
   $resMunicipios = $oMunicipio->consultarMunicipios();
   $resMatricula = $oMatricula->modalidadesCadastradasPorAluno($numgAluno);
endif;
?>
<html>
    <head>
        <title>Cadastro de Alunos - Escola de M&uacute;sica</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript" src="../javascripts/jquery.maskedinput-1.2.2.min.js"></script>
        <script type="text/javascript" src="../javascripts/jquery.validate.js"></script>
        <script type="text/javascript" src="../javascripts/util.validate.js"></script>
        <!--moptips-->
        <link rel="stylesheet" type="text/css" href="../javascripts/mopTip/mopTip/mopTip-2.2.css" />
        <script type="text/javascript" src="../javascripts/mopTip/mopTip/mopTip-2.2.js"></script>
        <script type="text/javascript" src="../javascripts/mopTip/mopTip/jquery.pngFix-1.2.js"></script>
        <script type="text/javascript">
            /**
             * Descrição: Carregando as funções da Interface.
             * @author Fabricio Nogueira.
             **/
            $(function(){
                /**
                 * Descrição: Validade se o cpf digitado é válido.
                 **/
                 $("#form").validate({
                    rules: {
                        "numrCpfCnpj" : {
                            cpf: 'both' //valida tanto Formatação como os Digitos
                         }
                    }
                 });
                /**
                 * Descrição: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();
               /**
                * Descrição: Carregamento do formulario.
                **/
                $(window).load(function(){
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#relatorio").delay(500).fadeIn(900);
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?=$oAluno->getNumgAluno()?>')
                });
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var numrAluno = $( "#numrAluno" );
                var nomeAluno = $( "#descNomePessoa" );
                var sobreNomeAluno = $( "#descSobreNomePessoa" );
                var sexo = $( "#sexo" );
                var cpf = $( "#numrCpfCnpj" );
                var identificacao = $( "#numrCarteiraIdentidade" );
                var orgaoExpedidor = $( "#descOrgaoExpedidor" );
                var dddTelefone = $( "#numrDddTelefone" );
                var telefone = $( "#numrTelefone" );
                var dddTelefone2 = $( "#numrDddTelefoneContato" );
                var telefone2 = $( "#numrTelefoneContato" );
                var dddCelular = $( "#numrDddCelular" );
                var celular = $( "#numrCelular" );
                var nacionalidade = $( "#descNacionalidade" );
                var naturalidade = $( "#descNaturalidade" );
                var dataNascimento = $( "#dataNascimento" );
                var email = $( "#descEmail" );
                var endereco = $( "#descEndereco" );
                var numero = $( "#numrEndereco" );
                var setor = $( "#descBairro" );
                var complemento = $( "#descComplemento" );
                var cep = $( "#numrCep" );
                var siglaUf = $( "#siglaUf" );
                var numgMunicipio = $( "#numgMunic" );
                var observacao = $( "#descObservacao" );
                /**
                 * Descrição: mascara dos campos
                 **/
                $("#numrCpfCnpj").mask("999.999.999-99");
                $("#numrDddTelefone").mask("99");
                $("#numrTelefone").mask("9999-9999");
                $("#numrDddTelefoneContato").mask("99");
                $("#numrTelefoneContato").mask("9999-9999");
                $("#numrDddCelular").mask("99");
                $("#numrCelular").mask("9999-9999");
                $("#numrCep").mask("99999-999");
                $("#dataNascimento").mask("99/99/9999",{placeholder:" "});
                /**
                 * Descrição: inicializa a mensagem
                 **/
		function updateTips( t ) {
                    $("#validateTips").show(1000);
                    tips.text( t ).addClass( "ui-state-highlight" );
		}
                /**
                 * Descrição: Validação do tamanho do campo
                 **/
		function checkLength( o, n, min, max ) {
                    if ( o.val().length > max || o.val().length < min ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "O Campo " + n + " é de prenchimento obrigatório e deve conter mais de " + min +  " caracteres." );
                        return false;
                    } else {
                        return true;
                    }
		}
                /**
                 * Descrição: Validação da expressão regular
                 **/
		function checkRegexp(o,regexp,n) {
                    if ( !( regexp.test( o.val() ) ) ) {
                        o.addClass('ui-state-error');
                        updateTips(n);
                        return false;
                    } else {
                        return true;
                    }
		}
                /**
                 * Descrição: Novo Registro.
                 **/
                $("#novo",".buttonBar").button().click(function(){
                    window.location.href = '<?=$CODG_FORMULARIO ?>.php';
                });
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( numrAluno ).add( nomeAluno ).add( sobreNomeAluno ).add( identificacao ).add( email ).add( numero ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeAluno, "Nome", 1, 100 );
                    bValid = bValid && checkLength( sobreNomeAluno, "Sobre nome", 1, 100 );
                    $( "#numrCarteiraIdentidade" ).val()!="" ? bValid = bValid && checkRegexp(identificacao,/^[0-9]*$/,"Somente números no campo identidade") : "";
                    $( "#numrEndereco" ).val() != "" ? bValid = bValid && checkRegexp(numero,/^[0-9]*$/,"Somente números no campo Número") : "";
                    $( "#descEmail" ).val() != "" ? bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "e-mail inválido Ex.: tocandoasnacoes@mtn.com.br" ) : "";
                    if ( bValid ) {
                        if (confirm("Confirma o CADASTRO dos dados?")){
                            /**
                             * Descrição: Fechamento do formulario
                             **/                            
                            $("#txtFuncao").val("cadastrar");
                            $("form").submit();
                            $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                });
                /**
                 * Descrição: Editar.
                 **/
                $("#editar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( numrAluno ).add( nomeAluno ).add( sobreNomeAluno ).add( identificacao ).add( email ).add( numero ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeAluno, "Nome", 1, 100 );
                    bValid = bValid && checkLength( sobreNomeAluno, "Sobre nome", 1, 100 );
                    $( "#numrCarteiraIdentidade" ).val()!="" ? bValid = bValid && checkRegexp(identificacao,/^[0-9]*$/,"Somente números no campo identidade") : "";
                    $( "#numrEndereco" ).val() != "" ? bValid = bValid && checkRegexp(numero,/^[0-9]*$/,"Somente números no campo Número") : "";
                    $( "#descEmail" ).val() != "" ? bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "e-mail inválido Ex.: tocandoasnacoes@mtn.com.br" ) : "";
                    if ( bValid ) {
                        if (confirm("Confirma a EDIÇÃO dos dados?")){
                            /**
                             * Descrição: Fechamento do formulario
                             **/
                            $("#txtFuncao").val("editar");
                            $("form").submit();
                            $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Bloquear.
                 **/
                $("#desativar",".buttonBar").button().click(function(){
                    if (confirm("Confirma o Desativamento?")){
                        /**
                         * Descrição: Fechamento do formulario
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("desativar");
                        $("form").submit()
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Desbloquear.
                 **/
                $("#ativar",".buttonBar").button().click(function(){
                    if (confirm("Confirma a ativação?")){
                        /**
                         * Descrição: Fechamento do formulario
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("ativar");
                        $("form").submit();
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: ajax populando o campo de municipios
                 **/
                $("#siglaUf").change(function(){
                    var opt = "";
                    $("#loadMunc").show();
                    $.post("../ajax/municipio.php",{
                        funcao: "consultarPorUf",
                        sigl_uf: siglaUf.val()
                    }, function(municipios){
                        $("#numgMunic").empty();
                        $.each(municipios, function(i,vals){
                            opt += '<option value="'+vals.numg_municipio+'">'+vals.nome_municipio+'</option>';
                        })
                        $("#loadMunc").hide();
                        $("#numgMunic").append(opt);
                    }, "json")
                })
                /**
                 * Descrição: Impressão da ficha do aluno.
                 **/
                 $("#ficha",".buttonBar").button().click(function(){
                    window.open("../relatorios/relalunosmusica.php?numgAluno=<?=$oAluno->getNumgAluno()?>", "_blank");
                    return false;
                 });
                 /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelAlunos").click(function(){
                    if(option==0){
                        $("#relAlunos").show(999);
                        $("#iconlinkRelAlunos").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relAlunos").hide(999);
                        $("#iconlinkRelAlunos").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                $("#impRecibo").button().click(function(){
                   form.action = "../financeiro/cadrecibosalu.php";
                   $("#form").submit();
                });
                $("#matricula").button().click(function(){
                   form.action = "cadmatriculas.php";
                   $("#form").submit();
                });
                $(".deleteModalidadeAluno").click(function(){
                    if(confirm("Tem certeza que deseja deletar o(s) horario(s) selecionado(s)?")){
                        $("#txtFuncao").val("excluirModalidade");
                        form.action = "../../controllers/musica/pcadmatriculas.php";
                        $("form").submit();
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                    }
                });
                $("#limpar").button().click(function(){
                    nomeAluno.val("");
                    sobreNomeAluno.val("");
                    sexo.empty();
                    cpf.val("");
                    identificacao.val("");
                    orgaoExpedidor.val("");
                    dddTelefone.val("");
                    telefone.val("");
                    dddTelefone2.val("");
                    telefone2.val("");
                    dddCelular.val("");
                    celular.val("");
                    nacionalidade.val("");
                    naturalidade.val("");
                    dataNascimento.val("");
                    email.val("");
                    endereco.val("");
                    numero.val("");
                    setor.val("");
                    complemento.val("");
                    cep.val("");
                    siglaUf.val("");
                    numgMunicipio.empty();;
                    observacao.val("");
                    return false;
                });
                /**
                 * Descrição: Autocomplete Nome do aluno
                 **/
                $( "#descNomePessoa" ).autocomplete({
                    source: "completecadalunos.php?tipoBusca=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $(this).val(ui.item.value);
                        consultaForm(ui.item.id);
                    }
		}).focus(function(){
                    $("#helpBuscaNomeAluno").show(500);
                }).blur(function(){
                    $("#helpBuscaNomeAluno").hide(500);
                });
                /**
                 * Descrição: Recarrega o formulário com os dados do aluno setado pela consulta.
                 **/
                function consultaForm(id){
                    if(id!=""){
                        location.href='<?=$CODG_FORMULARIO?>.php?numgAluno='+id+'';
                        return true;
                    }else{
                        return false;
                    }
                }
                /**
                 * Ajuda
                 **/
                $("#helpBuscaNomeAluno").mopTip({'w':350,'style':"overOut",'get':"#tipHelpBuscaNomeAluno"});
            });
        </script>
        <style type="text/css">
            .ui-autocomplete-loading { background: url('../imagens/ui-anim_basic_16x16.gif') right center no-repeat; }
            .hiden{display: none;}
        </style>
        <base target="conteudo">
    </head>
    <body>
    <div class="conteiner" style="display:none">
    <form method="post" action="../../controllers/musica/pcadalunos.php" name="form" id="form">
    <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
    <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="EM">
    <input type="hidden" name="numgAluno" id="numgAluno" value="<?=$oAluno->getNumgAluno()?>">
    <div id="tabs">
        <ul><li><a href="#dados">Dados Gerais do Cadastro</a></li></ul>
        <div id="dados">            
            <?if ($_GET["info"] != ""){?>
            <table border="0" cellpadding="0" cellspacing="0" width="800px">
                <tr>
                    <td colspan="4" align="center" height="20" valign="middle" class="normal11">
                        <img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;
                        <?switch ($_GET[info]) {
                            case 1:echo "Cadastro realizado com sucesso!";break;
                            case 2:echo "Edição realizada com sucesso!";break;
                            case 3:echo "Desativação realizada com sucesso!";break;
                            case 4:echo "Ativação realizado com sucesso!";break;
                            case 5:echo "Matricula realizada com sucesso!";break;
                            case 6:echo "Horário removido do sucesso!";break;
                        }?>
                    </td>
                </tr>
            </table>
            <?}?>
            <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
            <p class="validateTips"></p>
            <fieldset class="fieldFormulario" style="width: 800px;">
                <legend>Dados do Aluno</legend>
                <table border="0" cellpadding="0" cellspacing="3" width="100%">
                    <tr>
                        <td colspan="2">
                            N&uacute;mero do aluno<br />
                            <input type="text" name="numrAluno" id="numrAluno" size="15" maxlength="50" style="text-align:center;" readonly class="somenteLeitura" value="<?=$oAluno->getNumrAluno()!=""?$oAluno->getNumrAluno():$oAluno->geraNumrAluno()?>" />
                        </td>
                        <td align="center" <?=$oAluno->getNumgAluno()!=""?$oAluno->getDescStatus()=="Ativo"?" class=\"ui-corner-all\" style=\"background-color:green;font-weight: bold;color:#ffffff;\"":"class=\"ui-corner-all\" style=\"background-color:red;font-weight: bold;color:#ffffff;\"":""?> >
                            <?=$oAluno->getDescStatus()?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td class="normal11b">
                            Nome*<br />
                            <input type="text" name="descNomePessoa" id="descNomePessoa" maxlength="100" class="borda" style="width:330px;" value="<?=$oAluno->getDescNomePessoa()?>" />
                            <div id="helpBuscaNomeAluno" style="position:relative;float:right;right:3px;display: none;text-align: center;"><img src="../imagens/icones/question.png" border="0" align="absmiddle" /></div>
                        </td>
                        <td class="normal11b">
                            Sobrenome*<br />
                            <input type="text" name="descSobreNomePessoa" id="descSobreNomePessoa" maxlength="150" class="borda" style="width:300px;" value="<?=$oAluno->getDescSobreNomePessoa()?>" />
                        </td>
                        <td>
                            <fieldset class="fieldInFormulario">
                                <legend>Sexo</legend>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td><input type="radio" name="sexo" id="sexoMasc" <?=$oAluno->getDescSexo()=="M"?"checked":""?> value="M" /><label for="sexoMasc">Masc</label></td>
                                        <td><input type="radio" name="sexo" id="sexoFem" <?=$oAluno->getDescSexo()=="F"?"checked":""?> value="F" /><label for="sexoFem">Fem</label></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Cpf<br />
                            <input type="text" name="numrCpfCnpj" id="numrCpfCnpj" maxlength="20" class="borda" style="width:95px;" value="<?=$oAluno->getNumrCpfcnpj()?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>                                    
                                    <td>
                                        Identidade<br />
                                        <input type="text" name="numrCarteiraIdentidade" id="numrCarteiraIdentidade" maxlength="30" class="borda" style="width:240px;" value="<?=$oAluno->getNumrCarteiraIdentidade()?>" />
                                    </td>
                                    <td>
                                        &Oacute;rg. Exp.<br />
                                        <input type="text" name="descOrgaoExpedidor" id="descOrgaoExpedidor" maxlength="30" class="borda" style="width:100px;text-transform: uppercase" value="<?=$oAluno->getDescOrgaoExpedidor()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Telefone 1<br />
                                        <input type="text" name="numrDddTelefone" id="numrDddTelefone" maxlength="3" class="borda" style="width:30px;" value="<?=$oAluno->getNumrDddTelefone()?>" />
                                        <input type="text" name="numrTelefone" id="numrTelefone" maxlength="15" class="borda" style="width:100px;" value="<?=$oAluno->getNumrTelefone()?>" />
                                    </td>
                                    <td>
                                        Telefone 2<br />
                                        <input type="text" name="numrDddTelefoneContato" id="numrDddTelefoneContato" maxlength="3" class="borda" style="width:30px;" value="<?=$oAluno->getNumrDddTelefoneContato()?>" />
                                        <input type="text" name="numrTelefoneContato" id="numrTelefoneContato" maxlength="15" class="borda" style="width:100px;" value="<?=$oAluno->getNumrTelefoneContato()?>" />
                                    </td>
                                    <td>
                                        Celular<br />
                                        <input type="text" name="numrDddCelular" id="numrDddCelular" maxlength="3" class="borda" style="width:30px;" value="<?=$oAluno->getNumrDddCelular()?>" />
                                        <input type="text" name="numrCelular" id="numrCelular" maxlength="15" class="borda" style="width:100px;" value="<?=$oAluno->getNumrCelular()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Nacionalidade<br />
                                        <input type="text" name="descNacionalidade" id="descNacionalidade" maxlength="150" class="borda" style="width:135px;" value="<?=$oAluno->getDescNacionalidade()?>" />
                                    </td>
                                    <td>
                                        Naturalidade<br />
                                        <input type="text" name="descNaturalidade" id="descNaturalidade" maxlength="50" class="borda" style="width:213px;" value="<?=$oAluno->getDescNaturalidade()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Data Nascimento<br />
                                        <input type="text" name="dataNascimento" id="dataNascimento" maxlength="10" class="borda" style="width:110px;" value="<?=$oAluno->getDataNascimento()?>" />
                                    </td>
                                    <td>
                                        Email<br />
                                        <input type="text" name="descEmail" id="descEmail" maxlength="50" class="borda" style="width:310px;" value="<?=$oAluno->getDescEmail()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Endere&ccedil;o<br />
                                        <input type="text" name="descEndereco" id="descEndereco" maxlength="250" class="borda" style="width:275px;" value="<?=$oAluno->getDescEndereco()?>" />
                                    </td>
                                    <td>
                                        N&uacute;mero<br />
                                        <input type="text" name="numrEndereco" id="numrEndereco" maxlength="10" class="borda" style="width:70px;" value="<?=$oAluno->getNumrEndereco()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Setor/Bairro<br />
                                        <input type="text" name="descBairro" id="descBairro" maxlength="50" class="borda" style="width:140px;" value="<?=$oAluno->getDescBairro()?>" />
                                    </td>
                                    <td>
                                        Complemento<br />
                                        <input type="text" name="descComplemento" id="descComplemento" maxlength="250" class="borda" style="width:280px;" value="<?=$oAluno->getDescComplemento()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Cep<br />
                                        <input type="text" name="numrCep" id="numrCep" maxlength="10" class="borda" style="width:80px;" value="<?=$oAluno->getNumrCep()?>" />
                                    </td>
                                    <td>
                                        Estado<br />
                                        <select name="siglaUf" class="borda" id="siglaUf" style="width:80px">
                                            <option value=""></option>
                                            <option value="AC"<?=$oAluno->getSiglUf()=="AC"?'selected="selected"':""?>>Acre</option>
                                            <option value="AL"<?=$oAluno->getSiglUf()=="AL"?'selected="selected"':""?>>Alagoas</option>
                                            <option value="AP"<?=$oAluno->getSiglUf()=="AP"?'selected="selected"':""?>>Amapá</option>
                                            <option value="AM"<?=$oAluno->getSiglUf()=="AM"?'selected="selected"':""?>>Amazonas</option>
                                            <option value="BA"<?=$oAluno->getSiglUf()=="BA"?'selected="selected"':""?>>Bahia</option>
                                            <option value="CE"<?=$oAluno->getSiglUf()=="CE"?'selected="selected"':""?>>Ceará</option>
                                            <option value="DF"<?=$oAluno->getSiglUf()=="DF"?'selected="selected"':""?>>Distrito Federal</option>
                                            <option value="ES"<?=$oAluno->getSiglUf()=="ES"?'selected="selected"':""?>>Espírito Santo</option>
                                            <option value="GO"<?=$oAluno->getSiglUf()=="GO"?'selected="selected"':""?>>Goiás</option>
                                            <option value="MA"<?=$oAluno->getSiglUf()=="MA"?'selected="selected"':""?>>Maranhão</option>
                                            <option value="MT"<?=$oAluno->getSiglUf()=="MT"?'selected="selected"':""?>>Mato Grosso</option>
                                            <option value="MS"<?=$oAluno->getSiglUf()=="MS"?'selected="selected"':""?>>Mato Grosso do Sul</option>
                                            <option value="MG"<?=$oAluno->getSiglUf()=="MG"?'selected="selected"':""?>>Minas Gerais</option>
                                            <option value="PA"<?=$oAluno->getSiglUf()=="PA"?'selected="selected"':""?>>Pará</option>
                                            <option value="PB"<?=$oAluno->getSiglUf()=="PB"?'selected="selected"':""?>>Paraíba</option>
                                            <option value="PR"<?=$oAluno->getSiglUf()=="PR"?'selected="selected"':""?>>Paraná</option>
                                            <option value="PE"<?=$oAluno->getSiglUf()=="PE"?'selected="selected"':""?>>Pernambuco</option>
                                            <option value="PI"<?=$oAluno->getSiglUf()=="PI"?'selected="selected"':""?>>Piauí</option>
                                            <option value="RJ"<?=$oAluno->getSiglUf()=="RJ"?'selected="selected"':""?>>Rio de Janeiro</option>
                                            <option value="RN"<?=$oAluno->getSiglUf()=="RN"?'selected="selected"':""?>>Rio Grande do Norte</option>
                                            <option value="RS"<?=$oAluno->getSiglUf()=="RS"?'selected="selected"':""?>>Rio Grande do Sul</option>
                                            <option value="RO"<?=$oAluno->getSiglUf()=="RO"?'selected="selected"':""?>>Rondônia</option>
                                            <option value="RR"<?=$oAluno->getSiglUf()=="RR"?'selected="selected"':""?>>Roraima</option>
                                            <option value="SC"<?=$oAluno->getSiglUf()=="SC"?'selected="selected"':""?>>Santa Catarina</option>
                                            <option value="SP"<?=$oAluno->getSiglUf()=="SP"?'selected="selected"':""?>>São Paulo</option>
                                            <option value="SE"<?=$oAluno->getSiglUf()=="SE"?'selected="selected"':""?>>Sergipe</option>
                                            <option value="TO"<?=$oAluno->getSiglUf()=="TO"?'selected="selected"':""?>>Tocantins</option>
                                        </select>
                                    </td>
                                    <td>
                                        Municipio<br />
                                        <select name="numgMunic" class="borda" id="numgMunic" style="width:150px">
                                            <?montaCombo($resMunicipios,"numg_municipio","nome_municipio",$oAluno->getNumgMunicipio(),true); ?>
                                        </select>
                                    </td>
                                    <td width="10%" align="left" valign="bottom"><img src="../imagens/ajax-loader_pequeno.gif" border="0" alt="" id="loadMunc" align="absmiddle" style="display:none;"/></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2">
                            <?if($oAluno->getDataCadastro   ()!=""):?>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="right">Data Cadastro:</td>
                                    <td class="normal11b" align="left" style="padding-right: 10px;"><?=$oAluno->getDataCadastro()?></td>
                                </tr>
                                <tr>
                                    <td align="right">Usu&aacute;rio Cadastro:</td>
                                    <td class="normal11b" align="left" style="padding-right: 10px;" ><?=$oAluno->getNomeUsuarioCadastro()?></td>
                                </tr>
                            </table>
                            <?endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Observa&ccedil;&otilde;es<br />
                            <textarea name="descObservacao" id="descObservacao" style="width: 790px;" rows="5" class="borda"><?=$oAluno->getDescObservacao()?></textarea>
                        </td>
                    </tr>
                    <?if($oAluno->getNumgAluno()!=""){?>
                    <tr>
                        <td colspan="3">
                            <?if($resMatricula->getCount()==0 && $oAluno->getDescStatus()=="Ativo" ){?>
                                <button id="matricula" style="position: relative;float: left;left:0;width:100%;height:50px;font-weight: bold;">O Aluno n&atilde;o possui matricula, clique aqui para matriculá-lo</button>
                            <?}elseif($resMatricula->getCount()>0 && $oAluno->getDescStatus()!="Inativo" ){?>
                            <fieldset class="fieldInFormulario">
                                <legend>Modalidades Cadastradas  para o aluno</legend>
                                <table border="0" cellpadding="3" cellspacing="3" width="100%">
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all" align="center">Modalidade</td>
                                        <td class="ui-widget-header ui-corner-all" align="center">Dia</td>
                                        <td class="ui-widget-header ui-corner-all" align="center">Horar&aacute;rio</td>
                                        <td class="ui-widget-header ui-corner-all" align="center">Professor</td>
                                        <td class="ui-widget-header ui-corner-all" align="center" ><img style="cursor: pointer;" src="../imagens/delete.png" border="0" id="imgDelHorarios" class="deleteModalidadeAluno" alt="Deletar Horários selecionados" title="Deletar Horário selecionados" /></td>
                                    </tr>
                                    <?for($i=0;$i<$resMatricula->getCount();$i++){?>
                                    <tr>
                                        <td class="ui-widget-content ui-corner-all" align="center" style="font-weight: bold;color: #666"><?=$resMatricula->getValores($i,"desc_modalidade")?></td>
                                        <td class="ui-widget-content ui-corner-all" align="center" style="font-weight: bold;color: #666"><?=$resMatricula->getValores($i,"dia_semana")?></td>
                                        <td class="ui-widget-content ui-corner-all" align="center" style="font-weight: bold;color: #666"><?="das ".str_replace("|", " às ", $resMatricula->getValores($i,"numr_horarios")." horas")?></td>
                                        <td class="ui-widget-content ui-corner-all" align="center" style="font-weight: bold;color: #666"><a href="cadprofessores.php?numgProfessor=<?=$resMatricula->getValores($i,"numg_professor")?>"><?=$resMatricula->getValores($i,"nome_professor")?></a></td>
                                        <td class="ui-widget-content ui-corner-all" align="center" style="font-weight: bold;color: #666;cursor: pointer;">
                                            <input type="checkbox" class="delHorarios" name="numgMatricula[<?=$resMatricula->getValores($i,"numg_matricula")?>]" id="numgMatricula<?=$resMatricula->getValores($i,"numg_matricula")?>" />
                                        </td>
                                    </tr>
                                <?}?>
                                </table>
                            </fieldset>
                            <?}?>
                        </td>
                    </tr>
                    <?}?>
                    <?if($oAluno->getDataDesativacao()!= "") { ?>
                    <tr>
                        <td align="center" valign="middle" class="normal11"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Desativado em: <b><?=$oAluno->getDataDesativacao()?></b></td>
                    </tr>
                    <?}?>
                    <tr>
                        <td colspan="3" valign="middle" align="right">
                             <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;">
                                <?if($oAluno->getNumgAluno()==""){?>
                                    <button id="cadastrar">Cadastrar</button>
                                    <button id="limpar">Limpar</button>
                                <?}else{?>
                                    <button id="novo">Novo</button>
                                    <button id="editar">Editar</button>
                                     <?if($oAluno->getDescStatus() == "Ativo"){?>
                                        <button id="desativar">Desativar</button>
                                    <?}else{?>
                                        <button id="ativar">Ativar</button>
                                    <?}?>
                                    <button id="ficha">Ficha do Aluno</button>
                                    <?if($bolRecibo=='sim'){?>
                                        <button id="impRecibo">Imprimir Recibo</button>
                                    <?}?>
                                <?}?>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>       
    </div>
    </form>
    <?if(count($vAlunos)>0){?>
        <div id="linkRelAlunos" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:220px;cursor: pointer;">
            Rela&ccedil;&atilde;o de Alunos cadastrados
            <div id="iconlinkRelAlunos" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
        </div>
        <table id="relAlunos" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
            <thead>
            <tr>
                <th class="ui-widget-header ui-corner-all" align="center" width="5%">Número</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="30%">Nome</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="10%">Telefone 1</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="10%">Telefone 2</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="10%">Celular</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="20%">Email</th>
                <th class="ui-widget-header ui-corner-all" align="center" width="10%">Status</th>
            </tr>
            <thead>
            <tbody>
                <?for($i = 0; $i < $vAlunos->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
                <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgAluno=<?=$vAlunos->getValores($i,"numg_aluno")?>'">
                    <td align="center"><?=$vAlunos->getValores($i,"numr_aluno")?></td>
                    <td><?=$vAlunos->getValores($i,"nomealuno")?></td>
                    <td><?="(".$vAlunos->getValores($i,"numr_dddtelefone").") ".$vAlunos->getValores($i,"numr_telefone")?></td>
                    <td><?="(".$vAlunos->getValores($i,"numr_dddtelefonecontato").") ".$vAlunos->getValores($i,"numr_telefonecontato")?></td>
                    <td><?="(".$vAlunos->getValores($i,"numr_dddcelular").") ".$vAlunos->getValores($i,"numr_celular")?></td>
                    <td><?=$vAlunos->getValores($i,"desc_email")?></td>
                    <td align=center <?=$vAlunos->getValores($i, "status")=="Ativo"?'style="color:green;"':'style="color:red;"'?>><?=$vAlunos->getValores($i, "status");?></td>
                </tr>
                <?}?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="height:30px" class="ui-widget-header ui-corner-all">
                        <div style="float:left;position:relative;left:20px;">
                            * Clique no item para edit&aacute;-lo
                        </div>
                        <div style="float:right;position:relative;right:40px;">
                            TOTAL: <?=$vAlunos->getCount()?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?}?>
    </div>
<!--mopTips-->
<div class="hiden">
    <div id="tipHelpBuscaNomeAluno" style="text-align: justify;">
        <img src="../imagens/icones/tips.png" border="0" style="position: relative;float: left;margin-right:10px;" />
        <span style="text-align: justify"> Para consultar, digite as iniciais do nome desejado.<br />
            Caso não o localize, para cadastrar o novo aluno, continue preenchendo as informações normalmente clicando no botão cadastrar ao final.</span>
    </div>
</div>
</body>
</html>