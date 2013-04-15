<?php
include_once "funcoes.php";
include_once "classes/Operador.php";
/**
 * Descrição: control relatorio de operadores.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
$CODG_FORMULARIO = "preloperadores";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO,$_SESSION["NUMG_OPERADOR"]);
$sTitulo = "RELATÓRIO DE OPERADORES";
switch ($_POST["rdoOpcao"]) {
    case 1:
        $oOperadores = new Operador;
        $vDados = $oOperadores->consultarOperadores(array($_POST["txtNomeOperador"],$_POST["txtDataNascimentoInicial"],$_POST["txtDataNascimentoFinal"],$_POST["txtDataCadastroInicial"],$_POST["txtDataCadastroFinal"]));
        if (Erro::isError()) MostraErros();
        if ($vDados->getCount() > 0) {
            $vLabels = array("Nome","E-mail","Data Cadastro");
            $vFormat = array("40E0","35C0","25C3");
            $vPosicao = array(1,2,3);
        }
        break;
    case 2:
        $oOperadores = new Operador;

        $vDados = $oOperadores->consultarBloqueados();
        if (Erro::isError()) MostraErros();

        if ($vDados->getCount() > 0) {
            $vLabels = array("Nome","E-mail","Data Cadastro");
            $vFormat = array("40E0","35C0","25C3");
            $vPosicao = array(1,2,3);
        }

        break;

    case 3:
        $oOperadores = new Operador;
        $vDados = $oOperadores->consultarNaoBloqueados();
        if (Erro::isError()) MostraErros();

        if ($vDados->getCount() > 0) {
            $vLabels = array("Nome","E-mail","Data Cadastro");
            $vFormat = array("40E0","35C0","25C3");
            $vPosicao = array(1,2,3);
        }
        break;
    case 4:
        $oOperadores = new Operador;
        $vDados = $oOperadores->consultarOperadores(array());
        if (Erro::isError()) MostraErros();
        if ($vDados->getCount() > 0) {
            $vLabels = array("Nome","E-mail","Data Cadastro");
            $vFormat = array("40E0","35C0","25C3");
            $vPosicao = array(1,2,3);
        }
        break;
    default:
        header("reloperadores.php");
        exit;
}
?>
<html>
    <head>
        <title>TISS - Relatório de Operadores</title>
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <SCRIPT language=JavaScript src="javascripts/funcoes.js"></SCRIPT>
        <script language="JavaScript">
            function iniForm(){
                montaFuncoes('<?=$CODG_FORMULARIO?>','<?=$NOME_FORMULARIO?>','1')
            }
        </script>
    </head>
    <body onLoad="iniForm()" rightmargin="0" marginwidth="0" marginheight="0" leftmargin="0" bottommargin="0" topmargin="0">
        <TABLE border=0 width="650" align=center cellspacing=0 cellpadding=0>
            <tr>
                <td colspan=2 class=normal11b height=40 align=center><?=$sTitulo?></td>
            </tr>
            <?if($vDados->getCount() > 0){?>
            <tr>
                <td colspan=2>
                    <table border=0 width=100% cellspacing=0 cellpadding=0 align=center>
                        <tr height=20 class=normal11b align=center>
                            <?for ($i=0; $i<count($vLabels); $i++){?>
                                <td width="<?=Left($vFormat[$i],2)?>%" align="<?=RetornaAlign(substr($vFormat[$i],2,1))?>" background="imagens/fundoBarraRelatorio.gif"><?=$vLabels[$i]?></td>
                            <?}?>
                        </tr>
                        <?for($i=0;$i<$vDados->getCount();$i++){ $bgColor = ($i % 2 == 1) ? '#E8E8E8' : '#FFFFFF';?>
                        <tr height=20 <? if ($i % 2 == 1) {?>bgcolor="#EEEEEE"<?}?> class=relatorio onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='<?= $bgColor;?>'">
                            <?for($j=0;$j<count($vLabels);$j++){
                                if ($j==0){?>
                                    <td width="<?=Left($vFormat[$j],2)?>%" align="<?=RetornaAlign(substr($vFormat[$j],2,1))?>"><a href="cadoperadores.php?numg_operador=<?=$vDados->getValores($i,"numg_operador")?>" class=relatorio><?=RetornaDadoFormatado($vDados->getValores($i,$vPosicao[$j]),Right($vFormat[$j],1))?></a></td>
                                <?}else{?>
                                    <td width="<?=Left($vFormat[$j],2)?>%" align="<?=RetornaAlign(substr($vFormat[$j],2,1))?>"><?=RetornaDadoFormatado($vDados->getValores($i,$vPosicao[$j]),Right($vFormat[$j],1))?></td>
                                <?}}?>
                        </tr>
                    <?}?>
                    </table>
                </td>
            </tr>
            <tr <?if($i%2==1){?>bgcolor="#EEEEEE"<? }?> height=20>
                <td width=80% class=destaque>*Clique no operador para visualizar seus dados</td>
                <td width=20% class=normal11b align=right>TOTAL: <?=$vDados->getCount()?></td>
            </tr>
            <tr>
                <td colspan="2"><a href="javascript:window.print()" class="relatorio"><img src="imagens/botoes/imprimir.gif" alt="" border="0" align="absmiddle">&nbsp;Imprimir</a></td>
            </tr>
            <?}else{?>
                <tr>
                <td colspan=2 class=destaque align=center>Nenhum registro encontrado</td>
            </tr>
            <?}?>
        </TABLE>
        <script language="JavaScript">
            function imprimir_operadores(){
                if (confirm("Confirma a IMPRESSÃO do relatório?")){
                    window.print()
                }
            }
        </script>
    </body>
</html>