<?php
session_start();
/**
 * Descrição: Relatório de Professores - Escola de Música
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 11/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Professor.php");

$CODG_FORMULARIO = "relprofessores";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

/**
 * Descrição: Objetos.
 */
$oProfessor = new Professor;
?>
<html>
    <head>
        <title>Relat&oacute;rio de Professores</title>
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
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oProfessor->getNumgProfessor() ?>')
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
                $("#numrCpfCnpj").mask("999.999.999-99");
                $("#numrDdd").mask("99");
                $("#numrTel").mask("9999-9999");

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
                 * Descrição: Gerar Relatório EXCEL.
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
            });
        </script>
        <style type="text/css">
            ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>
    <body bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
            <form method="get" name="form" id="form" action="prelprofessores.php">
                <input type="hidden" name="tipoRelatorio" id="tipoRelatorio" value="">
                <div id="tabs">
                    <ul><li><a href="#dados">Dados Gerais do Relat&oacute;rio</a></li></ul>
                    <div id="dados">
                        <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                        <p class="validateTips"></p>
                        <fieldset class="fieldFormulario">
                            <legend>Filtros:</legend>
                            <table border="0" cellpadding="1" cellspacing="3" width="100%">
                                <tr>
                                    <td class="normal11b" colspan="2">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Dados Gerais</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b" width="50%">
                                                    Nome:<br />
                                                    <input type="text" name="nomeProfessor" id="nomeProfessor" size="40" maxlength="40" class="borda"/>
                                                </td>
                                                <td class="normal11b"  width="50%">
                                                    Cpf:<br />
                                                    <input type="text" name="numrCpfCnpj" id="numrCpfCnpj" size="20" class="borda"/>
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" width="50%">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Data Cadastro</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b" >
                                                    Inicial:<br/>
                                                    <input type="text" name="dataCadastroIni" id="dataCadastroIni" maxlength="10" class="borda"/>
                                                </td>
                                                <td class="normal11b">
                                                    Final:<br/>
                                                    <input type="text" name="dataCadastroFin" id="dataCadastroFin" maxlength="10" class="borda"/>
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                    <td class="normal11b" width="50%">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Telefone (Princ./Comerc./Cel.):</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b">
                                                    <br />
                                                    <input type="text" name="numrDdd" id="numrDdd" maxlength="3" class="borda" style="width:30px;"  />
                                                    <input type="text" name="numrTel" id="numrTel" maxlength="15" class="borda" style="width:100px;"  />
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" width="50%">
                                        <fieldset class="fieldInFormulario">
                                            <legend>Status:</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <input type="radio" name="status" id="status" value="AM" checked /> Ambos <br />
                                                <input type="radio" name="status" id="status" value="A" /> Ativos <br />
                                                <input type="radio" name="status" id="status" value="I" /> Inativos
                                            </table>
                                        </fieldset>
                                    </td>
                                    <td class="normal11b" valign="top" >
                                        <fieldset class="fieldInFormulario">
                                            <legend>Ordena&ccedil;&atilde;o</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b">
                                                    Por: <br />
                                                    <select name="ordem" class="borda" id="ordem" style="width:128px">
                                                        <option value="nome">Nome</option>
                                                        <option value="data">Data Cadastro</option>
                                                    </select>
                                                </td>
                                                <td class="normal11b">
                                                    Tipo: <br />
                                                    <select name="tipo" class="borda" id="tipo" style="width:128px">
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