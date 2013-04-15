<?php
header("Cache-control: private");
include_once "funcoes.php";
include_once "classes/Municipio.php";
/**
 * Empresa: Interagi Tecnologia
 * Descrição:
 * Releases (Data, responsável e descrição [Último release primeiro]):
 *	 10/03/2008 (Rafael Cícero)
 *		 Incluído este cabeçalho descrevendo a funcionalidade da página
 */

$CODG_FORMULARIO = "cadmunicipios";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO,$_SESSION["NUMG_OPERADOR"]);

//BUSCA MUNICIPIO ESPECÍFICO
$oMunicipio = new Municipio;

if ($_GET["numg_municipio"] != "") {

    $oMunicipio->setarDadosMunicipio($_GET["numg_municipio"]);
    if(Erro::isError()) MostraErros();

    $oResMunicipio = $oMunicipio->consultarPorUf($oMunicipio->getSiglUf());
    if(Erro::isError()) MostraErros();

}	

if ($_GET["sigl_uf"] != "") {

    //BUSCA OS MUNICIPIOS CADASTRADOS
    $oResMunicipio = $oMunicipio->consultarPorUf($_GET["sigl_uf"]);
    if(Erro::isError()) MostraErros();
}
?>
<html>
    <head>
        <title>TISS - Cadastro de Municipios</title>
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <SCRIPT language=JavaScript src="javascripts/funcoes.js"></SCRIPT>
        <SCRIPT language="JavaScript">
            function iniForm()
            {
                montaFuncoes('<?=$CODG_FORMULARIO?>','<?=$NOME_FORMULARIO?>','<?=$oMunicipio->getNumgMunicipio()?>');
                document.form.cboUf.focus()
            }
        </script>
    </head>
    <body onLoad="iniForm()" rightmargin="0" marginwidth="0" marginheight="0" leftmargin="0" bottommargin="0" topmargin="0" bgcolor="#FFFFFF">
        <table border=0 width=100% align=center cellspacing=0 cellpadding=0>
            <tr>
                <td><img src="imagens/space.gif" border=0 height=10></td>
            </tr>
            <tr>
                <td align=center>
                    <table border=0 width=600 cellspacing=0 cellpadding=0>
                        <tr>
                            <td><img src="imagens/formEsqSup.gif" border=0 width=10 height=10></td>
                            <td background="imagens/formMidSup.gif"></td>
                            <td><img src="imagens/formDirSup.gif" border=0 width=10 height=10></td>
                        </tr>
                        <tr valign=top>
                            <td width=10 background="imagens/formEsqMid.gif"></td>
                            <td>
                                <table border=0 width=100% cellspacing=0 cellpadding=2 align=center background="imagens/formMid.gif">
                                    <form method="post" action="pcadmunicipios.php" name="form">
                                        <input type=hidden name=txtFuncao value="">
                                        <input type=hidden name=txtNumgMunicipio value="<?php echo $oMunicipio->getNumgMunicipio(); ?>">
                                        <!-- INÍCIO CAMPOS DO FORMULÁRIO  -->
                                        <?php if ($_GET["info"] != "") {?>
                                        <tr>
                                            <td colspan=3 align=center height=20 valign=middle class=normal11>
                                                <img src="imagens/icones/info.gif" border=0 align=absbottom>&nbsp;&nbsp;
                                                    <?php
                                                    switch ($_GET["info"]) {
                                                        case 1:
                                                            echo "Cadastro de municipio realizado com sucesso";
                                                            break;
                                                        case 2:
                                                            echo "Edição de dados realizada com sucesso";
                                                            break;
                                                        case 3:
                                                            echo "Exclusão de municipio realizada com sucesso";
                                                            break;
                                                    }  ?>
                                            </td>
                                        </tr>
                                            <?php } ?>
                                        <tr>
                                            <td width="20%" align=right class=normal11b>UF:</td>
                                            <TD width="30%">
                                                <select class=borda name="cboUf" style="width:150" onChange="window.location.href='cadmunicipios.php?sigl_uf=' + document.form.cboUf.value" class="normal11">
                                                    <option value="">
                                                    <OPTION VALUE="AC"<? if ($oMunicipio->getSiglUf() == "AC" || $_GET["sigl_uf"] == "AC" ) {
    echo "selected";
}?>>Acre
                                                    <OPTION VALUE="AL"<? if ($oMunicipio->getSiglUf() == "AL" || $_GET["sigl_uf"] == "AL" ) {
    echo "selected";
}?>>Alagoas
                                                    <OPTION VALUE="AP"<? if ($oMunicipio->getSiglUf() == "AP" || $_GET["sigl_uf"] == "AP" ) {
    echo "selected";
}?>>Amapá
                                                    <OPTION VALUE="AM"<? if ($oMunicipio->getSiglUf() == "AM" || $_GET["sigl_uf"] == "AM" ) {
    echo "selected";
}?>>Amazonas
                                                    <OPTION VALUE="BA"<? if ($oMunicipio->getSiglUf() == "BA" || $_GET["sigl_uf"] == "BA" ) {
    echo "selected";
}?>>Bahia
                                                    <OPTION VALUE="CE"<? if ($oMunicipio->getSiglUf() == "CE" || $_GET["sigl_uf"] == "CE" ) {
    echo "selected";
}?>>Ceará
                                                    <OPTION VALUE="DF"<? if ($oMunicipio->getSiglUf() == "DF" || $_GET["sigl_uf"] == "DF" ) {
    echo "selected";
}?>>Distrito Federal
                                                    <OPTION VALUE="ES"<? if ($oMunicipio->getSiglUf() == "ES" || $_GET["sigl_uf"] == "ES" ) {
    echo "selected";
}?>>Espírito Santo
                                                    <OPTION VALUE="GO"<? if ($oMunicipio->getSiglUf() == "GO" || $_GET["sigl_uf"] == "GO" ) {
    echo "selected";
}?>>Goiás
                                                    <OPTION VALUE="MA"<? if ($oMunicipio->getSiglUf() == "MA" || $_GET["sigl_uf"] == "MA" ) {
    echo "selected";
}?>>Maranhão
                                                    <OPTION VALUE="MT"<? if ($oMunicipio->getSiglUf() == "MT" || $_GET["sigl_uf"] == "MT" ) {
    echo "selected";
}?>>Mato Grosso
                                                    <OPTION VALUE="MS"<? if ($oMunicipio->getSiglUf() == "MS" || $_GET["sigl_uf"] == "MS" ) {
    echo "selected";
}?>>Mato Grosso do Sul
                                                    <OPTION VALUE="MG"<? if ($oMunicipio->getSiglUf() == "MG" || $_GET["sigl_uf"] == "MG" ) {
    echo "selected";
}?>>Minas Gerais
                                                    <OPTION VALUE="PA"<? if ($oMunicipio->getSiglUf() == "PA" || $_GET["sigl_uf"] == "PA" ) {
    echo "selected";
}?>>Pará
                                                    <OPTION VALUE="PB"<? if ($oMunicipio->getSiglUf() == "PB" || $_GET["sigl_uf"] == "PB" ) {
    echo "selected";
}?>>Paraíba
                                                    <OPTION VALUE="PR"<? if ($oMunicipio->getSiglUf() == "PR" || $_GET["sigl_uf"] == "PR" ) {
    echo "selected";
}?>>Paraná
                                                    <OPTION VALUE="PE"<? if ($oMunicipio->getSiglUf() == "PE" || $_GET["sigl_uf"] == "PE" ) {
    echo "selected";
}?>>Pernambuco
                                                    <OPTION VALUE="PI"<? if ($oMunicipio->getSiglUf() == "PI" || $_GET["sigl_uf"] == "PI" ) {
    echo "selected";
}?>>Piauí
                                                    <OPTION VALUE="RJ"<? if ($oMunicipio->getSiglUf() == "RJ" || $_GET["sigl_uf"] == "RJ" ) {
    echo "selected";
}?>>Rio de Janeiro
                                                    <OPTION VALUE="RN"<? if ($oMunicipio->getSiglUf() == "RN" || $_GET["sigl_uf"] == "RN" ) {
                echo "selected";
            }?>>Rio Grande do Norte
                                                    <OPTION VALUE="RS"<? if ($oMunicipio->getSiglUf() == "RS" || $_GET["sigl_uf"] == "RS" ) {
    echo "selected";
}?>>Rio Grande do Sul
                                                    <OPTION VALUE="RO"<? if ($oMunicipio->getSiglUf() == "RO" || $_GET["sigl_uf"] == "RO" ) {
    echo "selected";
}?>>Rondônia
                                                    <OPTION VALUE="RR"<? if ($oMunicipio->getSiglUf() == "RR" || $_GET["sigl_uf"] == "RR" ) {
    echo "selected";
}?>>Roraima
                                                    <OPTION VALUE="SC"<? if ($oMunicipio->getSiglUf() == "SC" || $_GET["sigl_uf"] == "SC" ) {
                            echo "selected";
}?>>Santa Catarina
                                                    <OPTION VALUE="SP"<? if ($oMunicipio->getSiglUf() == "SP" || $_GET["sigl_uf"] == "SP" ) {
    echo "selected";
                        }?>>São Paulo
                                                    <OPTION VALUE="SE"<? if ($oMunicipio->getSiglUf() == "SE" || $_GET["sigl_uf"] == "SE" ) {
    echo "selected";
}?>>Sergipe
                                                    <OPTION VALUE="TO"<? if ($oMunicipio->getSiglUf() == "TO" || $_GET["sigl_uf"] == "TO" ) {
    echo "selected";
}?>>Tocantins
                                                    </OPTION>
                                                </select>
                                            </TD>
                                            <TD width=50%>
                                                <table border=0 width=263 cellspacing=0 cellpadding=0>
                                                    <tr>
                                                        <td align=right class=normal11>Capital do Estado <input type=checkbox name=chkFlagCapital value=1 <? if ($oMunicipio->getFlagCapital() == 't') echo "checked" ?>></td>
                                                    </tr>
                                                </table>
                                            </TD>
                                        </tr>
                                        <tr>
                                            <td align=right class=normal11b>Municipio:</td>
                                            <TD colspan="2"><INPUT type="text" name="txtNomeMunicipio" value='<?php echo $oMunicipio->getNomeMunicipio(); ?>' size=70 maxlength=50 class=borda onKeyPress="SetFocus(document.form.txtNomeMunicipio)"></TD>
                                        </tr>
                                        <!-- FIM CAMPOS DO FORMULÁRIO  -->

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
            <?if(isset($oResMunicipio)){
                if ($oResMunicipio->getCount()>0){?>
            <tr>
                <td>
                    <table border=0 width=500 cellspacing=0 cellpadding=0 align=center>
                        <tr>
                            <td colspan=4 class=normal11 height=25 valign=bottom>Relação de Municipios cadastrados para a UF:</td>
                        </tr>
                        <tr height=20 class=normal11b align=center>
                            <td colspan="2" background="imagens/fundoBarraRelatorio.gif">&nbsp;Municipio</td>
                        </tr>
                        <?for($i=0; $i<$oResMunicipio->getCount(); $i++){
                            $bgColor = ($i % 2 == 1) ? '#E8E8E8' : '#FFFFFF';?>
                        <tr height=20 <?if ($i % 2 == 1) { ?>bgcolor="#E8E8E8"<?}?> class=relatorio  onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'">
                            <td colspan="2"><a href="cadmunicipios.php?numg_municipio=<?=$oResMunicipio->getValores($i,'numg_municipio') ?>" <? if ($oResMunicipio->getValores($i,'flag_capital') == "t") echo "class=destaque"; else echo "class=relatorio"; ?>>&nbsp;<?php echo $oResMunicipio->getValores($i,'nome_municipio') ?></a></td>
                        </tr>
                        <?}?>
                        <tr height=20 <?if($i%2==1){?>bgcolor="#E8E8E8"<?}?>>
                            <td width="80%" class=destaque>* Clique no nome do município para editá-lo</td>
                            <td width="20%" align="right" class="normal11b">TOTAL: <?=$oResMunicipio->getCount(); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php }
}
?>
            <tr>
                <td><img src="imagens/space.gif" border=0 height=10></td>
            </tr>
        </table>

        <script language="JavaScript">
            function novo_municipio(){
                window.location.href = '<?php echo $CODG_FORMULARIO ?>.php?sigl_uf=' + document.form.cboUf.value
            }

            function cadastrar_municipio(){
                if (document.form.txtNumgMunicipio.value == ""){
                    if (pValidaGravacao()){
                        if (confirm("Confirma o CADASTRO dos dados do Municipio?")){
                            document.form.txtFuncao.value = "cadastrar_municipio"
                            document.form.submit()
                        }
                    }
                }else{
                    alert("Função de CADASTRO não disponível para este formulário!")
                }

            }

            function editar_municipio(){
                if (document.form.txtNumgMunicipio.value != ""){
                    if (pValidaGravacao()){
                        if (confirm("Confirma a EDIÇÃO dos dados do Municipio?")){
                            document.form.txtFuncao.value = "editar_municipio"
                            document.form.submit()
                        }
                    }
                }else{
                    alert("Função de EDIÇÃO não disponível para este formulário!")
                }

            }

            function excluir_municipio(){
                if (document.form.txtNumgMunicipio.value != ""){
                    if (confirm("Confirma a EXCLUSÃO dos dados do Municipio?")){
                        document.form.txtFuncao.value = "excluir_municipio"
                        document.form.submit()
                    }
                }else{
                    alert("Função de EXCLUSÃO não disponível para este formulário!")
                }
            }

            function pValidaGravacao(){

                var sErr = ""

                //...

                //VERIFICA SE FOI ENCONTRADO ALGUM ERRO NA VALIDAÇÃO DO FORMULÁRIO
                if (sErr != ""){
                    sErr = "Verifique os erros encontrados abaixo:\n\n" + sErr
                    alert(sErr)
                    return false
                }else
                    return true
            }

        </script>

<?php unset($oMunicipio); ?>

    </body>

    <head>
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
    </head>

</html>