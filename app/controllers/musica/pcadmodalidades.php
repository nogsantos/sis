<?php
session_start();
/**
 * Descri��o: Controler Cadastro de Modalidades.
 * @author Rodolfo Bueno
 * @release Cria��o do arquivo.
 * Data 26/09/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Modalidade.php");
require_once("../../models/seguranca/Log.php");
/**
 * Descri��o: valida se a se��o est� ativa.
 */
if (empty($_SESSION["NUMG_OPERADOR"]) || $_SESSION["NUMG_OPERADOR"] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}
/**
 * Descri��o: parametros.
 */
$numgModalidade = $_POST["txtNumgModalidade"];
$numgOperador = $_SESSION["NUMG_OPERADOR"];
$sCaminho = "../../../app/views/musica/cadmodalidades.php";
/**
 * Descri��o: Decidindo o caminho a se tomar.
 */
switch ($_POST["txtFuncao"]){
    /**
     * Descri��o: Cadastrando a Modalidade
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
     * Descri��o: Editando a Modalidade
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
            $oLog->cadastrar(2, "cadmodalidades", "Edi��o de Modalidade - Nome: " . $oModalidade->getNomeModalidade(), "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=2&numgModalidade=".$numgModalidade);}
    break;
    /**
     * Descri��o: Excluindo a Modalidade.
     */
    case "excluir":
        $oModalidade = new Modalidade;
        $oModalidade->excluir($numgModalidade);if(Erro::isError()){MostraErros();}
        else{
            $oModalidade->free;
            $oLog = new Log();
            $oLog->cadastrar(2, "cadmodalidades", "Exclus�o de Modalidade - Nome: " . $_POST[descModalidade], "excluir", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            $oLog->free;
            header("Location: $sCaminho?info=3");}
    break;
    default: header("Location: $sCaminho");break;

        /**
     * Descri��o: Bloqueando a Modalidade.
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
     * Descri��o: Desbloqueando a Modalidade.
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