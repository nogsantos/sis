<?php
/**
 * Descrição: Topo
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
?>
<html>
    <head>
        <title>Barra de Atalhos</title>
        <link rel="stylesheet" type="text/css" href="interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="javascripts/jquery.jqDock.js"></script>
        <script type="text/javascript">
            $(function(){
                $(document) .ready(function(){
                    $("#menu").jqDock(Options);
                });
            });
        </script>
    <base target="conteudo">
    </head>
    <body class="ui-widget-header">
        <div style="position: relative;float:left;left:15px;"><img src="imagens/logo_ong_mtn.png" alt="" width="204px" height="57px"></div>
        <div style="position: relative;float:right;right:15px;"><img src="imagens/logo_esc_musica.png" alt="" width="368px" height="57px"></div>
    </body>
</html>
