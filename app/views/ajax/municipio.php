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
include_once("../../models/geral/Municipio.php");
$funcao = $_POST[funcao];
$siglUf = $_POST[sigl_uf];
switch ($funcao) {
    case "consultarPorUf":
       if ($siglUf != "") {
            $oMunicipio = new Municipio();
            $oResult = new Resultset();
            $oResult = $oMunicipio->consultarPorUf($siglUf);
            echo json_encode($oResult);
        }else{
            echo "";
        }
    break;
    default: echo "";break;
}