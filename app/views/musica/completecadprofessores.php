<?php
/**
 * Descrição: Auto complete professores - Escola de Música
 * @author Fabricio Nogueira
 * @release Criação do arquivo.
 * Data 10/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Professor.php");

$valor = $_GET["term"];

switch ($_GET['tipoBusca']) {
    case "nome":
        $oProfessor = new Professor();
        $json = $oProfessor->consultaNomeProfessor($valor);
        echo json_encode($json);
    break;
    default: break;
}
$oProfessor->free;