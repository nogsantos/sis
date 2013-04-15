<?php
session_start();

//echo"<pre>";print_r($_GET);exit;

/**
 * Descrição: Resultado relatório de Modalidades.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/musica/Modalidade.php");

$tipoRelatorio = $_GET['tipoRelatorio'];
$ordem = $_GET['ordem'];
$oModalidade = new Modalidade;

$valores = array("descModalidade" => $_GET['descModalidade'], "dataCadastroIni" 
    => $_GET['dataCadastroIni'], "dataCadastroFin" => $_GET['dataCadastroFin']);

$resultado = $oModalidade->consultaRelatorioModalidades($valores, $ordem);
if (Erro::isError()) {
    MostraErros();
}

$nomeRel = "Modalidades Escola de música ".date("d m Y H:i s");

if ($resultado->getCount() > 0) {
    if($tipoRelatorio == "grafico"){
        include("topo.php");
    } else {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=relatModalidades.xls");
        header("Pragma: no-cache");
    } ?>
    <div id="corpo" style="display:table;width:842px">
        <table border="0" cellpadding="3" cellspacing="3" width="100%">
            <thead>
                <tr>
                    <td colspan="3" align="center" style="font-size:12px;font-family: verdana;border-bottom:1px solid #000;width:842px;margin-bottom: 30px;" height="25" valign="bottom">Relat&oacute;rio de Modalidades</td>
                </tr>
                <tr>
                    <th width="45%" align="left" style="font-size:12px;font-family: verdana;">Descri&ccedil;&atilde;o</th>
                    <th width="35%" align="left" style="font-size:12px;font-family: verdana;">Valor</th>
                    <th width="35%" align="left" style="font-size:12px;font-family: verdana;">Data Cadastro</th>
                </tr>
            <thead>
            <tbody>
            <? for ($i = 0; $i < $resultado->getCount(); $i++){
                if($tipoRelatorio == "grafico"){?>
                    <tr align="center" <?=$i%2==0?"bgcolor=\"#EEEEEE\"":""?>>
                <? } else { ?>
                    <tr align="center">
                <? } ?>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, desc_modalidade) ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= FormataValor($resultado->getValores($i, valr_modalidade)) ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= FormataDataHora($resultado->getValores($i, data_cadastro)); ?></td>
            </tr>
                <? } ?>
        </tbody>
        <tfoot>
            <tr style="font-size:12px;font-family: verdana;">
                <td colspan="3" style="height:30px;border-top: 1px solid #000">
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