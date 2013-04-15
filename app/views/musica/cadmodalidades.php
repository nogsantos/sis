<?php
session_start();
/**
 * Descri��o: View Cadastro de Modalidades do sistema.
 * @author Rodolfo Bueno
 * @release Cria��o do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Modalidade.php");

$CODG_FORMULARIO = "cadmodalidades";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Descri��o: Objetos.
 */
$oModalidades = new Modalidade();
/**
 * Descri��o: Parametros
 */
$numgModalidade = $_GET[numgModalidade];
if ($numgModalidade != "")
    $oModalidades->setarDadosFormulario($numgModalidade);if (Erro::isError()

    )MostraErros();
/**
 * Descri��o: BUSCA AS MODALIDADES CADASTRADAS.
 */
$vModalidades = $oModalidades->consultarModalidades();
if (Erro::isError()

    )MostraErros();
/**
 * Descri��o: Bot�es
 */
if ($_GET[flag_novoRegistro] != "") {
    $bFlagNovoRegistro = false;
} else {
    $bFlagNovoRegistro = true;
}
$numgOperador = $_SESSION[NUMG_OPERADOR];
?>
<html>
    <head>
        <title>Cadastro de Modalidades</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/jquery-price_format.1.3.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript">
            /**
             * Descri��o: Carregando as fun��es da Interface.
             * @author Fabricio Nogueira.
             **/
            $(function(){
                /**
                 * Descri��o: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();
                /**
                 * Descri��o: Inicializa os parametros do formul�rio
                 **/                
                var descModalidade = $( "#descModalidade" );
                var vlrModalidade = $( "#vlrModalidade" );
           
                /**
                 * Descri��o: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oModalidades->getNumgModalidade() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();
                    $("#descModalidade").focus();
                })
                /**
                 * Descri��o: Formantando campo de tipo Valor.
                 **/
                $('#vlrModalidade').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: ''
                });
                    
                /**
                 * Descri��o: inicializa a mensagem
                 **/
                function updateTips( t ) {
                    $("#validateTips").show(1000);
                    tips.text( t ).addClass( "ui-state-highlight" );
                }
               
                /**
                 * Descri��o: Valida��o do tamanho do campo
                 **/
                function checkLength( o, n, min, max ) {
                    if ( o.val().length > max || o.val().length < min ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "O Campo " + n + " � de prenchimento obrigat�rio e deve conter mais de " + min +  " caracteres." );
                        return false;
                    } else {
                        return true;
                    }
                }
                /**
                 * Descri��o: Valida��o da express�o regular
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
                 * Descri��o: Novo Registro.
                 **/
                $("#novo",".buttonBar").button().click(function(){
                    window.location.href = 'musica/<?= $CODG_FORMULARIO ?>.php';
                })                
                /**
                 * Descri��o: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( descModalidade ).add( vlrModalidade ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( descModalidade, "Nome da Modalidade", 3, 30 );
                    bValid = bValid && checkLength( vlrModalidade, "Valor da Modalidade", 3, 30 );
                    if ( bValid ) {
                        if (confirm("Confirma o CADASTRO dos dados?")){
                            /**
                             * Descri��o: loader
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
                 * Descri��o: Editar.
                 **/
                $("#editar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( descModalidade ).add( vlrModalidade ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( descModalidade, "Descri��o Modalidade", 3, 30 );
                    bValid = bValid && checkLength( vlrModalidade, "Valor da Modalidade", 1, 10 );
                    if ( bValid ) {
                        if (confirm("Confirma a EDI��O dos dados?")){
                            /**
                             * Descri��o: loader
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
                 * Descri��o: Excluir.
                 **/
                $("#excluir",".buttonBar").button().click(function(){
                    if (confirm("Confirma a EXCLUS�O dos dados?")){
                        /**
                         * Descri��o: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("excluir");
                        $("form").submit();
                    }else{
                        return false;
                    }
                })
                /**
                 * Descri��o: Bloquear.
                 **/
                $("#bloquear",".buttonBar").button().click(function(){
                    if (confirm("Confirma o BLOQUEIO?")){
                        /**
                         * Descri��o: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("bloquear");
                        $("#form").submit()
                    }else{
                        return false;
                    }
                })
                /**
                 * Descri��o: Desbloquear.
                 **/
                $("#desbloquear",".buttonBar").button().click(function(){
                    if (confirm("Confirma o DESBLOQUEIO?")){
                        /**
                         * Descri��o: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("desbloquear");
                        $("form").submit();
                    }else{
                        return false;
                    }
                });
                /**
                 * Descri��o: relat�rio.
                 **/
                 var option = 0;
                $("#linkRelModalidades").click(function(){
                    if(option==0){
                        $("#relModalidades").show(999);
                        $("#iconlinkRelModalidades").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relModalidades").hide(999);
                        $("#iconlinkRelModalidades").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descri��o: Limpar os campos do formul�rio
                 **/
                $("#limpar").button().click(function(){
                    descModalidade.val("");
                    vlrModalidade.val("");
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
            <form method="post" name="form" id="form" action="../../controllers/musica/pcadmodalidades.php">
                <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
                <input type="hidden" name="txtNumgModalidade" id="txtNumgModalidade" value="<?= $oModalidades->getNumgModalidade() ?>">
                <div id="tabs">
                    <ul><li><a href="#dados">Dados Gerais do Cadastro</a></li></ul>
                    <div id="dados">
                        <? if ($_GET[info] != "") {?>
                            <table border="0" cellpadding="0" cellspacing="0" width="800px">
                                <tr>
                                    <td align="center" height="20" valign="middle" class="normal11">
                                        <img src="../imagens/icones/info.png" border="0" align="absbottom" alt="">&nbsp;&nbsp;
                                    <?switch ($_GET["info"]) {
                                        case 1:echo "Cadastro realizado com sucesso";
                                            break;
                                        case 2:echo "Edi��o realizada com sucesso";
                                            break;
                                        case 3:echo "Exclus�o realizada com sucesso";
                                            break;
                                        case 4:echo "Bloqueio realizado com sucesso";
                                            break;
                                        case 5:echo "Desbloqueio realizado com sucesso";
                                            break;
                                    }?>
                                </td>
                            </tr>
                        </table>
                        <? } ?>
                                <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                                <p class="validateTips"></p>
                                <fieldset class="fieldFormulario" style="width: 800px;">
                                    <legend>Dados da Modalidade</legend>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <? if ($oModalidades->getDataCadastro() != "" && !is_null($oModalidades->getDataCadastro())) {
 ?>
                                    <tr>
                                        <td valign="middle" class="normal11">cadastrado em: <b><?= $oModalidades->getDataCadastro() ?></b> [<?= $oModalidades->getNomeOperadorCad() ?>]</td>
                                    </tr>
<? } ?>
                                <tr>
                                    <td class="normal11b">
                                        Nome*<br />
                                        <input type="text" name="descModalidade" id="descModalidade" size="50" maxlength="60" class="borda" value="<?= $oModalidades->getNomeModalidade() ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b">
                                        Valor*<br />
                                        <input type="text" name="vlrModalidade" id="vlrModalidade" size="10" maxlength="10" class="borda" value="<?= $oModalidades->getValorModalidade() ?>" />
                                    </td>
                                </tr>
                                <? if ($oModalidades->getDataBloqueio() != "" && !is_null($oModalidades->getDataBloqueio())) { ?>
                                    <tr>
                                        <td class="normal11" align="center" valign="middle"><img src="../imagens/icones/excla.png" border="0" align="absbottom" alt="">&nbsp;Formul&aacute;rio bloqueado em: <b><?= $oModalidades->getDataBloqueio() ?></b> [<?= $oModalidades->getNomeOperadorBloq() ?>]</td>
                                    </tr>
                                <? } ?>
                                    <tr>
                                        <td align="right" valign="middle">
                                             <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;">
                                                <?if($oModalidades->getNumgModalidade() == ""){?>
                                                    <button id="cadastrar">Cadastrar</button>
                                                    <button id="limpar">Limpar</button>
                                                <?}else {?>
                                                    <button id="novo">Novo</button>
                                                    <button id="editar">Editar</button>
                                                    <button id="excluir">Excluir</button>
                                                <?if ($oModalidades->getDataBloqueio() == "") {?>
                                                    <button id="bloquear">Bloquear</button>
                                                <?}else {?>
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
            <?if($vModalidades->getCount() > 0) { ?>
            <div id="linkRelModalidades" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:220px;cursor: pointer;">
                Rela&ccedil;&atilde;o das Modalidades cadastradas
                <div id="iconlinkRelModalidades" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
            </div>
            <table id="relModalidades" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
                <thead>
                    <tr>
                        <th class="ui-widget-header ui-corner-all" align="center" width="50%">Nome</th>
                        <th class="ui-widget-header ui-corner-all" align="center" width="25%">Valor</th>
                        <th class="ui-widget-header ui-corner-all" align="center" width="25%">Data Bloqueio</th>
                    </tr>
                <thead>
                <tbody>
                <? for ($i = 0; $i < $vModalidades->getCount(); $i++) {
                    $bgColor = ($i % 2 == 1) ? '#E8E8E8' : '#FFFFFF'; ?>
                    <tr style="height: 20px;cursor:pointer;" <?= $i % 2 == 1 ? "bgcolor=\"#E8E8E8\"" : "" ?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor; ?>'" onclick="location.href='<?= $CODG_FORMULARIO ?>.php?numgModalidade=<?= $vModalidades->getValores($i, numg_modalidade) ?>'">
                            <td><?= $vModalidades->getValores($i, desc_modalidade) ?></td>
                            <td><?= FormataValor($vModalidades->getValores($i, valr_modalidade)) ?></td>
                            <td align=center><?= FormataDataHora($vModalidades->getValores($i, data_bloqueio)); ?></td>
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
                                TOTAL: <?=$vModalidades->getCount()?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <? } ?>
            <? $oModalidades->free; ?>
        </div>
    </body>
</html>