<?php
/**
 * Descrição: View Cadastro de grupos de usuários.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Grupo.php");

$CODG_FORMULARIO = "cadgrupos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

$numgGrupo = $_GET[numgGrupo];

$oGrupos = new Grupo;
if($numgGrupo != "")
    $oGrupos->setarDadosGrupo($numgGrupo);if (Erro::isError())MostraErros();
/*
 * BUSCA OS GRUPOS DE ACESSO CADASTRADOS
 */
$vGrupos = $oGrupos->consultarGrupos();if (Erro::isError())MostraErros();
?>
<html>
    <head>
        <title>Cadastro de Grupos de Acesso</title>
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
                * Descrição: Carregamento do formulario.
                **/
                $(window).load(function(){
                    $(".conteiner").delay(500).fadeIn(900);
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oGrupos->getNumgGrupo() ?>')
                    $("#txtNomeGrupo").focus();
                })                
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/
                var nomeGrupo = $( "#txtNomeGrupo" );
                var descGrupo = $( "#txtDescGrupo   " );                
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
                });
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( nomeGrupo ).add( descGrupo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeGrupo, "Nome Grupo", 3, 50 );
                    bValid = bValid && checkLength( descGrupo, "Descrição", 6, 255 );
                    if ( bValid ) {                        
                        if (confirm("Confirma o CADASTRO dos dados?")){
                            /**
                             * Descrição: Fechamento do formulario
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
                });
                /**
                 * Descrição: Editar.
                 **/
                $("#editar",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( nomeGrupo ).add( descGrupo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( nomeGrupo, "Nome Grupo", 3, 50 );
                    bValid = bValid && checkLength( descGrupo, "Descrição", 6, 255 );
                    if ( bValid ) {
                        if (confirm("Confirma a EDIÇÃO dos dados?")){
                            /**
                             * Descrição: Fechamento do formulario
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
                });
                /**
                 * Descrição: Excluir.
                 **/
                $("#excluir",".buttonBar").button().click(function(){                   
                    if (confirm("Confirma a EXCLUSÃO dos dados?")){
                        /**
                         * Descrição: Fechamento do formulario
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("excluir");
                        $("form").submit();
                    }else{
                        return false;
                    }
                });
                /**
                 * Descrição: Bloquear.
                 **/
                $("#bloquear",".buttonBar").button().click(function(){                   
                    if (confirm("Confirma o BLOQUEIO?")){
                        /**
                         * Descrição: Fechamento do formulario
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("bloquear");
                        $("form").submit()
                    }else{
                        return false;
                    }
                });
                /**
                 * Descrição: Desbloquear.
                 **/
                $("#desbloquear",".buttonBar").button().click(function(){                    
                    if (confirm("Confirma o DESBLOQUEIO?")){
                        /**
                         * Descrição: Fechamento do formulario
                         **/
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("desbloquear");
                        $("form").submit();
                    }else{
                        return false;
                    }
                });
                /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelGrupos").click(function(){
                    if(option==0){
                        $("#relGrupos").show(999);
                        $("#iconlinkRelGrupos").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relGrupos").hide(999);
                        $("#iconlinkRelGrupos").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descrição: Limpar formulário
                 **/
                $("#limpar").button().click(function(){
                    nomeGrupo.val("");
                    descGrupo.val("");
                    return false;
                });
            });
        </script>
    </head>
    <body bgcolor="#FFFFFF">
    <div class="conteiner" style="display: none">
    <form method="post" action="../../controllers/seguranca/pcadgrupos.php" name="form" id="form">
    <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
    <input type="hidden" name="txtNumgGrupo" id="txtNumgGrupo" value="<?= $oGrupos->getNumgGrupo() ?>">
    <div id="tabs">
        <ul><li><a href="#dados">Dados Gerais do Cadastro</a></li></ul>
        <div id="dados">            
            <?if ($_GET["info"] != ""){?>
            <table border="0" cellpadding="0" cellspacing="0" width="850px">
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
                <legend>Dados dos Grupos</legend>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <?if ($oGrupos->getDataCadastro() != "" && !is_null($oGrupos->getDataCadastro())) { ?>
                    <tr>
                        <td class="normal11">
                            cadastrado em: <b><?= $oGrupos->getDataCadastro() ?></b> [<?= $oGrupos->getNomeOperadorCad() ?>]
                        </td>
                    </tr>
                    <?}?>
                    <tr>
                        <td class="normal11b">
                            Nome grupo*<br />
                            <input type="text" name="txtNomeGrupo" id="txtNomeGrupo" size="25" maxlength="50" class="borda" value="<?= $oGrupos->getNomeGrupo() ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <td class="normal11b">
                            Descri&ccedil;&atilde;o*<br />
                            <textarea name="txtDescGrupo" id="txtDescGrupo" rows="3" cols="69" class="borda" onKeyUp="limitaCampo(this,255)"><?= $oGrupos->getDescGrupo() ?></textarea>
                        </td>
                    </tr>
                    <?if ($oGrupos->getDataBloqueio() != "" && !is_null($oGrupos->getDataBloqueio())) { ?>
                    <tr>
                        <td align="center" valign="middle" class="normal11"><img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;Bloqueado em: <b><?= $oGrupos->getDataBloqueio() ?></b> [<?= $oGrupos->getNomeOperadorBloq() ?>]</td>
                    </tr>
                    <?}?>
                    <tr>
                        <td>
                            <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                <?if($oGrupos->getNumgGrupo()==""){?>
                                    <button id="cadastrar">Cadastrar</button>
                                    <button id="limpar">Limpar</button>
                                <?}else{?>
                                    <button id="novo">Novo</button>
                                    <button id="editar">Editar</button>
                                    <button id="excluir">Excluir</button>
                                     <?if($oGrupos->getDataBloqueio() == ""){?>
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
    <?if(isset($vGrupos)){
        if ($vGrupos->getCount() > 0){?>
        <div id="linkRelGrupos" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:300px;cursor: pointer;">
            Rela&ccedil;&atilde;o de grupos de acesso cadastrados
            <div id="iconlinkRelGrupos" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
        </div>
        <table id="relGrupos" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
        <thead>
            <tr>
                <th class="ui-widget-header ui-corner-all"align="center" width="30%">Grupo</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="40%">Descri&ccedil;&atilde;o</th>
                <th class="ui-widget-header ui-corner-all"align="center" width="30%">Data Bloqueio</th>
            </tr>
            </thead>
            <tbody>
                <?for($i = 0; $i < $vGrupos->getCount(); $i++){$bgColor=($i%2==1)?'#E8E8E8':'#FFFFFF';?>
                <tr style="height: 20px;cursor:pointer;" <?=$i%2==1?"bgcolor=\"#E8E8E8\"":""?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?=$bgColor;?>'" onclick="location.href='<?=$CODG_FORMULARIO?>.php?numgGrupo=<?=$vGrupos->getValores($i, numg_grupo)?>'" >
                    <td><?= $vGrupos->getValores($i, nome_grupo)?></td>
                    <td><?=$vGrupos->getValores($i, desc_grupo) ?></td>
                    <td align="center"><?= FormataDataHora($vGrupos->getValores($i, data_bloqueio))?></td>
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
                        TOTAL: <?=$vGrupos->getCount()?>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
        <?}}?>
    </div>
</body>
</html>