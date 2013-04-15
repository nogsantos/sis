<?php
/**
 * Descrição: Barra de estatus do sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../funcoes.php");
?>
<html>
    <head>
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
    </head>
    <body>
        <table border="0" style="height:20px;" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="bottom">
                    <table border="0" cellpadding="0" cellspacing="0" width=100% class="ui-widget-header">
                        <tr style="height:20px;color: #277CBF;" class="titulo11">
                            <td align="right" style="padding-right: 30px;">&nbsp;
                            <?
                                if (date("G") < 12 and date("G") > 6) {
                                    echo "Bom-dia, ";
                                }elseif (date("G") >= 12 and date("G") < 19){
                                    echo "Boa-tarde, ";
                                }else{
                                    echo "Boa-noite, ";
                                }
                                echo $_SESSION[NOME_COMPLETO] . " !";
                            ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>