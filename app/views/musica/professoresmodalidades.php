<?php
/**
 * Descrição: Viewer com a tabela das modalidades e horarios cadastradas por professor
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 08/11/2010
 */
require_once("../../funcoes.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../models/musica/Matricula.php");
require_once("../../models/musica/Professor.php");
require_once("../../models/musica/Modalidade.php");
require_once("../../models/musica/ProfessorModalidade.php");

$oProfessor = new Professor();
$oModalidade = new Modalidade();
$oProfessoreMoralidade = new ProfessorModalidade();
$oMatriculas = new Matricula();

$numgModalidade = $_GET["numgModalidade"];
$numgProfessor = $_GET["numgProfessor"];
if($numgModalidade!=""){
    $oModalidade->setarDadosFormulario($numgModalidade);if (Erro::isError()) MostraErros();
}
if($numgProfessor!=""){
    $oProfessor->setarDados($numgProfessor);if (Erro::isError()) MostraErros();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Tabela de horarios</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/estilosformularios.css">
        <link rel="stylesheet" type="text/css" href="../interface_3/css/custom-theme/jquery-ui-1.8.6.custom.css">
        <script type="text/javascript" src="../interface_3/js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="../interface_3/js/jquery-ui-1.8.6.custom.min.js"></script>
        <script type="text/javascript" src="../javascripts/funcoes.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#cancelarModalidade").button().click(function(){
                   if(confirm("Tem certeza que deseja cancelar as aulas nessa modalidade?\nAo confirmar, todas as matriculas referentes\nserão altomaticamente canceladas.")){
                        form.action = "../../controllers/musica/pcadprofessoresmodalidades.php";
                        $("#txtFuncao").val("removerModalidade");
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
        <style type="text/css" >
            table{
                border: 1px solid #A6C9E2;
            }
            th{
                border: 1px solid #A6C9E2;
            }
            td{
                border: 1px solid #A6C9E2;
            }
            .horarioAula{
                width:100px;
                height: 20px;
                text-align: center;
                padding-top:5px;
                position: relative;
                float: left;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <form name="form" id="form" action="" method="post">
        <div style="padding-left: 20px;padding: 10px 10px 10px 10px" class="ui-corner-all ui-widget-content">
            <input type="hidden" name="numgProfessor" value="<?=$oProfessor->getNumgProfessor()?>" />
            <input type="hidden" name="numgModalidade" value="<?=$oModalidade->getNumgModalidade()?>" />
            Pofessor: <b><?=$oProfessor->getDescNomePessoa()." ".$oProfessor->getDescSobreNomePessoa()?></b><br />
            Modalidade: <b><?=$oModalidade->getNomeModalidade()?></b>
        </div>
        <fieldset class="fieldFormulario" style="width:700px;">
            <legend>Hor&aacute;rios</legend>
            <table border="0" cellpadding="3" cellspacing="3" width="100%" class="tableMod" id="tbHorarios">
                    <tr>
                        <th class="thMod1 ui-corner-all ui-widget-header">Hor&aacute;rios</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">Segunda-feira</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">Ter&ccedil;a-feira</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">Quarta-feira</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">Quinta-feira</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">Sexta-feira</th>
                        <th class="thMod ui-corner-all ui-widget-header" width="15%">S&aacute;bado</th>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">08:00<br />&agrave;s<br />09:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf20809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "8|9");                            
                            if($resAlunoProf20809->getCount()>0){
                                echo $resAlunoProf20809->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf20809->getValores(0,"numg_aluno")?>" />
                            <?}else{?>
                                <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf30809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "8|9");
                            if($resAlunoProf30809->getCount()>0){
                                echo $resAlunoProf30809->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf30809->getValores(0,"numg_aluno")?>" />
                            <?}else{?>
                                <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf40809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "8|9");
                            if($resAlunoProf40809->getCount()>0){
                                echo $resAlunoProf40809->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf40809->getValores(0,"numg_aluno")?>" />
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf50809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "8|9");
                            if($resAlunoProf50809->getCount()>0){
                                echo $resAlunoProf50809->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf50809->getValores(0,"numg_aluno")?>" />
                            <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf60809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "8|9");
                            if($resAlunoProf60809->getCount()>0){
                                echo $resAlunoProf60809->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf60809->getValores(0,"numg_aluno")?>"
                            <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf70809 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "8|9");
                            if($resAlunoProf70809->getCount()>0){
                                echo $resAlunoProf70809->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf70809->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">09:00<br />&agrave;s<br />10:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf20910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "9|10");
                            if($resAlunoProf20910->getCount()>0){
                                echo $resAlunoProf20910->getValores(0,"nome_aluno");?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf20910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf30910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "9|10");
                            if($resAlunoProf30910->getCount()>0){
                                echo $resAlunoProf30910->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf30910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod"  align="center" valign="middle">
                            <?$resAlunoProf40910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "9|10");
                            if($resAlunoProf40910->getCount()>0){
                                echo $resAlunoProf40910->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf40910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod"  align="center" valign="middle">
                            <?$resAlunoProf50910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "9|10");
                             if($resAlunoProf50910->getCount()>0){
                                echo $resAlunoProf50910->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf50910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod"  align="center" valign="middle">
                            <?$resAlunoProf60910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "9|10");
                            if($resAlunoProf60910->getCount()>0){
                                echo $resAlunoProf60910->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf60910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf70910 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "9|10");
                             if($resAlunoProf70910->getCount()>0){
                                echo $resAlunoProf70910->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf70910->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">10:00<br />&agrave;s<br />11:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf21011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "10|11");
                            if($resAlunoProf21011->getCount()>0){
                                echo $resAlunoProf21011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf21011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf31011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "10|11");
                            if($resAlunoProf31011->getCount()>0){
                                echo $resAlunoProf31011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf31011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf41011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "10|11");
                            if($resAlunoProf41011->getCount()>0){
                                echo $resAlunoProf41011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf41011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf51011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "10|11");
                            if($resAlunoProf51011->getCount()>0){
                                echo $resAlunoProf51011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf51011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf61011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "10|11");
                            if($resAlunoProf61011->getCount()>0){
                                echo $resAlunoProf61011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf61011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf71011 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "10|11");
                            if($resAlunoProf71011->getCount()>0){
                                echo $resAlunoProf71011->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf71011->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">11:00<br />&agrave;s<br />12:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf21112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "11|12");
                            if($resAlunoProf21112->getCount()>0){
                                echo $resAlunoProf21112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf21112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf31112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "11|12");
                            if($resAlunoProf31112->getCount()>0){
                                echo $resAlunoProf31112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf31112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf41112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "11|12");
                            if($resAlunoProf41112->getCount()>0){
                                echo $resAlunoProf41112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf41112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf51112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "11|12");
                            if($resAlunoProf51112->getCount()>0){
                                echo $resAlunoProf51112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf51112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf61112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "11|12");
                            if($resAlunoProf61112->getCount()>0){
                                echo $resAlunoProf61112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf61112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoProf71112 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "11|12");
                            if($resAlunoProf71112->getCount()>0){
                                echo $resAlunoProf71112->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoProf71112->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">12:00<br />&agrave;s<br />13:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "12|13");
                            if($resAlunoPro21213->getCount()>0){
                                echo $resAlunoPro21213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "12|13");
                            if($resAlunoPro31213->getCount()>0){
                                echo $resAlunoPro31213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "12|13");
                            if($resAlunoPro41213->getCount()>0){
                                echo $resAlunoPro41213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "12|13");
                            if($resAlunoPro51213->getCount()>0){
                                echo $resAlunoPro51213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "12|13");
                            if($resAlunoPro61213->getCount()>0){
                                echo $resAlunoPro61213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71213 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "12|13");
                            if($resAlunoPro71213->getCount()>0){
                                echo $resAlunoPro71213->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71213->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">13:00<br />&agrave;s<br />14:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "13|14");
                            if($resAlunoPro21314->getCount()>0){
                                echo $resAlunoPro21314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "13|14");
                            if($resAlunoPro31314->getCount()>0){
                                echo $resAlunoPro31314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "13|14");
                            if($resAlunoPro41314->getCount()>0){
                                echo $resAlunoPro41314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "13|14");
                            if($resAlunoPro51314->getCount()>0){
                                echo $resAlunoPro51314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "13|14");
                            if($resAlunoPro61314->getCount()>0){
                                echo $resAlunoPro61314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71314 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "13|14");
                            if($resAlunoPro71314->getCount()>0){
                                echo $resAlunoPro71314->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71314->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">14:00<br />&agrave;s<br />15:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "14|15");
                            if($resAlunoPro21415->getCount()>0){
                                echo $resAlunoPro21415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "14|15");
                            if($resAlunoPro31415->getCount()>0){
                                echo $resAlunoPro31415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "14|15");
                            if($resAlunoPro41415->getCount()>0){
                                echo $resAlunoPro41415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "14|15");
                            if($resAlunoPro51415->getCount()>0){
                                echo $resAlunoPro51415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "14|15");
                            if($resAlunoPro61415->getCount()>0){
                                echo $resAlunoPro61415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71415 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "14|15");
                            if($resAlunoPro71415->getCount()>0){
                                echo $resAlunoPro71415->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71415->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">15:00<br />&agrave;s<br />16:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "15|16");
                            if($resAlunoPro21516->getCount()>0){
                                echo $resAlunoPro21516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "15|16");
                            if($resAlunoPro31516->getCount()>0){
                                echo $resAlunoPro31516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "15|16");
                            if($resAlunoPro41516->getCount()>0){
                                echo $resAlunoPro41516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "15|16");
                            if($resAlunoPro51516->getCount()>0){
                                echo $resAlunoPro51516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "15|16");
                            if($resAlunoPro61516->getCount()>0){
                                echo $resAlunoPro61516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71516 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "15|16");
                            if($resAlunoPro71516->getCount()>0){
                                echo $resAlunoPro71516->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71516->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">16:00<br />&agrave;s<br />17:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "16|17");
                            if($resAlunoPro21617->getCount()>0){
                                echo $resAlunoPro21617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "16|17");
                            if($resAlunoPro31617->getCount()>0){
                                echo $resAlunoPro31617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "16|17");
                            if($resAlunoPro41617->getCount()>0){
                                echo $resAlunoPro41617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "16|17");
                            if($resAlunoPro51617->getCount()>0){
                                echo $resAlunoPro51617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "16|17");
                            if($resAlunoPro61617->getCount()>0){
                                echo $resAlunoPro61617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71617 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "16|17");
                            if($resAlunoPro71617->getCount()>0){
                                echo $resAlunoPro71617->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71617->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">17:00<br />&agrave;s<br />18:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "17|18");
                            if($resAlunoPro21718->getCount()>0){
                                echo $resAlunoPro21718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "17|18");
                            if($resAlunoPro31718->getCount()>0){
                                echo $resAlunoPro31718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "17|18");
                            if($resAlunoPro41718->getCount()>0){
                                echo $resAlunoPro41718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "17|18");
                            if($resAlunoPro51718->getCount()>0){
                                echo $resAlunoPro51718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "17|18");
                            if($resAlunoPro61718->getCount()>0){
                                echo $resAlunoPro61718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71718 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "17|18");
                            if($resAlunoPro71718->getCount()>0){
                                echo $resAlunoPro71718->getValores(0,"nome_alunos")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71718->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">18:00<br />&agrave;s<br />19:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "18|19");
                            if($resAlunoPro21819->getCount()>0){
                                echo $resAlunoPro21819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "18|19");
                            if($resAlunoPro31819->getCount()>0){
                                echo $resAlunoPro31819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "18|19");
                            if($resAlunoPro41819->getCount()>0){
                                echo $resAlunoPro41819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "18|19");
                            if($resAlunoPro51819->getCount()>0){
                                echo $resAlunoPro51819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "18|19");
                            if($resAlunoPro61819->getCount()>0){
                                echo $resAlunoPro61819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71819 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "18|19");
                            if($resAlunoPro71819->getCount()>0){
                                echo $resAlunoPro71819->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71819->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">19:00<br />&agrave;s<br />20:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro21920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "19|20");
                            if($resAlunoPro21920->getCount()>0){
                                echo $resAlunoPro21920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro21920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro31920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "19|20");
                            if($resAlunoPro31920->getCount()>0){
                                echo $resAlunoPro31920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro31920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro41920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "19|20");
                            if($resAlunoPro41920->getCount()>0){
                                echo $resAlunoPro41920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro41920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro51920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "19|20");
                            if($resAlunoPro51920->getCount()>0){
                                echo $resAlunoPro51920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro51920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro61920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "19|20");
                            if($resAlunoPro61920->getCount()>0){
                                echo $resAlunoPro61920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro61920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro71920 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "19|20");
                            if($resAlunoPro71920->getCount()>0){
                                echo $resAlunoPro71920->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro71920->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr class="linhaTab">
                        <td class="tdMod" align="center" valign="middle">20:00<br />&agrave;s<br />21:00</td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro22021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 2, "20|21");
                             if($resAlunoPro22021->getCount()>0){
                                echo $resAlunoPro22021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro22021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro32021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 3, "20|21");
                            if($resAlunoPro32021->getCount()>0){
                                echo $resAlunoPro32021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro32021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro42021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 4, "20|21");
                            if($resAlunoPro42021->getCount()>0){
                                echo $resAlunoPro42021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro42021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro52021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 5, "20|21");
                            if($resAlunoPro52021->getCount()>0){
                                echo $resAlunoPro52021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro52021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro62021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 6, "20|21");
                            if($resAlunoPro62021->getCount()>0){
                                echo $resAlunoPro62021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro62021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                        <td class="tdMod" align="center" valign="middle">
                            <?$resAlunoPro72021 = $oProfessor->consultarAlunosProfessor($numgModalidade, $numgProfessor, 7, "20|21");
                            if($resAlunoPro72021->getCount()>0){
                                echo $resAlunoPro72021->getValores(0,"nome_aluno")?>
                                <input type="hidden" name="numgAluno[]" value="<?=$resAlunoPro72021->getValores(0,"numg_aluno")?>"
                           <?}else{?>
                                 <span style="color: blue;font-weight: bold;">Livre</span>
                            <?}?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" valign="middle" align="right">
                            <button id="cancelarModalidade" style="width:100%;height: 40px;">Cancelar Aulas na Modalidade</button>
                        </td>
                    </tr>
                </table>
        </fieldset>
        </form>
    </body>
</html>