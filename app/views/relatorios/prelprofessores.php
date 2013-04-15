<?php
session_start();

//echo"<pre>";print_r($_GET);exit;

/**
 * Descrição: Resultado - Relatório de Professores
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 11/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/musica/Professor.php");

$tipoRelatorio = $_GET['tipoRelatorio'];
$ordem = $_GET['ordem'];
$oProfessor = new Professor;

$valores = array("numrProfessor" => $_GET['numrProfessor'], "nomeProfessor" => $_GET['nomeProfessor'], "numrCpfCnpj" => $_GET['numrCpfCnpj'],
    "dataCadastroIni" => $_GET['dataCadastroIni'], "dataCadastroFin" => $_GET['dataCadastroFin'], "status" => $_GET['status'],
    "tipo" => $_GET['tipo'], "numrDdd" => $_GET['numrDdd'], "numrTel" => $_GET['numrTel']);

$resultado = $oProfessor->consultaRelatorioProfessores($valores, $ordem);
if (Erro::isError()) {
    MostraErros();
}

$nomeRel = "Professores Escola de música ".date("d m Y H:i s");

if ($resultado->getCount() > 0) {
    if($tipoRelatorio == "grafico"){
        include("topo.php");
    } else {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=relatorioProfessores.xls");
        header("Pragma: no-cache");
    } ?>
    <div id="corpo" style="display:table;width:842px">
        <table border="0" cellpadding="3" cellspacing="3" width="100%">
            <thead>
                <tr>
                    <td colspan="5" align="center" style="font-size:12px;font-family: verdana;border-bottom:1px solid #000;width:842px;margin-bottom: 30px;" height="25" valign="bottom">Relat&oacute;rio de Professores</td>
                </tr>
                <tr>
                    <th width="30%" align="left" style="font-size:12px;font-family: verdana;">Nome Completo</th>
                    <th width="30%" align="left" style="font-size:12px;font-family: verdana;">E-mail</th>
                    <th width="15%" align="left" style="font-size:12px;font-family: verdana;">Telefones</th>
                    <th width="10%" align="center" style="font-size:12px;font-family: verdana;">Status</th>
                    <th width="15%" align="left" style="font-size:12px;font-family: verdana;">Data Cadastro</th>
                </tr>
            <thead>
            <tbody>
            <? for ($i = 0; $i < $resultado->getCount(); $i++){
                if($tipoRelatorio == "grafico"){?>
                    <tr align="center" <?=$i%2==0?"bgcolor=\"#EEEEEE\"":""?>>
                <? } else { ?>
                    <tr align="center">
                <? } ?>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, nomeprofessor) ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, desc_email) ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, telefones) ?></td>
                    <td align="center" style="font-size:12px;font-family: verdana;"><?= $resultado->getValores($i, status) ?></td>
                    <td align="left" style="font-size:12px;font-family: verdana;"><?= FormataDataHora($resultado->getValores($i, data_cadastro)) ?></td>
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