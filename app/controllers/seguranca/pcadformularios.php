<?php
session_start();
/**
 * Descrição: Controler Cadastro de formulários.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 28/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Formulario.php");
/**
 * Descrição: valida se a seção está ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}
/**
 * Descrição: parametros.
 */
$numgFormulario = $_POST[txtNumgFormulario];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/seguranca/cadformularios.php";
/**
 * Descrição: testes.
 */
switch ($_POST[txtFuncao]){
    /**
     * Descrição: Cadastrando o formulário.
     */
    case "cadastrar":
        $oFormulario = new Formulario;
        $oFormulario->setCodgFormulario($_POST[txtCodgFormulario]);
        $oFormulario->setNomeFormulario($_POST[txtNomeFormulario]);
        $oFormulario->setNomeCompleto($_POST[txtNomeCompleto]);
        $oFormulario->setDescFormulario($_POST[txtDescFormulario]);
        $oFormulario->setNumgModulo($_POST[numgModulo]);
        if ($_POST[chkFlagOculto]) {
            $oFormulario->setFlagOculto("t");
        } else {
            $oFormulario->setFlagOculto("f");
        }
        $oFormulario->setNumrOrdem($_POST[txtNumrOrdem]);
        $oFormulario->setNumgOperadorCad($numgOperador);
        $oFormulario->cadastrar();if (Erro::isError()){MostraErros();}
        else {header("Location: $sCaminho?info=1&numgFormulario=".$oFormulario->getNumgFormulario());}
    break;
    /**
     * Descrição: Editando o formulário.
     */    
    case "editar":
        $oFormulario = new Formulario;
        $oFormulario->setNumgFormulario($numgFormulario);
        $oFormulario->setCodgFormulario($_POST[txtCodgFormulario]);
        $oFormulario->setNomeFormulario($_POST[txtNomeFormulario]);
        $oFormulario->setNomeCompleto($_POST[txtNomeCompleto]);
        $oFormulario->setDescFormulario($_POST[txtDescFormulario]);
        $oFormulario->setNumgModulo($_POST[numgModulo]);
        if ($_POST[chkFlagOculto]) {
            $oFormulario->setFlagOculto("t");
        } else {
            $oFormulario->setFlagOculto("f");
        }
        $oFormulario->setNumrOrdem($_POST[txtNumrOrdem]);
        $oFormulario->editar();if (Erro::isError()){MostraErros();}
        else {header("Location: $sCaminho?info=2&numgFormulario=".$numgFormulario);}
    break;
    /**
     * Descrição: Excluindo o formulário.
     */
    case "excluir":
        $oFormulario = new Formulario;
        $oFormulario->excluir($numgFormulario);if(Erro::isError()){MostraErros();}
        else{header("Location: $sCaminho?info=3");}
    break;
    /**
     * Descrição: Bloqueando o formulário.
     */
    case "bloquear":
        $oFormulario = new Formulario;
        $oFormulario->bloquear(array($numgFormulario, $numgOperador));if(Erro::isError()) {MostraErros();}
        else{header("Location: $sCaminho?info=4&numgFormulario=".$numgFormulario);}
    break;
    /**
     * Descrição: Desbloqueando o formulário.
     */
    case "desbloquear":
        $oFormulario = new Formulario;
        $oFormulario->desbloquear($numgFormulario);if (Erro::isError()){MostraErros();}
        else{header("Location: $sCaminho?info=5&numgFormulario=".$numgFormulario);}
    break;
    default: header("Location: $sCaminho");break;
}