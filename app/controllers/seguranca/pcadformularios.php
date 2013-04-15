<?php
session_start();
/**
 * Descri��o: Controler Cadastro de formul�rios.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 28/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Formulario.php");
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
$numgFormulario = $_POST[txtNumgFormulario];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/seguranca/cadformularios.php";
/**
 * Descri��o: testes.
 */
switch ($_POST[txtFuncao]){
    /**
     * Descri��o: Cadastrando o formul�rio.
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
     * Descri��o: Editando o formul�rio.
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
     * Descri��o: Excluindo o formul�rio.
     */
    case "excluir":
        $oFormulario = new Formulario;
        $oFormulario->excluir($numgFormulario);if(Erro::isError()){MostraErros();}
        else{header("Location: $sCaminho?info=3");}
    break;
    /**
     * Descri��o: Bloqueando o formul�rio.
     */
    case "bloquear":
        $oFormulario = new Formulario;
        $oFormulario->bloquear(array($numgFormulario, $numgOperador));if(Erro::isError()) {MostraErros();}
        else{header("Location: $sCaminho?info=4&numgFormulario=".$numgFormulario);}
    break;
    /**
     * Descri��o: Desbloqueando o formul�rio.
     */
    case "desbloquear":
        $oFormulario = new Formulario;
        $oFormulario->desbloquear($numgFormulario);if (Erro::isError()){MostraErros();}
        else{header("Location: $sCaminho?info=5&numgFormulario=".$numgFormulario);}
    break;
    default: header("Location: $sCaminho");break;
}