<?php
session_start();
/**
 * Descrição: Login Sistema
 * @author Fabricio Nogueira
 * @release Criação do arquivo
 * Data 29/08/2010
 */
require_once("app/funcoes.php");
require_once("app/models/seguranca/Operador.php");
require_once("app/models/Erro.php");
require_once("app/Oad.php");
require_once("app/Resultset.php");

if ($_GET[opt] == 1) {
    if ($_SESSION["NUMG_OPERADOR"] != "" && !empty($_SESSION["NUMG_OPERADOR"])) {
        $oOperador = new Operador;
        /**
         * Descrição: Atualiza a data do último acesso ao sistema.
         */
        $oOperador->editarUltimoAcesso($_SESSION["NUMG_OPERADOR"]);if(Erro::isError())MostraErros();
    }
}
/**
 * Decrição: Inicializa as variáveis de seção com os dados do operador.
 */
$_SESSION["NUMG_OPERADOR"] = "";
$_SESSION["NOME_OPERADOR"] = "";
$_SESSION["NOME_COMPLETO"] = "";
$_SESSION["DATA_ULTIMOACESSO"] = "";

if ($_POST["nomeOperador"] != "" && $_POST["descSenha"] != "") {
    $bOpen = true;
    $oOperador = new Operador;
    $oResult = $oOperador->consultarPorNomeOperador($_POST["nomeOperador"]);if (Erro::isError())MostraErros();

    if ($oResult->getCount() == 0) {
        header("Location: login.php?erro=1");
        exit;
    } else {
        /**
         * Descrição: Validando se a senha está correta
         */
        if (trim(Descriptografa($oResult->getValores(0, "desc_senha"))) != trim($_POST["descSenha"])) {
            header("Location: login.php?erro=3");
            exit;
            /**
             * VERIFICA SE O OPERADOR ESTÁ BLOQUEADO
             */
        } elseif (!is_null($oResult->getValores(0, "data_bloqueio"))) {
            header("Location: login.php?erro=2");
            exit;
        } else {
            $_SESSION["NUMG_OPERADOR"] = $oResult->getValores(0, "numg_operador");
            $_SESSION["NOME_OPERADOR"] = strtolower($_POST["nomeOperador"]);
            $_SESSION["NOME_COMPLETO"] = $oResult->getValores(0, "nome_completo");
            $_SESSION["DATA_ULTIMOACESSO"] = $oResult->getValores(0, "data_ultimoacesso");
            $bOpen = true;
        }
    }
}
?>
<html>
    <head>
        <title>Acesso ao Sistema</title>
        <meta http-equiv="Content-Type" content="text/html;">
        <link rel=stylesheet type="text/css" href="app/views/css/estilos.css" />
        <link rel="stylesheet" type="text/css" href="app/views/css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="app/views/interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="app/views/interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="app/views/interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="app/views/javascripts/funcoes.js"></script>
        <script type="text/javascript" src="app/views/javascripts/jquery.maskedinput-1.2.2.min.js"></script>
        <script type="text/javascript">
            function Open(){
                <?if ($bOpen && $_GET["opt"] == "") { ?>
                    window.location.href = "gerenciador.php";
                <?}?>
                $("#nomeOperador").focus();
            }
            $(function(){
                $("#entrar").button();
                $(window).submit(function(){
                    var nomeOperador = $("#nomeOperador");
                    var descSenha = $("#descSenha");
                    if(nomeOperador.val()==""){
                        alert("Nome do operador inválido!");
                        nomeOperador.focus();
                        return false;
                    }
                    if(descSenha.val()==""){
                        alert("Senha inválida!");
                        descSenha.focus();
                        return false;
                    }
                })
            })
        </script>
        <style type="text/css">
            body{
                background-color: #277CBF;
            }
            .borderLogin{
                -moz-box-shadow:0px 0px 10px 4px #A6C9E2;
                -webkit-box-shadow:0px 0px 10px 4px #A6C9E2;
            }
        </style>
    </head>
    <body onLoad="Open();" bgcolor="#f3f3f3" >
        <div style="width:600px; position:absolute; left:50%; margin-left:-300px; height:350px; top:30%; margin-top:-175px;">
            <div style="width:100%; background-image:url(app/views/imagens/background_login.gif); background-repeat:repeat-x; height:90px;">&nbsp;</div>
            <div style="background-image:url(app/views/imagens/background_login.jpg); background-repeat:repeat-x; background-color:#FFFFFF;" class="ui-corner-all borderLogin">
                <div style="display:table; width:100%;">
                    <div style="position:relative;float:left;padding-top:70px;height:150px;padding-left:15px;width:220px;">
                        <a href="http://www.mtn.org.br" target="_blank">
                        <img src="app/views/imagens/imgLogin.png" border="0" vspace="0" hspace="0" alt="" title="">
                        </a>
                    </div>
                    <div style="position: relative;float:right;top:50px;padding: 15px 15px 15px 15px;right:10px;" class="ui-corner-all ui-widget-content" align="center">
                        <form method="post" action="login.php" name="form" id="form" autocomplete="off">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <input type="hidden" name="txtTipoFuncao" value="">
                                <tr>
                                    <td valign="top"><table border="0" align="center" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="destaque" align="center" height="25" colspan="3">&nbsp;
                                                <?if ($_GET[erro] != "") {
                                                        switch ($_GET[erro]) {
                                                            case 1:echo "Operador não encontrado !";break;
                                                            case 2:echo "Este operador encontra-se bloqueado!";break;
                                                            case 3:echo "Senha incorreta! Tente novamente.";break;
                                                        }
                                                    } elseif ($_GET[opt] != "") {
                                                        switch ($_GET[opt]) {
                                                            case 1:echo "Operador efetuou logoff!";break;
                                                            case 2:echo "Tempo de conexão expirado!";break;
                                                        }
                                                    }?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="normal11b" height="15">Operador:</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="text" name="nomeOperador" id="nomeOperador" size="25" maxlength="20" class="borda" tabindex="1" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="normal11b" height="15">Senha:</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="password" name="descSenha" id="descSenha" size="25" maxlength="8" class="borda" tabindex="2" /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td height="10"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" align="right">
                                                    <table border="0" width="100%" align="center" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="40%" class="normal11">vers&atilde;o 2.0</td>
                                                            <td width="60%" align="right">
                                                                <button id="entrar">Entrar</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
<!--                                            <tr>
                                                <td height="25" colspan="3" class="normal11">Deseja alterar a senha? <a href="alterasenha.php" class="relatorio">Clique aqui</a></td>
                                            </tr>-->
                                        </table>
                                    </td>
                                </tr>
                            </table>
                         </form>
                    </div>
                </div>
                <br>
                <div style="background-image:url(app/views/imagens/background_barra.jpg); text-align: center; height:50px;padding-top: 15px;">
                    Escola de M&uacute;sica Tocando as Na&ccedil;&otilde;es<br />
                    Telefone +55 62 3941-0884
                </div>
            </div>
        </div>
    </body>
</html>