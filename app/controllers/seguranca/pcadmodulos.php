<?php
session_start();
/**
 * Descrição: Controler Cadastro de modulos.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/seguranca/Modulo.php");
require_once("../../models/seguranca/Grupo.php");
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
$numgModulo = $_POST[txtnumgModulo];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sCaminho = "../../../app/views/seguranca/cadmodulos.php";
/**
 * Descrição: Objetos.
 */
$oModulo = new Modulo();
/**
 * Descrição: Parametros.
 */
$numgModulo = $_POST[numgModulo];
$codgModulo = $_POST[codgModulo];
$numrOrdem = $_POST[numrOrdem];
$descModulo = $_POST[descModulo];
$descNome = $_POST[descNome];
$numgOperadorCad = $_SESSION[NUMG_OPERADOR];
$vGruposDisponiveis = $_POST[cboGruposDisponiveis];
$vGruposOperador = $_POST[cboGruposCadastrados];
switch ($_POST[txtFuncao]){
    /**
     * Descrição: Cadastrando.
     */
    case "cadastrar":        
        $oModulo->setCodgModulo($codgModulo);
        $oModulo->setDescModulo($descModulo);
        $oModulo->setNumrOrdem($numrOrdem);
        $oModulo->setNumgOperadorCad($numgOperador);
        $oModulo->setDataCadastro("now()");
        $oModulo->setDescNome($descNome);
        $oModulo->cadastrar();
        $numgModulo = $oModulo->getNumgModulo();
        $oModulo->free;
        if (Erro::isError()){MostraErros();}
        else {header("Location: $sCaminho?info=1&numgModulo=".$numgModulo);}
    break;
    /**
     * Descrição: Editando o formulário.
     */
    case "editar":
        $oModulo->setNumgModulo($numgModulo);
        $oModulo->setCodgModulo($codgModulo);
        $oModulo->setDescModulo($descModulo);
        $oModulo->setNumrOrdem($numrOrdem);
        $oModulo->setDescNome($descNome);
        $oModulo->editar();
        $oModulo->free;
        if (Erro::isError()){MostraErros();}
        else {header("Location: $sCaminho?info=2&numgModulo=".$numgModulo);}
    break;
    /**
     * Descrição: Excluindo o formulário.
     */
    case "excluir":
        $oModulo->setNumgModulo($numgModulo);
        $oModulo->excluir($numgModulo);
        $oModulo->free;
        if(Erro::isError()){MostraErros();}
        else{header("Location: $sCaminho?info=3");}
    break;
    /**
     * Descrição: Bloqueando o formulário.
     */
    case "bloquear":
        $oModulo->bloquear(array("numgOperador"=>$numgOperador,"numgModulo"=>$numgModulo));
        $oModulo->free;
        if(Erro::isError()) {MostraErros();}
        else{header("Location: $sCaminho?info=4&numgModulo=".$numgModulo);}
    break;
    /**
     * Descrição: Desbloqueando o formulário.
     */
    case "desbloquear":
        $oModulo->desbloquear($numgModulo);
        $oModulo->free;
        if(Erro::isError()) {MostraErros();}
        else{header("Location: $sCaminho?info=5&numgModulo=".$numgModulo);}
    break;
    /**
     * Descrição: Cadastrando grupos.
     */
    case "cadastrar_grupomod":
        $oGrupo = new Grupo();
        for ($i = 0; $i < count($vGruposDisponiveis); $i++) {
            $oGrupo->cadastrarGrupoModulo(array($numgModulo, $vGruposDisponiveis[$i]));
        }
        $oGrupo->free;
        if (Erro::isError()){MostraErros();}
        else header("Location: $sCaminho?info=6&numgModulo=" . $numgModulo);
    break;
    /**
     * Descrição: Excluindo grupos.
     */
    case "excluir_grupomod":
        $oGrupo = new Grupo();
        for ($i = 0; $i < count($vGruposOperador); $i++) {
            $oGrupo->excluirGrupoModulo(array($numgModulo, $vGruposOperador[$i]));
        }
        $oGrupo->free;
        if (Erro::isError()){MostraErros();}
        else header("Location: $sCaminho?info=7&numgModulo=" . $numgModulo);
    break;
    default: header("Location: $sCaminho");break;
}