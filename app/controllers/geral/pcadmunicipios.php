<?php
/**
 * Descrição: controller cadastro de municipios.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
include_once "funcoes.php";
include_once "classes/Municipio.php";


	switch ($_POST["txtFuncao"]){
	
		case "cadastrar_municipio":

			$oMunicipio = new Municipio;
			
			$oMunicipio->setNumgMunicipio(0);
			$oMunicipio->setNomeMunicipio($_POST["txtNomeMunicipio"]);
			$oMunicipio->setSiglUf($_POST["cboUf"]);
			$oMunicipio->setFlagCapital($_POST["chkFlagCapital"]);
			
			$oMunicipio->cadastrar();
			
			if(Erro::isError()) {
				MostraErros();
			}
			
			$numgMunicipio = $oMunicipio->getNumgMunicipio();
			
			unset($oMunicipio);
			
			header("Location: cadmunicipios.php?info=1&numg_municipio=".$numgMunicipio); exit;
		break;
								
		case "editar_municipio":
			
			$oMunicipio = new Municipio();
			
			$oMunicipio->setNumgMunicipio($_POST["txtNumgMunicipio"]);
			$oMunicipio->setNomeMunicipio($_POST["txtNomeMunicipio"]);
			$oMunicipio->setSiglUf($_POST["cboUf"]);
			$oMunicipio->setFlagCapital($_POST["chkFlagCapital"]);
			
			$oMunicipio->editar();
			
			if(Erro::isError()) {
				MostraErros();
			}
						
			$numgMunicipio = $oMunicipio->getNumgMunicipio();

			unset($oMunicipio);
			
			header("Location: cadmunicipios.php?info=2&numg_municipio=".$_POST["txtNumgMunicipio"]); exit;
		break;

		case "excluir_municipio":

			$oMunicipio = new Municipio();
			
			$oMunicipio->excluir($_POST["txtNumgMunicipio"]);
			
			if(Erro::isError()) {
				MostraErros();
			}

			unset($oMunicipio);
			
			header("Location: cadmunicipios.php?info=3"); exit;
		break;
		
		case 'allMunicipiosEstado':
			$oMunicipio = new Municipio();
			$result = $oMunicipio->consultarPorNomeUf('', $_POST['estado']);
			echo '[';
			for($i=0; $i<$result->getCount(); $i++)
			{
				if($i != $result->getCount()-1)
				{
					echo '"' . ucwords(strtolower($result->getValores($i, 'numg_municipio'))) . '-' . ucwords(strtolower($result->getValores($i, 'nome_municipio'))) . '",';
				}
				else
				{
					echo '"' . ucwords(strtolower($result->getValores($i, 'numg_municipio'))) . '-' . ucwords(strtolower($result->getValores($i, 'nome_municipio'))) . '"';
				}
			}//end for($i=0; $i<$result->getCount(); $i++)
			echo ']';
		break;

		default:
			header("Location: cadmunicipios.php"); exit;
		break;									
	}

?>