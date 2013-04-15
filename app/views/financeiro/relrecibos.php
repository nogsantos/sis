<?php
session_start();
/**
 * Descrição: Resultado emissão de recibo avulso.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 18/10/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/financeiro/Recibo.php");

$CODG_FORMULARIO = "relrecibos";

/**
 * Descrição: valida se a seção está ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}

/**
 * Descrição: Objetos.
 */
$oRecibo = new Recibo();

/**
 * Descrição: Parametros
 */
$numgRecibo = $_GET["numgRecibo"];
$numrVias = $_GET["vias"]!=""?$_GET["vias"]:$_GET["numrVias"];
$tipo = $_GET[tipo];

if ($numgRecibo != "")
    $oRecibo->setarDados($numgRecibo, $tipo);if (Erro::isError())MostraErros();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?="recibo_numero".$oRecibo->getNumrRecibo()."-".FormataData($oRecibo->getDataEmissao())?></title>
        <link rel="stylesheet" type="text/css" href="../interface/css/redmond/jquery-ui-1.8.4.custom.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <script type="text/javascript" src="../interface/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#imprimir").button().click(function(){
                    window.print();
                })
                $("#voltar").button().click(function(){
                    history.back(-1);
                })
            })
        </script>
        <style type="text/css" media="print">
            .botao {
                display: none;
            }
        </style>
    </head>
<body>
<div class="buttonBar">
    <button class="botao" id="imprimir">Imprimir&nbsp;&nbsp;&nbsp;<img src="../imagens/printer.png" border="0" title="" alt=""/></button>
    <button class="botao" id="voltar">Voltar&nbsp;&nbsp;&nbsp;<img src="../imagens/goback.png" border="0" title="" alt=""/></button>
</div>
<div id="corpo" style="display:table;width:842px">
<?for($i=0;$i<$numrVias;$i++){?>
    <table style="border: 1px solid #000;" cellpadding="3" cellspacing="3" width="100%">
    <thead>
    <tr>
        <td align="right" valign="middle" style="font-size:16px;font-family: verdana;font-weight: bold;" width="20%">Recibo N&uacute;mero:</td>
        <td align="left" valign="middle" style="font-size:16px;font-family: verdana;font-weight: bold;" width="60%"><?=$oRecibo->getNumrRecibo()."/".date("Y")?></td>
        <td align="right" valign="middle" style="font-size:16px;font-family: verdana;font-weight: bold;" width="20%">Valor: R$ <?=FormataValor($oRecibo->getValrRecibo())?></td>
    </tr>
    <tr>
        <td colspan="3"><hr style="border-bottom: 1px solid #000000;border-left: 0px;border-top:0px;border-right: 0px;" /></td>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td align="right" style="font-size:12px;font-family: verdana;">Recebi(emos) de(a):
          <? if($oRecibo->getNumgProfessor() != "") {?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold">Miss&atilde;o Tocando as Na&ccedil;&otilde;es</td>
          <? } else if($oRecibo->getNumgAluno() != "") { ?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getNomePessoa()?></td>
          <? } else { ?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getDescRecebido()?></td>
          <? } ?>
        </tr>
        <tr>
            <td align="right" style="font-size:12px;font-family: verdana;"><?=$oRecibo->getNumgProfessor()!=""?$oRecibo->getNumgAluno()!=""?"CPF:":"CNPJ:":"CPF/CNPJ:"?></td>
            <? if($oRecibo->getNumgProfessor() != "") {?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold">06.248.938/0001-01</td>
            <? } else if($oRecibo->getNumgAluno() != "") { ?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getNumrCpfCnpj()?></td>
            <? } else { ?>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getNumrCpfCnpjRec()?></td>
            <? } ?>
        </tr>
        <tr>
            <td align="right" style="font-size:12px;font-family: verdana;">A import&acirc;ncia de:</td>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=valrExtenso($oRecibo->getValrRecibo(), "real", "reais", "centavo", "centavos" )?></td>
        </tr>
        <tr>
            <td align="right" style="font-size:12px;font-family: verdana;">Referente a:</td>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getDescReferente()?></td>
        </tr>
        <?if($oRecibo->getDescObs()!=""){?>
        <tr>
            <td align="right" style="font-size:12px;font-family: verdana;">Observa&ccedil;&atilde;o:</td>
            <td colspan="2" align="left" style="font-size:12px;font-family: verdana;font-weight: bold"><?=$oRecibo->getDescObs()?></td>
        </tr>
        <?}?>
        <tr>
            <td colspan="3"><hr style="border-bottom: 1px solid #000000;border-left: 0px;border-top:0px;border-right: 0px;" /></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td align="left" colspan="3" style="font-size:12px;font-family: verdana;">
                Para maior clareza, firmo(amos) o presente,<br />
                Goi&acirc;nia - GO, <?=retornaDiaData($oRecibo->getDataCadastro())." de ".escreveNomeMesPorExtenso(retornaMesData($oRecibo->getDataCadastro()))." de ".retornaAnoData($oRecibo->getDataCadastro())?><br/><br/><br/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td align="center" style="font-size:12px;font-family: verdana;font-weight: bold">
                <br />________________________________________<br />
                Emitente: 
                <? if($oRecibo->getNumgProfessor() != "") { ?>
                      <?=$oRecibo->getNomePessoa(); ?>
                <? } else if($oRecibo->getNumgAluno() != "") { ?>
                      Miss&atilde;o Tocando as Na&ccedil;&otilde;es
                <? } else { ?>
                      <?=$oRecibo->getDescEmitente();?>
                <? } ?>
                <br />
                <? if($oRecibo->getNumgProfessor() != "") { ?>
                      CPF <?=$oRecibo->getNumrCpfCnpj(); ?>
                <? } else if($oRecibo->getNumgAluno() != "") { ?>
                     CNPJ 06.248.938/0001-01
                <? } else { ?>
                      CPF/CNPJ <?=$oRecibo->getNumrCpfCnpjEmi(); ?>
                <? } ?>
                <br />
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"  style="font-size: 9px;" align="right"><?=$i+1?>&ordm; VIA</td>
        </tr>
    </tfoot>
</table>
    <hr style="border-bottom: 1px dotted #666;border-left: 0px;border-top:0px;border-right: 0px;margin: 10px 0 10px 0;" />
<?}?>
</div>
</body>
</html>