<?php
session_start();
/**
 * Descrição: Emissão de recibos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 14/10/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/financeiro/Recibo.php");
require_once("../../models/financeiro/Referente.php");

$CODG_FORMULARIO = "cadrecibos";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION[NUMG_OPERADOR]);

/**
 * Descrição: Objetos.
 */
$oProfessor = new Professor;
$oRecibo = new Recibo;
$oReferente = new Referente;

// Buscando as referencias ativas.
$resRef = $oReferente->consultarReferenciasAtivas();

/**
 * Descrição: Parametros
 */
$numgRecibo = $_GET["numgRecibo"];
$numrRecibo = $_GET["numrRecibo"];
$descTipo = $_GET[descTipo];

/** Verificando com qual informaçao serão setados os dados, caso seja com numgRecibo significa que a origem é o proprio grid desta tela,
 * caso seja por numrRecibo a origem é o botao de CONSULTAR recibo.
*/
if ($numgRecibo != "" || $numrRecibo != "") {
    $oRecibo->setarDados($numgRecibo, $descTipo, $numrRecibo);
    if (Erro::isError()) {
        MostraErros();
    } else {
        // Caso não seja encontrado nenhum recibo o número informado pelo usuario será exibida uma mensagem.
        if ($oRecibo->getNumgProfessor() == "") {
            $info = "Não Existe Recibo de Professor Cadastrado com o Número Informado!";
        }
    }
}

/**
 * Descrição: Busca os recibos já emitidos para o grid.
 * Obs: O 'P' passado como parametro significa que deverá listar somente os recibos do ripo PROFESSORES.
 * Tipos Existentes: P - Professor, A - Aluno e V - Avulso.
 */
$vRecibos = $oRecibo->consultarRecibos("P");
if (Erro::isError()

    )MostraErros();
?>
<html>
    <head>
        <title>Recibo de Professores</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/jquery-price_format.1.3.js"></script>
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
                var numrRecibo = $( "#numrRecibo" );
                var dataEmissao = $( "#dataEmissao" );
                var valrRecibo = $( "#valor" );
                var descReferente = $( "#referente" );
                var numgRef = $( "#numgRef" );


                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oRecibo->getNumgRecibo() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();

                    <? if ($oRecibo->getNumgRecibo() != "") { ?>
                            $("#dataEmissao").attr('disabled','disabled');
                            $("#dataEmissao").attr('class','somenteLeitura');
                            $("#valor").attr('disabled','disabled');
                            $("#valor").attr('class','somenteLeitura');
                            $("#referente").attr('disabled','disabled');
                            $("#referente").attr('class','somenteLeitura');
                            $("#emitente").attr('disabled','disabled');
                            $("#emitente").attr('class','somenteLeitura');
                            $("#obs").attr('disabled','disabled');
                            $("#obs").attr('class','somenteLeitura');
                            $("#numgRef").attr('disabled','disabled');
                            $("#numgRef").attr('class','somenteLeitura');
                    <? if ($oRecibo->getDataCancelamento() != "") { ?>
                                $("#numrRecibo").attr('disabled','disabled');
                                $("#numrRecibo").attr('class','somenteLeitura');
                                $("#vias").attr('disabled','disabled');
                                $("#vias").attr('class','somenteLeitura');
                    <? }
                    } ?>
                })

                /**
                 * Descrição: mascara dos campos
                 **/
                $("#dataEmissao").mask("99/99/9999",{placeholder:" "});
                $('#valor').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: ''
                });

                /**
                 * Descrição: Setando calendários para os campos DATE.
                 **/
                 $("#dataEmissao").datepicker({
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
                 * Descrição: Validação do tamanho do campo
                 **/
                function checkLength( o, n, min, max ) {
                    if ( o.val().length > max || o.val().length < min ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "O Campo " + n + " é de prenchimento obrigatório." );
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
                 * Descrição: Emitir Recibo.
                 **/
                $("#emitir",".buttonBar").button().click(function(){
                    allFields = $( [] ).add( dataEmissao ).add( valrRecibo ).add( descReferente ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( dataEmissao, "Data de Emissão", 1 );
                    bValid = bValid && checkLength( valrRecibo, "Valor do Recibo", 1 );
                    bValid = bValid && checkLength( descReferente, "Referente", 1 );
                    if ( bValid ) {
                        if (confirm("Confirma a EMISSÃO do recibo?")){
                            $(".ajaxLoader").show().delay(300).fadeOut(1000);
                            $("#txtFuncao").val("emitir");
                            $("#txtTipo").val("P");
                            $("#form").submit();
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                })

                /**
                 * Descrição: Reemitir recibo.
                 **/
                $("#reemitir",".buttonBar").button().click(function(){
                    if (confirm("Confirma a REEMISSÃO do recibo?")){
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("reemitir");
                        $("#txtTipo").val("P");
                        $("#form").submit();
                    }else{
                        return false;
                    }
                })

                /**
                 * Descrição: Cancelar Recibo.
                 **/
                $("#cancelar",".buttonBar").button().click(function(){
                    if (confirm("Confirma o CANCELAMENTO do recibo?")){
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("cancelar");
                        $("#form").submit();
                    }else{
                        return false;
                    }
                })

                /**
                 * Descrição: Consultar um recibo pelo seu número.
                 **/
                $("#consultar").button().click(function(){
                    allFields = $( [] ).add( numrRecibo ),
                    tips = $( ".validateTips" );
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = checkLength( numrRecibo, "Número do Recibo", 1 ) && checkRegexp(numrRecibo,/^[0-9]*$/,"Somente números são aceitos no campo 'Número do Recibo'");
                    if ( bValid ) {
                        $(".ajaxLoader").show().delay(300).fadeOut(1000);
                        $("#txtFuncao").val("consultar");
                        $("#txtTipo").val("P");
                        $("#form").submit();
                    } else{
                        return false;
                    }
                })

                /**
                 * Descrição: ajax populando o campo de Referencias
                 **/
                $("#numgRef").change(function(){
                    var texto = "";
                    $("#loadMunc").show();
                    $.post("../ajax/referente.php",{
                        funcao: "consultar",
                        numgRef: numgRef.val()
                    }, function(resultadoConsultaAjax){
                        if(resultadoConsultaAjax != null){
                            $.each(resultadoConsultaAjax, function($,valores){
                                texto = valores.desc_referente;
                            })
                            $("#referente").val(texto);
                            $("#loadMunc").hide();
                        }else{
                            $("#referente").val("");
                            $("#loadMunc").hide();
                        }
                    }, "json");
                });
                /**
                 * Descrição: Novo Registro.
                 **/
//                $("#novoReciboProfessor").button().click(function(){
//                    window.location.href = 'cadrecibos.php';
//                });
                /**
                 * Descrição: relatório.
                 **/
                 var option = 0;
                $("#linkRelReciboProfessores").click(function(){
                    if(option==0){
                        $("#relReciboProfessores").show(999);
                        $("#iconlinkRelReciboProfessores").removeClass("ui-icon ui-icon-circle-arrow-s").addClass("ui-icon ui-icon-circle-arrow-n");
                        option = 1;
                    }else{
                        $("#relReciboProfessores").hide(999);
                        $("#iconlinkRelReciboProfessores").removeClass("ui-icon ui-icon-circle-arrow-n").addClass("ui-icon ui-icon-circle-arrow-s");
                        option = 0;
                    }
                });
                /**
                 * Descrição: Limpar Formulário
                 **/
                $("#limpar").button().click(function(){
                    numrRecibo.val("");
                    $("#obs").val("");
                    $("#emitente").val("");
                    valrRecibo.val("");
                    descReferente.val("");
                    numgRef.val("");
                    return false;
                });
                /**
                 * Descrição: Auto complete nome do professor.
                 **/
                $("#emitente").autocomplete({
                    source: "completerecprofessor.php",
                    minLength: 2,
                    select: function( event, ui ) {
                        $(this).val(ui.item.value);
                        $("#numgProfessor").val(ui.item.id);
                    }
		});
            });
        </script>
        <style type="text/css">
            ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
            .ui-autocomplete-loading { background: url('../imagens/ui-anim_basic_16x16.gif') right center no-repeat; }
        </style>
    </head>
    <body bgcolor="#FFFFFF">
        <div class="conteiner" style="display: none">
            <form method="post" name="form" id="form" action="../../controllers/financeiro/pcadrecibos.php">
                <input type="hidden" name="txtFuncao" id="txtFuncao" value="">
                <input type="hidden" name="numgRecibo" id="numgRecibo" value="<?= $oRecibo->getNumgRecibo() ?>">
                <input type="hidden" name="txtTipo" id="txtTipo" value="<?= $oRecibo->getDescTipo() ?>">
                <input type="hidden" name="codgForm" id="codgForm" value="<?= $CODG_FORMULARIO ?>">
                <div id="tabs">
                    <ul>
                        <li><a href="#dadosProf">Dados Gerais do Recibo</a></li></ul>
                    <div id="dadosProf">
                        <div class="ajaxLoader"><img src="../imagens/ajax-loader.gif" border="0" alt="" title=""/></div>
                        <p class="validateTips"></p>
                         <?if($oRecibo->getDataCadastro() != "" && !is_null($oRecibo->getDataCadastro())) { ?>
                        <tr>
                            <td class="normal11">Cadastrado em: <b><?= $oRecibo->getDataCadastro() ?></b> [<?= $oRecibo->getNomeOperadorCad() ?>]</td>
                        </tr>
                        <?}?>
                        <?if($oRecibo->getDataReemissao() != "" && !is_null($oRecibo->getDataReemissao()) && ($oRecibo->getDataCancelamento() == "" || is_null($oRecibo->getDataCancelamento()))) { ?>
                        <tr>
                        <br/>
                        <td class="normal11">Reemitido em: <b><?= $oRecibo->getDataReemissao() ?></b> [<?= $oRecibo->getNomeOperadorRem() ?>]</td>
                        </tr>
                        <?}?>
                        <?if($oRecibo->getDataCancelamento() != "" && !is_null($oRecibo->getDataCancelamento())) { ?>
                        <tr>
                        <br/>
                        <td class="normal11">Cancelado em: <b><?= $oRecibo->getDataCancelamento() ?></b> [<?= $oRecibo->getNomeOperadorCanc() ?>]</td>
                        </tr>
                        <?}
                        if($info != ""){ ?>
                        <table border="0" cellpadding="0" cellspacing="0" id="tableInfo">
                            <tr>
                                <td class="normal11b">
                                    <img src="../imagens/icones/excla.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;
                                    <? echo $info; ?>
                                </td>
                            </tr>
                        </table>
                        <? } ?>
                        <fieldset class="fieldFormulario">
                            <legend>Filtros:</legend>
                            <table border="0" cellpadding="1" cellspacing="3" width="70%">
                            <?php if ($oRecibo->getNumgRecibo() != 0) { ?>
                                <tr>
                                    <td colspan="2" align="right">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="120" height="35" align="center" <?= $oRecibo->getDescStatus() == "Emitido" || $oRecibo->getDescStatus() == "Reemitido" ? "class=\"ui-corner-all\" style=\"background-color:green;font-weight: bold;color:#ffffff;\"" : " class=\"ui-corner-all\" style=\"background-color:red;font-weight: bold;color:#ffffff;\"" ?> >
                                                    <?= $oRecibo->getDescStatus() ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <? } ?>
                                <tr>
                                    <td class="normal11b" colspan="2">
                                        <fieldset class="fieldFormulario">
                                            <legend>Dados Gerais</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b" width="16%" >
                                                    N&uacute;mero do Recibo<br />
                                                    <input type="text" name="numrRecibo" id="numrRecibo" size="10" style="width:150px;text-align: center;" class="borda" value="<?= $oRecibo->getNumrRecibo()!=""?$oRecibo->getNumrRecibo():$oRecibo->geraNumrRecibo() ?>"/>
                                                </td>
                                                <td width="14%" valign="middle" align="left">
                                                    &nbsp;&nbsp;<button id="consultar" style="width:auto;" title="Consultar"><span class="ui-icon ui-icon-search"></span></button>
                                                </td>
                                                <td class="normal11b"  width="25%">
                                                    Data de Emiss&atilde;o *<br />
                                                    <input type="text" name="dataEmissao" id="dataEmissao" size="20" class="borda" value="<?= $oRecibo->getDataEmissao() == "" ? date("d/m/Y") : $oRecibo->getDataEmissao() ?>" />
                                                </td>
                                                <td class="normal11b"  width="25%">
                                                    Valor *<br />
                                                    <input type="text" name="valor" id="valor" size="10" class="borda" value="<?=FormataValor($oRecibo->getValrRecibo())?>"/>
                                                </td>
                                                <td class="normal11b" width="20%">
                                                    <fieldset class="fieldInFormulario">
                                                        <legend>Vias *</legend>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="50%"
                                                               <select name="vias" class="borda" id="vias" style="width:80px">
                                                                <option value="2">2</option>
                                                                <option value="1">1</option>
                                                            </select>
                                                        </table>
                                                    </fieldset>
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" width="50%">
                                        <fieldset class="fieldFormulario">
                                            <legend>Emitente *</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <td class="normal11b">
                                                    Professor <br />
                                                    <?$professor = $oRecibo->getNumgProfessor();?>
                                                    <input type="text" name="emitente" id="emitente" class="borda" id="recebido" style="width:372px" value="<?=$oProfessor->consultaNomeProfessorNumg($professor)?>" />
                                                    <input type="hidden" name="numgProfessor" id="numgProfessor" value="" />
                                                </td>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" >
                                        <fieldset class="fieldFormulario">
                                            <legend>Referente a *</legend>
                                            <table border="0" cellpadding="3" cellspacing="0" width="100%"
                                                   <tr>
                                                    <td class="normal11b">
                                                        Selecione abaixo a mensgem que será exibida<br />
                                                        <select name="numgRef" class="borda" id="numgRef" style="width:370px">
                                                        <? montaCombo($resRef, "numg_referente", "desc_codigo", $oRecibo->getNumgReferente(), true); ?>
                                                        </select>
                                                        <div id="loadMunc" style="position:absolute;float:left;left:440px;top:235px;display: none;">
                                                            <img src="../imagens/ajax-loader_pequeno.gif" border="0" alt="" align="absmiddle" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea rows="2" cols="82" id="referente" name="referente" class="borda"><?= $oRecibo->getDescReferente() ?></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="normal11b" width="50%">
                                        <fieldset class="fieldFormulario">
                                            <legend>Observa&ccedil;&atilde;o</legend>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                   <textarea rows="2" cols="82" id="obs" name="obs" class="borda"><?= $oRecibo->getDescObs() ?></textarea>
                                            </table>
                                        </fieldset>
                                    </td>
                                </tr>
                            <? if ($oRecibo->getNumgRecibo() == "") { ?>
                                <tr>
                                    <td class="normal11b">
                                        * O número do recibo ser&aacute; gerado autom&aacute;ticamente pelo sistema.
                                    </td>
                                </tr>
                            <? } ?>
                                <tr>
                                    <td>
                                        <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                                            <?if($oRecibo->getNumgRecibo() == ""){?>
                                                <button id="emitir">Emitir Recibo</button>
                                                <button id="limpar">Limpar</button>
                                            <?}else{?>
<!--                                                <button id="novoReciboProfessor">Novo Recibo</button>-->
                                            <?if($oRecibo->getDataCancelamento() == ""){?>
                                                <button id="reemitir">Imprimir</button>
                                                <button id="cancelar">Cancelar Recibo</button>
                                            <?}}?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <table id="relatorio" style="width: 100%">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
            <? if ($vRecibos->getCount() > 0) { ?>
            <div id="linkRelReciboProfessores" class="ui-corner-all ui-widget-content titles-rel-forms" style="width:240px;cursor: pointer;">
                Rela&ccedil;&atilde;o de recibos emitidos
                <div id="iconlinkRelReciboProfessores" class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
            </div>
            <table id="relReciboProfessores" cellpadding="3" cellspacing="3" style="width:100%;display: none;">
                <thead>
                    <tr>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="6%">N&uacute;mero</th>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="12%">Data Emiss&atilde;o</th>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="10%">Valor</th>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="12%">Emitente</th>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="9%">Status</th>
                        <th class="ui-widget-header ui-corner-all" style="height: 30px;" align="center" width="52%">Referente</th>
                    </tr>
                <thead>
                <tbody>
                <? for ($i = 0; $i < $vRecibos->getCount(); $i++) {
                    $bgColor = ($i % 2 == 1) ? '#E8E8E8' : '#FFFFFF'; ?>
                <tr style="height: 20px;cursor:pointer;" <?= $i % 2 == 1 ? "bgcolor=\"#E8E8E8\"" : "" ?> class="relatorio" onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor; ?>'" onclick="location.href='<?= $CODG_FORMULARIO ?>.php?numgRecibo=<?= $vRecibos->getValores($i, numg_recibo) ?>&descTipo=<?= $vRecibos->getValores($i, desc_tipo) ?>'">
                    <td align="center"><?= $vRecibos->getValores($i, numr_recibo) ?></td>
                    <td align="center"><?=FormataData($vRecibos->getValores($i, data_emissao)) ?></td>
                    <td align="center"><?=FormataValor($vRecibos->getValores($i, valr_recibo)) ?></td>
                    <td align="center"><?=$vRecibos->getValores($i, nomepessoa) ?></td>
                    <td align="center"><?= $vRecibos->getValores($i, status) ?></td>
                    <td align="center"><?=$vRecibos->getValores($i, desc_referente); ?></td>
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
                            TOTAL: <?=$vRecibos->getCount()?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <? } ?>
        <? $oFormularios->free; ?>
        </div>
    </body>
</html>