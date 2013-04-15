<?php
session_start();
/**
 * Descrição: View Cadastro de Referentes do sistema.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/financeiro/Referente.php");

$CODG_FORMULARIO = "cadreferente";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Descrição: Objetos.
 */
$oReferente = new Referente();
/**
 * Descrição: Parametros
 */
$numgReferente = $_GET[numgReferente];
if ($numgReferente != "")
    $oReferente->setarDadosReferencia ($numgReferente);if (Erro::isError()

    )MostraErros();
/**
 * Descrição: BUSCA AS ReferenteS CADASTRADAS.
 */
$vReferentes = $oReferente->consultarReferencias();
if (Erro::isError()

    )MostraErros();

$numgOperador = $_SESSION[NUMG_OPERADOR];
?>
<html>
    <head>
        <title>Cadastro de Refer&ecirc;ncias</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../interface/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript">
            /**
             * Descrição: Carregando as funções da Interface.
             * @author Rodolfo Bueno
             **/
            $(function(){
                /**
                 * Descrição: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/                
                var descReferente = $( "#descReferente" );
                var descCodigo = $( "#descCodigo" );
           
                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oReferente->getNumgReferente() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();
                    $("#descReferente").focus();
                })
                    
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
                        updateTips( "O Campo " + n + " é de prenchimento obrigatório e deve conter mais de " + min +  " caracteres. Seu tamanho máximo é de "+ max +" caracteres." );
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
                    window.location.href = 'Financeiro/<?= $CODG_FORMULARIO ?>.php';
                })                
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( descReferente ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( descReferente, "Descrição da Referência", 3, 155 );

                    if ( bValid ) {
                        if (confirm("Confirma o CADASTRO dos dados?")){
                            /**
                             * Descrição: loader
                             **/
                            $(".ajaxLoader").show().delay(300).fadeOut(1000);
                            $("#txtFuncao").val("cadastrar");
                            $("form").submit();
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
                    allFields = $( [] ).add( descReferente ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( descReferente, "Descrição da Referência", 3, 155 );
                    if ( bValid ) {
                        if (confirm("Confirma a EDIÇÃO dos dados?")){
                            /**
                             * Descrição: loader
                             **/
                            $(".ajaxLoader").show().delay(300).fadeOut(1000);
                            $("#txtFuncao").val("editar");
                            $("form").submit();
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Excluir.
                 **/
                $("#excluir",".buttonBar").button().click(function(){
                    if (confirm("Confirma a EXCLUSÃO dos dados?")){
                        /**
                         * Descrição: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("excluir");
                        $("form").submit();
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Bloquear.
                 **/
                $("#bloquear",".buttonBar").button().click(function(){
                    if (confirm("Confirma o BLOQUEIO?")){
                        /**
                         * Descrição: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("bloquear");
                        $("#form").submit()
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Desbloquear.
                 **/
                $("#desbloquear",".buttonBar").button().click(function(){
                    if (confirm("Confirma o DESBLOQUEIO?")){
                        /**
                         * Descrição: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("desbloquear");
                        $("form").submit();
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelReciboReferente").click(function(){
                    if(option==0){
                        $("#relReciboReferente").show(999);
                        $("#iconlinkRelReciboReferente").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relReciboReferente").hide(999);
                        $("#iconlinkRelReciboReferente").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descriçao: Limpar Dados
                 **/
                $("#limpar").button().click(function(){
                     descReferente.val("");
                     descCodigo.val("");
                     return false;
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
            <form method="post" name="form" id="form" action="../../controllers/financeiro/pcadreferente.php">
                <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
                <input type="hidden" name="txtNumgReferente" id="txtNumgReferente" value="<?= $oReferente->getNumgReferente() ?>">
                <div id="tabs">
                    <ul><li><a href="#dados">Dados Gerais do Cadastro</a></li></ul>
                    <div id="dados">
                        <? if ($_GET[info] != "") {
                        ?>
                                <table border="0" cellpadding="0" cellspacing="0" width="800px">
                                    <tr>
                                        <td align="center" height="20" valign="middle" class="normal11">
                                            <img src="../imagens/icones/info.png" border="0" align="absbottom" alt="">&nbsp;&nbsp;
                                    <?
                                    switch ($_GET[info]) {
                                        case 1:echo "Cadastro realizado com sucesso";
                                            break;
                                        case 2:echo "Edição realizada com sucesso";
                                            break;
                                        case 3:echo "Exclusão realizada com sucesso";
                                            break;
                                        case 4:echo "Bloqueio realizado com sucesso";
                                            break;
                                        case 5:echo "Desbloqueio realizado com sucesso";
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <? } ?>
                                <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                                <p class="validateTips"></p>
                                <fieldset class="fieldFormulario">
                                    <legend>Refer&ecirc;ncia</legend>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <? if ($oReferente->getDataCadastro() != "" && !is_null($oReferente->getDataCadastro())) {
                                ?>
                                    <tr>
                                        <td valign="middle" class="normal11">cadastrado em: <b><?= $oReferente->getDataCadastro() ?></b> [<?= $oReferente->getNomeOperadorCad() ?>]</td>
                                    </tr>
                                <? } ?>
                                <tr>
                                    <td class="normal11b">
                                        C&oacute;digo:<br />
                                        <input type="text" name="descCodigo" id="descCodigo" class="borda" size="20" value="<?= $oReferente->getDescCodigo() ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b">
                                        Descri&ccedil&atilde;o<br />
                                        <textarea name="descReferente" id="descReferente" rows="2" cols="82"  class="borda"><?= $oReferente->getDescReferente() ?></textarea>
                                    </td>
                                </tr>
                                <? if ($oReferente->getDataBloqueio() != "" && !is_null($oReferente->getDataBloqueio())) { ?>
                                    <tr>
                                        <td class="normal11" align="center" valign="middle"><img src="../imagens/icones/excla.png" border="0" align="absbottom" alt="">&nbsp;Refer&ecirc;ncia bloqueada em: <b><?= $oReferente->getDataBloqueio() ?></b> [<?= $oReferente->getNomeOperadorBloq() ?>]</td>
                                    </tr>
                                <? } ?>
                                    <tr>
                                        <td>
                                            <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                                <?if($oReferente->getNumgReferente() == "") {?>
                                                    <button id="cadastrar">Cadastrar</button>
                                                    <button id="limpar">Limpar</button>
                                                <?}else{?>
                                                    <button id="novo">Novo</button>
                                                    <button id="editar">Editar</button>
                                                    <button id="excluir">Excluir</button>
                                                <?if($oReferente->getDataBloqueio() == ""){?>
                                                    <button id="bloquear">Bloquear</button>
                                                <?}else{?>
                                                    <button id="desbloquear">Desbloquear</button>
                                                <?}}?>
                                            </div>
                                        </td>
                                    </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </form>
            <? if (!empty($vReferentes)) { ?>
            <div id="linkRelReciboReferente" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:240px;cursor: pointer;">
                Rela&ccedil;&atilde;o das refer&ecirc;ncias cadastradas
                <div id="iconlinkRelReciboReferente" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
            </div>
            <table id="relReciboReferente" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
                <thead>
                    <tr>
                        <th class="ui-widget-header ui-corner-all" align="center" width="20%">C&oacute;digo</th>
                        <th class="ui-widget-header ui-corner-all" align="center" width="55%">Descri&ccedil;&atilde;o</th>
                        <th class="ui-widget-header ui-corner-all" align="center" width="25%">Data Bloqueio</th>
                    </tr>
                <thead>
                <tbody>
                <? for ($i = 0; $i < $vReferentes->getCount(); $i++) {
                    $bgColor = ($i % 2 == 1) ? '#E8E8E8' : '#FFFFFF'; ?>
                <tr style="height: 20px;cursor:pointer;" <?= $i % 2 == 1 ? "bgcolor=\"#E8E8E8\"" : "" ?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor; ?>'" onclick="location.href='<?= $CODG_FORMULARIO ?>.php?numgReferente=<?= $vReferentes->getValores($i, numg_referente) ?>'">
                        <td><?= $vReferentes->getValores($i, desc_codigo) ?></td>
                        <td><?= $vReferentes->getValores($i, desc_referente) ?></td>
                        <td align=center><?= FormataDataHora($vReferentes->getValores($i, data_bloqueio)); ?></td>
                    </tr>
                <? } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" style="height:30px" class="ui-widget-header ui-corner-all">
                        <div style="float:left;position:relative;left:20px;">
                            * Clique no item para edit&aacute;-lo
                        </div>
                        <div style="float:right;position:relative;right:40px;">
                            TOTAL: <?=$vReferentes->getCount()?>
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
            <? } ?>
            <? $oReferente->free; ?>
        </div>
    </body>
</html>