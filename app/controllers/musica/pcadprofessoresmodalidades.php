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
require_once("../../models/musica/ProfessorModalidade.php");

$sCaminho = "../../../app/views/musica/cadprofessores.php";

$numgProfessor = $_POST["numgProfessor"];
$numgModalidade = $_POST["numgModalidade"];

$oProfessorModalidade = new ProfessorModalidade();
$oProfessorModalidade->setNumgProfessor($numgProfessor);
$oProfessorModalidade->setNumgModalidade($_POST["numgModalidade"]);
switch($_POST["txtFuncao"]){
    case "cadastrarModalidade":
        $oProfessorModalidade->cadastrar();if (Erro::isError()) MostraErros();
        else header("Location:$sCaminho?info=5&numgProfessor=$numgProfessor");
    break;
    case"removerModalidade":
        $oProfessorModalidade->excluir();
        if(Erro::isError())MostraErros();
        else header("Location: $sCaminho?info=6&numgProfessor=$numgProfessor");
    break;
    default:header("Location: $sCaminho?numgProfessor=$numgProfessor");break;
}