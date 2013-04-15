<?php
/**
 * Descri��o: Relat�rio de Alunos - Escola de M�sica
 * @author Fabricio Nogueira
 * @release Cria��o do arquivo.
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