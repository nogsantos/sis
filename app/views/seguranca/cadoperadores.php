<?php
session_start();
/**
 * Descrição: View Cadastro de Operadores.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 30/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Grupo.php");
require_once("../../models/seguranca/Operador.php");

$CODG_FORMULARIO = "cadoperadores";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);
/**
 * Objetos.
 */
$oOperadores = new Operador;
/**
 * Parametros
 */
$bPesquisa = true;
$numgOperador = $_GET[numgOperador];
$nomeOperador = $_GET[nomeOperador];

if ($numgOperador != "" || $nomeOperador != "") {
    $oOperadores->setarDadosOperador(array($numgOperador, $nomeOperador));if (Erro::isError())MostraErros();
    if ($oOperadores->getNumgOperador() != ""){
        $oGrupos = new Grupo;
        /**
         * BUSCA OS GRUPOS DISPONÍVEIS PARA O OPERADOR
         */
        $vGruposDisponiveis = $oGrupos->consultarGruposNaoOperador(array($oOperadores->getNumgOperador()));if (Erro::isError())MostraErros();
        /**
         * BUSCA OS GRUPOS AOS QUAIS O OPERADOR PERTENCE
         */
        $vGruposOperador = $oGrupos->consultarGruposOperador(array($oOperadores->getNumgOperador()));if (Erro::isError())MostraErros();
        $oGrupos->free;
    }else {
        $bPesquisa = false;
    }
}
$resOperador = $oOperadores->consultarTodosOperadores();
?>
<html>
    <head>
        <title>Cadastro de Operadores</title>
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
                })
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var nomeOperador = $( "#txtNomeOperador" ),
                    nomeCompleto = $( "#txtNomeCompleto" ),
                    descSenha = $( "#txtDescSenha" ),
                    confirmaSenha = $( "#txtConfirmaSenha" ),
                    descEmail = $( "#txtDescEmail" ),
                    gruposDisponiveis = $( "#cboGruposDisponiveis" ),
                    gruposOperador = $( "#cboGruposOperador" ),
                    allFields = $( [] ).add( nomeOperador ).add( nomeCompleto ).add( descSenha ).add( confirmaSenha ).add( descEmail ).add( gruposDisponiveis ).add( gruposOperador ),
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
                    bValid = bValid && checkLength( nomeOperador, "Nome Operador", 3, 20 );
                    bValid = bValid && checkLength( nomeCompleto, "Nome Completo", 3, 50 );
                    bValid = bValid && checkLength( descSenha, "Senha", 4, 8 );
                    bValid = bValid && checkLength( confirmaSenha, "Confirma Senha", 4, 8 );
                    bValid = bValid && checkRegexp( descEmail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Ex.: email@mail.com" );
                    bValid = bValid && checkRegexp( descSenha, /^([0-9a-zA-Z])+$/, "São permitidos apenas letras e números a-z 0-9" );
                    bValid = bValid && checkRegexp( confirmaSenha, /^([0-9a-zA-Z])+$/, "São permitidos apenas letras e números : a-z 0-9" );
                    if ( bValid ) {
                        if(descSenha.val()==confirmaSenha.val()){
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
                            alert('As senhas não conferem.');
                            descSenha.focus();
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
                    bValid = bValid && checkLength( nomeOperador, "Nome Operador", 3, 20 );
                    bValid = bValid && checkLength( nomeCompleto, "Nome Completo", 3, 50 );
                    bValid = bValid && checkRegexp( descEmail, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Ex.: email@mail.com" );
                    bValid = bValid && checkRegexp( descSenha, /^([0-9a-zA-Z])+$/, "São permitidos apenas letras e números a-z 0-9" );
                    bValid = bValid && checkRegexp( confirmaSenha, /^([0-9a-zA-Z])+$/, "São permitidos apenas letras e números : a-z 0-9" );
                    if ( bValid ) {
                        if(descSenha.val()==confirmaSenha.val()){
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
                            alert('As senhas não conferem.');
                            descSenha.focus();
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
                    if (confirm("Confirma a EXCLUSÃO do dados?")){
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
                        $("form").submit()
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
                 * Descrição: Enviar Senha.
                 **/
                $("#enviarsenha",".buttonBar").button().click(function(){
                    if (confirm("Confirma o ENVIO de SENHA para o Operador?")){
                        /**
                         * Descrição: loader
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("enviar_senha");
                        $('form').submit();
                    }else{
                        return false;
                    }
                })
                /**
                 * Descrição: Cadastrar Grupo Operador.
                 **/
                $("#cadastrargrupo",".buttonBar2").button().click(function(){
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( gruposDisponiveis, "Grupos disponíveis", 1, 20 );
                    if ( bValid ) {
                        if (confirm("Confirma o CADASTRO do(s) Grupo(s)?")){
                            $("#txtFuncao").val("cadastrar_grupoope");
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
                    bValid = bValid && checkLength( gruposOperador, "Grupos operador", 1, 20 );
                    if ( bValid ) {
                        if (confirm("Confirma a EXCLUSÃO do(s) Grupo(s)?")){
                            $("#txtFuncao").val("excluir_grupoope");
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
                $("#linkRelOperadores").click(function(){
                    if(option==0){
                        $("#relOperadores").show(999);
                        $("#iconlinkRelOperadores").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relOperadores").hide(999);
                        $("#iconlinkRelOperadores").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descrição: Limpar campos do formulário
                 **/
                $("#limpar").button().click(function(){
                    nomeOperador.val("");
                    nomeCompleto.val("");
                    descSenha.val("");
                    confirmaSenha.val("");
                    descEmail.val("");
                    gruposDisponiveis.val("");
                    gruposOperador.val("");
                    return false;
                });
            });
            /**
             * Descrição: inicialização do formulário.
             **/
            function iniForm(){
                montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oOperadores->getNumgOperador() ?>');
                $("#txtNomeOperador").focus();
            }
        </script>
        </head>
        <body onLoad="iniForm()" bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
        <form method="post" action="../../controllers/seguranca/pcadoperadores.php" name="form" id="form">
        <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
        <input type="hidden" name="txtNumgOperador" id="txtNumgOperador" value="<?=$oOperadores->getNumgOperador()?>">
        <div id="tabs">
            <ul>
                <li><a href="#geral">Dados Gerais do Cadastro</a></li>
                <?=$oOperadores->getNumgOperador()!=""?'<li><a href="#grupos">Grupos de Usu&aacute;rios</a></li>':''?>
            </ul>
            <div id="geral">               
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
                    <legend>Dados do Operador</legend>
                    <table border="0" width="100%" cellspacing="3" cellpadding="0">
                    <?if ($oOperadores->getDataCadastro() != "" && !is_null($oOperadores->getDataCadastro())) { ?>
                    <tr>
                        <td class="normal11">cadastrado em: <b><?= $oOperadores->getDataCadastro() ?></b> [<?= $oOperadores->getNomeOperadorCad() ?>]</td>
                    </tr>
                    <?}?>
                    <tr>
                        <td class="normal11b">
                            Operador*<br />
                            <input type="text" name="txtNomeOperador" id="txtNomeOperador" value="<?= $oOperadores->getNomeOperador() ?>" size="20" maxlength="20" class="borda">
                        </td>
                    </tr>
                    <tr>
                        <td class="normal11b">
                            Nome Completo*<br />
                            <input type="text" name="txtNomeCompleto" id="txtNomeCompleto" value="<?= $oOperadores->getNomeCompleto() ?>" size="70" maxlength="50" class="borda" onKeyDown="setarFocus(this,'form',event)">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="position: relative;float: left;" class="normal11b" >
                                Senha*<br />
                                    <input type="password" name="txtDescSenha" id="txtDescSenha" value="<?= $oOperadores->getDescSenha() ?>" size="20" maxlength="8" class="borda" onKeyDown="setarFocus(this,'form',event)">
                            </div>
                            <div style="position: relative;float: right;right: 500px;" class="normal11b">
                                Confirmação*<br />
                                <input type="password" name="txtConfirmaSenha" id="txtConfirmaSenha" value="<?= $oOperadores->getDescSenha()?>" size="20" maxlength="8" class="borda" onKeyDown="setarFocus(this,'form',event)">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="normal11b">
                            E-mail*<br />
                            <input type="text" name="txtDescEmail" id="txtDescEmail" value="<?= $oOperadores->getDescEmail() ?>" size="70" maxlength="50" class="borda" onKeyDown="setarFocus(this,'form',event)">
                        </td>
                    </tr>
                    <?if ($oOperadores->getDataBloqueio() != "" && !is_null($oOperadores->getDataBloqueio())) { ?>
                    <tr>
                        <td align="center" class="normal11"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Bloqueado em: <b><?= $oOperadores->getDataBloqueio() ?></b> [<?= $oOperadores->getNomeOperadorBloq() ?>]</td>
                    </tr>
                    <?}?>
                    <?if ($oOperadores->getDataUltimaAlt() != "" && !is_null($oOperadores->getDataUltimaAlt())) { ?>
                    <tr>
                        <td class="normal11">última alteração: <b><?= $oOperadores->getDataUltimaAlt() ?></b> [<?= $oOperadores->getNomeOperadorAlt() ?>]</td>
                    </tr>
                    <?} ?>
                    <tr>
                        <td>
                             <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                <?if($oOperadores->getNumgOperador()==""){?>
                                    <button id="cadastrar">Cadastrar</button>
                                    <button id="limpar">Limpar</button>
                                <?}else if($oOperadores->getNumgOperador()!=1){?>
                                    <button id="novo">Novo</button>
                                    <button id="editar">Editar</button>
                                    <button id="excluir">Excluir</button>
                                     <?if($oOperadores->getDataBloqueio() == ""){?>
                                        <button id="bloquear">Bloquear</button>
                                    <?}else{?>
                                        <button id="desbloquear">Desbloquear</button>
                                    <?}?>
                                <?}else{?>
                                    <button id="novo">Novo</button>
                                <?}?>
                            </div>
                        </td>
                    </tr>
                </table>
                </fieldset>
            </div>
            <?if($oOperadores->getNumgOperador()!=""){?>
            <div id="grupos">                
                <fieldset class="fieldFormulario">
                    <legend>Grupos de Acesso</legend>
                    <table border="0" width="580" cellspacing="0" cellpadding="2" >
                        <tr class="normal11b" style="height: 15px;">
                            <td width="10%">Grupos Dispon&iacute;veis</td>
                            <td>Grupos do Operador</td>
                        </tr>
                        <tr>
                            <td>
                                <select multiple name="cboGruposDisponiveis[]" id="cboGruposDisponiveis" class="borda" size="10" style="width:230px;"><?montaCombo($vGruposDisponiveis, numg_grupo, nome_grupo); ?></select>
                            </td>
                            <td>
                                <select name="cboGruposOperador[]" id="cboGruposOperador" multiple class="borda" size="10" style="width:230px;"><?montaCombo($vGruposOperador, numg_grupo, nome_grupo); ?></select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                               <div class="buttonBar2" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                    <?if($oOperadores->getNumgOperador()!=""){?>
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
        <?if(count($resOperador)>0){?>
        <div id="linkRelOperadores" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:240px;cursor: pointer;">
            Rela&ccedil;&atilde;o de operadores cadastrados
        <div id="iconlinkRelOperadores" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
        </div>
        <table id="relOperadores" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
            <thead>
            <tr>
                <th class="ui-widget-header ui-corner-all"align="center" width="50%">Nome Completo</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="25%">Data Cadastro</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="25%">Data Bloqueio</th>
            </tr>
            </thead>
            <tbody>
                <?for($i = 0; $i < $resOperador->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
                <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgOperador=<?=$resOperador->getValores($i, numg_operador)?>'">
                    <td><?=$resOperador->getValores($i, nome_completo)?></td>
                    <td><?=FormataDataHora($resOperador->getValores($i, data_cadastro));?></td>
                    <td><?=FormataDataHora($resOperador->getValores($i, data_bloqueio));?></td>
                </tr>
                <?}?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" style="height:30px" class="ui-widget-header ui-corner-all">
                    <div style="float:left;position:relative;left:20px;">
                        * Clique no item para edit&aacute;-lo
                    </div>
                    <div style="float:right;position:relative;right:40px;">
                        TOTAL: <?=$resOperador->getCount()?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
    <?}?>
    <?$oOperadores->free; ?>
    </div>
</body>
</html>