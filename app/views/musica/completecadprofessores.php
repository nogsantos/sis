<?php
/**
 * Descri��o: Auto complete professores - Escola de M�sica
 * @author Fabricio Nogueira
 * @release Cria��o do arquivo.
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