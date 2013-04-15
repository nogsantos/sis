<?php
session_start();
/**
 * Descrição: Resultado - Gráficos Alunos
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 19/11/2010
 */

require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/musica/Aluno.php");

$oAluno = new Aluno();

$dataIni = $_GET['dataCadastroIni'];
$dataFin = $_GET['dataCadastroFin'];
$tipoData = $_GET['tipoData'];
$tipoGrafico = $_GET['tipo'];

$resultadoGraf = $oAluno->geracaoGraficos($dataIni, $dataFin, $tipoData, $tipoGrafico);
if (Erro::isError()) {
    MostraErros();
}

if($tipoGrafico == 'T' || $tipoGrafico == 'S'){
    for ($i = 0; $i < $resultadoGraf->getCount(); $i++) {
        if($resultadoGraf->getValores($i, desc_status) == 'A'){
            $contA += 1;
        } else if($resultadoGraf->getValores($i, desc_status) == 'I'){
            $contI += 1;
        }
    }

    $vetorStatus = array(
        'Ativos' => $contA,
        'Inativos' => $contI,
    );
}

if($tipoGrafico == 'T' || $tipoGrafico == 'X'){
    for ($i = 0; $i < $resultadoGraf->getCount(); $i++) {
        if($resultadoGraf->getValores($i, desc_sexo) == 'M'){
            $contM += 1;
        } else if($resultadoGraf->getValores($i, desc_sexo) == 'F'){
            $contF += 1;
        } else{
            $contS += 1;
        }
    }
    
    $vetorSexo = array(
        'Masculino' => $contM,
        'Feminino' => $contF,
        'Nao Informado' => $contS,
    );
}

    // ------------ FIM GRAFICO POR STATUS. --------------------------- //

$nomeRel = "Gráficos - Alunos ".date("d m Y H:i s");

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
           if($tipoGrafico == 'T' || $tipoGrafico == 'X'){ ?>
                <tr align="center">
                    <td>
                        <?  $grafico2 = googleCharts(750,250,'pizza3d',$vetorSexo,"Sexo", "66CDAA|2E8B57|6B8E23");
                        print "<img src='$grafico2' />";
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