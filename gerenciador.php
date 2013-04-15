<?php
session_start();
/**
 * Descrição: View Quadro principal do sistema.
 * @author Fabricio Nogueira
 * @release Criação do arquivo
 * Data 01/08/2010
 */
require_once ("app/funcoes.php");
/**
 * Descrição: Validando o operador logado.
 */
if (empty($_SESSION[NUMG_OPERADOR]) || $_SESSION[NUMG_OPERADOR] == "") {
    header("Location: app/views/expirou.htm");
    exit;
}
?>
<html>
    <head>
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="app/views/css/estilos.css">
        <link rel="stylesheet" type="text/css" href="app/views/css/estilosformularios.css">
        <script type="text/javascript">
            function VerificaWindow(){
                if (top.name != "gerenciador"){
                }
            }
        </script>
    </head>
    <frameset onLoad="VerificaWindow();window.focus()" framespacing="0" border="0" rows="60,100%,25" frameborder="0" marginwidth="0" marginheight="0">
        <!-- BARRA DE ATALHOS -->
        <frame name="barra_atalhos" target="conteudo" src="app/views/barra_atalhos.php" scrolling="no" noresize marginwidth="0" marginheight="0">
            <frameset framespacing="0" border="0" cols="200,100%" frameborder="0">
                <!-- MENU DE NAVEGAÇÃO -->
                <frame  name="menu" target="conteudo" src="app/views/menu.php" scrolling="no" noresize marginwidth="0" marginheight="0">
                    <frameset framespacing="0" border="0" rows="30,100%" frameborder="0">
                        <!-- BARRA DE FUNÇÕES -->
                        <frame  name="barra_funcoes" target="conteudo" src="app/views/barra_funcoes.php" scrolling="no" noresize>
                        <!-- CONTEÚDO GERAL -->
                        <frame name="conteudo" target="conteudo" src="app/views/index.php" scrolling="auto">
                    </frameset>
            </frameset>
            <!-- BARRA DE STATUS -->
        <frame name="status" target="conteudo" src="app/views/barra_status.php" scrolling="no" noresize marginwidth="0" marginheight="0">
        <noframes>
                <body topmargin="0" leftmargin="0">
                    <p>Este navegador não suporta quadros.</p>
                </body>
            </noframes>
    </frameset>
</html>