<?php
session_start();
/**
 * Descrição: Descrição: Menu de acesso.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once("../models/seguranca/Formulario.php");
require_once("../models/Erro.php");
require_once("../Oad.php");
require_once("../funcoes.php");
$oFormularios = new Formulario;
/*
 * ADMINISTRADOR GERAL
 */
if ($_SESSION[NUMG_OPERADOR] == 1) {
    $vFormularios = $oFormularios->consultarFormsAdministrador();if (Erro::isError())MostraErros();
} else {
    $vFormularios = $oFormularios->consultarFormsOperador($_SESSION[NUMG_OPERADOR]);if (Erro::isError())MostraErros();
}
/**
 * Descrição: montando o menu.
 */
$vMenuForm = array();
$vMenuFormAux = array();
for($i=0;$i<$vFormularios->getCount();$i++){
    $vMenuForm[$vFormularios->getValores($i,desc_nome)] .= $vFormularios->getValores($i,nome_formulario)."|";
    $vLinkMenuForm[$vFormularios->getValores($i,codg_modulo)] .= $vFormularios->getValores($i,codg_formulario)."|";
}
$oFormularios->free;
?>
<html>
    <head>
        <title>Menu</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
<!--        <link rel="stylesheet" type="text/css" href="interface/css/redmond/jquery-ui-1.8.4.custom.css">
        <script type="text/javascript" src="interface/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="interface/js/jquery-ui-1.8.4.custom.min.js"></script>-->
        <script type="text/javascript" language=JavaScript>
            /**
             * Descrição: Carregando as funções da Interface.
             **/
            $(function(){
                /**
                 * Descrição: Inicializando Accordion.
                 **/
                $("#accordion").accordion({ 
                    header: "h3",
                    autoHeight: false,
                    navigation: true
                });
            });            
        </script>
        <style type="text/css">
            .posMenu{
                margin-top: 8px;
            }
        </style>
    <base target="conteudo">
    </head>
    <body bgcolor="#DEEDF7" >
        <table border=0 cellspacing="0" width="100%" cellpadding="0" class="ui-widget-header">
            <tr style="height: 27px;" class="titulo11" >
                <td width="90%" style="color:#277CBF;font-weight: bold;" >&nbsp;Menu&nbsp;&nbsp;</td>
                <td width="10%"><a href="menu.php" target=menu><img src="imagens/icones/atualizar.png" border=0 alt="Atualizar Menu" align=absbottom></a></td>
            </tr>
        </table>
        <div id="accordion" class="posMenu">
             <?for($i = 0; $i < $vFormularios->getCount(); $i++){?>
                <?if($i == 0){?>
                    <h3><a href="#"><?=$vFormularios->getValores($i, desc_nome);?></a></h3>
                    <div style="text-align: left;">
                        <img src="imagens/L.gif" border="0" alt="">&nbsp;<a href="<?=$vFormularios->getValores($i, codg_modulo); ?>/<?=$vFormularios->getValores($i, codg_formulario); ?>.php"><?=$vFormularios->getValores($i, nome_formulario);?></a><br>
                <?}else if ($vFormularios->getValores($i, numg_modulo) != $vFormularios->getValores($i - 1, numg_modulo)){?>
                    </div>
                    <h3><a href="#"><?=$vFormularios->getValores($i, desc_nome);?></a></h3>
                    <div style="text-align: left;">
                        <img src="imagens/L.gif" border="0" alt="">&nbsp;<a href="<?=$vFormularios->getValores($i, codg_modulo); ?>/<?=$vFormularios->getValores($i, codg_formulario); ?>.php"><?=$vFormularios->getValores($i, nome_formulario);?></a><br>
                <?}else if ($i >= $vFormularios->getCount()){?>
                    </div>
            <?}else{?>
                <img src="imagens/L.gif" border="0" alt="">&nbsp;<a href="<?=$vFormularios->getValores($i, codg_modulo); ?>/<?=$vFormularios->getValores($i, codg_formulario); ?>.php"><?=$vFormularios->getValores($i, nome_formulario); ?></a><br>
            <?}}?>
        </div>        
</body>
</html>