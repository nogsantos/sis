<?php
/**
 * Descrição: Carrega referencas via ajax.
 * @author Rodolfo Bueno.
 * @release Criação do arquivo.
 * Data 28/10/2010
 */

//echo"<pre>";print_r($_POST);exit;

include_once("../../funcoes.php");
include_once("../../models/Erro.php");
include_once("../../Oad.php");
include_once("../../Resultset.php");
include_once("../../models/financeiro/Referente.php");

$funcao = $_POST["funcao"];
$numgRef = $_POST["numgRef"];

switch ($funcao) {
    case "consultar":
       if ($numgRef != "") {
            $oReferente = new Referente();
            $oResult = $oReferente->consultarPorNumg($numgRef);if (Erro::isError()) MostraErros();
            echo json_encode($oResult);
        }else{
            echo "";
        }
    break;
}