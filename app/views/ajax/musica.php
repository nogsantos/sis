<?php
/**
 * Descri��o: Controller para consultas ajax no cadastro de Alunos escola de m�sica.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 07/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");

switch($_POST["txtFuncao"]){
    /**
     * Descri��o: Valida duplicidade cpf
     */
    case"validaduplicidadecpf":
        $json = $oAluno->validaGravacaoDuplicidadeCpf();if (Erro::isError()) MostraErros();
        echo $json;
    break;
     default:header("Location: $sCaminho");break;
}