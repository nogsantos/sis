<?php
session_start();
/**
 * Descrição: Controller - Emissao de recibos.
 * @author Rodolfo Bueno
 * @release Criação do arquivo.
 * Data 18/10/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/financeiro/Recibo.php");
require_once("../../models/seguranca/Log.php");

/**
 * Descrição: valida se a seção está ativa.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == "") {
    header("Location: ../views/expirou.htm");
    exit;
}

$numgRecibo = $_POST['numgRecibo'];
$numrVias = $_POST['vias'];
$sCaminho = "../../../app/views/financeiro/relrecibos.php";
$tipo = $_POST['txtTipo'];

// Como são três formulários diferentes, um para cada tipo de recibo. Abaixo eu vejo qual é o formulário de origem.
$formPai = $_POST['codgForm'].".php";
$sCaminhoCad = "../../../app/views/financeiro/".$formPai;

switch ($_POST[txtFuncao]){
    /**
     * Descrição: Cadastrando e emitindo o recibo.
     */
    case "emitir":
        $oRecibo = new Recibo;
        $oRecibo->setDataEmissao($_POST['dataEmissao']);
        $oRecibo->setValrRecibo($_POST['valor']);
        $oRecibo->setDescReferente($_POST['referente']);
        $oRecibo->setDescObs($_POST['obs']);
        $oRecibo->setNumgOperadorCad($_SESSION[NUMG_OPERADOR]);
        $oRecibo->setDescTipo($_POST['txtTipo']);
        $oRecibo->setNumgReferente($_POST['numgRef']);

        if ($oRecibo->getDescTipo() == "P") { // Recibo de Professores
            if($_POST['numgProfessor']!="")
                $oRecibo->setNumgProfessor($_POST['numgProfessor']);
            else
                Erro::addErro ("Professor inválido ou inexistente!");
            if (Erro::isError()){MostraErros();}
        } else if ($oRecibo->getDescTipo() == "A") { // Recibo de Alunos
            if($_POST['numgAluno']!="")
                $oRecibo->setNumgAluno($_POST['numgAluno']);
            else
                Erro::addErro ("Aluno inválido ou inexistente!");
            if (Erro::isError()){MostraErros();}
        } else { // Recibo Avulso
            $oRecibo->setDescEmitente($_POST['descEmitente']);
            $oRecibo->setDescRecebido($_POST['descRecebido']);
            $oRecibo->setNumrCpfCnpjEmi($_POST['numrcpfcnpjEmi']);
            $oRecibo->setNumrCpfCnpjRec($_POST['numrcpfcnpjRec']);
        }

        $oRecibo->cadastrar();if (Erro::isError()){MostraErros();}
    else {
        $oLog = new Log();
        $oLog->cadastrar(4, "cadrecibos", "Emissão de Recibo - Núm: ".$oRecibo->getNumrRecibo(), "emitir", $_SESSION[NOME_COMPLETO]);
        if (Erro::isError()){MostraErros();}
        header("Location: $sCaminho?numgRecibo=".$oRecibo->getNumgRecibo()."&numrVias=".$numrVias."&tipo=".$oRecibo->getDescTipo());}
    break;

    /**
     * Descrição: Reemissão de recibo.
     */
    case "reemitir":
        $oRecibo = new Recibo;
        $oRecibo->setNumgOperadorRem($_SESSION["NUMG_OPERADOR"]);
        $oRecibo->setNumgRecibo($numgRecibo);
        $oRecibo->reemitir();if (Erro::isError()){MostraErros();}
        else {
            $oLog = new Log();
            $oLog->cadastrar(4, "cadrecibos", "Reemissão de Recibo - Núm: ".$oRecibo->getNumrRecibo(), "reemitir", $_SESSION[NOME_COMPLETO]);
            if (Erro::isError()){MostraErros();}
            header("Location: $sCaminho?numgRecibo=".$oRecibo->getNumgRecibo()."&numrVias=".$numrVias."&tipo=".$tipo);
        }
    break;

     /**
     * Descrição: Cancelamento de recibo.
     */
    case "cancelar":
        $oRecibo = new Recibo;
        $oRecibo->setNumgOperadorCanc($_SESSION["NUMG_OPERADOR"]);
        $oRecibo->setNumgRecibo($numgRecibo);
        $oRecibo->cancelar();if (Erro::isError()){MostraErros();}
      else {
        $oLog = new Log();
        $oLog->cadastrar(4, "cadrecibos", "Cancelamento de Recibo - Núm: ".$oRecibo->getNumrRecibo(), "cancelar", $_SESSION[NOME_COMPLETO]);
        if (Erro::isError()){MostraErros();}
        header("Location: $sCaminhoCad?numgRecibo=".$oRecibo->getNumgRecibo()."&descTipo=".$tipo);}
    break;

     /**
     * Descrição: Conulta de recibo (Relatório.).
     */
    case "consultar":
        $numrRecibo = $_POST['numrRecibo'];
        $tipo = $_POST['txtTipo'];
        header("Location: $sCaminhoCad?numrRecibo=".$numrRecibo."&descTipo=".$tipo);
    break;

    default: header("Location: $sCaminho");
    break;
}

