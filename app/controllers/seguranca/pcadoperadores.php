<?php
session_start();
/**
 * Descrição: controller Cadastro de Operadores.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Operador.php");
require_once("../../models/seguranca/Grupo.php");
require_once("../../models/seguranca/Log.php");
/**
 * Descrição: valida se a seção está ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == ""){
    header("Location: ../../views/expirou.htm");
    exit;
}
/**
 * Descrição: parametros.
 */
$numgOperador = $_POST[txtNumgOperador];
$numgOperadorCad = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/seguranca/cadoperadores.php";
/**
 * Descrição: testes.
 */
switch ($_POST[txtFuncao]){
    /**
     * Descrição: Cadastrando.
     */
    case "cadastrar":
        $oOperador = new Operador;
        $oOperador->setNomeOperador($_POST[txtNomeOperador]);
        $oOperador->setNomeCompleto($_POST[txtNomeCompleto]);
        $oOperador->setDescSenha($_POST[txtDescSenha]);
        $oOperador->setDescEmail($_POST[txtDescEmail]);
        $oOperador->setNumgOperadorCad($numgOperadorCad);
        $oOperador->cadastrar();if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(1, "cadoperadores", "Cadastro de Operador - Nome: " . $oOperador->getNomeOperador(), "cadastrar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=1&numgOperador=" . $oOperador->getNumgOperador()); }
    break;
    /**
     * Descrição: Editando.
     */
    case "editar":
        $oOperador = new Operador;
        $oOperador->setNumgOperador($numgOperador);
        $oOperador->setNomeOperador($_POST[txtNomeOperador]);
        $oOperador->setNomeCompleto($_POST[txtNomeCompleto]);
        $oOperador->setDescSenha($_POST[txtDescSenha]);
        $oOperador->setDescEmail($_POST[txtDescEmail]);
        $oOperador->setNumgOperadorAlt($numgOperadorCad);
        $oOperador->editar();if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(1, "cadoperadores", "Edição de Operador - Nome: " . $oOperador->getNomeOperador(), "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=2&numgOperador=" . $oOperador->getNumgOperador());}
    break;
    /**
     * Descrição: Excluindo.
     */
    case "excluir":
        $oOperador = new Operador;
        $oOperador->excluir($numgOperador);if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(1, "cadoperadores", "Exclusão de Operador - Nome: " . $_POST[txtNomeOperador], "excluir", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=3"); }
    break;
    /**
     * Descrição: Bloqueando.
     */
    case "bloquear":
        $oOperador = new Operador;
        $oOperador->bloquear(array($numgOperador, $numgOperadorCad));if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(1, "cadoperadores", "Bloqueamento de Operador - Nome: " . $_POST[txtNomeOperador], "bloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=4&numgOperador=" . $numgOperador); }
    break;
    /**
     * Descrição: Desbloqueando.
     */
    case "desbloquear":
        $oOperador = new Operador;
        $oOperador->desbloquear($numgOperador);if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(1, "cadoperadores", "Desbloqueamento de Operador - Nome: " . $_POST[txtNomeOperador], "desbloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=5&numgOperador=" . $numgOperador); }
    break;
    /**
     * Descrição: Cadastrando grupos operadores.
     */
    case "cadastrar_grupoope":
        $vGruposDisponiveis = $_POST[cboGruposDisponiveis];
        $oGrupos = new Grupo;
        for ($i = 0; $i < count($vGruposDisponiveis); $i++) {
            $oGrupos->cadastrarOperadorGrupo(array($numgOperador, $vGruposDisponiveis[$i]));
        }
        if (Erro::isError()){MostraErros();}
        else header("Location: $sCaminho?info=6&numgOperador=" . $numgOperador);
    break;
    /**
     * Descrição: Excluindo grupos operadores.
     */
    case "excluir_grupoope":
        $vGruposOperador = $_POST[cboGruposOperador];
        $oGrupos = new Grupo;
        for ($i = 0; $i < count($vGruposOperador); $i++) {
            $oGrupos->excluirOperadorGrupo(array($numgOperador, $vGruposOperador[$i]));
        }
        if (Erro::isError()){MostraErros();}
        else header("Location: $sCaminho?info=7&numgOperador=" . $numgOperador);
    break;
    /**
     * Descrição: Enviando senha para o operador.
     */
    case "enviar_senha":
        $oOperador = new Operador;
        $oOperador->enviarSenha($numgOperador);if (Erro::isError()) {MostraErros();}
        else header("Location: $sCaminho?info=8&numgOperador=" . $numgOperador);
    break;
    default:header("Location: $sCaminho");break;
}