<?php
session_start();
/**
 * Descrição: Emissão de logs.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 12/11/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Log.php");
require_once("../../models/seguranca/Modulo.php");

$CODG_FORMULARIO = "rellogs";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Descrição: Objetos.
 */
$oLogs = new Log();
$oModulo = new Modulo();
?>
<html>
    <head>
        <title>Cadastro de Modalidades</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript" src="../javascripts/jquery.maskedinput-1.2.2.min.js"></script>
        <script type="text/javascript">
            /**
             * Descrição: Carregando as funções da Interface.
             * @author Rodolfo Bueno.
             **/
            $(function(){
                /**
                 * Descrição: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();

                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var dataCadastroIni = $( "#dataCadastroIni" );
                var dataCadastroFin = $( "#dataCadastroFin" );
                var modulo = $( "#modulo" );
                
                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oLogs->getNumgLog() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();
                
                })

                /**
                 * Descrição: Setando calendários para os campos DATE.
                 **/
                 $("#dataCadastroIni").datepicker({
                    dateFormat: 'dd/mm/yy',
                    prevText: '&#x3c;Anterior',
                    nextText: 'Pr&oacute;ximo&#x3e;',
                    currentText: 'Hoje',
                    dayNames:['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                    dayNamesMin:['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    monthNames:['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort:['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    weekHeader: 'Sm',
                    changeMonth: true,
                    changeYear: true

                });
                 $("#dataCadastroFin").datepicker({
                    dateFormat: 'dd/mm/yy',
                    prevText: '&#x3c;Anterior',
                    nextText: 'Pr&oacute;ximo&#x3e;',
                    currentText: 'Hoje',
                    dayNames:['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                    dayNamesMin:['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    monthNames:['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort:['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    weekHeader: 'Sm',
                    changeMonth: true,
                    changeYear: true

                });

                /**
                 * Descrição: inicializa a mensagem
                 **/
                function updateTips( t ) {
                    $("#validateTips").show(1000);
                    tips.text( t ).addClass( "ui-state-highlight" );
                }

                /**
                 * Descrição: Validando se a data final é maior que a data inicial.
                 **/
                function checkData( dataInicial, dataFinal ) {
                    if ( (dataInicial.val() > dataFinal.val()) && dataFinal.val().length > 0  ) {
                        dataFinal.addClass( "ui-state-error" );
                        updateTips( "A data final deve ser maior que a data inicial." );
                        return false;
                    } else {
                        return true;
                    }
                }

                /**
                 * Descrição: mascara dos campos
                 **/
                $("#dataCadastroIni").mask("99/99/9999",{placeholder:" "});
                $("#dataCadastroFin").mask("99/99/9999",{placeholder:" "});

                /**
                 * Descrição: Gerar Relatório.
                 **/
                $("#gerar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( dataCadastroIni ).add( dataCadastroFin ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkData( dataCadastroIni, dataCadastroFin );

                    if(bValid){
                        $("#tipoRelatorio").val("grafico");
                        $("#form").submit();
                    }else{
                        return false;
                    }
                })

                /**
                 * Descrição: Gerar Relatório.
                 **/
                $("#gerarExcel",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( dataCadastroIni ).add( dataCadastroFin ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkData( dataCadastroIni, dataCadastroFin );

                    if(bValid){
                        $("#tipoRelatorio").val("excel");
                        $("#form").submit();
                    }else{
                        return false;
                    }
                })

                /**
                 * Descrição: ajax populando o campo de formularios
                 **/
                $("#modulo").change(function(){
                    var opt = "";
                    $("#loadForm").show();
                    $.post("../ajax/log.php",{
                        funcao: "consultarFormularios",
                        numgModulo: modulo.val()
                    }, function(formularios){
                        $("#formulario").empty();
                        opt += '<option value=""></option>';
                        $.each(formularios, function($,vals){
                            opt += '<option value="'+vals.codg_formulario+'">'+vals.nome_formulario+'</option>';
                        })
                        $("#loadForm").hide();
                        $("#formulario").append(opt);
                    }, "json")
                })
                
            });
        </script>
        <style type="text/css">
            ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>
    <body bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
            <form method="get" name="form" id="form" action="prellogs.php">
                <input type="hidden" name="tipoRelatorio" id="tipoRelatorio" value="">
                <div id="tabs">
                    <ul><li><a href="#dados">Relat&oacute;rio de logs do sistema</a></li></ul>
                    <div id="dados">                        
                        <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                        <p class="validateTips"></p>
                        <fieldset class="fieldFormulario">
                            <legend>Filtros:</legend>
                            <table border="0" cellpadding="3" cellspacing="3" width="100%">
                                <tr>
                                    <td class="normal11b" colspan="2">
                                        M&oacute;dulo:<br />
                                        <select name="modulo" class="borda" id="modulo" style="width:128px">
                                            <?=montaCombo($oModulo->consultarModulos(), numg_modulo, desc_modulo, null, true); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b">
                                        Formul&aacute;rio:<br />
                                        <select name="formulario" class="borda" id="formulario" style="width:198px">
                                        </select>
                                    </td>
                                    <td width="10%" align="left" valign="bottom"><img src="../imagens/ajax-loader_pequeno.gif" border="0" alt="" id="loadForm" align="absmiddle" style="display:none;"/></td>
                                </tr>
                                <tr>
                                    <td class="normal11b" colspan="2">
                                        Ação:<br />
                                        <select name="acao" class="borda" id="acao" style="width:128px">
                                            <option value="" ></option>
                                            <option value="ativar" >Ativa&ccedil;&atilde;o</option>
                                            <option value="bloquear" >Bloqueio</option>
                                            <option value="cadastrar" >Cadastro</option>
                                            <option value="cancelar" >Cancelamento</option>
                                            <option value="emitir" >Emiss&atilde;o</option>
                                            <option value="desativar" >Desativa&ccedil;&atilde;o</option>
                                            <option value="desbloquear" >Desbloqueio</option>
                                            <option value="editar" >Edi&ccedil;&atilde;o</option>
                                            <option value="excluir" >Exclus&atilde;o</option>
                                            <option value="reemitir" >Reemiss&atilde;o</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" width="15%">
                                        Data A&ccedil;&atilde;o:<br />
                                        Inicial<br/>
                                        <input type="text" name="dataCadastroIni" id="dataCadastroIni" maxlength="10" class="borda"/>
                                    </td>
                                    <td align="left " class="normal11b" width="85%">
                                        <br />
                                        Final<br/>
                                        <input type="text" name="dataCadastroFin" id="dataCadastroFin" maxlength="10" class="borda"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b">
                                        Ordena&ccedil;&atilde;o<br />
                                        <select name="ordem" class="borda" id="ordem" style="width:120px">
                                            <option value="data_cadastro">Data</option>
                                            <option value="desc_tipoacao">A&ccedil;&atilde;o</option>
                                        </select>
                                    </td>
                                    <td class="normal11b">
                                        Tipo<br />
                                        <select name="ordemTipo" class="borda" id="ordemTipo" style="width:120px">
                                            <option value="asc">Ascedente</option>
                                            <option value="desc">Descedente</option>
                                        </select>
                                    </td>
                                <tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                            <button id="gerar">Gerar Relat&oacute;rio</button>
                                            <button id="gerarExcel">Exportar para Excel</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>