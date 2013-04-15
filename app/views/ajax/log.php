<?php
/**
 * Descrição: Consulta formulários via ajax.
 * @author Rodolfo Bueno.
 * @release Criação do arquivo.
 * Data 13/11/2010
 */
include_once("../../funcoes.php");
include_once("../../models/Erro.php");
include_once("../../Oad.php");
include_once("../../Resultset.php");
include_once("../../models/seguranca/Log.php");
$funcao = $_POST[funcao];
$numgModulo = $_POST[numgModulo];
switch ($funcao) {
    case "consultarFormularios":
       if ($numgModulo != "") {
            $oFormulario = new Formulario();
            $oResult = new Resultset();
            $oResult = $oFormulario->consultarFormulariosPorModulo($numgModulo);           
            echo json_encode($oResult);
        }else{
            echo "";
        }
    break;
    default: echo "";break;
}