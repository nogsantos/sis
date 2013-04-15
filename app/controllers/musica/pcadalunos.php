<?php
/**
 * Descri��o: Controller Cadastro de Alunos escola de m�sica.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 27/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");
require_once("../../models/seguranca/Log.php");

$sCaminho = "../../../app/views/musica/cadalunos.php";
$funcao = $_POST["txtFuncao"];

$oAluno = new Aluno();
$numgAluno = $_POST["numgAluno"];
$oAluno->setDescEmail($_POST["descEmail"]);
$oAluno->setDataNascimento($_POST["dataNascimento"]);
$oAluno->setDescTipo($_POST["tipoPessoa"]);
$oAluno->setDescNomePessoa($funcao==="consultar_aluno"?"pesquisa":$_POST["descNomePessoa"]);
$oAluno->setDescSobreNomePessoa($_POST["descSobreNomePessoa"]);
$oAluno->setDescSexo($_POST["sexo"]);
$oAluno->setNumrCpfcnpj($_POST["numrCpfCnpj"]);
$oAluno->setNumrCarteiraIdentidade($_POST["numrCarteiraIdentidade"]);
$oAluno->setDescOrgaoExpedidor($_POST["descOrgaoExpedidor"]);
$oAluno->setNumrDddTelefone($_POST["numrDddTelefone"]);
$oAluno->setNumrTelefone($_POST["numrTelefone"]);
$oAluno->setNumrDddTelefoneContato($_POST["numrDddTelefoneContato"]);
$oAluno->setNumrTelefoneContato($_POST["numrTelefoneContato"]);
$oAluno->setNumrDddCelular($_POST["numrDddCelular"]);
$oAluno->setNumrCelular($_POST["numrCelular"]);
$oAluno->setDescNacionalidade($_POST["descNacionalidade"]);
$oAluno->setDescNaturalidade($_POST["descNaturalidade"]);
$oAluno->setDescEndereco($_POST["descEndereco"]);
$oAluno->setNumrEndereco($_POST["numrEndereco"]);
$oAluno->setDescBairro($_POST["descBairro"]);
$oAluno->setDescComplemento($_POST["descComplemento"]);
$oAluno->setNumrCep($_POST["numrCep"]);
$oAluno->setSiglUf($_POST["siglaUf"]);
$oAluno->setNumgMunicipio($_POST["numgMunic"]);
$oAluno->setDescObservacao($_POST["descObservacao"]);

switch ($funcao) {
    /**
     * Descri��o: Cadastro
     */
    case"cadastrar":
        $oAluno->setNumgUsuarioCadastro($_SESSION["NUMG_OPERADOR"]);
        $oAluno->cadastrar();
        $numgAluno = $oAluno->getNumgAluno();
        if (Erro::isError()) {MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadalunos", "Cadastro de Aluno - Nome: " . $oAluno->getDescNomePessoa(), "cadastrar", $_SESSION["NOME_COMPLETO"]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=1&numgAluno=" . $numgAluno);
        }
        break;
    /**
     * Descri��o: Edi��o
     */
    case"editar":
        $oAluno->setNumgUsuarioAlteracao($_SESSION["NUMG_OPERADOR"]);
        $oAluno->setNumgAluno($numgAluno);
        $oAluno->editar();
        $numgAluno = $oAluno->getNumgAluno();
        if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadalunos", "Edi��o de Aluno - Nome: " . $oAluno->getDescNomePessoa(), "editar", $_SESSION["NOME_COMPLETO"]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=2&numgAluno=" . $numgAluno);
        }
        break;
    /**
     * Descri��o: Desativa��o
     */
    case"desativar":
        $oAluno->setNumgUsuarioDesativacao($_SESSION["NUMG_OPERADOR"]);
        $oAluno->setNumgAluno($numgAluno);
        $numgAluno = $oAluno->getNumgAluno();
        $oAluno->desativar();
        if (Erro::isError()) {MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadalunos", "Desativa��o do Aluno - Nome: " . $oAluno->getDescNomePessoa(), "desativar", $_SESSION["NOME_COMPLETO"]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=3&numgAluno=" . $numgAluno);
        }
    break;
    /**
     * Descri��o: Ativa��o
     */
    case"ativar":
        $oAluno->setNumgUsuarioAtivacao($_SESSION["NUMG_OPERADOR"]);
        $oAluno->setNumgAluno($numgAluno);
        $numgAluno = $oAluno->getNumgAluno();
        $oAluno->ativar();
        if (Erro::isError()) {MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadalunos", "Ativa��o do Aluno - Nome: " . $oAluno->getDescNomePessoa(), "ativar", $_SESSION["NOME_COMPLETO"]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=4&numgAluno=" . $numgAluno);
        }
    break;
    case"consultar_aluno":
        header("Location: $sCaminho?numgAluno=$numgAluno");
    break;
    default:header("Location: $sCaminho");
        break;
}
$oAluno->free;