<?php
/**
 * Descrição: Controller para consultas ajax no cadastro de Alunos escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 07/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");

switch($_POST["txtFuncao"]){
    /**
     * Descrição: Valida duplicidade cpf
     */
    case"validaduplicidadecpf":
        $json = $oAluno->validaGravacaoDuplicidadeCpf();if (Erro::isError()) MostraErros();
        echo $json;
    break;
     default:header("Location: $sCaminho");break;
}