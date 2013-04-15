<?php
/**
 * Descrição: Consulta municipios via ajax.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
include_once("../../funcoes.php");
include_once("../../models/Erro.php");
include_once("../../Oad.php");
include_once("../../Resultset.php");
include_once("../../models/musica/ProfessorModalidade.php");
$funcao = $_POST[funcao];
$numgMod = $_POST[numgMod];
$numgProf = $_POST[numgProf];

switch ($funcao) {
    case "consultarProfessoresPorMod":
       if ($numgMod != "") {
            $oProfessorModalidade = new ProfessorModalidade();
            $oResult = new Resultset();
            $oResult = $oProfessorModalidade->consultarProfessoresPorModalidades($numgMod);
            echo json_encode($oResult);
        }else{
            echo "";
        }
    break;

   case "consultarhorariosProf":
       if ($numgProf != "") {
            $oProfessorModalidade = new ProfessorModalidade();
            $oResult = new Resultset();
            $oResult = $oProfessorModalidade->consultaHorariosModalidadesProfessores($numgProf, null, $numgMod);
            echo json_encode($oResult);
        }else{
            echo "";
        }
    break;
    default: echo "";break;
}