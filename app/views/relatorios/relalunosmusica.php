<?php
/**
 * Descrição: View Relatório de alunos da escola de música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 04/10/2010
 *
 * padrões de uma folha A4
 */
require_once("../../models/musica/Aluno.php");
require_once("../../models/Erro.php");
require_once("../../Oad.php");
require_once("../../Resultset.php");
require_once("../../funcoes.php");

$numgAluno = $_GET['numgAluno'];
$oAluno = new Aluno();
$oAluno->setarDados($numgAluno);if (Erro::isError())MostraErros();
$nomeRel = "Ficha do aluno ".$oAluno->getDescNomePessoa()." ".$oAluno->getDescSobreNomePessoa();
include("topo.php");
?>
<div id="corpo" style="display:table;width:842px">
    <table border="0" cellpadding="3" cellspacing="3" width="100%">
        <tr>
            <td style="font-size:12px;font-family: verdana;" colspan="2">
                <b>N&uacute;mero do aluno: </b><?=$oAluno->getNumrAluno()?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;font-family: verdana;" width="45%">
                <b>Nome: </b><?=$oAluno->getDescNomePessoa()." ".$oAluno->getDescSobreNomePessoa()?>
            </td>
            <td style="font-size:12px;font-family: verdana;">
                <b>Sexo: </b><?=$oAluno->getDescSexo()=="M"?"Masculino":"Feminino"?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;font-family: verdana;">
                <b>Cpf: </b><?=$oAluno->getNumrCpfcnpj()?>
            </td>
            <td style="font-size:12px;font-family: verdana;">
                <b>Identidade: </b><?=$oAluno->getNumrCarteiraIdentidade()." <b>Orgão: </b>".$oAluno->getDescOrgaoExpedidor()?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Telefone 1:</b> (".$oAluno->getNumrDddTelefone().")".$oAluno->getNumrTelefone()." <b>Telefone 2:</b> (".$oAluno->getNumrDddTelefoneContato().")".$oAluno->getNumrTelefoneContato()?>
            </td>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Celular:</b> (".$oAluno->getNumrDddCelular().")".$oAluno->getNumrCelular()?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Nacionalidade: </b>".$oAluno->getDescNacionalidade()." <b>Naturalidade: </b>".$oAluno->getDescNaturalidade()?>
            </td>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Data de Nascimento: </b>".FormataData($oAluno->getDataNascimento())."  <b>e-mail: </b>".$oAluno->getDescEmail()?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Endereço: </b>".$oAluno->getDescEndereco()." <b>Número: </b>".$oAluno->getNumrEndereco()?>
            </td>
            <td style="font-size:12px;font-family: verdana;" align="left">
                <?="<b>Setor/Bairro: </b>".$oAluno->getDescBairro()."  <b>Complemento: </b>".$oAluno->getDescComplemento()?>
            </td>
        </tr>
    </table>
</div>
<div id="dados" align="center">
    <div class="buttonBar">
        <button class="botao" id="imprimir">Imprimir&nbsp;&nbsp;&nbsp;<img src="../imagens/printer.png" border="0" title="" alt=""/></button>
    </div>
</div>