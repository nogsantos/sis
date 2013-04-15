<?php
/**
 * Descrição: Controller Cadastro de Professores da escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 08/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/seguranca/Log.php");

$sCaminho = "../../../app/views/musica/cadprofessores.php";

$oProfessor = new Professor();
$numgProfessor = $_POST["numgProfessor"];
$oProfessor->setDescEmail($_POST["descEmail"]);
$oProfessor->setDataNascimento($_POST["dataNascimento"]);
$oProfessor->setDescTipo($_POST["tipoPessoa"]);
$oProfessor->setDescNomePessoa($_POST["descNomePessoa"]);
$oProfessor->setDescSobreNomePessoa($_POST["descSobreNomePessoa"]);
$oProfessor->setDescSexo($_POST["sexo"]);
$oProfessor->setNumrCpfcnpj($_POST["numrCpfCnpj"]);
$oProfessor->setNumrCarteiraIdentidade($_POST["numrCarteiraIdentidade"]);
$oProfessor->setDescOrgaoExpedidor($_POST["descOrgaoExpedidor"]);
$oProfessor->setNumrDddTelefone($_POST["numrDddTelefone"]);
$oProfessor->setNumrTelefone($_POST["numrTelefone"]);
$oProfessor->setNumrDddTelefoneContato($_POST["numrDddTelefoneContato"]);
$oProfessor->setNumrTelefoneContato($_POST["numrTelefoneContato"]);
$oProfessor->setNumrDddCelular($_POST["numrDddCelular"]);
$oProfessor->setNumrCelular($_POST["numrCelular"]);
$oProfessor->setDescNacionalidade($_POST["descNacionalidade"]);
$oProfessor->setDescNaturalidade($_POST["descNaturalidade"]);
$oProfessor->setDescEndereco( $_POST["descEndereco"]);
$oProfessor->setNumrEndereco($_POST["numrEndereco"]);
$oProfessor->setDescBairro($_POST["descBairro"]);
$oProfessor->setDescComplemento($_POST["descComplemento"]);
$oProfessor->setNumrCep($_POST["numrCep"]);
$oProfessor->setSiglUf($_POST["siglaUf"]);
$oProfessor->setNumgMunicipio($_POST["numgMunic"]);
$oProfessor->setDescObservacao($_POST["descObservacao"]);

switch($_POST["txtFuncao"]){
    /**
     * Descrição: Cadastro
     */
    case"cadastrar":
        $oProfessor->setNumgUsuarioCadastro($_SESSION["NUMG_OPERADOR"]);
        $oProfessor->cadastrar();
        $numgProfessor = $oProfessor->getNumgProfessor();
        if (Erro::isError()) { MostraErros(); }
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadprofessores", "Cadastro de Professor - Nome: " . $oProfessor->getDescNomePessoa(), "cadastrar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=1&numgProfessor=".$numgProfessor) ; }
    break;
    /**
     * Descrição: Edição
     */
    case"editar":
        $oProfessor->setNumgUsuarioAlteracao($_SESSION["NUMG_OPERADOR"]);
        $oProfessor->setNumgProfessor($numgProfessor);
        $oProfessor->editar();
        $numgProfessor = $oProfessor->getNumgProfessor();
        if (Erro::isError()) { MostraErros(); }
        else { 
            $oLog = new Log();
            $oLog->cadastrar(2, "cadprofessores", "Edição de Professor - Nome: " . $oProfessor->getDescNomePessoa(), "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=2&numgProfessor=".$numgProfessor); }
    break;
    /**
     * Descrição: Desativação
     */
    case"desativar":
        $oProfessor->setNumgUsuarioDesativacao($_SESSION["NUMG_OPERADOR"]);
        $oProfessor->setNumgProfessor($numgProfessor);
        $numgProfessor = $oProfessor->getNumgProfessor();
        $oProfessor->desativar();if (Erro::isError()) { MostraErros(); }
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadprofessores", "Desativação de Professor - Nome: " . $oProfessor->getDescNomePessoa(), "desativar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=3&numgProfessor=".$numgProfessor); }
    break;
    /**
     * Descrição: Ativação
     */
    case"ativar":
        $oProfessor->setNumgUsuarioAtivacao($_SESSION["NUMG_OPERADOR"]);
        $oProfessor->setNumgProfessor($numgProfessor);
        $numgProfessor = $oProfessor->getNumgProfessor();
        $oProfessor->ativar();if (Erro::isError()) { MostraErros(); }
        else {
            $oLog = new Log();
            $oLog->cadastrar(2, "cadprofessores", "Ativação de Professor - Nome: " . $oProfessor->getDescNomePessoa(), "ativar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=4&numgProfessor=".$numgProfessor); }
    break;    
    default:header("Location: $sCaminho");break;
}
$oProfessor->free;