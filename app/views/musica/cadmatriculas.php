<?php
session_start();
/**
 * Descrição: View Cadastro de Matriculas do sistema.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 17/11/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Aluno.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/musica/Matricula.php");
require_once("../../models/musica/Modalidade.php");
require_once("../../models/musica/ProfessorModalidade.php");

//print_pre($_GET,1);

$CODG_FORMULARIO = "cadmatriculas";
$NOME_FORMULARIO = validarAcesso($CODG_FORMULARIO, $_SESSION["NUMG_OPERADOR"]);
/**
 * Descrição: Objetos.
 */
$oAlunos = new Aluno();
$oProfessor = new Professor();
$oMatriculas = new Matricula();
$oModalidade = new Modalidade();
$oProfessorModalidade = new ProfessorModalidade();
/**
 * Descrição: Parametros
 */
$numgAluno = $_GET["numgAluno"]!=""?$_GET["numgAluno"]:$_POST["numgAluno"];
$numgMatricula = $_GET["numgMatricula"];
$numgModalidade = $_GET["numgModalidade"];
$numgProfessor = $_GET["numgProfessor"];

$numgOperador = $_SESSION["NUMG_OPERADOR"];
?>
<html>
    <head>
        <title>Cadastro de Matr&iacute;culas</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript">
            /**
             * Descrição: Carregando as funções da Interface.
             * @author Fabricio Nogueira.
             **/
            $(function(){
                /**
                 * Descrição: Inicializando as Tabs.
                 **/
                $('#tabs').tabs();
                /**
                 * Descrição: Inicializa os parametros do formulário
                 **/                
                var numgModalidade = $( "#numgModalidade" );
                var numgProf = $( "#numgProf" );
           
                /**
                 * Descrição: Carregamento do formulario.
                 **/
                $(window).load(function(){
                    montaFuncoes('<?= $CODG_FORMULARIO ?>','<?= $NOME_FORMULARIO ?>','<?= $oMatriculas->getNumgMatricula() ?>')
                    $(".conteiner").delay(500).fadeIn(900);
                    $("#validateTips").hide();
                    $("#descMatricula").focus();
                })
                /**
                 * Descrição: inicializa a mensagem
                 **/
                function updateTips( t ) {
                    $("#validateTips").show(1000);
                    tips.text( t ).addClass( "ui-state-highlight" );
                }
               
                /**
                 * Descrição: Validação do tamanho do campo
                 **/
                function checkLength( o, n, min, max ) {
                    if ( o.val().length > max || o.val().length < min ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "O Campo " + n + " é de prenchimento obrigatório e deve conter mais de " + min +  " caracteres." );
                        return false;
                    } else {
                        return true;
                    }
                }
                /**
                 * Descrição: Validação da expressão regular
                 **/
                function checkRegexp(o,regexp,n) {
                    if ( !( regexp.test( o.val() ) ) ) {
                        o.addClass('ui-state-error');
                        updateTips(n);
                        return false;
                    } else {
                        return true;
                    }
                }
                /**
                 * Descrição: Novo Registro.
                 **/
                $("#novo").button().click(function(){
                    window.location.href = 'musica/<?= $CODG_FORMULARIO ?>.php';
                })                
                /**
                 * Descrição: Cadastrar
                 **/
                $("#cadastrar").button().click(function(){
                    if (confirm("Confirma o CADASTRO dos dados?")){
                        $("#txtFuncao").val("cadastrar");
                        $("form").submit();
                    }else{
                        return false;
                    }
                });
                /**
                 * Descrição: habilitar select modalidade
                 **/
                $("#numgAluno").change(function(){
                    if($(this).val()!="null"){
                       $("#selModalidades").show(999);
                   }else{
                       $("#selModalidades").hide(999);
                   }
                });
                /**
                 * Descrição: submetendo o numg da modalidade
                 **/
                $("#numgModalidade").change(function(){
                    if($(this).val()!="null"){
                        $("#txtFuncao").val("consultar");
                        if($("#numgProfessor").val()!="null")
                            $("#numgProfessor").val("");
                        $("form").submit();                        
                    }
                });
                /**
                 * Descrição: submetendo o numg do numgProfessor
                 **/
                $("#numgProfessor").change(function(){
                    if($(this).val()!="null"){
                        $("#txtFuncao").val("consultar");
                        $("form").submit();
                    }
                });
                $(".linhaTab").mouseover(function(){
                    $(this).css("background-color", "#FFFFCC");
                }).mouseout(function(){
                    $(this).css("background-color", "#FFFFFF");
                });
            });
        </script>
        <style type="text/css">
            .divAlunoModalidade{
                border: 1px solid #A6C9E2;
                padding: 10px 10px 10px 20px;
                width: auto;
                height: auto;
                display: none;
            }
            .tableMod{
                margin-top: 5px;
                border: 1px solid #A6C9E2;
            }
            .thMod{
                width: 13%;
                border: 1px solid #A6C9E2;
            }
            .thMod1{
                width: 10%;
                border: 1px solid #A6C9E2;
            }
            .tdMod{
                text-align: center;
                border: 1px solid #A6C9E2;
                cursor: pointer;
            }
            input{
                cursor: pointer;
            }
            label{
                cursor: pointer;
            }
        </style>
    </head>
    <body bgcolor="#FFFFFF">
    <div class="conteiner" style="display: none">
    <form method="post" name="form" id="form" action="../../controllers/musica/pcadmatriculas.php">
        <input type="hidden" name="txtFuncao" id="txtFuncao" value="" />
        <div id="tabs">
        <ul><li><a href="#dados">Dados Gerais do cadastro</a></li></ul>
        <div id="dados" style="width: 800px;">
            <fieldset class="fieldFormulario">
                    <legend>Matricula do aluno</legend>
                <table border="0" cellpadding="3" cellspacing="3" width="100%">
                    <?if ($_GET["info"] != ""){?>
                    <tr>
                        <td>
                            <?switch ($_GET["info"]) {
                                case 1:echo '<img src="../imagens/icones/info.png" border="0" align="absmiddle" alt="">&nbsp;&nbsp;Cadastro realizado com sucesso';break;
                            }?>
                        </td>
                    </tr>
                    <?}?>
                    <tr>
                        <td>
                            <b>Aluno</b><br />
                            <select name="numgAluno" id="numgAluno" class="borda" style="width:400px;">
                                <optgroup label="Selecione o Aluno abaixo" />
                                <?
                                    $resAluno = $oAlunos->consultarAlunosAtivos();  //$oMatriculas->consultarAlunosNaoMatriculados();
                                    montaCombo($resAluno, "numg_aluno", "nomealuno", $numgAluno, true);
                                ?>
                            </select><br />
                        </td>
                    </tr>
                    <tr id="selModalidades" <?=$numgModalidade==""&&$numgAluno==""?'style="display: none;"':''?>>
                        <td>
                            <b>Modalidade</b><br />
                            <select name="numgModalidade" id="numgModalidade" class="borda" style="width:400px;">
                                <optgroup label="Selecione a modalidade abaixo" />
                                <?
                                    $resModalidade = $oModalidade->consultarModalidadesNaoBloqueadas();
                                    montaCombo($resModalidade, "numg_modalidade", "desc_modalidade", $numgModalidade, true);
                                ?>
                            </select><br />
                        </td>
                    </tr>
                    <?if($numgModalidade!=""){?>
                    <tr>
                        <td>
                            <b>Professor</b><br />
                            <select name="numgProfessor" id="numgProfessor" class="borda" style="width:400px;">
                                <optgroup label="Selecione o professor abaixo" />
                                <?
                                    $resProfessoresModalidade = $oProfessorModalidade->consultarProfessoresPorModalidades($numgModalidade);
                                    montaCombo($resProfessoresModalidade, "numg_professor", "nome_professor", $numgProfessor, true);
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?}?>
                </table>
                <?if($numgProfessor!="" && $numgProfessor!="null"){?>
                <div id="horariosMatriculas">
                    <div class="ui-corner-all ui-widget-content titles-rel-forms" style="width:250px;">
                        Hor&aacute;rios do professor
                        <div class="ui-icon ui-icon-circle-arrow-s" style="position: relative;float: right;right: 10px"></div>
                    </div>
                    <table border="0" cellpadding="3" cellspacing="3" width="100%" class="tableMod" id="tbHorarios">
                        <tr>
                            <th class="thMod1 ui-corner-all ui-widget-header">Hor&aacute;rios</th>
                            <th class="thMod ui-corner-all ui-widget-header">Segunda-feira</th>
                            <th class="thMod ui-corner-all ui-widget-header">Ter&ccedil;a-feira</th>
                            <th class="thMod ui-corner-all ui-widget-header">Quarta-feira</th>
                            <th class="thMod ui-corner-all ui-widget-header">Quinta-feira</th>
                            <th class="thMod ui-corner-all ui-widget-header">Sexta-feira</th>
                            <th class="thMod ui-corner-all ui-widget-header">S&aacute;bado</th>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">08:00<br />&agrave;s<br />09:00</td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="289" value="2#8|9" /><label for="289" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="389" value="3#8|9" /><label for="389" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="489" value="4#8|9" /><label for="489" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="589" value="5#8|9" /><label for="589" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="689" value="6#8|9" /><label for="689" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "8|9");
                                    if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="789" value="7#8|9" /><label for="789" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                        <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                            <?=$resMatricula->getValores(0,'nome_aluno')?>
                                        </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">09:00<br />&agrave;s<br />10:00</td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="2910" value="2#9|10" /><label for="2910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="3910" value="3#9|10" /><label for="3910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="4910" value="4#9|10" /><label for="4910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="5910" value="5#9|10" /><label for="5910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="6910" value="6#9|10" /><label for="6910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "9|10");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="7910" value="7#9|10" /><label for="7910" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">10:00<br />&agrave;s<br />11:00</td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21011" value="2#10|11" /><label for="21011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula = $oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31011" value="3#10|11" /><label for="31011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula =$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41011" value="4#10|11" /><label for="41011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51011" value="5#10|11" /><label for="51011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61011" value="6#10|11" /><label for="61011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "10|11");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71011" value="7#10|11" /><label for="71011" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">11:00<br />&agrave;s<br />12:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21112" value="2#11|12" /><label for="21112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31112" value="3#11|12" /><label for="31112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41112" value="4#11|12" /><label for="41112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51112" value="5#11|12" /><label for="51112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61112" value="6#11|12" /><label for="61112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "11|12");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71112" value="7#11|12" /><label for="71112" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">12:00<br />&agrave;s<br />13:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21213" value="2#12|13" /><label for="21213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31213" value="3#12|13" /><label for="31213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41213" value="4#12|13" /><label for="41213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51213" value="5#12|13" /><label for="51213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61213" value="6#12|13" /><label for="61213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "12|13");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71213" value="7#12|13" /><label for="71213" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">13:00<br />&agrave;s<br />14:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21314" value="2#13|14" /><label for="21314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31314" value="3#13|14" /><label for="31314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41314" value="4#13|14" /><label for="41314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51314" value="5#13|14" /><label for="51314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61314" value="6#13|14" /><label for="61314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "13|14");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71314" value="7#13|14" /><label for="71314" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">14:00<br />&agrave;s<br />15:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21415" value="2#14|15" /><label for="21415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31415" value="3#14|15" /><label for="31415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41415" value="4#14|15" /><label for="41415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51415" value="5#14|15" /><label for="51415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61415" value="6#14|15" /><label for="61415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "14|15");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71415" value="7#14|15" /><label for="71415" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">15:00<br />&agrave;s<br />16:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21516" value="2#15|16" /><label for="21516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31516" value="3#15|16" /><label for="31516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41516" value="4#15|16" /><label for="41516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51516" value="5#15|16" /><label for="51516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61516" value="6#15|16" /><label for="61516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "15|16");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71516" value="7#15|16" /><label for="71516" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                 <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">16:00<br />&agrave;s<br />17:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21617" value="2#16|17" /><label for="21617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31617" value="3#16|17" /><label for="31617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41617" value="4#16|17" /><label for="41617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51617" value="5#16|17" /><label for="51617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61617" value="6#16|17" /><label for="61617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "16|17");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71617" value="7#16|17" /><label for="71617" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">17:00<br />&agrave;s<br />18:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21718" value="2#17|18" /><label for="21718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                    <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31718" value="3#17|18" /><label for="31718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41718" value="4#17|18" /><label for="41718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51718" value="5#17|18" /><label for="51718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61718" value="6#17|18" /><label for="61718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "17|18");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71718" value="7#17|18" /><label for="71718" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">18:00<br />&agrave;s<br />19:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="21819" value="2#18|19" /><label for="21819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="31819" value="3#18|19" /><label for="31819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="41819" value="4#18|19" /><label for="41819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="51819" value="5#18|19" /><label for="51819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61819" value="6#18|19" /><label for="61819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "18|19");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71819" value="7#18|19" /><label for="71819" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">19:00<br />&agrave;s<br />20:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="21920" value="2#19|20" /><label for="21920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="31920" value="3#19|20" /><label for="31920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="41920" value="4#19|20" /><label for="41920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="51920" value="5#19|20" /><label for="51920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="61920" value="6#19|20" /><label for="61920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "19|20");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="71920" value="7#19|20" /><label for="71920" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                        <tr class="linhaTab">
                            <td class="tdMod" align="center" valign="middle">20:00<br />&agrave;s<br />21:00</td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 2, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="22021" value="2#20|21" /><label for="22021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 3, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="32021" value="3#20|21" /><label for="32021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 4, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                        <input type="checkbox" name="numrSemana[]" id="42021" value="4#20|21" /><label for="42021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 5, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="52021" value="5#20|21" /><label for="52021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 6, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="62021" value="6#20|21" /><label for="62021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                            <td class="tdMod">
                                <?$resMatricula=$oMatriculas->consultarHorariosDisponiveisPorProfessor($numgModalidade, $numgProfessor, 7, "20|21");
                                if($resMatricula->getCount()<=0){?>
                                    <input type="checkbox" name="numrSemana[]" id="72021" value="7#20|21" /><label for="72021" style="color: green;font-weight: bold;">Dispon&iacute;vel</label>
                                <?}else{?>
                                    <div style="position: relative;float: left;left: 5px;" onclick="document.location.href='cadalunos.php?numgAluno=<?=$resMatricula->getValores(0,'numg_aluno')?>'">
                                        <?=$resMatricula->getValores(0,'nome_aluno')?>
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="buttonBar" style="border-top: 1px solid #A6C9E2;margin:10px 0 0 0;padding: 10px 0 10px 0;text-align: right;">
                    <button id="novo">Cancelar</button>
                    <button id="cadastrar">Cadastrar matricula</button>
                </div>
                <?}?>                                
            </fieldset>
            </div>
            </div>
            
        </form>
    </div>
</body>
</html>