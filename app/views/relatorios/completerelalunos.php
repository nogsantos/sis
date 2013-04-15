<?php
/**
 * Descrição: Relatório de Alunos - Escola de Música
 * @author Fabricio Nogueira
 * @release Criação do arquivo.
 * Data 10/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");

$valor = $_GET["term"];

switch ($_GET['tipoBusca']) {
    case "numr":
        $oAluno = new Aluno();
        $json = $oAluno->consultaNumrAlunos($valor);
        echo json_encode($json);
    break;
    case "nome":
        $oAluno = new Aluno();
        $json = $oAluno->consultaNomeAlunos($valor);
        echo json_encode($json);
    break;
    default: break;
}
$oAluno->free;