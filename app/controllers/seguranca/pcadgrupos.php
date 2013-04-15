<?php
session_start();
/**
 * Descri��o: controller Cadastro de grupos de usu�rios.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Grupo.php");
require_once("../../models/seguranca/Log.php");
/**
 * Descri��o: valida se a se��o est� ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == ""){
    header("Location: ../../views/expirou.htm");
    exit;
}
/**
 * Descri��o: parametros.
 */
$numgGrupo = $_POST[txtNumgGrupo];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/seguranca/cadgrupos.php";
/**
 * Descri��o: testes.
 */
switch ($_POST[txtFuncao]) {
    /**
     * Descri��o: Cadastrando.
     */
    case "cadastrar":
        $oGrupo = new Grupo;
        $oGrupo->setNomeGrupo($_POST[txtNomeGrupo]);
        $oGrupo->setDescGrupo($_POST[txtDescGrupo]);
        $oGrupo->setNumgOperadorCad($numgOperador);
        $oGrupo->cadastrar();
        $numgGrupo = $oGrupo->getNumgGrupo();
        if (Erro::isError()) {MostraErros();}
        else{
            $oGrupo->free;
            $oLog = new Log();
            $oLog->cadastrar(1, "cadgrupos", "Cadastro de Grupo - Nome: " . $_POST[txtNomeGrupo], "cadastrar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=1&numgGrupo=" . $numgGrupo);
        }
    break;
    /**
     * Descri��o: Editando.
     */
    case "editar":
        $oGrupo = new Grupo;
        $oGrupo->setNumgGrupo($numgGrupo);
        $oGrupo->setNomeGrupo($_POST[txtNomeGrupo]);
        $oGrupo->setDescGrupo($_POST[txtDescGrupo]);
        $oGrupo->editar();if (Erro::isError()){MostraErros();}
        else{
            $oGrupo->free;
            $oLog = new Log();
            $oLog->cadastrar(1, "cadgrupos", "Edi��o de Grupo - Nome: " . $_POST[txtNomeGrupo], "editar", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=2&numgGrupo=" . $numgGrupo);
        }
    break;
    /**
     * Descri��o: Excluindo.
     */
    case "excluir":
        $oGrupo = new Grupo;
        $oGrupo->excluir($numgGrupo);if (Erro::isError()) {MostraErros();}
        else{
            $oGrupo->free;
            $oLog = new Log();
            $oLog->cadastrar(1, "cadgrupos", "Exclus�o de Grupo - Nome: " . $_POST[txtNomeGrupo], "excluir", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=3");
        }
    break;
    /**
     * Descri��o: Bloqueando grupos.
     */
    case "bloquear":
        $oGrupo = new Grupo;
        $oGrupo->bloquear(array($numgGrupo, $numgOperador));if (Erro::isError()) {MostraErros();}
        else{
            $oGrupo->free;
            $oLog = new Log();
            $oLog->cadastrar(1, "cadgrupos", "Bloqueamento de Grupo - Nome: " . $_POST[txtNomeGrupo], "bloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=4&numgGrupo=" . $numgGrupo);
        }
    break;
    /**
     * Descri��o: Desbloqueando grupos.
     */
    case "desbloquear":
        $oGrupo = new Grupo;
        $oGrupo->desbloquear($numgGrupo);if (Erro::isError()) {MostraErros();}
        else{
            $oGrupo->free;
            $oLog = new Log();
            $oLog->cadastrar(1, "cadgrupos", "Desbloqueamento de Grupo - Nome: " . $_POST[txtNomeGrupo], "bloquear", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?info=5&numgGrupo=" . $numgGrupo);
        }
    break;
    default: header("Location: $sCaminho");break;
}