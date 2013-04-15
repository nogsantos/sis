<?php
session_start();

/**
 * Descrição: Resultado - Emissão de logs.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 12/11/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/seguranca/Log.php");

$oLog = new Log();
$tipoRelatorio = $_GET['tipoRelatorio'];

$valores = array("codgModulo" => $_GET['modulo'], "dataCadastroIni" => $_GET['dataCadastroIni'],
    "dataCadastroFin" => $_GET['dataCadastroFin'], "codgFormulario" => $_GET['formulario'],
    "acao" => $_GET['acao'], "ordem" => $_GET['ordem'], "ordemTipo" => $_GET['ordemTipo']);

$resultado = $oLog->relatorioLogs($valores);
if (Erro::isError()) {
    MostraErros();
}

$nomeRel = "Logs ".date("d m Y H:i s");

if ($resultado->getCount() > 0) {
    if($tipoRelatorio == "grafico"){
        include("../relatorios/topo.php");
    } else {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=registroLogs.xls");
        header("Pragma: no-cache");
    } ?>
    <div id="corpo" style="display:table;width:842px">
        <table border="0" cellpadding="3" cellspacing="3" width="100%">
            <thead>
                <tr>
                    <td colspan="5" align="center" style="font-size:12px;font-family: verdana;border-bottom:1px solid #000;width:842px;margin-bottom: 30px;" height="25" valign="bottom">Registro de Logs</td>
                </tr>
                <tr>
                    <th width="15%" align="center" style="font-size:12px;font-family: verdana;">Formul&aacute;rio</th>
                    <th width="40%" align="center" style="font-size:12px;font-family: verdana;">Descri&ccedil;&atilde;o</th>
                    <th width="10%" align="center" style="font-size:12px;font-family: verdana;">Tipo A&ccedil;&atilde;o</th>
                    <th width="15%" align="center" style="font-size:12px;font-family: verdana;">Data</th>
                    <th width="20%" align="center" style="font-size:12px;font-family: verdana;">Usu&aacute;rio</th>
                </tr>
            <thead>
            <tbody>
            <? for ($i = 0; $i < $resultado->getCount(); $i++){
                if($tipoRelatorio == "grafico"){?>
                    <tr align="center" <?=$i%2==0?"bgcolor=\"#EEEEEE\"":""?>>
                <? } else { ?>
                    <tr align="center">
                <? } ?>
                <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "desc_formulario") ?></td>
                <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "descricao") ?></td>
                <td align="center" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "desc_tipoacao"); ?></td>
                <td align="center" style="font-size:12px;font-family: verdana;"><?= FormataDataHora($resultado->getValores($i, "datahora_cadastro")); ?></td>
                <td align="center" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "desc_usuario"); ?></td>
            </tr>
                <? } ?>
        </tbody>
        <tfoot>
            <tr style="font-size:12px;font-family: verdana;">
                <td colspan="5" style="height:30px;border-top: 1px solid #000">
                    <div style="font-size:12px;font-family: verdana;" align="right">
                        TOTAL: <?= $resultado->getCount() ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<? if($tipoRelatorio == "grafico"){ ?>
<div id="dados" align="center">
    <div class="buttonBar">
        <button class="botao" id="imprimir">Imprimir&nbsp;&nbsp;&nbsp;<img src="../imagens/printer.png" border="0" title="" alt=""/></button>
        <button class="botao" id="voltar">Voltar&nbsp;&nbsp;&nbsp;<img src="../imagens/goback.png" border="0" title="" alt=""/></button>
    </div>
</div>
<? } 
 } else {
    include("../relatorios/topo.php"); ?>
    <div id="corpo" style="display:table;width:842px;page-break-after:always;">
        <table border="0" cellpadding="20" cellspacing="0" width="100%">
            <tr>
                <td class="normal11b" align="center">
                    N&atilde;o existem registros que cumpram a condi&ccedil;&atilde;o!
                </td>
            </tr>
        </table>
    </div>
<? } ?>
</body>
</html>