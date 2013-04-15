<?php
/**
 * Descrição: Auto complete alunos recibos - Escola de Música
 * @author Fabricio Nogueira
 * @release Criação do arquivo.
 * Data 17/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");

$valor = $_GET["term"];

if($valor!=""){
    $oAluno = new Aluno();
    $json = $oAluno->consultaNomeAlunos($valor);
    echo json_encode($json);
    $oAluno->free;
}
