<?php
/**
 * Descrição: Barra de Funções do sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once ("../funcoes.php");
require_once ("../Oad.php");
require_once ("../models/Erro.php");

$sCodgFormulario = $_GET[codg_formulario];
$numgOperador = $_SESSION[NUMG_OPERADOR];
$sOperador = $_SESSION[NOME_COMPLETO];
$nomeFormulario = $_GET[nome_formulario];
?>
<html>
    <head>
        <title>Barra de Fun&ccedil;&otilde;es</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="javascripts/funcoes.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#logoff").click(function(){
                    if(confirm("Deseja sair do sistema?")){
                        try{
                            top.location.href = '../../index.php?opt=1';
                        } catch(e){
                            //não faz nada só para não dar erro no ie
                        }
                    }
                });
            });          
            /**
             * Descrição: Setando o titulo da página.
             */
            function setaTitulo(){
                top.document.title = "Escola de Música Tocando as Nações";
            }
            /**
             * Descrição: Solicita a confirmação do usuário para sair do sistema.
             */
            function confirmaSaida(){
                
            }
        </script>
        <style type="text/css">
            *{
                padding: 0;
                margin: 0;
                font-family: verdana, arial;
            }
            a{outline:none;}
        </style>
    <base target="conteudo">
    </head>
    <body onLoad="setaTitulo();" class="ui-widget-header">
        <table border="0" width="50%" cellpadding="0" cellspacing="0">
            <tr style="height:auto;">
                <td width=100% >
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">
                        <tr>                           
                            <?if ($nomeFormulario!="") {?>
                            <td align="left" style="padding-top:7px;color: #277CBF;font-size: 1.5em;" valign="middle">
                                <span style="font-weight: bold;position: relative;float: left;left:10px;top:-3px"><?=$nomeFormulario?></span>
                            </td>
                            <?}else{?>
                            <td align="left" style="padding-top:7px;color:#277CBF;font-size: 1.5em;" valign="middle">
                                <span style="position: relative;float: left;left:15px;top:-3px"><b><?=$sOperador?></b>, bem vindo ao sistema!</span>
                            </td>
                            <?}?>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="position:absolute;float:right;right:65px;top:3px">
            <a href="javascript:window.location.reload();top.frames[3].location.reload()"><img src="imagens/icones/atualizar.png" border="0" alt="Atualizar Formulário" title="Atualizar Formulário" /></a>
        </div>
        <div style="position:absolute;float: right;right:27px;top:3px;cursor: pointer;" class="selflink"><img id="logoff" src="imagens/icones/logoff.png" border="0" align="absmiddle" title="Efetuar logoff" alt="Efetuar logoff" /></div>
    </body>
</html>