<?php
session_start();
/**
 * Descrição: Controler Cadastro de Modalidades.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Modalidade.php");
require_once("../../models/seguranca/Log.php");
/**
 * Descrição: valida se a seção está ativa.
 */
if (empty($_SESSION["NUMG_OPERADOR"]) || $_SESSION["NUMG_OPERADOR"] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}
/**
 * Descrição: parametros.
 */
$numgModalidade = $_POST["txtNumgModalidade"];
$numgOperador = $_SESSION["NUMG_OPERADOR"];
$sCaminho = "../../../app/views/musica/cadmodalidades.php";
/**
 * Descrição: Decidindo o caminho a se tomar.
 */
switch ($_POST["txtFuncao"]){
    /**
     * Descrição: Cadastrando a Modalidade
     */
    case "cadastrar":
        $oModalidade = new Modalidade;
        $oModalidade->setNomeModalidade($_POST[descModalidade]);
        $oModalidade->setValorModalidade($_POST[vlrModalidade]);
        $oModalidade->setNumgOperadorCad($numgOperador);
        $oModalidade->cadastrar();if (Erro::isError()){MostraErros();}
        else {
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Cadastro de Modalidade - Nome: " . $oModalidade->getNomeModalidade(), "cadastrar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=1&numgModalidade=".$oModalidade->getNumgModalidade());}
    break;
    /**
     * Descrição: Editando a Modalidade
     */    
    case "editar":
        $oModalidade = new Modalidade;
        $oModalidade->setNumgModalidade($numgModalidade);
        $oModalidade->setNomeModalidade($_POST[descModalidade]);
        $oModalidade->setValorModalidade($_POST[vlrModalidade]);
        $oModalidade->editar();if (Erro::isError()){MostraErros();}
        else {
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Edição de Modalidade - Nome: " . $oModalidade->getNomeModalidade(), "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=2&numgModalidade=".$numgModalidade);}
    break;
    /**
     * Descrição: Excluindo a Modalidade.
     */
    case "excluir":
        $oModalidade = new Modalidade;
        $oModalidade->excluir($numgModalidade);if(Erro::isError()){MostraErros();}
        else{
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Exclusão de Modalidade - Nome: " . $_POST[descModalidade], "excluir", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=3");}
    break;
    default: header("Location: $sCaminho");break;

        /**
     * Descrição: Bloqueando a Modalidade.
     */
    case "bloquear":
        $oModalidade = new Modalidade;
        $oModalidade->bloquear(array($numgModalidade, $numgOperador));if(Erro::isError()) {MostraErros();}
        else{
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Bloqueamento de Modalidade - Nome: " . $_POST[descModalidade], "bloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=4&numgModalidade=".$numgModalidade);}
    break;
    /**
     * Descrição: Desbloqueando a Modalidade.
     */
    case "desbloquear":
        $oModalidade = new Modalidade;
        $oModalidade->desbloquear($numgModalidade);if (Erro::isError()){MostraErros();}
        else{
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Desbloqueamento de Modalidade - Nome: " . $_POST[descModalidade], "desbloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=5&numgModalidade=".$numgModalidade);}
    break;
    default: header("Location: $sCaminho");break;
}