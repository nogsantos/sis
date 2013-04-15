<?php
session_start();
/**
 * Descrição: Relatório de Recibos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 30/10/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/financeiro/Recibo.php");

$CODG_FORMULARIO = "relrecibos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

/**
 * Descrição: Objetos.
 */
$oRecibo = new Recibo();
?>
<html>
    <head>
        <title>Relat&oacute;rio de Recibos</title>
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
                var numrRecibo = $("#numrRecibo");
                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oRecibo->getNumgRecibo() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();

                    // Desabilitando campos e alterando sua cor, referente a opção TODOS do filtro TIPO.
                    $("#nomeDevedor").attr('disabled','disabled');
                    $("#nomeDevedor").attr('class','somenteLeitura');
                    $("#numrCpfCnpjDev").attr('disabled','disabled');
                    $("#numrCpfCnpjDev").attr('class','somenteLeitura');
                    $("#nomeEmitente").attr('disabled','disabled');
                    $("#nomeEmitente").attr('class','somenteLeitura');
                    $("#numrCpfCnpjEmi").attr('disabled','disabled');
                    $("#numrCpfCnpjEmi").attr('class','somenteLeitura');

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

                })
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

                })

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
                 * Descrição: Validação da expressão regular
                 **/
                function checkRegexp(o,regexp,n) {
                    if ( !( regexp.test( o.val() ) ) && (o.val().length > 0)) {
                        o.addClass('ui-state-error');
                        updateTips(n);
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
                $("#numrCpfCnpjEmi").mask("999.999.999-99");
                $("#numrCpfCnpjDev").mask("999.999.999-99");

                /**
                 * Descrição: Gerar Relatório.
                 **/
                $("#gerar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( dataCadastroIni ).add( dataCadastroFin ).add( numrRecibo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkData( dataCadastroIni, dataCadastroFin );
                    bValid = bValid && checkRegexp(numrRecibo,/^[0-9]/,"Somente números são aceitos no campo 'Número do Recibo'");
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
                    allFields = $( [] ).add( dataCadastroIni ).add( dataCadastroFin ).add( numrRecibo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkData( dataCadastroIni, dataCadastroFin );
                    bValid = bValid && checkRegexp(numrRecibo,/^[0-9]/,"Somente números são aceitos no campo 'Número do Recibo'");
                    if(bValid){
                        $("#tipoRelatorio").val("excel");
                        $("#form").submit();
                    }else{
                        return false;
                    }
                })

                //Desabilitando os campos de acordo com o que foi selecionado no filtro TIPO.
               $("input[type=radio][name=tipo]").click(function() {
                var tipoRecibo = $("input[type=radio][name=tipo]:checked").val();
                    if (tipoRecibo=="A") {
                         $("#nomeDevedor").removeAttr("disabled");
                         $("#numrCpfCnpjDev").removeAttr("disabled");

                         $("#nomeEmitente").attr('disabled','disabled');
                         $("#nomeEmitente").attr('class','somenteLeitura');
                         $("#nomeDevedor").attr('class','borda');
                         $("#numrCpfCnpjEmi").attr('disabled','disabled');
                         $("#numrCpfCnpjEmi").attr('class','somenteLeitura');
                         $("#numrCpfCnpjDev").attr('class','borda');
                    } else if (tipoRecibo=="P") {
                        $("#nomeEmitente").removeAttr("disabled");
                        $("#numrCpfCnpjEmi").removeAttr("disabled");
                        
                        $("#nomeDevedor").attr('disabled','disabled');
                        $("#nomeDevedor").attr('class','somenteLeitura');
                        $("#numrCpfCnpjDev").attr('disabled','disabled');
                        $("#numrCpfCnpjDev").attr('class','somenteLeitura');

                        $("#nomeEmitente").attr('class','borda');
                        $("#numrCpfCnpjEmi").attr('class','borda');
                    } else if (tipoRecibo=="T"){
                         $("#nomeDevedor").attr('disabled','disabled');
                         $("#nomeDevedor").attr('class','somenteLeitura');
                         $("#numrCpfCnpjDev").attr('disabled','disabled');
                         $("#numrCpfCnpjDev").attr('class','somenteLeitura');
                         $("#nomeEmitente").attr('disabled','disabled');
                         $("#nomeEmitente").attr('class','somenteLeitura');
                         $("#numrCpfCnpjEmi").attr('disabled','disabled');
                         $("#numrCpfCnpjEmi").attr('class','somenteLeitura');
                    } else {
                        $("#nomeEmitente").removeAttr("disabled");
                        $("#numrCpfCnpjEmi").removeAttr("disabled");
                        $("#nomeDevedor").removeAttr("disabled");
                        $("#numrCpfCnpjDev").removeAttr("disabled");

                        $("#nomeEmitente").attr('class','borda');
                        $("#numrCpfCnpjEmi").attr('class','borda');
                        $("#nomeDevedor").attr('class','borda');
                        $("#numrCpfCnpjDev").attr('class','borda');
                    }
                    });

                    // Setando o valor do campo TIPODATA de acordo com o que foi selecionado em STATUS.
                    $("input[type=radio][name=status]").click(function() {
                    var status = $("input[type=radio][name=status]:checked").val();
                    switch (status){
                        case "E":
                         $("#tipoData").val("data_emissao");
                        break;
                        case "R":
                         $("#tipoData").val("data_reemissao");
                        break;
                        case "C":
                         $("#tipoData").val("data_cancelamento");
                        break;
                        case "T":
                         $("#tipoData").val("data_cadastro");
                        break;
                    }
                });
            });
        </script>
        <style type="text/css">
            ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>
    <body bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
            <form method="get" name="form" id="form" action="prelrecibos.php">
                <input type="hidden" name="tipoRelatorio" id="tipoRelatorio" value="">
                <div id="tabs">
                    <ul><li><a href="#dados">Dados Gerais do Relat&oacute;rio</a></li></ul>
                    <div id="dados">
                        <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                        <p class="validateTips"></p>
                        <fieldset class="fieldFormulario">
                            <legend>Filtros:</legend>
                            <table border="0" cellpadding="1" cellspacing="3" style="width: 900px;">
                                <tr>
                                      <td class="normal11b" style="width: 50px">
                                      <fieldset class="fieldInFormulario">
                                            <legend>Tipo:</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                <input type="radio" name="tipo" id="tipo" value="T" checked /> Todos <br />
                                                <input type="radio" name="tipo" id="tipo" value="A" /> Alunos <br />
                                                <input type="radio" name="tipo" id="tipo" value="V" /> Avulsos <br/>
                                                <input type="radio" name="tipo" id="tipo" value="P" /> Professores <br/>
                                            </table>
                                        </fieldset>
                                    </td>
                                    <td class="normal11b" style="width: 850px" valign="top">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Data</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                <td class="normal11b" >
                                                    Inicial:<br/>
                                                    <input type="text" name="dataCadastroIni" id="dataCadastroIni" maxlength="10" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Final:<br/>
                                                    <input type="text" name="dataCadastroFin" id="dataCadastroFin" maxlength="10" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                     Tipo: <br />
                                                    <select name="tipoData" class="borda" id="tipoData" style="width:128px">
                                                        <option value="data_cadastro">Cadastro</option>
                                                        <option value="data_emissao">Emiss&atilde;o</option>
                                                        <option value="data_reemissao">Reemiss&atilde;o</option>
                                                        <option value="data_cancelamento">Cancelamento</option>
                                                    </select>
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                 <tr>
                                     <td class="normal11b" colspan="2">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Dados Gerais</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" style="width: 800px;">
                                                <tr>
                                                <td class="normal11b">
                                                    N&uacute;mero do Recibo:<br />
                                                    <input type="text" name="numrRecibo" id="numrRecibo" size="20" maxlength="25" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Nome Emitente:<br />
                                                    <input type="text" name="nomeEmitente" id="nomeEmitente" size="30" maxlength="40" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Cpf Emitente:<br />
                                                    <input type="text" name="numrCpfCnpjEmi" id="numrCpfCnpjEmi" size="20" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Nome Devedor:<br />
                                                    <input type="text" name="nomeDevedor" id="nomeDevedor" size="30" maxlength="40" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Cpf Devedor:<br />
                                                    <input type="text" name="numrCpfCnpjDev" id="numrCpfCnpjDev" size="20" class="borda"/>
                                                </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" style="width: 200px">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Status:</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                <input type="radio" name="status" id="status" value="T" checked /> Todos <br />
                                                <input type="radio" name="status" id="status" value="E" /> Emitidos <br />
                                                <input type="radio" name="status" id="status" value="R" /> Reemitidos <br/>
                                                <input type="radio" name="status" id="status" value="C" /> Cancelados <br/>
                                            </table>
                                        </fieldset>
                                    </td>
                                    <td class="normal11b" style="width: 700px" valign="top">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Ordena&ccedil;&atilde;o</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                               <td class="normal11b">
                                                    Por: <br />
                                                    <select name="ordem" class="borda" id="ordem" style="width:128px">
                                                        <option value="num">N&uacute;mero</option>
                                                        <option value="data">Data</option>
                                                    </select>
                                                </td>
                                                <td class="normal11b">
                                                    Tipo: <br />
                                                    <select name="tipoOrdem" class="borda" id="tipoOrdem" style="width:128px">
                                                        <option value="asc">Ascendente</option>
                                                        <option value="desc">Descendente</option>
                                                    </select>
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2">
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