<?php
session_start();
/**
 * Descrição: Resultado - Relatório de Recibos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 01/11/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/financeiro/Recibo.php");

$tipoRelatorio = $_GET['tipoRelatorio'];
$ordem = $_GET['ordem'];
$oRecibo = new Recibo;

// Pegando valores de todos os filtros e jogando em um array.
$valores = array("numrRecibo" => $_GET['numrRecibo'], "nome" => $_GET['nome'], "numrCpfCnpjDev" => $_GET['numrCpfCnpjDev'], "numrCpfCnpjEmi" => $_GET['numrCpfCnpjEmi'],
    "dataCadastroIni" => $_GET['dataCadastroIni'], "dataCadastroFin" => $_GET['dataCadastroFin'], "status" => $_GET['status'],
    "tipoData" => $_GET['tipoData'], "tipo" => $_GET['tipo'], "tipoOrdem" => $_GET['tipoOrdem'],
    "nomeEmitente" => $_GET['nomeEmitente'],"nomeDevedor" => $_GET['nomeDevedor']);

$resultado = $oRecibo->consultaRelatorioRecibos($valores, $ordem);
if (Erro::isError()) {
    MostraErros();
}

$nomeRel = "Recibos ".date("d m Y H:i s");

switch ($valores[tipo]){
    case 'V':
        $tipo = "Avulsos";
    break;
    case 'P':
        $tipo = "Professores";
    break;
    case 'A':
        $tipo = "Alunos";
    break;
    case 'T':
        $tipo = "Todos";
    break;
}

switch ($valores[tipoData]){
    case 'data_cadastro':
        $data = "Data Cadastro";
    break;
    case 'data_emissao':
        $data = "Data Emissão";
    break;
    case 'data_reemissao':
        $data = "Data Reemissão";
    break;
    case 'data_cancelamento':
        $data = "Data Cancelamento";
    break;
}

switch ($valores[status]){
    case 'T':
        $status = "Todos";
    break;
    case 'E':
        $status = "Emitidos";
    break;
    case 'R':
        $status = "Reemitidos";
    break;
    case 'C':
        $status = "Cancelados";
    break;
}


if ($resultado->getCount() > 0) {
    if($tipoRelatorio == "grafico"){
        include("topo.php");
    } else {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=relatorioRecibos.xls");
        header("Pragma: no-cache");
    } ?>
    <div id="corpo" style="display:table;width:842px;page-break-after:always;">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
            <thead>
                <? if($tipoRelatorio == "grafico"){?>
                <tr>
                    <td style="font-size:10px;font-family: verdana;width: 50px;">
                      <b>Tipo:</b> <?=$tipo ?>
                    </td>
                    <td style="font-size:10px;font-family: verdana;width: 200px;">
                      <b>Status:</b> <?=$status ?>
                    </td>
                    <? if($valores[dataCadastroIni] != "" || $valores["dataCadastroFin"] != "" ) { ?>
                    <td colspan="3" style="font-size:10px;font-family: verdana;width: 300px;">
                     <b> <?=$data ?>:</b> <br/> Inicial <?= $valores["dataCadastroIni"] == "" ? "--" : $valores["dataCadastroIni"] ?> /
                                                Final <?= $valores["dataCadastroFin"] == "" ? "--" : $valores["dataCadastroFin"] ?>
                    <? } ?>
                    </td>
                </tr>
                <br/>
                <? } ?>
                <tr>
                    <td colspan="6" align="center" style="font-size:12px;font-family: verdana;border-bottom:1px solid #000;width:842px;margin-bottom: 30px;" height="25" valign="middle">Relat&oacute;rio de Recibos</td>
                </tr>
                <tr>
                    <th align="center" style="font-size:12px;font-family: verdana;width:140px;">N&uacute;mero</th>
                    <? if ($valores[tipo] != "T") { ?>
                    <th align="left" style="font-size:12px;font-family: verdana;width:140px;">Emitente</th>
                    <th align="left" style="font-size:12px;font-family: verdana;width:140px;">Devedor</th>
                    <? } ?>
                    <th align="left" style="font-size:12px;font-family: verdana;width:140px;">Valor</th>
                    <th align="center" style="font-size:12px;font-family: verdana;width:140px;">Status</th>
                    <th align="left" style="font-size:12px;font-family: verdana;width:140px;">Data Emiss&atilde;o</th>
                </tr>
            <thead>
            <tbody>
                <? for ($i = 0; $i < $resultado->getCount(); $i++){
                if($tipoRelatorio == "grafico"){?>
                    <tr align="center" <?=$i%2==0?"bgcolor=\"#EEEEEE\"":""?>>
                <? } else { ?>
                    <tr align="center">
                <? } ?>
                    <td align="center" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "numr_recibo") ?></td>
                    <? if ($valores[tipo] == "P") { ?>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "nomeprofessor") ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;">Miss&atilde;o Tocando as Na&ccedil;&otilde;es</td>
                    <? } else if($valores[tipo] == "A") { ?>
                    <td align="left" style="font-size:12px;font-family: verdana;">Miss&atilde;o Tocando as Na&ccedil;&otilde;es</td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "nomealuno") ?></td>
                    <? } else if($valores[tipo] == "V") { ?>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "desc_emitente") ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "desc_recebido") ?></td>
                    <? } ?>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?=  FormataValor($resultado->getValores($i, "valr_recibo")) ?></td>
                    <td align="center" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, "status") ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= FormataData($resultado->getValores($i, "data_emissao")) ?></td>
                </tr>
             <? $valorTotal += $resultado->getValores($i, "valr_recibo"); ?>
            <? } ?>
        </tbody>
        <tfoot>
            <tr style="font-size:12px;font-family: verdana;">
                <td colspan="6" style="height:30px;border-top: 1px solid #000">
                    <div style="font-size:12px;font-family: verdana;position:relative;float: right;">
                        TOTAL: <?= $resultado->getCount() ?>
                    </div>
                    <div style="font-size:12px;font-family: verdana;position: relative;float: left;">
                        VALOR TOTAL DOS RECIBOS: <b> R$ <?=  FormataValor($valorTotal) ?> </b>
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