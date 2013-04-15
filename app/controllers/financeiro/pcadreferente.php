<?php
session_start();
/**
 * Descri��o: Controler Cadastro de Referentes.
 * @author Rodolfo Bueno
 * @release Cria��o do arquivo.
 * Data 24/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/financeiro/Referente.php");
require_once("../../models/seguranca/Log.php");
/**
 * Descri��o: valida se a se��o est� ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}
/**
 * Descri��o: parametros.
 */
$numgReferente = $_POST[txtNumgReferente];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/financeiro/cadreferente.php";
/**
 * Descri��o: Decidindo o caminho a se tomar.
 */
switch ($_POST[txtFuncao]){
    /**
     * Descri��o: Cadastrando a Referente
     */
    case "cadastrar":
        $oReferente = new Referente;
        $oReferente->setDescCodigo($_POST[descCodigo]);
        $oReferente->setDescReferente($_POST[descReferente]);
        $oReferente->setNumgOperadorCad($numgOperador);
        $oReferente->cadastrar();if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(4, "cadreferente", "Cadastro de Refer�ncia - Nome: " . $_POST[descReferente], "cadastrar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=1&numgReferente=".$oReferente->getNumgReferente());}
    break;
    /**
     * Descri��o: Editando a Referente
     */    
    case "editar":
        $oReferente = new Referente;
        $oReferente->setNumgReferente($numgReferente);
        $oReferente->setDescCodigo($_POST[descCodigo]);
        $oReferente->setDescReferente($_POST[descReferente]);
        $oReferente->editar();if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(4, "cadreferente", "Edi��o de Refer�ncia - Nome: " . $_POST[descReferente], "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=2&numgReferente=".$numgReferente);}
    break;
    /**
     * Descri��o: Excluindo a Referente.
     */
    case "excluir":
        $oReferente = new Referente;
        $oReferente->excluir($numgReferente);if(Erro::isError()){MostraErros();}
        else{
            $oLog = new Log();
            $oLog->cadastrar(4, "cadreferente", "Exclus�o de Refer�ncia - Nome: " . $_POST[descReferente], "exclusao", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=3");}
    break;
    default: header("Location: $sCaminho");break;

        /**
     * Descri��o: Bloqueando a Referente.
     */
    case "bloquear":
        $oReferente = new Referente;
        $oReferente->bloquear(array($numgReferente, $numgOperador));if(Erro::isError()) {MostraErros();}
        else{
            $oLog = new Log();
            $oLog->cadastrar(4, "cadreferente", "Bloqueamento de Refer�ncia - Nome: " . $_POST[descReferente], "bloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=4&numgReferente=".$numgReferente);}
    break;
    /**
     * Descri��o: Desbloqueando a Referente.
     */
    case "desbloquear":
        $oReferente = new Referente;
        $oReferente->desbloquear($numgReferente);if (Erro::isError()){MostraErros();}
        else{
            $oLog = new Log();
            $oLog->cadastrar(4, "cadreferente", "Desbloquemento de Refer�ncia - Nome: " . $_POST[descReferente], "desbloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=5&numgReferente=".$numgReferente);}
    break;
    default: header("Location: $sCaminho");break;
}