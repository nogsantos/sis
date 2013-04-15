<?
include_once('classes/Municipio.php');
include_once('funcoes.php');

/**
 * Descrição: controller pesquisa de municipios.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */

	$oMunicipio = new Municipio();

	if ($_GET["nome"] <> "" || $_GET["uf"] <> "") {
		$sNome = $_GET["nome"];
		$sUf = $_GET["uf"];
	} else {
		$sNome = $_POST["txtNomeMunicipio"];
		$sUf = $_POST["cboUf"];
	}
	
	$sCampoUf   = $_GET["campo_uf"];
	$sCampoNome = $_GET["campo_nome"];
	$sCampoNumg = $_GET["campo_numg"];

	
	if ($sNome != "" && $sUf != "") {
	
		$oResMunicipios = $oMunicipio->consultarPorNomeUf($sNome, $sUf);
		if(Erro::isError()) MostraErros();
		
	}		
?>

<HTML>
<HEAD>

<title>SIS - Pesquisa de Municípios</title>

<link rel="stylesheet" type="text/css" href="estilos.css">

<SCRIPT language=JavaScript src="funcoes.js"></SCRIPT>

</HEAD>
<BODY onLoad="window.focus();document.form.txtNomeMunicipio.focus()" onkeypress="FechaForm()" bgColor=white bottomMargin=0 leftMargin=0 topMargin=0 rightMargin=0>

<table border=0 width=100% align=center cellspacing=0 cellpadding=0>
	<tr>
		<td><img src="imagens/space.gif" border=0 height=5></td>
	</tr>
	<tr>
		<td align=center>
			<table border=0 width=420 cellspacing=0 cellpadding=0>
				<tr>
					<td><img src="imagens/formEsqSup.gif" border=0 width=10 height=10></td>
					<td background="imagens/formMidSup.gif"></td>
					<td><img src="imagens/formDirSup.gif" border=0 width=10 height=10></td>
				</tr>
				<tr valign=top>
					<td width=10 background="imagens/formEsqMid.gif"></td>
					<td>
						<table border=0 cellspacing=0 cellpadding=2 align=center width="100%" background="imagens/formMid.gif">
						<form method=post name=form action="pesqmunicipios.php?campo_uf=<?=$sCampoUf?>&campo_nome=<?=$sCampoNome?>&campo_numg=<?=$sCampoNumg?>" onSubmit="return ValidaPesquisa()">
							<tr>
								<td width=100% class="normal11b">Município:</td>
							</tr>
							<tr>
								<td>
									<table border=0 cellpadding=0 cellspacing=0>
										<tr>
											<td>
												<select class=borda name="cboUf">
													<OPTION VALUE="AC" <? if ($sUf == "AC") echo "selected" ?>>AC
													<OPTION VALUE="AL" <? if ($sUf == "AL") echo "selected" ?>>AL
													<OPTION VALUE="AP" <? if ($sUf == "AP") echo "selected" ?>>AP
													<OPTION VALUE="AM" <? if ($sUf == "AM") echo "selected" ?>>AM
													<OPTION VALUE="BA" <? if ($sUf == "BA") echo "selected" ?>>BA
													<OPTION VALUE="CE" <? if ($sUf == "CE") echo "selected" ?>>CE
													<OPTION VALUE="DF" <? if ($sUf == "DF") echo "selected" ?>>DF
													<OPTION VALUE="ES" <? if ($sUf == "ES") echo "selected" ?>>ES
													<OPTION VALUE="GO" <? if ($sUf == "GO" || $sUf == "") echo "selected" ?>>GO
													<OPTION VALUE="MA" <? if ($sUf == "MA") echo "selected" ?>>MA
													<OPTION VALUE="MT" <? if ($sUf == "MT") echo "selected" ?>>MT
													<OPTION VALUE="MS" <? if ($sUf == "MS") echo "selected" ?>>MS
													<OPTION VALUE="MG" <? if ($sUf == "MG") echo "selected" ?>>MG
													<OPTION VALUE="PA" <? if ($sUf == "PA") echo "selected" ?>>PA
													<OPTION VALUE="PB" <? if ($sUf == "PB") echo "selected" ?>>PB
													<OPTION VALUE="PR" <? if ($sUf == "PR") echo "selected" ?>>PR
													<OPTION VALUE="PE" <? if ($sUf == "PE") echo "selected" ?>>PE
													<OPTION VALUE="PI" <? if ($sUf == "PI") echo "selected" ?>>PI
													<OPTION VALUE="RJ" <? if ($sUf == "RJ") echo "selected" ?>>RJ
													<OPTION VALUE="RN" <? if ($sUf == "RN") echo "selected" ?>>RN
													<OPTION VALUE="RS" <? if ($sUf == "RS") echo "selected" ?>>RS
													<OPTION VALUE="RO" <? if ($sUf == "RO") echo "selected" ?>>RO
													<OPTION VALUE="RR" <? if ($sUf == "RR") echo "selected" ?>>RR
													<OPTION VALUE="SC" <? if ($sUf == "SC") echo "selected" ?>>SC
													<OPTION VALUE="SP" <? if ($sUf == "SP") echo "selected" ?>>SP
													<OPTION VALUE="SE" <? if ($sUf == "SE") echo "selected" ?>>SE
													<OPTION VALUE="TO" <? if ($sUf == "TO") echo "selected" ?>>TO
													</OPTION>
												</select>
											</td>
											<td><input type=text name=txtNomeMunicipio value="<?=$oMunicipio->getNomeMunicipio()?>" class=borda size=50 maxlength=50></td></TD>
											<td>&nbsp;<input type=image src='imagens/icones/pesquisar.gif' border=0 align=center id=image1 name=image1></td>
										</tr>
									</table>
								</td>
							</tr>
						</form>
						</table>
					</td>
					<td width=10 background="imagens/formDirMid.gif"></td>
				</tr>
				<tr>
					<td><img src="imagens/formEsqInf.gif" border=0 width=10 height=10></td>
					<td background="imagens/formMidInf.gif"></td>
					<td><img src="imagens/formDirInf.gif" border=0 width=10 height=10></td>
				</tr>
			</table>
		</td>
	</tr>

	<?
	if (isset($oResMunicipios)){
		if ($oResMunicipios->getCount() > 0) { ?>
	<tr>
		<td align=center>
			<table border=0 cellpadding=0 cellspacing=0 width=420>
				<tr>
					<td colspan=2 height=20 class=normal11>Resultado da pesquisa:</td>
				</tr>
				<tr height=20 class="normal11b">
					<td background="imagens/fundoBarraRelatorio.gif" width=74% align=left>Municipio</td>
					<td width=26% align="center" background="imagens/fundoBarraRelatorio.gif">UF</td>
				</tr>							
				<?php for ($i=0; $i<$oResMunicipios->getCount(); $i++) {?>
				<tr height=20 <?php if ($i % 2 == 1){ ?>bgcolor="#E8E8E8"<? } ?> class="normal11">
					<td align=left><a href="javascript:SetaValores('<?=$oResMunicipios->getValores($i, "sigl_uf")?>','<?=$oResMunicipios->getValores($i, "nome_municipio")?>','<?=$oResMunicipios->getValores($i, "numg_municipio")?>')" class=relatorio><?=$oResMunicipios->getValores($i, "nome_municipio")?></a></td>
					<td align="center"><?=$oResMunicipios->getValores($i, "sigl_uf")?></td>
				</tr>
				<? } ?>
				<tr height=20 <?php if ($i % 2 == 1){ ?>bgcolor="#E8E8E8"<? } ?>>
					<td colspan=2 class=normal11b align=right>TOTAL: <?=$oResMunicipios->getCount()?></td>
				</tr>
		  </table>
		</td>
	</tr>
	<? } else {?>
	<tr class=destaque>
		<td align=center colspan=2 height=30>Nenhum municipio encontrado para a pesquisa!</td>
	</tr>	
	<? }
	} ?>
	<tr>
		<td><img src="imagens/space.gif" border=0 height=5></td>
	</tr>

</TABLE>


<script language="JavaScript">
<!--

//==============================================
// FUNÇÃO PARA SETAR OS VALORES NO FORMULÁRIO DA 
// PÁGINA QUE FEZ A CHAMADA
//==============================================
function SetaValores(uf,nome,numg)
{
	top.opener.document.forms[0].<?=$sCampoUf?>.value = uf
	top.opener.document.forms[0].<?=$sCampoNome?>.value = nome
	top.opener.document.forms[0].<?=$sCampoNumg?>.value = numg
		
	window.self.close()
}

//========================================
// FUNÇÃO PARA VALIDAR O CAMPO DE PESQUISA
//========================================
function ValidaPesquisa()
{
	if (document.form.txtNomeMunicipio.value.length < 2){
		alert("Informe um nome de munic&iacute;pio com pelo menos 2 caracteres!")
		document.form.txtNomeMunicipio.focus()
		return false
	}
	
}

//-->
</script>

</body>
</html>