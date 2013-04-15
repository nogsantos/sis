<?php
session_start();
/**
 * Descrição: Resultado - Gráficos Recibos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 17/11/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/financeiro/Recibo.php");

$oRecibo = new Recibo;

$dataIni = $_GET['dataCadastroIni'];
$dataFin = $_GET['dataCadastroFin'];
$tipoData = $_GET['tipoData'];
$tipoGrafico = $_GET['tipo'];

$resultadoGraf = $oRecibo->geracaoGraficos($dataIni, $dataFin, $tipoData, $tipoGrafico);
if (Erro::isError()) {
    MostraErros();
}

if($tipoGrafico == 'T' || $tipoGrafico == 'P'){
    for ($i = 0; $i < $resultadoGraf->getCount(); $i++) {
        if($resultadoGraf->getValores($i, desc_tipo) == 'P'){
            $contP += 1;
        } else if($resultadoGraf->getValores($i, desc_tipo) == 'A'){
            $contA += 1;
        } else{
            $contV += 1;
        }
    }

    $vetorTipos = array(
        'Professores' => $contP,
        'Alunos' => $contA,
        'Avulsos' => $contV,
    );
}

if($tipoGrafico == 'T' || $tipoGrafico == 'S'){
    for ($i = 0; $i < $resultadoGraf->getCount(); $i++) {
        if($resultadoGraf->getValores($i, desc_status) == 'C'){
            $contC += 1;
        } else if($resultadoGraf->getValores($i, desc_status) == 'E'){
            $contE += 1;
        } else{
            $contR += 1;
        }
    }

    $vetorStatus = array(
        'Cancelados' => $contC,
        'Emitidos' => $contE,
        'Reemitidos' => $contR,
    );
}

if($tipoGrafico == 'T' || $tipoGrafico == 'V'){
    for ($i = 0; $i < $resultadoGraf->getCount(); $i++) {
        if($resultadoGraf->getValores($i, valr_recibo) >= 0.00 && $resultadoGraf->getValores($i, valr_recibo) <= 100.00){
            $cont1 += 1;
        } else if($resultadoGraf->getValores($i, valr_recibo) >= 100.01 && $resultadoGraf->getValores($i, valr_recibo) <= 200.00){
            $cont2 += 1;
        } else if($resultadoGraf->getValores($i, valr_recibo) >= 200.01 && $resultadoGraf->getValores($i, valr_recibo) <= 500.00){
            $cont3 += 1;
        }else if($resultadoGraf->getValores($i, valr_recibo) >= 500.01 && $resultadoGraf->getValores($i, valr_recibo) <= 1000.00){
            $cont4 += 1;
        } else if($resultadoGraf->getValores($i, valr_recibo) >= 1000.01){
            $cont5 += 1;
        }
    }

    $vetorValor = array(
        'Faixa: R$ 0,00 a R$ 100,00' => $cont1,
        'Faixa: R$ 100,01 a R$ 200,00' => $cont2,
        'Faixa: R$ 200,01 a R$ 500,00' => $cont3,
        'Faixa: R$ 500,01 a R$ 1000,00' => $cont4,
        'Faixa: R$ Acima de R$ 1000,01' => $cont5,
    );
}

    // ------------ FIM GRAFICO POR STATUS. --------------------------- //

$nomeRel = "Gráficos - Recibos ".date("d m Y H:i s");

include("../relatorios/topo.php");
if ($resultadoGraf->getCount() > 0) { ?>
<div id="corpo" style="display:table;width:842px;page-break-after:always;">
    <table border="0" cellpadding="20" cellspacing="0" width="100%">
           <? if($tipoGrafico == 'T' || $tipoGrafico == 'S'){ ?>
                <tr align="center">
                    <td>
                        <? $grafico = googleCharts(750,250,'pizza3d',$vetorStatus,"Status");
                        print "<img src='$grafico' />";
                        ?>
                    </td>
                </tr>
           <? }
           if($tipoGrafico == 'T' || $tipoGrafico == 'P'){ ?>
                <tr align="center">
                    <td>
                        <?  $grafico2 = googleCharts(750,250,'pizza3d',$vetorTipos,"Tipo", "66CDAA|2E8B57|6B8E23");
                        print "<img src='$grafico2' />";
                        ?>
                    </td>
                </tr>
            <? }
         if($tipoGrafico == 'T' || $tipoGrafico == 'V'){ ?>
                <tr>
                    <td colspan="2" align="center">
                        <?  $grafico3 = googleCharts(750,250,'pizza3d',$vetorValor,"Valor", "BBFFFF|CD8C95|F4A460|00C5CD|CDCDB4");
                        print "<img src='$grafico3' />";
                        ?>
                    </td>
                </tr>
        <? } ?>
    </table>
</div>
<div id="dados" align="center">
    <div class="buttonBar">
        <button class="botao" id="imprimir">Imprimir&nbsp;&nbsp;&nbsp;<img src="../imagens/printer.png" border="0" title="" alt=""/></button>
        <button class="botao" id="voltar">Voltar&nbsp;&nbsp;&nbsp;<img src="../imagens/goback.png" border="0" title="" alt=""/></button>
    </div>
</div>
<? } else { ?>
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