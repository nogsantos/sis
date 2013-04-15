<?php
/**
 * Descrição: Enviando os erros gerados pelo sistema
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
include "../../mime/htmlMimeMail.php";
$email = "suporte.sis.setal@gmail.com";
/**
 * senha gmail: #Suporte#Sis#Setal$
 */
$mail = new htmlMimeMail();
$mail->setFrom("suporte.sis.setal@gmail.com");
$mail->setSubject("SIS - Erro");

$sMensagem = "Erro(s) encontrado(s) no sistema:<br><br>";
$sMensagem .= trim($_POST["txtErro"]) . "<br><br>";
$sMensagem .= "Operador: " . $_POST["txtOperador"] . " [" . $_POST["txtId"] . "]<br>";
$sMensagem .= "Data Envio: " . date("d/m/Y H:i");

$mail->setHtml($sMensagem);
$result = $mail->send(array($email));
?>
<html>
    <head>
        <title>SIS - Erros</title>
    </head>
    <body onload="setTimeout('window.close()',5000)">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
            <tr>
                <td height=100% align=center style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000000"><b>Aguarde, enviando erro para o Suporte...</b></td>
            </tr>
        </table>
    </body>
</html>