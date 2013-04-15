<?php
/**
 * Descrição: Controller Cadastro de Modalidades dos Professores da escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 05/11/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Matricula.php");

$numgModalidade = $_POST["numgModalidade"];
$numgProfessor = $_POST["numgProfessor"];
$numgAluno = $_POST["numgAluno"];
$sCaminho = "../../../app/views/musica/cadmatriculas.php";
$sCaminho2 = "../../../app/views/musica/cadalunos.php";
$oMatricula = new Matricula();
$oMatricula->setNumgAluno($numgAluno);
$oMatricula->setNumgModalidade($numgModalidade);
$oMatricula->setNumgUsuarioMatricula($_SESSION["NUMG_OPERADOR"]);
$oMatricula->setDataMatricula("now()");
$oMatricula->setNumrDiaSemana($_POST["numrSemana"]);
$oMatricula->setNumgProfessor($numgProfessor);

switch($_POST["txtFuncao"]){
    case "consultar":
        header("Location: {$sCaminho}?numgModalidade={$numgModalidade}&numgProfessor={$numgProfessor}&numgAluno={$numgAluno}");
    break;
    case "cadastrar":
        $oMatricula->cadastrar();if (Erro::isError()){MostraErros();}
        else header("Location: {$sCaminho2}?info=5&numgAluno=$numgAluno&recibo=sim");
    break;
    case"excluirModalidade":
        $oMatricula->setNumgMatricula($_POST["numgMatricula"]);
        $oMatricula->deletar();
        header("Location: {$sCaminho2}?info=6&numgAluno=$numgAluno&recibo=sim");
    break;
    default:header("Location:{$sCaminho}");break;
}