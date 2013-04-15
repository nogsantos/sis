<?php
/**
 * Descrição: View Topo padrão dos relatórios do sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 04/10/2010
 *
 * padrões de uma folha A4
 *  width: 842px
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?= $nomeRel ?></title>
        <link rel="stylesheet" type="text/css" href="../interface/css/redmond/jquery-ui-1.8.4.custom.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <script type="text/javascript" src="../interface/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface/js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#imprimir").button().click(function(){
                    window.print();
                });
                $("#voltar").button().click(function(){
                    history.back(-1);
                });
            });
        </script>
        <style type="text/css" media="print">
            .botao {
                display: none;
            }
        </style>
    </head>
    <body>
    <div id="topo" style="border-bottom:1px solid #000;width:842px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px;">
            <tr>
                <td>
                    <div style="position: relative;float: left;left: 10px;"><img src="../imagens/topoRelatorios.png" border="0" alt="" /></div>
                    <div style="position: relative;float: left;left:20px; text-align: center;">
                        <b><h2> Escola de M&uacute;sica - Miss&atilde;o Tocando as Na&ccedil;&otilde;es</h2></b>
                                CNPJ 06.248.938/0001-01<br />
                                Rua C-212, n. 882, Qd. 523, Lt. 24, Jd. Am&eacute;rica CEP: 74270-250 Goi&acirc;nia GO<br />
                                Fone:(62) 3941-0884
                    </div>
                    <div style="position: relative;float: right;right: 10px;text-align: right;top:100px;">Data: <?=date("d/m/Y  H:i s")?></div>
                </td>
            </tr>
        </table>
    </div>