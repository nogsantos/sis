<?php
/**
 * Descrição: Pagina contendo os erros gerados pelo sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once ('../funcoes.php');
require_once ('../models/Erro.php');
?>
<html>
    <head>
        <title>SIS - Erros</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css" >
        <script type="text/javascript" src="javascripts/funcoes.js"></script>
        <script type="text/javascript">
            function enviaErro(){
                document.form.txtErro.value = document.getElementById("erro").innerHTML;
                window.open("", "envia_erro", "directories=no,height=500,width=500,hotkeys=no,location=no,menubar=no,resizable=no,scrollbars=yes,status=no,toolbar=no,copyhistory=no,top=20,left=20")
                document.form.submit()
            }
        </script>
    </head>
    <body bgcolor="#FFFFFF">
        <table border=0 width=100% align=center cellspacing=0 cellpadding=0>
            <form method="post" action="enviaerro.php" name="form" target="envia_erro" onsubmit="return false">
                <input type="hidden" name="txtErro" value="">
                <input type="hidden" name="txtOperador" value="<?= $_SESSION[NOME_OPERADOR]?>">
                <input type="hidden" name="txtId" value="<?= $_SESSION[NUMG_OPERADOR]?>">
                <tr>
                    <td><img src="imagens/space.gif" border="0" height="10" alt=""></td>
                </tr>
                <tr>
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><img src="imagens/formEsqSup.gif" border=0 width=10 height=10 alt=""></td>
                                <td style="background-image:url('imagens/formMidSup.gif');"></td>
                                <td><img src="imagens/formDirSup.gif" border="0" width="10" height="10" alt=""></td>
                            </tr>
                            <tr valign="top">
                                <td width="10" style="background-image:url('imagens/formEsqMid.gif');"></td>
                                <td align="center">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-image:url('imagens/formMid.gif');">
                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="3">
                                                <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="50%" class="normal11b" align="center">
                                                            <img src="imagens/icones/atencao.png" border="0" alt=""><br />ATEN&Ccedil;&Atilde;O
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        <tr>
                                        <tr style="height: 30px;" valign="top">
                                            <td class="normal11" align="center">Confira o(s) erro(s) encontrado(s) na execução da operação e clique no botão Voltar para corrigí-los:</td>
                                        </tr>
                                        <tr valign="top" align="left">
                                            <td class="normal11"><span id="erro"><?=Erro::geraErro();?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                        <tr style="height: 25px;" valign="bottom">
                                            <td valign="middle" colspan="4" align="center">
                                                <input type="button" value="Enviar Erro" onClick="enviaErro()" class="botao" id="submit1" name="submit1">&nbsp;
                                                <input type="button" value="Voltar" onClick="javascript:history.back()" class="botao" id="submit1" name="submit1">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="10" style="background-image:url('imagens/formDirMid.gif');"></td>
                            </tr>
                            <tr>
                                <td><img src="imagens/formEsqInf.gif" border="0" width="10" height="10" alt=""></td>
                                <td style="background-image:url('imagens/formMidInf.gif');"></td>
                                <td><img src="imagens/formDirInf.gif" border="0" width="10" height="10" alt=""></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><img src="imagens/space.gif" border="0" height="10" alt=""></td>
                </tr>
            </form>
        </table>
    </body>
</html>