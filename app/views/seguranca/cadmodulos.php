<?php
session_start();
/**
 * Descrição: View Cadastro de modulos.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Modulo.php");
require_once("../../models/seguranca/Grupo.php");

$CODG_FORMULARIO = "cadmodulos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Descrição: Objetos.
 */
$oModulos = new Modulo();
/**
 * Descrição: Parametros
 */
$numgModulo = $_GET[numgModulo];
if($numgModulo!=""){
    $oModulos->setarDados($numgModulo);if (Erro::isError())MostraErros();
    $oGrupos = new Grupo;
    $vGruposDisponiveis = $oGrupos->consultarGruposDisponiveis($oModulos->getNumgModulo());if (Erro::isError())MostraErros();
    $vGruposCadastrados = $oGrupos->consultarGruposCadastrados($oModulos->getNumgModulo());if (Erro::isError())MostraErros();
    $oGrupos->free;
}
/**
 * Descrição: BUSCA TODOS OS MODULOS CADASTRADOS.
 */
$vModulos = $oModulos->consultarModulos();if (Erro::isError())MostraErros();
?>
<html>
    <head>
        <title>Cadastro de Módulos</title>
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
                * Descrição: Carregamento do formulario.
                **/
                $(window).load(function(){
                    $(".conteiner").delay(500).fadeIn(900);
                    /**
                     * Descrição: Inicializando as Tabs.
                     **/
                    $('#tabs').tabs();
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oModulos->getNumgModulo() ?>')
                    $("#codgFormulario").focus();
                })
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var codgModulo = $( "#codgModulo" );
                var numrOrdem = $( "#numrOrdem" );
                var descNome = $( "#descNome" );
                var descModulo = $( "#descModulo" );
                var gruposDisponiveis = $( "#cboGruposDisponiveis" );
                var gruposCadastrados = $( "#cboGruposCadastrados" );
                allFields = $( [] ).add( codgModulo ).add( numrOrdem ).add( descNome ).add( descModulo ).add( gruposDisponiveis ).add( gruposCadastrados ),
                tips = $( ".validateTips" );
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
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( codgModulo, "Código", 3, 50 );
                    bValid = bValid && checkLength( numrOrdem, "Ordem", 1, 3 );
                    bValid = bValid && checkLength( descNome, "Nome", 3, 50 );
                    bValid = bValid && checkLength( descModulo, "Descriçao", 3, 250 );
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
                   var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( codgModulo, "Código", 3, 50 );
                    bValid = bValid && checkLength( numrOrdem, "Ordem", 1, 3 );
                    bValid = bValid && checkLength( descNome, "Nome", 3, 50 );
                    bValid = bValid && checkLength( descModulo, "Descriçao", 3, 250 );
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
                 * Descrição: Cadastrar Grupo modulo.
                 **/
                $("#cadastrargrupo",".buttonBar2").button().click(function(){
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( gruposDisponiveis, "Grupos disponíveis", 1, 20 );
                    if ( bValid ) {
                        if (confirm("Confirma o CADASTRO do(s) Grupo(s)?")){
                            $("#txtFuncao").val("cadastrar_grupomod");
                            $("form").submit();
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Excluir Grupo Operador.
                 **/
                $("#excluirgrupo",".buttonBar2").button().click(function(){
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( gruposCadastrados, "Grupos cadastrados", 1, 20 );
                    if ( bValid ) {
                        if (confirm("Confirma a EXCLUSÃO do(s) Grupo(s)?")){
                            $("#txtFuncao").val("excluir_grupomod");
                            $("form").submit();
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelModulos").click(function(){
                    if(option==0){
                        $("#relModulos").show(999);
                        $("#iconlinkRelModulos").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relModulos").hide(999);
                        $("#iconlinkRelModulos").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descrição: Limpar dados do formulário
                 **/
                $("#limpar").button().click(function(){
                    codgModulo.val("");
                    numrOrdem.val("");
                    descNome.val("");
                    descModulo.val("");
                    gruposDisponiveis.val("");
                    gruposCadastrados.val("");
                    return false;
                });
            });
        </script>
    </head>
    <body bgcolor="#FFFFFF">
    <div class="conteiner" style="display: none">
    <form method="post" name="form" id="form" action="../../controllers/seguranca/pcadmodulos.php">
    <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
    <input type="hidden" name="numgModulo" id="numgModulo" value="<?=$oModulos->getNumgModulo() ?>">   
    <div id="tabs">
        <ul>
            <li><a href="#dados">Dados Gerais do Cadastro</a></li>
            <?=$oModulos->getNumgModulo()!=""?'<li><a href="#grupos">Grupos de usu&aacute;rios</a></li>':''?>
        </ul>
        <div id="dados">            
            <?if ($_GET[info] != ""){?>
            <table border="0" cellpadding="0" cellspacing="0" width="800px">
                <tr>
                    <td align="center" height="20" valign="middle" class="normal11">
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
                <legend>Dados do m&oacute;dulo</legend>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <?if($oModulos->getDataCadastro() != "" && !is_null($oModulos->getDataCadastro())) { ?>
                    <tr>
                        <td class="normal11">cadastrado em: <b><?= $oModulos->getDataCadastro() ?></b> [<?= $oModulos->getNomeOperadorCad() ?>]</td>
                    </tr>
                    <?}?>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="50%">
                                <tr>
                                    <td class="normal11b">
                                        C&oacute;digo*<br />
                                        <input type="text" name="codgModulo" id="codgModulo" size="25" maxlength="50" class="borda" value="<?=$oModulos->getCodgModulo()?>" />
                                    </td>
                                    <td class="normal11b">
                                        Ordem*<br />
                                        <input  type="text" name="numrOrdem" id="numrOrdem"  size="10" maxlength="3" class="borda" onKeyDown="setarFocus(this,'form',event)" value="<?= $oModulos->getNumrOrdem() ?>" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="normal11b">
                            Nome*<br />
                            <input type="text" name="descNome" id="descNome" size="73" maxlength="50" class="borda" value="<?=$oModulos->getDescNome()?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <td class="normal11b">
                            Descri&ccedil;&atilde;o*<br />
                            <textarea name="descModulo" id="descModulo" rows="3" cols="70" class="borda" onKeyUp="limitaCampo(this,250)"><?=$oModulos->getDescModulo()?></textarea>
                        </td>
                    </tr>
                    <?if($oModulos->getDataBloqueio() != "" && !is_null($oModulos->getDataBloqueio())){?>
                    <tr>
                        <td align="center" valign="middle" class="normal11"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Bloqueado em: <b><?= $oModulos->getDataBloqueio() ?></b> [<?= $oModulos->getNomeOperadorBloq() ?>]</td>
                   </tr>
                   <?}?>
                   <tr>
                       <td>
                           <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                            <?if($oModulos->getNumgModulo()==""){?>
                                <button id="cadastrar">Cadastrar</button>
                                <button id="limpar">Limpar</button>
                            <?}else{?>
                                <button id="novo">Novo</button>
                                <button id="editar">Editar</button>
                                <button id="excluir">Excluir</button>
                                 <?if($oModulos->getDataBloqueio() == ""){?>
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
        <?if($oModulos->getNumgModulo()!=""){?>
        <div id="grupos">            
            <fieldset class="fieldFormulario">
                <legend>Grupos de usu&aacute;rios</legend>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                        <tr class="normal11b" style="height: 15px;">
                            <td width="10%">Grupos dispon&iacute;veis</td>
                            <td>Grupos cadastrados</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="cboGruposDisponiveis[]" id="cboGruposDisponiveis" multiple class="borda" size="9" style="width:230px"><?montaCombo($vGruposDisponiveis, numg_grupo, nome_grupo);?></select>
                            </td>
                            <td>
                                <select name="cboGruposCadastrados[]" id="cboGruposCadastrados" multiple class="borda" size="9" style="width:230px"><?montaCombo($vGruposCadastrados, numg_grupo, nome_grupo); ?></select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="buttonBar2" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                    <?if($oModulos->getNumgModulo()!=""){?>
                                        <button id="cadastrargrupo">Cadastrar Grupo Operador</button>
                                        <button id="excluirgrupo">Excluir Grupo Operador</button>
                                    <?}?>
                                </div>
                            </td>
                        </tr>
                    </table>
            </fieldset>
        </div>
    <?}?>
    </form>
    </div>
    <?if(count($vModulos)>0){?>
    <div id="linkRelModulos" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:240px;cursor: pointer;">
        Rela&ccedil;&atilde;o de modulos cadastrados
        <div id="iconlinkRelModulos" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
    </div>
    <table id="relModulos" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
        <thead>
            <tr>
                <th class="ui-widget-header ui-corner-all"align="center" width="20%">C&oacute;digo</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="25%">Descri&ccedil;&atilde;o</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="10%">Ordem</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="10%">Data Bloqueio</th>
            </tr>
        </thead>
        <tbody>
            <?for($i = 0; $i < $vModulos->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
            <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgModulo=<?=$vModulos->getValores($i, numg_modulo)?>'">
                <td align="left"><?=$vModulos->getValores($i, codg_modulo)?></td>
                <td align="left"><?=$vModulos->getValores($i, desc_modulo)?></td>
                <td align="center"><?=$vModulos->getValores($i, numr_ordem)?></td>
                <td align=center><?=FormataDataHora($vModulos->getValores($i, data_bloqueio));?></td>
            </tr>
            <?}?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" style="height:30px" class="ui-widget-header ui-corner-all">
                <div style="float:left;position:relative;left:20px;">
                    * Clique no item para edit&aacute;-lo
                </div>
                <div style="float:right;position:relative;right:40px;">
                    TOTAL: <?=$vModulos->getCount()?>
                </div>
            </td>
        </tr>
        </tfoot>
    </table>
    <?}?>
    <?$oModulos->free;?>
    </div>
</body>
</html>