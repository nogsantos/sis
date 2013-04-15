<?php
session_start();
/**
 * Descrição: View Cadastro de formulários do sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Formulario.php");
require_once("../../models/seguranca/Modulo.php");

$CODG_FORMULARIO = "cadformularios";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Descrição: Objetos.
 */
$oFormularios = new Formulario();
$oModulos = new Modulo();
/**
 * Descrição: Parametros
 */
$numgFormulario = $_GET[numgFormulario];
if ($numgFormulario!="")
    $oFormularios->setarDadosFormulario($numgFormulario);if (Erro::isError())MostraErros();
/**
 * Descrição: BUSCA OS FORMULÁRIOS CADASTRADOS PARA RELATÓRIO.
 */
$vFormularios = $oFormularios->consultarFormularios();if (Erro::isError())MostraErros();
/**
 * Descrição: Botões
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
        <title>Cadastro de Formul&aacute;rios</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript">
            /**
             * Descrição: Carregando as funções da Interface.
             * @author Fabricio Nogueira.
             **/
            $(function(){
                /**
                 * Descrição: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/                
                var codigoFormulario = $( "#txtCodgFormulario" );
                var nomeFormulario = $( "#txtNomeFormulario" );
                var nomeCompleto = $( "#txtNomeCompleto" );
                var descFormulario = $( "#txtDescFormulario" );
                var numrOrdem = $( "#txtNumrOrdem" );
                var numModulo = $( "#numgModulo" );                
                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    $(".conteiner").delay(500).fadeIn(900);
                });
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
                    window.location.href = 'seguranca/<?= $CODG_FORMULARIO ?>.php';
                })                
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( codigoFormulario ).add( nomeFormulario ).add( nomeCompleto ).add( descFormulario ).add( numrOrdem ).add( numModulo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( codigoFormulario, "Código", 3, 30 );
                    bValid = bValid && checkLength( nomeFormulario, "Nome do Formulário", 1, 30 );
                    bValid = bValid && checkLength( nomeCompleto, "Nome Completo", 1, 50 );
                    bValid = bValid && checkLength( descFormulario, "Descrição", 1, 255 );
                    bValid = bValid && checkLength( numrOrdem, "Ordem", 1, 2 );
                    bValid = bValid && checkLength( numModulo, "Módulo", 1, 100 );
                    bValid = bValid && checkRegexp( codigoFormulario, /^[a-z]([0-9a-z_])+$/i, "Não são permitidos caracteres especiais e/ou acentos no campo código." );
                    bValid = bValid && checkRegexp( numrOrdem, /^([0-9])+$/, "Somente números no campo ordem." );
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
                    allFields = $( [] ).add( codigoFormulario ).add( nomeFormulario ).add( nomeCompleto ).add( descFormulario ).add( numrOrdem ).add( numModulo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( codigoFormulario, "Código", 3, 30 );
                    bValid = bValid && checkLength( nomeFormulario, "Nome do Formulário", 1, 30 );
                    bValid = bValid && checkLength( nomeCompleto, "Nome Completo", 1, 50 );
                    bValid = bValid && checkLength( descFormulario, "Descrição", 1, 255 );
                    bValid = bValid && checkLength( numrOrdem, "Ordem", 1, 2 );
                    bValid = bValid && checkLength( numModulo, "Módulo", 1, 100 );
                    bValid = bValid && checkRegexp( codigoFormulario, /^[a-z]([0-9a-z_])+$/i, "Não são permitidos caracteres especiais e/ou acentos no campo código." );
                    bValid = bValid && checkRegexp( numrOrdem, /^([0-9])+$/, "Somente números no campo ordem." );
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
                $("#linkRelFormularios").click(function(){
                    if(option==0){
                        $("#relFormularios").show(999);
                        $("#iconlinkRelFormularios").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relFormularios").hide(999);
                        $("#iconlinkRelFormularios").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descrição: Limpar formulário
                 **/
                $("#limpar").button().click(function(){
                    codigoFormulario.val("");
                    nomeFormulario.val("");
                    nomeCompleto.val("");
                    descFormulario.val("");
                    numrOrdem.val("");
                    numModulo.val("");
                    return false;
                });
            });
            /**
             * Descrição: Inicialização do formulário.
             */
            function iniForm(){
                montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oFormularios->getNumgFormulario() ?>')
                $("#validateTips").hide();
                $("#txtCodgFormulario").focus();
            }
        </script>
        <style type="text/css">
            ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>
    <body onLoad="iniForm()" bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
        <form method="post" name="form" id="form" action="../../controllers/seguranca/pcadformularios.php">
        <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
        <input type="hidden" name="txtNumgFormulario" id="txtNumgFormulario" value="<?=$oFormularios->getNumgFormulario() ?>">        
        <div id="tabs">
            <ul><li><a href="#dados">Dados Gerais do cadastro</a></li></ul>
            <div id="dados">
                <?if ($_GET[info] != ""){?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="4" align="center" height="20" valign="middle" class="normal11">
                            <img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;
                            <?switch ($_GET[info]) {
                                case 1:echo "Cadastro realizado com sucesso";break;
                                case 2:echo "Edição realizada com sucesso";break;
                                case 3:echo "Exclusão realizada com sucesso";break;
                                case 4:echo "Bloqueio realizado com sucesso";break;
                                case 5:echo "Desbloqueio realizado com sucesso";break;
                                case 6:echo "Inclusão de grupo realizado com sucesso";break;
                                case 7:echo "Exclusão de grupo realizado com sucesso";break;
                                case 8:echo "Senha enviada com sucesso";break;
                            }?>
                        </td>
                    </tr>
                </table>
                <?}?>
                <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                <p class="validateTips"></p>
                <fieldset class="fieldFormulario">
                    <legend>Dados do Formul&aacute;rio</legend>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <?if($oFormularios->getDataCadastro() != "" && !is_null($oFormularios->getDataCadastro())){?>
                            <tr>
                                <td valign="middle" class="normal11">cadastrado em: <b><?=$oFormularios->getDataCadastro()?></b>[<?= $oFormularios->getNomeOperadorCad()?>]</td>
                            </tr>
                        <?}?>
                        <tr>
                            <td class="normal11b">
                                C&oacute;digo*<br />
                                <input type="text" name="txtCodgFormulario" id="txtCodgFormulario" size="25" maxlength="30" class="borda" value="<?=$oFormularios->getCodgFormulario()?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="normal11b">
                                Nome formul&aacute;rio*<br />
                                <input type="text" name="txtNomeFormulario" id="txtNomeFormulario" size="70" maxlength="30" class="borda" value="<?=$oFormularios->getNomeFormulario()?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="normal11b">
                                Nome completo*<br />
                                <input type="text" name="txtNomeCompleto" id="txtNomeCompleto" size="70" maxlength="50" class="borda" value="<?=$oFormularios->getNomeCompleto()?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="normal11b">
                                Descri&ccedil;&atilde;o*<br />
                                <textarea name="txtDescFormulario" id="txtDescFormulario" rows="3" cols="69" class="borda" onKeyUp="limitaCampo(this,255)"><?=$oFormularios->getDescFormulario()?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0" width="50%">
                                    <tr>
                                        <td class="normal11b">
                                            M&oacute;dulo*<br />
                                            <select name="numgModulo" id="numgModulo" class="borda" style="width:163px;">
                                                <?=montaCombo($oModulos->consultarModulos(), numg_modulo, desc_nome,$oFormularios->getNumgModulo(),true);?>
                                            </select>
                                        </td>
                                        <td class="normal11b">
                                            Ordem*<br />
                                            <input type="text" name="txtNumrOrdem" id="txtNumrOrdem"  size="10" maxlength="2" class="borda" onKeyDown="setarFocus(this,'form',event)" value="<?= $oFormularios->getNumrOrdem() ?>" />
                                        </td>
                                        <td align="right" class="normal11" valign="middle">
                                            Formul&aacute;rio Oculto <input type="checkbox" name="chkFlagOculto" id="chkFlagOculto" value="f" <?=($oFormularios->getFlagOculto() != "f" && $oFormularios->getFlagOculto() != "")?"checked":""?> />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?if($oFormularios->getDataBloqueio() != "" && !is_null($oFormularios->getDataBloqueio())){?>
                        <tr>
                            <td class="normal11" align="center" valign="middle"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Bloqueado em: <b><?= $oFormularios->getDataBloqueio() ?></b> [<?= $oFormularios->getNomeOperadorBloq() ?>]</td>
                        </tr>
                       <?}?>
                        <tr>
                            <td>
                                <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                    <?if($oFormularios->getNumgFormulario()==""){?>
                                        <button id="cadastrar">Cadastrar</button>
                                        <button id="limpar">Limpar</button>
                                    <?}else{?>
                                        <button id="novo">Novo</button>
                                        <button id="editar">Editar</button>
                                        <button id="excluir">Excluir</button>
                                         <?if($oFormularios->getDataBloqueio() == ""){?>
                                            <button id="bloquear">Bloquear</button>
                                        <?}else{?>
                                            <button id="desbloquear">Desbloquear</button>
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
        <?if(count($vFormularios)>0){?>
            <div id="linkRelFormularios" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:220px;cursor: pointer;">
                Rela&ccedil;&atilde;o de formul&aacute;rios cadastrados
            <div id="iconlinkRelFormularios" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
        </div>
        <table id="relFormularios" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
            <thead>
            <tr>
                <th class="ui-widget-header ui-corner-all"align="center" width="20%">C&oacute;digo</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="25%">Formul&aacute;rio</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="25%">Nome completo</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="10%">Ordem</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="10%">Oculto</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="10%">Data Bloq.</th>
            </tr>
            <thead>
            <tbody>
                <?for($i = 0; $i < $vFormularios->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
                <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgFormulario=<?=$vFormularios->getValores($i, numg_formulario)?>'">
                    <td>[ <?=$vFormularios->getValores($i, codg_modulo) . "] - " . $vFormularios->getValores($i, codg_formulario)?></td>
                    <td><?=$vFormularios->getValores($i, nome_formulario)?></td>
                    <td><?=$vFormularios->getValores($i, nome_completo)?></td>
                    <td align="center"><?=$vFormularios->getValores($i, numr_ordem)?></td>
                    <td align="center"><?=$vFormularios->getValores($i, flag_oculto)!="f"?"<span class=destaque>sim</span>":"não";?></td>
                    <td align=center><?=FormataDataHora($vFormularios->getValores($i, data_bloqueio));?></td>
                </tr>
                <?}?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="height:30px" class="ui-widget-header ui-corner-all">
                        <div style="float:left;position:relative;left:20px;">
                            * Clique no item para edit&aacute;-lo
                        </div>
                        <div style="float:right;position:relative;right:40px;">
                            TOTAL: <?=$vFormularios->getCount()?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?}?>
    <?$oFormularios->free;?>
    </div>
</body>
</html>