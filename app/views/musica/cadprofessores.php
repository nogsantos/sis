<?php
/**
 * Descrição: View Cadastro de Professores da escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 07/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/geral/Municipio.php");
require_once("../../models/musica/ProfessorModalidade.php");

$CODG_FORMULARIO = "cadprofessores";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION["NUMG_OPERADOR"]);

$oProfessor = new Professor();
$oMunicipio = new Municipio();

$numgProfessor = $_GET["numgProfessor"];
/**
 * Descrição: Relatório de professores cadastrados
 */
$vProfessor = $oProfessor->consultarProfessores();if (Erro::isError())MostraErros();

/**
 * Descrição: seta dos dados do aluno.
 */
if($numgProfessor!=""):
   $oProfessor->setarDados($numgProfessor);
    $resMunicipios = $oMunicipio->consultarMunicipios();

endif;
?>
<html>
    <head>
        <title>Cadastro de Professores - Escola de M&uacute;sica</title>
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
                $('#tabs').tabs(/*{selected:1}*/);
               /**
                * Descrição: Carregamento do formulario.
                **/
                $(window).load(function(){
                    $(".conteiner").delay(500).fadeIn(900);
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?=$oProfessor->getNumgProfessor()?>')
                })
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var nomeProfessor = $( "#descNomePessoa" );
                var sobreNomeProfessor = $( "#descSobreNomePessoa" );
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
                    window.location.href = 'musica/<?= $CODG_FORMULARIO ?>.php';
                })
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( nomeProfessor ).add( sobreNomeProfessor ).add( identificacao ).add( email ).add( numero ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeProfessor, "Nome", 1, 100 );
                    bValid = bValid && checkLength( sobreNomeProfessor, "Sobre nome", 1, 100 );
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
                })
                /**
                 * Descrição: Editar.
                 **/
                $("#editar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( nomeProfessor ).add( sobreNomeProfessor ).add( identificacao ).add( email ).add( numero ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeProfessor, "Nome", 1, 100 );
                    bValid = bValid && checkLength( sobreNomeProfessor, "Sobre nome", 1, 100 );
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
                        $.each(municipios, function($,vals){
                            opt += '<option value="'+vals.numg_municipio+'">'+vals.nome_municipio+'</option>';
                        })
                        $("#loadMunc").hide();
                        $("#numgMunic").append(opt);
                    }, "json")
                })
                /**
                 * Descrição: Ocultando ou revelando os horários das modalidades.
                 **/
                $("#numgModalidade").change(function(){
                    if($(this).val()== "null"){
                        $("#btsModalidade").hide(1000);
                    }else{
                        $("#btsModalidade").show(1000);
                    }
                })
                /**
                 * Descrição: Impressão da ficha do professor.
                 **/
//                 $("#ficha",".buttonBar").button().click(function(){
//                    window.open("../relatorios/relprofessormusica.php?numgProfessor=<?=$oProfessor->getNumgProfessor()?>", "_blank");
//                    return false;
//                 })
                 /**
                  * Descrição: Botão de cadastro das modalidades
                  **/
                 $("#btCadastrarModalidade").button().click(function(){
                    form.action = "../../controllers/musica/pcadprofessoresmodalidades.php";
                    $("#txtFuncao").val("cadastrarModalidade");
                    $("form").submit();
                 });
                 /**
                  * Descrição: Formulário com os horarios cadastrados
                  **/
                 $("#formHorariosCadastrados").dialog({
                    autoOpen: false,
                    height: 600,
                    width: 800,
                    modal: true,
                    show: "drop",
                    hide: "drop",
                    buttons:{
                        Fechar: function() {
                            $("#ajaxLoader").show();
                            $( this ).dialog( "close" ).html("");
                            $("#ajaxLoader").hide();
                        }
                    }
                })
                /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelProfessores").click(function(){
                    if(option==0){
                        $("#relProfessores").show(999);
                        $("#iconlinkRelProfessores").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relProfessores").hide(999);
                        $("#iconlinkRelProfessores").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                $("#limpar").button().click(function(){
                    nomeProfessor.val("");
                    sobreNomeProfessor.val("");
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
                    source: "completecadprofessores.php?tipoBusca=nome",
                    minLength: 2,
                    select: function( event, ui ) {
                        $(this).val(ui.item.value);
                        consultaForm(ui.item.id);
                    }
		}).focus(function(){
                    $("#helpBuscaNomeProfessor").show(500);
                }).blur(function(){
                    $("#helpBuscaNomeProfessor").hide(500);
                });
                /**
                 * Descrição: Recarrega o formulário com os dados do aluno setado pela consulta.
                 **/
                function consultaForm(id){
                    if(id!=""){
                        location.href='<?=$CODG_FORMULARIO?>.php?numgProfessor='+id+'';
                        return true;
                    }else{
                        return false;
                    }
                }
                /**
                 * Ajuda
                 **/
                $("#helpBuscaNomeProfessor").mopTip({'w':350,'style':"overOut",'get':"#tipHelpBuscaNomeProfessor"});
            });
        </script>
        <style type="text/css">
            .horariosModalidadeProfessores{
                padding:10px 10px 10px 10px;
                font-weight: bold;
                width:800px;
                position: relative;
                margin:5px 0 5px 0;
                border: 1px solid #E4E4E4;
            }
            .tituloDiaSemana{
                color: #000000;
                font-weight: bold;
                font-size: 1.0em;
            }
            .cbtsModalidade{
                margin:5px 0 5px 0;
            }
            .ui-autocomplete-loading { background: url('../imagens/ui-anim_basic_16x16.gif') right center no-repeat; }
            .hiden{display: none;}
        </style>
    </head>
    <body>
    <div class="conteiner" style="display:none">
    <form method="post" action="../../controllers/musica/pcadprofessores.php" name="form" id="form">
    <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
    <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="PM">
    <input type="hidden" name="numgProfessor" id="numgProfessor" value="<?=$oProfessor->getNumgProfessor()?>">
    <input type="hidden" name="numgModalidadeD" id="numgModalidadeD" value="">
    <div id="tabs">
        <ul>
            <li><a href="#dados">Dados Gerais do Cadastro</a></li>
        </ul>
        <div id="dados">
            <?if ($_GET["info"] != ""){?>
            <table border="0" cellpadding="0" cellspacing="0" width="800px">
                <tr>
                    <td colspan="4" align="center" height="20" valign="middle" class="normal11">
                        <?switch ($_GET["info"]) {
                            case 1:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Cadastro realizado com sucesso';break;
                            case 2:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Edição realizada com sucesso';break;
                            case 3:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Desativação realizada com sucesso';break;
                            case 4:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Ativação realizado com sucesso';break;
                            case 5:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Modalidade cadastrada com sucesso';break;
                            case 6:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Modalidade excluida com sucesso';break;
                        }?>
                    </td>
                </tr>
            </table>
            <?}?>
            <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
            <p class="validateTips"></p>
            <fieldset class="fieldFormulario" style="width: 800px">
                <legend>Dados do Professor</legend>
                <table border="0" cellpadding="0" cellspacing="3" width="100%">
                    <tr>
                        <td colspan="2" style="height:30px;" class="normal11b"></td>
                        <td align="center" valign="middle" <?=$oProfessor->getNumgProfessor()!=""?$oProfessor->getDescStatus()=="Ativo"?"class=\"ui-corner-all\" style=\"background-color:green;font-weight: bold;color:#ffffff;\"":"class=\"ui-corner-all\" style=\"background-color:red;font-weight: bold;color:#ffffff;\"":""?> >
                            <?=$oProfessor->getDescStatus()?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td class="normal11b">
                            Nome*<br />
                            <input type="text" name="descNomePessoa" id="descNomePessoa" maxlength="100" class="borda" style="width:330px;" value="<?=$oProfessor->getDescNomePessoa()?>" />
                            <div id="helpBuscaNomeProfessor" style="position:relative;float:right;right:3px;display: none;text-align: center;"><img src="../imagens/icones/question.png" border="0" align="absmiddle" /></div>
                        </td>
                        <td class="normal11b">
                            Sobrenome*<br />
                            <input type="text" name="descSobreNomePessoa" id="descSobreNomePessoa" maxlength="150" class="borda" style="width:300px;" value="<?=$oProfessor->getDescSobreNomePessoa()?>" />
                        </td>
                        <td class="normal">
                            <fieldset class="fieldInFormulario">
                                <legend>Sexo</legend>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td><input type="radio" name="sexo" id="sexo" <?=$oProfessor->getDescSexo()=="M"?"checked":""?> value="M" />Masc</td>
                                        <td><input type="radio" name="sexo" id="sexo" <?=$oProfessor->getDescSexo()=="F"?"checked":""?> value="F" />Fem</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Cpf<br />
                            <input type="text" name="numrCpfCnpj" id="numrCpfCnpj" maxlength="20" class="borda" style="width:95px;" value="<?=$oProfessor->getNumrCpfcnpj()?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>                                    
                                    <td>
                                        Identidade<br />
                                        <input type="text" name="numrCarteiraIdentidade" id="numrCarteiraIdentidade" maxlength="30" class="borda" style="width:240px;" value="<?=$oProfessor->getNumrCarteiraIdentidade()?>" />
                                    </td>
                                    <td>
                                        &Oacute;rg. Exp.<br />
                                        <input type="text" name="descOrgaoExpedidor" id="descOrgaoExpedidor" maxlength="30" class="borda" style="width:100px;text-transform: uppercase" value="<?=$oProfessor->getDescOrgaoExpedidor()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Telefone 1<br />
                                        <input type="text" name="numrDddTelefone" id="numrDddTelefone" maxlength="3" class="borda" style="width:30px;" value="<?=$oProfessor->getNumrDddTelefone()?>" />
                                        <input type="text" name="numrTelefone" id="numrTelefone" maxlength="15" class="borda" style="width:100px;" value="<?=$oProfessor->getNumrTelefone()?>" />
                                    </td>
                                    <td>
                                        Telefone 2<br />
                                        <input type="text" name="numrDddTelefoneContato" id="numrDddTelefoneContato" maxlength="3" class="borda" style="width:30px;" value="<?=$oProfessor->getNumrDddTelefoneContato()?>" />
                                        <input type="text" name="numrTelefoneContato" id="numrTelefoneContato" maxlength="15" class="borda" style="width:100px;" value="<?=$oProfessor->getNumrTelefoneContato()?>" />
                                    </td>
                                    <td>
                                        Celular<br />
                                        <input type="text" name="numrDddCelular" id="numrDddCelular" maxlength="3" class="borda" style="width:30px;" value="<?=$oProfessor->getNumrDddCelular()?>" />
                                        <input type="text" name="numrCelular" id="numrCelular" maxlength="15" class="borda" style="width:100px;" value="<?=$oProfessor->getNumrCelular()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Nacionalidade<br />
                                        <input type="text" name="descNacionalidade" id="descNacionalidade" maxlength="150" class="borda" style="width:135px;" value="<?=$oProfessor->getDescNacionalidade()?>" />
                                    </td>
                                    <td class="normal">
                                        Naturalidade<br />
                                        <input type="text" name="descNaturalidade" id="descNaturalidade" maxlength="50" class="borda" style="width:213px;" value="<?=$oProfessor->getDescNaturalidade()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2" class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Data Nascimento<br />
                                        <input type="text" name="dataNascimento" id="dataNascimento" maxlength="10" class="borda" style="width:110px;" value="<?=$oProfessor->getDataNascimento()?>" />
                                    </td>
                                    <td class="normal">
                                        Email<br />
                                        <input type="text" name="descEmail" id="descEmail" maxlength="50" class="borda" style="width:310px;" value="<?=$oProfessor->getDescEmail()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Endere&ccedil;o<br />
                                        <input type="text" name="descEndereco" id="descEndereco" maxlength="250" class="borda" style="width:275px;" value="<?=$oProfessor->getDescEndereco()?>" />
                                    </td>
                                    <td class="normal">
                                        N&uacute;mero<br />
                                        <input type="text" name="numrEndereco" id="numrEndereco" maxlength="10" class="borda" style="width:70px;" value="<?=$oProfessor->getNumrEndereco()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2" class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Setor/Bairro<br />
                                        <input type="text" name="descBairro" id="descBairro" maxlength="50" class="borda" style="width:140px;" value="<?=$oProfessor->getDescBairro()?>" />
                                    </td>
                                    <td class="normal">
                                        Complemento<br />
                                        <input type="text" name="descComplemento" id="descComplemento" maxlength="250" class="borda" style="width:280px;" value="<?=$oProfessor->getDescComplemento()?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="normal">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        Cep<br />
                                        <input type="text" name="numrCep" id="numrCep" maxlength="10" class="borda" style="width:80px;" value="<?=$oProfessor->getNumrCep()?>" />
                                    </td>
                                    <td class="normal">
                                        Estado<br />
                                        <select name="siglaUf" class="borda" id="siglaUf" style="width:80px">
                                            <option value=""></option>
                                            <option value="AC"<?=$oProfessor->getSiglUf()=="AC"?'selected="selected"':""?>>Acre</option>
                                            <option value="AL"<?=$oProfessor->getSiglUf()=="AL"?'selected="selected"':""?>>Alagoas</option>
                                            <option value="AP"<?=$oProfessor->getSiglUf()=="AP"?'selected="selected"':""?>>Amapá</option>
                                            <option value="AM"<?=$oProfessor->getSiglUf()=="AM"?'selected="selected"':""?>>Amazonas</option>
                                            <option value="BA"<?=$oProfessor->getSiglUf()=="BA"?'selected="selected"':""?>>Bahia</option>
                                            <option value="CE"<?=$oProfessor->getSiglUf()=="CE"?'selected="selected"':""?>>Ceará</option>
                                            <option value="DF"<?=$oProfessor->getSiglUf()=="DF"?'selected="selected"':""?>>Distrito Federal</option>
                                            <option value="ES"<?=$oProfessor->getSiglUf()=="ES"?'selected="selected"':""?>>Espírito Santo</option>
                                            <option value="GO"<?=$oProfessor->getSiglUf()=="GO"?'selected="selected"':""?>>Goiás</option>
                                            <option value="MA"<?=$oProfessor->getSiglUf()=="MA"?'selected="selected"':""?>>Maranhão</option>
                                            <option value="MT"<?=$oProfessor->getSiglUf()=="MT"?'selected="selected"':""?>>Mato Grosso</option>
                                            <option value="MS"<?=$oProfessor->getSiglUf()=="MS"?'selected="selected"':""?>>Mato Grosso do Sul</option>
                                            <option value="MG"<?=$oProfessor->getSiglUf()=="MG"?'selected="selected"':""?>>Minas Gerais</option>
                                            <option value="PA"<?=$oProfessor->getSiglUf()=="PA"?'selected="selected"':""?>>Pará</option>
                                            <option value="PB"<?=$oProfessor->getSiglUf()=="PB"?'selected="selected"':""?>>Paraíba</option>
                                            <option value="PR"<?=$oProfessor->getSiglUf()=="PR"?'selected="selected"':""?>>Paraná</option>
                                            <option value="PE"<?=$oProfessor->getSiglUf()=="PE"?'selected="selected"':""?>>Pernambuco</option>
                                            <option value="PI"<?=$oProfessor->getSiglUf()=="PI"?'selected="selected"':""?>>Piauí</option>
                                            <option value="RJ"<?=$oProfessor->getSiglUf()=="RJ"?'selected="selected"':""?>>Rio de Janeiro</option>
                                            <option value="RN"<?=$oProfessor->getSiglUf()=="RN"?'selected="selected"':""?>>Rio Grande do Norte</option>
                                            <option value="RS"<?=$oProfessor->getSiglUf()=="RS"?'selected="selected"':""?>>Rio Grande do Sul</option>
                                            <option value="RO"<?=$oProfessor->getSiglUf()=="RO"?'selected="selected"':""?>>Rondônia</option>
                                            <option value="RR"<?=$oProfessor->getSiglUf()=="RR"?'selected="selected"':""?>>Roraima</option>
                                            <option value="SC"<?=$oProfessor->getSiglUf()=="SC"?'selected="selected"':""?>>Santa Catarina</option>
                                            <option value="SP"<?=$oProfessor->getSiglUf()=="SP"?'selected="selected"':""?>>São Paulo</option>
                                            <option value="SE"<?=$oProfessor->getSiglUf()=="SE"?'selected="selected"':""?>>Sergipe</option>
                                            <option value="TO"<?=$oProfessor->getSiglUf()=="TO"?'selected="selected"':""?>>Tocantins</option>
                                        </select>
                                    </td>
                                    <td class="normal">
                                        Municipio<br />
                                        <select name="numgMunic" class="borda" id="numgMunic" style="width:150px">
                                            <?montaCombo($resMunicipios,"numg_municipio","nome_municipio",$oProfessor->getNumgMunicipio(),true); ?>
                                        </select>
                                    </td>
                                    <td width="10%" align="left" valign="bottom"><img src="../imagens/ajax-loader_pequeno.gif" border="0" alt="" id="loadMunc" align="absmiddle" style="display:none;"/></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2" class="normal">
                            <?if($oProfessor->getDataCadastro   ()!=""):?>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="normal" align="right">Data Cadastro:</td>
                                    <td class="normal11b" align="left" style="padding-right: 10px;"><?=$oProfessor->getDataCadastro()?></td>
                                </tr>
                                <tr>
                                    <td class="normal" align="right">Usu&aacute;rio Cadastro:</td>
                                    <td class="normal11b" align="left" style="padding-right: 10px;" ><?=$oProfessor->getNomeUsuarioCadastro()?></td>
                                </tr>
                            </table>
                            <?endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Observa&ccedil;&otilde;es<br />
                            <textarea name="descObservacao" id="descObservacao" style="width: 790px;" rows="5" class="borda"><?=$oProfessor->getDescObservacao()?></textarea>
                        </td>
                    </tr>
                    <?if($oProfessor->getDataDesativacao()!= "") { ?>
                    <tr>
                        <td align="center" valign="middle" class="normal11"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Desativado em: <b><?=$oProfessor->getDataDesativacao()?></b></td>
                    </tr>
                    <?}?>
                    <tr>
                        <td colspan="3" valign="middle" align="right">
                            <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;">
                                <?if($oProfessor->getNumgProfessor()==""){?>
                                    <button id="cadastrar">Cadastrar</button>
                                    <button id="limpar">Limpar</button>
                                <?}else{?>
                                    <button id="novo">Novo</button>
                                    <button id="editar">Editar</button>
                                     <?if($oProfessor->getDescStatus() == "Ativo"){?>
                                        <button id="desativar">Desativar</button>
                                    <?}else{?>
                                        <button id="ativar">Ativar</button>
                                    <?}?>
                                <?}?>
                            </div>
                        </td>
                    </tr>
                </table>
        </fieldset>
        <?if($oProfessor->getNumgProfessor()!="" && $oProfessor->getDescStatus()!="Inativo"){?>
            <div id="btsModalidade" class="cbtsModalidade" style="display: none;">
                <button id="btCadastrarModalidade">Cadastrar Modalidade</button>
            </div>
            <fieldset class="fieldFormulario">
                <legend>Modalidades</legend>
                <?$oModalidade = new ProfessorModalidade();
                  $resModalidades = $oModalidade->consultaModalidadesNaoCadastradas($oProfessor->getNumgProfessor());
                  if($resModalidades->getCount()>0){?>
                    <div class="margin10">
                        Selecione a Modalidade<br />
                        <select name="numgModalidade" id="numgModalidade" class="borda" style="width:350px;">
                             <? montaCombo($resModalidades, "numg_modalidade", "desc_modalidade","",true);?>
                        </select>
                    </div>
                <?}
                $oModalidadesCadastradas = $oModalidade->consultaModalidadesCadastradas($oProfessor->getNumgProfessor());
                if($oModalidadesCadastradas->getCount()>0){?>
                <fieldset class="fieldInFormulario">
                    <legend>Modalidades cadastradas</legend>
                    <div style="width:100%">
                    <?for($i=0;$i<$oModalidadesCadastradas->getCount();$i++){?>
                        <button id="btModalidade<?=$oModalidadesCadastradas->getValores($i,'numg_modalidade')?>"><?=$oModalidadesCadastradas->getValores($i,"desc_modalidade")?></button>
                    <?}?>
                    </div>
                </fieldset><br />
                <?}?>
            </fieldset>
        <?}?>
        </div>
    </div>
    </form>
    <?if(count($vProfessor)>0){?>
        <div id="linkRelProfessores" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:280px;cursor: pointer;">
            Rela&ccedil;&atilde;o de Professores cadastrados
            <div id="iconlinkRelProfessores" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
        </div>
        <table id="relProfessores" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
            <thead>
                <tr>
                    <th class="ui-widget-header ui-corner-all" align="center" width="30%">Nome</th>
                    <th class="ui-widget-header ui-corner-all" align="center" width="10%">Telefone 1</th>
                    <th class="ui-widget-header ui-corner-all" align="center" width="10%">Telefone 2</th>
                    <th class="ui-widget-header ui-corner-all" align="center" width="10%">Celular</th>
                    <th class="ui-widget-header ui-corner-all" align="center" width="20%">Email</th>
                    <th class="ui-widget-header ui-corner-all" align="center" width="10%">Status</th>
                </tr>
            <thead>
            <tbody>
                <?for($i = 0; $i < $vProfessor->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
                <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgProfessor=<?=$vProfessor->getValores($i,"numg_professor")?>'">
                    <td><?=$vProfessor->getValores($i,"nomeprofessor")?></td>
                    <td><?="(".$vProfessor->getValores($i,"numr_dddtelefone").") ".$vProfessor->getValores($i,"numr_telefone")?></td>
                    <td><?="(".$vProfessor->getValores($i,"numr_dddtelefonecontato").") ".$vProfessor->getValores($i,"numr_telefonecontato")?></td>
                    <td><?="(".$vProfessor->getValores($i,"numr_dddcelular").") ".$vProfessor->getValores($i,"numr_celular")?></td>
                    <td><?=$vProfessor->getValores($i,"desc_email")?></td>
                    <td align=center <?=$vProfessor->getValores($i, "status")=="Ativo"?'style="color:green;"':'style="color:red;"'?>><?=$vProfessor->getValores($i, "status");?></td>
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
                            TOTAL: <?=$vProfessor->getCount()?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?}?>
    <!--mopTips-->
    <div class="hiden">
        <div id="tipHelpBuscaNomeProfessor" style="text-align: justify;">
            <img src="../imagens/icones/tips.png" border="0" style="position: relative;float: left;margin-right:10px;" />
            <span style="text-align: justify"> Para consultar, digite as iniciais do nome desejado.<br />
                Caso não o localize, para cadastrar o novo professor, continue preenchendo as informações normalmente clicando no botão cadastrar ao final.</span>
        </div>
    </div>
    <div id="formHorariosCadastrados" title="Alunos por modalidade" style="display: none;"></div>
    <script type="text/javascript">
        /**
         * Descrição: Botões das modalidades
         **/
         <?for($i=0;$i<$oModalidadesCadastradas->getCount();$i++){?>
            $("#btModalidade<?=$oModalidadesCadastradas->getValores($i,'numg_modalidade')?>").button().click(function(){
                $( "#formHorariosCadastrados" ).dialog( "open" );
                $( "#formHorariosCadastrados" ).html('<iframe name="horariosModalidades" width="750" height="900" src="professoresmodalidades.php?numgModalidade=<?=$oModalidadesCadastradas->getValores($i,'numg_modalidade')?>&numgProfessor=<?=$numgProfessor?>" frameborder="0" scrolling="auto" allowtransparency="true" style="background:transparent;z-index:999" />');
                $("#numgModalidadeD").val("<?=$oModalidadesCadastradas->getValores($i,'numg_modalidade')?>");
                return false;
            })            
        <?}?>
    </script>
    </div>
</body>
</html>