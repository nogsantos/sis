<?php
session_start();
/**
 * Descrição: Gráfico de Recibos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 17/11/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/financeiro/Recibo.php");

$CODG_FORMULARIO = "grafrecibos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

/**
 * Descrição: Objetos.
 */
$oRecibo = new Recibo();
?>
<html>
    <head>
        <title>Gr&aacute;ficos - Recibos</title>
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

                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oRecibo->getNumgRecibo() ?>')
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

                /**
                 * Descrição: Gerar Gráfico.
                 **/
                $("#gerar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( dataCadastroIni ).add( dataCadastroFin ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkData( dataCadastroIni, dataCadastroFin );
                    if(bValid){
                        $("#form").submit();
                    }else{
                        return false;
                    }
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
            <form method="get" name="form" id="form" action="pgrafrecibos.php">
                <div id="tabs">
                    <ul><li><a href="#dados">Dados Gerais do Gr&aacute;fico</a></li></ul>
                    <div id="dados">
                        <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                        <p class="validateTips"></p>
                        <fieldset class="fieldFormulario">
                            <legend>Filtros:</legend>
                            <table border="0" cellpadding="1" cellspacing="3" style="width: 900px;">
                                <tr>
                                      <td class="normal11b" style="width: 200px">
                                      <fieldset class="fieldInFormulario">
                                            <legend>Por:</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td class="normal11b"><input type="radio" name="tipo" id="todos" value="T" checked /><label for="todos" >Todos</label></td>
                                                </tr>
                                                <tr>
                                                    <td class="normal11b"><input type="radio" name="tipo" id="status" value="S" /><label for="status" > Status</label></td>
                                                </tr>
                                                <tr>
                                                    <td class="normal11b"><input type="radio" name="tipo" id="tipos" value="P" /><label for="tipos" > Tipos</label></td>
                                                </tr>
                                                <tr>
                                                    <td class="normal11b"><input type="radio" name="tipo" id="valores" value="V" /><label for="valores" > Valores</label></td>
                                                </tr>
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
                                    <td colspan="2" align="right" valign="middle">
                                        <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;">
                                            <button id="gerar">Gerar Gr&aacute;fico</button>
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