<?php
session_start();
/**
 * Descri��o: Fun��es Gerais do sistema.
 * @author Fabricio Nogueira
 * @release Cria��o do arquivo
 * Data 29/08/2010
 */
require_once("models/seguranca/Formulario.php");
/**
 * Descri��o: Mostram os erros gerados pelo sistema.
 * @author Fabricio Nogueira.
 * Data: 27/08/2010
 */
function MostraErros() {
    if (!headers_sent()) {
        header('Location: erros.php');
        exit;
    }
}
/**
 * Descri��o: Formata a string para consulta com like sem colocar ' nas extremidades
 * Autor: Fabricio Nogueira.
 * Data: 13/09/2010
 */
function formataStrLike($str) {
    if ($str == "") {
        $str = "null";
    } else {
        $str = str_replace("'", "''", $str);
        $str = trim($str);
    }
    return $str;
}
/**
 * Descri��o: Formata uma string para grava��o no banco de dados.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010
 */
function FormataStr($str) {
    if ($str == "" || $str == "NULL") {
        $str = "null";
    } else {
        $str = str_replace("'", "''", $str);
        $str = trim($str);
        $str = "'" . $str . "'";
    }
    return $str;
}
/**
 * Descri��o: Formata um valor Boolean.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010
 */
function FormataBool($valor) {
    if (trim($valor) == "") {
        return "NULL";
    } else if ($valor == NULL) {
        return "NULL";
    } else if ((trim($valor) == 't') OR (trim($valor) == 'true') OR (trim($valor) == 'y') OR (trim($valor) == 'yes') OR (trim($valor) == '1')) {
        return "'t'";
    } else if ((trim($valor) == 'f') OR (trim($valor) == 'false') OR (trim($valor) == 'n') OR (trim($valor) == 'no') OR (trim($valor) == '0')) {
        return "'f'";
    }
}
/**
 * Descri��o: Retira caracteres epeciais de uma string
 */
function RetiraCaracEsp($texto) {
    $texto = str_replace("�", "a", $texto);
    $texto = str_replace("�", "a", $texto);
    $texto = str_replace("�", "a", $texto);
    $texto = str_replace("�", "a", $texto);
    $texto = str_replace("�", "a", $texto);
    $texto = str_replace("�", "A", $texto);
    $texto = str_replace("�", "A", $texto);
    $texto = str_replace("�", "A", $texto);
    $texto = str_replace("�", "A", $texto);
    $texto = str_replace("�", "A", $texto);
    $texto = str_replace("�", "e", $texto);
    $texto = str_replace("�", "e", $texto);
    $texto = str_replace("�", "e", $texto);
    $texto = str_replace("�", "e", $texto);
    $texto = str_replace("�", "E", $texto);
    $texto = str_replace("�", "E", $texto);
    $texto = str_replace("�", "E", $texto);
    $texto = str_replace("�", "E", $texto);
    $texto = str_replace("�", "i", $texto);
    $texto = str_replace("�", "i", $texto);
    $texto = str_replace("�", "i", $texto);
    $texto = str_replace("�", "i", $texto);
    $texto = str_replace("�", "I", $texto);
    $texto = str_replace("�", "I", $texto);
    $texto = str_replace("�", "I", $texto);
    $texto = str_replace("�", "I", $texto);
    $texto = str_replace("�", "o", $texto);
    $texto = str_replace("�", "o", $texto);
    $texto = str_replace("�", "o", $texto);
    $texto = str_replace("�", "o", $texto);
    $texto = str_replace("�", "o", $texto);
    $texto = str_replace("�", "O", $texto);
    $texto = str_replace("�", "O", $texto);
    $texto = str_replace("�", "O", $texto);
    $texto = str_replace("�", "O", $texto);
    $texto = str_replace("�", "O", $texto);
    $texto = str_replace("�", "u", $texto);
    $texto = str_replace("�", "u", $texto);
    $texto = str_replace("�", "u", $texto);
    $texto = str_replace("�", "u", $texto);
    $texto = str_replace("�", "U", $texto);
    $texto = str_replace("�", "U", $texto);
    $texto = str_replace("�", "U", $texto);
    $texto = str_replace("�", "U", $texto);
    $texto = str_replace("�", "c", $texto);
    $texto = str_replace("�", "C", $texto);
    $texto = str_replace("�", "n", $texto);
    $texto = str_replace("�", "N", $texto);
    $texto = str_replace("~", " ", $texto);
    $texto = str_replace("`", " ", $texto);
    $texto = str_replace("�", " ", $texto);
    $texto = str_replace("^", " ", $texto);
    $texto = str_replace("�", " ", $texto);
    $texto = str_replace(" ", "_", $texto);
    return $texto;
}
/**
 * Retira Acentua��o das palavras
 * @author Fabricio Nogueira.
 * Data: 24/07/2010
 */
function retiraAcentuacao($texto) {
    return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($texto));
}
/**
 * Decri��o: FORMATA A DATA NO PADR�O DD/MM/AAAA
 */
function FormataData($vData) {
    if ($vData == "")
        return false;

    $vData = ereg_replace("-", "/", $vData);
    $pos = strpos($vData, "/");

    if ($pos === 4) {
        $vXchange = explode("/", $vData);
        $vXchangeAux = explode(" ", $vXchange[2]);
        $vData = $vXchangeAux[0] . "/" . $vXchange[1] . "/" . $vXchange[0] . " " . $vXchangeAux[1];
    }

    if (strstr($vData, '/')) {
        $vTime = null;
        $vData = explode("/", $vData);

        if (strlen($vData[1]) == 1) {
            $vData[1] = "0" . $vData[1];
        }
        if (strlen($vData[0]) == 1) {
            $vData[0] = "0" . $vData[0];
        }

        if (strlen($vData[2] > 4)) {
            $vTimeAux = explode(" ", $vData[2]);
            $vTime = explode(":", $vTimeAux[1]);
            $vData[2] = $vTimeAux[0];
            return $vData[0] . "/" . $vData[1] . "/" . $vData[2];
        } else {
            return $vData[0] . "/" . $vData[1] . "/" . $vData[2];
        }
    } else {
        return $vData;
    }
}
/**
 * Descri��o: FORMATA O VALOR NO FORMATO XXX,XX
 */
function FormataValor($valor) {
    if ($valor != "" && !is_null($valor)) {
        return number_format($valor, 2, ',', '.');
    } else {
        return "";
    }
}
/**
 * FORMATA O VALOR NO FORMATO XXX,XXXX
 */
function FormataValor4($valor) {
    if ($valor != "" && !is_null($valor)) {
        return number_format($valor, 4, ',', '.');
    } else {
        return "";
    }
}
/**
 * Descri��o: VALIDA O ACESSO DE UM OPERADOR A UM FORMUL�RIO.
 */
function validarAcesso($sCodgFormulario, $nNumgOperador) {
    /**
     * Descri��o: Verifica se a se��o Expirou.
     */
    if (empty($nNumgOperador) || $nNumgOperador == "") {
        header("Location: views/expirou.htm");
        exit;
    } else {
        $oFormulario = new Formulario;
        return $oFormulario->validarAcesso($sCodgFormulario, $nNumgOperador);
        $oFormulario->free;
    }
}
/**
 * Descri��o: VALIDA O CPF INFORMADO (SEM DIVISORES)
 */
function IsCpf($cpf) {
    $tam_cpf = strlen($cpf);
    $cpf_limpo = "";

    for ($i = 0; $i < $tam_cpf; $i++) {
        $carac = substr($cpf, $i, 1);
        // verifica se o codigo asc refere-se a 0-9
        if (ord($carac) >= 48 && ord($carac) <= 57)
            $cpf_limpo .= $carac;
    }
    if (strlen($cpf_limpo) != 11)
        return false;

    // achar o primeiro digito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++)
        $soma += (int) substr($cpf_limpo, $i, 1) * (10 - $i);

    if ($soma == 0)
        return false;

    $primeiro_digito = 11 - $soma % 11;

    if ($primeiro_digito > 9)
        $primeiro_digito = 0;

    if (substr($cpf_limpo, 9, 1) != $primeiro_digito)
        return false;

    // acha o segundo digito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++)
        $soma += (int) substr($cpf_limpo, $i, 1) * (11 - $i);

    $segundo_digito = 11 - $soma % 11;

    if ($segundo_digito > 9)
        $segundo_digito = 0;

    if (substr($cpf_limpo, 10, 1) != $segundo_digito)
        return false;

    return true;
}
/**
 * Descri��o:  VALIDA O CNPJ INFORMADO (SEM DIVISORES)
 */
function IsCnpj($cnpj) {
    $pontos = array(',', '-', '.', '', '/');

    $cnpj = str_replace($pontos, '', $cnpj);
    $cnpj = trim($cnpj);

    if (empty($cnpj) || strlen($cnpj) != 14)
        return FALSE;
    else {
        if (check_fake($cnpj, 14))
            return FALSE;
        else {
            $rev_cnpj = strrev(substr($cnpj, 0, 12));
            for ($i = 0; $i <= 11; $i++) {
                $i == 0 ? $multiplier = 2 : $multiplier;
                $i == 8 ? $multiplier = 2 : $multiplier;
                $multiply = ($rev_cnpj[$i] * $multiplier);
                $sum = $sum + $multiply;
                $multiplier++;
            }
            $rest = $sum % 11;
            if ($rest == 0 || $rest == 1)
                $dv1 = 0;
            else
                $dv1 = 11 - $rest;

            $sub_cnpj = substr($cnpj, 0, 12);
            $rev_cnpj = strrev($sub_cnpj . $dv1);
            unset($sum);
            for ($i = 0; $i <= 12; $i++) {
                $i == 0 ? $multiplier = 2 : $multiplier;
                $i == 8 ? $multiplier = 2 : $multiplier;
                $multiply = ($rev_cnpj[$i] * $multiplier);
                $sum = $sum + $multiply;
                $multiplier++;
            }
            $rest = $sum % 11;
            if ($rest == 0 || $rest == 1)
                $dv2 = 0;
            else
                $dv2 = 11 - $rest;

            if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
                return TRUE; //$cnpj;
            else
                return FALSE;
        }
    }
}
/**
 * Descri��o: Fun��o para gerar listas de estados brasileiros em um select.
 */
function geraListaEstados($initSel) {
    $estados = array("AC", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
    for ($linha = 0; $linha <= count($estados) - 1; $linha++) {
        $selected = ($initSel == $estados[$linha]) ? " selected" : "";
        echo "<option value=\"" . $estados[$linha] . "\"" . $selected . ">" . $estados[$linha] . "</option>";
    }
}
/**
 * Descri��o: FORMATA A DATA PARA GRAVA��O
 */
function FormataDataGravacao($vData) {
    if (trim($vData) == "") {
        return "null";
    } else {
        $vData = ereg_replace("/", "-", $vData);
        $vData = trim($vData);
        $pos = strpos($vData, "-");
        if ($pos === 2) {
            $vXchange = explode("-", $vData); //10-10-2005 12:12:12
            $vXchangeAux = explode(" ", $vXchange[2]); //
            $vData = $vXchangeAux[0] . "-" . $vXchange[1] . "-" . $vXchange[0] . " " . $vXchangeAux[1];
        }
        $vTime = null;
        $vData = explode("-", $vData);
        if (strlen($vData[1]) == 1) {
            $vData[1] = "0" . $vData[1];
        }
        if (strlen($vData[0]) == 1) {
            $vData[0] = "0" . $vData[0];
        }
        if (strlen($vData[2]) > 4) {
            $vTimeAux = explode(" ", $vData[2]);
            $vTime = explode(":", $vTimeAux[1]);
            $vData[2] = $vTimeAux[0];
            if ($vTime[2] != "") {
                return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
            } else {
                $vTime[2] = "00";
                return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
            }
        } else {
            return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . "'";
        }
    }
}
/**
 * Descri��o:  RETORNA A DATA
 */
function FormataDataConsulta($vData) {
//return variant_date_to_timestamp($vData);
    if ($vData == "")
        return false;
    $vData = ereg_replace("/", "-", $vData);
    $vData = trim($vData);
    $pos = strpos($vData, "-");
    if ($pos === 2) {
        $vXchange = explode("-", $vData);
        $vXchangeAux = explode(" ", $vXchange[2]);
        $vData = $vXchangeAux[0] . "-" . $vXchange[1] . "-" . $vXchange[0] . " " . $vXchangeAux[1];
    }
    if (strstr($vData, '-')) {
        $vTime = null;
        $vData = explode("-", $vData);
        if (strlen($vData[1]) == 1) {
            $vData[1] = "0" . $vData[1];
        }
        if (strlen($vData[0]) == 1) {
            $vData[0] = "0" . $vData[0];
        }
        if (strlen($vData[2]) > 4) {
            $vTimeAux = explode(" ", $vData[2]);
            $vTime = explode(":", $vTimeAux[1]);
            $vData[2] = $vTimeAux[0];
            if ($vTime[2] != "") {
                return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
            } else {
                $vTime[2] = "00";
                return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1] . ":" . $vTime[2] . "'";
            }
        } else {
            return "'" . $vData[0] . "-" . $vData[1] . "-" . $vData[2] . "'";
        }
    }
}
/**
 * Descri��o: RETORNA A HORA DE UMA DATA/HORA
 */
function FormataHora($vData) {
    if ($vData == "")
        return false;
    $vData = ereg_replace("-", "/", $vData);
    $pos = strpos($vData, "/");
    if ($pos === 2) {
        $vXchange = explode("/", $vData);
        $vXchangeAux = explode(" ", $vXchange[2]);
        $vData = $vXchangeAux[0] . "/" . $vXchange[1] . "/" . $vXchange[0] . " " . $vXchangeAux[1];
    }
    $vTime = null;
    $vData = explode("/", $vData);
    if (strlen($vData[1]) == 1) {
        $vData[1] = "0" . $vData[1];
    }
    if (strlen($vData[0]) == 1) {
        $vData[0] = "0" . $vData[0];
    }
    if (strlen($vData[2]) > 4) {
        $vTimeAux = explode(" ", $vData[2]);
        $vTime = explode(":", $vTimeAux[1]);
        $vData[2] = $vTimeAux[0];
        return $vTime[0] . ":" . $vTime[1];
    }
}
/**
 * Descri��o: RETONRA A DATA E A HORA
 */
function FormataDataHora($vData) {
    if ($vData == "")
        return false;
    $vData = ereg_replace("-", "/", $vData);
    $pos = strpos($vData, "/");
    if ($pos === 2) {
        $vXchange = explode("/", $vData);
        $vXchangeAux = explode(" ", $vXchange[2]);
        $vData = $vXchangeAux[0] . "/" . $vXchange[1] . "/" . $vXchange[0] . " " . $vXchangeAux[1];
    }
    $vTime = null;
    $vData = explode("/", $vData);
    if (strlen($vData[1]) == 1) {
        $vData[1] = "0" . $vData[1];
    }
    if (strlen($vData[0]) == 1) {
        $vData[0] = "0" . $vData[0];
    }
    if (strlen($vData[2]) > 4) {
        $vTimeAux = explode(" ", $vData[2]);
        $vTime = explode(":", $vTimeAux[1]);
        $vData[2] = $vTimeAux[0];
        return $vData[2] . "/" . $vData[1] . "/" . $vData[0] . " " . $vTime[0] . ":" . $vTime[1];
    } else {
        return $vData[2] . "/" . $vData[1] . "/" . $vData[0];
    }
}
/**
 * Descri��o: RETONRA A DATA E A HORA
 */
function FormataDataHoraConsulta($vData) {
    if ($vData == "")
        return false;
    $vData = ereg_replace("-", "/", $vData);
    $pos = strpos($vData, "/");
    if ($pos === 2) {
        $vXchange = explode("/", $vData);
        $vXchangeAux = explode(" ", $vXchange[2]);
        $vData = $vXchangeAux[0] . "/" . $vXchange[1] . "/" . $vXchange[0] . " " . $vXchangeAux[1];
    }
    $vTime = null;
    $vData = explode("/", $vData);
    if (strlen($vData[1]) == 1) {
        $vData[1] = "0" . $vData[1];
    }
    if (strlen($vData[0]) == 1) {
        $vData[0] = "0" . $vData[0];
    }
    if (strlen($vData[2]) > 4) {
        $vTimeAux = explode(" ", $vData[2]);
        $vTime = explode(":", $vTimeAux[1]);
        $vData[2] = $vTimeAux[0];
        return $vData[0] . "/" . $vData[1] . "/" . $vData[2] . " " . $vTime[0] . ":" . $vTime[1];
    } else {
        return $vData[0] . "/" . $vData[1] . "/" . $vData[2];
    }
}
/**
 * Descri��o: formata valor para a grava��o [ formato XXX,XX ]
 */
function FormataValorGravacao($valor) {

    if (trim($valor) == "") {
        return "null";
    } else {
        return str_replace(",", ".", str_replace(".", "", $valor));
    }
}
/**
 * Descri��o: formata numero para a grava��o.
 */
function FormataNumeroGravacao($valor) {

    if (trim($valor) == "") {
        return "null";
    } else {
        return str_replace(",", ".", str_replace(".", "", $valor));
    }
}
/**
 * Descri��o: Criptografar senha.
 */
function Criptografa($strSenha) {

    for ($intContador = 0; $intContador < strlen($strSenha); $intContador++) {
        $strAux .=chr(ord(substr($strSenha, $intContador, 1)) + $intContador);
    }
    return $strAux;
}
/**
 * Descri��o: Descriptografar senha.
 */
function Descriptografa($strSenha) {
    for ($intContador = 0; $intContador < strlen($strSenha); $intContador++) {
        $strAux .= chr(ord(substr($strSenha, $intContador, 1)) - $intContador);
    }
    return $strAux;
}
/**
 * Descri��o: RETORNAR O NOME DO M�S.
 */
function RetornaMes($nMes) {
    switch ($nMes){
        case 1: return "Janeiro"; break;
        case 2: return "Fevereiro";break;
        case 3: return "Mar�o";break;
        case 4: return "Abril";break;
        case 5: return "Maio";break;
        case 6: return "Junho";break;
        case 7: return "Julho";break;
        case 8: return "Agosto";break;
        case 9: return "Setembro";break;
        case 10:return "Outubro";break;
        case 11:return "Novembro";break;
        case 12:return "Dezembro";break;
    }
}
/**
 * Descri��o: Monta selects com os dados.
 */
function montaCombo($oResultset, $indiceValue, $indiceLabel, $indiceSelecionado = null, $incluirOptVazia = false) {
    if (!is_null($oResultset)) {
        if ($incluirOptVazia) {
            echo '<option value="null"></option>' . chr(13);
        }
        if ($indiceSelecionado != null) {
            for ($i = 0; $i < $oResultset->getCount(); $i++) {?>
                <?='<option value="' . $oResultset->getValores($i, $indiceValue) . '"' ?><? if ($oResultset->getValores($i, $indiceValue) == $indiceSelecionado) {
                echo ' selected="selected"';
                } ?><?= ">" ?><?= $oResultset->getValores($i, $indiceLabel) . "</option>" . chr(13) ?>
        <?}
        } else {
            for ($i = 0; $i < $oResultset->getCount(); $i++) {?>
                <?= '<option value="' . $oResultset->getValores($i, $indiceValue) . '">' ?><?= $oResultset->getValores($i, $indiceLabel) . "</option>" . chr(13) ?>
            <?
            }
        }
    }
}
/**
 * Descri��o: Monta um select com os hor�rios fixos
 * @author Fabricio Nogueira
 * Data: 30/10/2010
 */
function selectHorariosFixos($horarioInicial, $horarioFinal, $incluirOptVazia=false){
    if($incluirOptVazia)
        echo '<option value="nulo"></option>' . chr(13);
    for($i=$horarioInicial, $j=($horarioInicial+1);$i<$horarioFinal;$i++, $j++)
        echo '<option value="['.$i.'|'.$j.']">'.$i.':00 �s '.$j.':00</option>';
}
/**
 * Descri��o: Monta tabela com horarios
 * @author Fabricio Nogueira
 * Data: 05/11/2010
 */
function montaTabelaHorariosFixos($numrSemana,$id){
    echo'<table border="0" cellpadding="0" cellspacing="0" width="100%" id="'.$id.'">';
        echo'<thead><th align="left" colspan="4"><input type="checkbox" id="ckTodos'.$id.'" /><label for="ckTodos'.$id.'">Selecionar Todos os hor�rios</label></th></thead>';
        echo'<tbody><tr>';
            for($i=8,$j=9,$l=0;$j<23;$i++,$j++,$l++){
                echo'<td><input type="checkbox" class="borda" name="'.$numrSemana.'[]" id="horarioSemana'.$i.'-'.$j.''.$numrSemana.'" value="'.$i.'|'.$j.'" /><label for="horarioSemana'.$i.'-'.$j.''.$numrSemana.'">'.$i.':00 �s '.$j.':00</label></td>';
            if($l%4==3){echo'</tr><tr>';}}
        echo'<tbody>';
    echo'</table>';
}
/**
 * Descri��o: monta select com check
 */
function montaComboCheck($oResultset, $idName, $indiceValue, $indiceLabel, $selecionados) {
    if (!empty($oResultset)) {
        if (empty($selecionados)) {
            for ($i = 0; $i < $oResultset->getCount(); $i++) {
                echo '<input type="checkbox" id="' . $idName . $i . '" name="' . $idName . $i . '" value="' . $oResultset->getValores($i, $indiceValue) . '"';

                echo ' /><label for="' . $idName . $i . '">' . $oResultset->getValores($i, $indiceLabel) . '</label><br />';
            }
        } else {
            for ($i = 0; $i < $oResultset->getCount(); $i++) {
                echo '<input type="checkbox" id="' . $idName . $i . '" name="' . $idName . $i . '" value="' . $oResultset->getValores($i, $indiceValue) . '"';

                if (is_array($selecionados)) {
                    if (in_array($oResultset->getValores($i, $indiceValue), $selecionados))
                        echo 'checked="checked"';
                } else {
                    if ($oResultset->getValores($i, $indiceValue) == $selecionados)
                        echo 'checked="checked"';
                }

                echo ' /><label for="' . $idName . $i . '">' . $oResultset->getValores($i, $indiceLabel) . '</label><br />';
            }
        }
    }
}
/**
 * Descri��o: fun��o para debugar arrays , parametro exit opcional.
 */
function print_pre($array, $exit=null) {
?><pre><? print_r($array); $exit != null ? exit : "";
}
/**
 * Descri��o: monta option fill.
 */
function optionFill($class, $function, $value, $name, $selecionar, $complemento = null) {
    require_once('classes/Resultset.php');
    require_once('classes/' . $class . '.php');
    $oClass = new $class();
    $return = $oClass->$function($complemento);
    for ($i = 0; $i < $return->getCount(); $i++) {
        $selected = ($return->getValores($i, $value) == $selecionar ) ? 'selected="selected"' : '';
        ?><option value="<?= $return->getValores($i, $value); ?>" <?= $selected; ?>><?= $return->getValores($i, $name); ?></option><?
    }
}
/**
 * Descri��o: monta option fill com estados.
 */
function optionFillEstado($selecionar) {
    $uf = array('AL' => 'Alagoas',
        'AC' => 'Acre',
        'AP' => 'Amap�',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Cear�',
        'DF' => 'Distrito Federal',
        'ES' => 'Esp�rito Santo',
        'GO' => 'Goi�s',
        'MA' => 'Maranh�o',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Par�',
        'PB' => 'Para�ba',
        'PR' => 'Paran�',
        'PE' => 'Pernambuco',
        'PI' => 'Piau�',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rond�nia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'S�o Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'
    );
    $array = array_keys($uf);
    for ($i = 0; $i < sizeof($array); $i++) {
        $selected = ($selecionar == $array[$i]) ? 'selected="selected"' : '';
        ?><option value="<?= $array[$i] ?>" <?= $selected; ?>><?= $uf[$array[$i]] ?></option><?php
    }
}
/**
 * Descri��o: fun��o espera um array para fazer options
 * @param array $array
 * @param int $selecionar
 */
function optionArray($array, $selecionar = null) {
    foreach ($array as $key => $value) {
        $selected = ($selecionar == $key) ? 'selected="selected"' : '';
        ?><option value="<?= $key ?>" <?= $selected ?>><?= $value ?></option><?php
    }
}
/**
 *
 * Descri��o: Escreve o valor por extenso.<br>
 * @uses valrExtenso( 12345678.90, "real", "reais", "centavo", "centavos" ) ;
 * @author Jairo Raiol - Adapta��o: Fabricio Nogueira.
 * @copyright OpenSource
 *
 */
function valrExtenso( $valor, $moedaSing, $moedaPlur, $centSing, $centPlur ) {
   $centenas = array( 0,
       array(0, "cento",        "cem"),
       array(0, "duzentos",     "duzentos"),
       array(0, "trezentos",    "trezentos"),
       array(0, "quatrocentos", "quatrocentos"),
       array(0, "quinhentos",   "quinhentos"),
       array(0, "seiscentos",   "seiscentos"),
       array(0, "setecentos",   "setecentos"),
       array(0, "oitocentos",   "oitocentos"),
       array(0, "novecentos",   "novecentos") ) ;
   $dezenas = array( 0,
            "dez",
            "vinte",
            "trinta",
            "quarenta",
            "cinquenta",
            "sessenta",
            "setenta",
            "oitenta",
            "noventa" ) ;
   $unidades = array( 0,
            "um",
            "dois",
            "tr�s",
            "quatro",
            "cinco",
            "seis",
            "sete",
            "oito",
            "nove" ) ;
   $excecoes = array( 0,
            "onze",
            "doze",
            "treze",
            "quatorze",
            "quinze",
            "dezeseis",
            "dezesete",
            "dezoito",
            "dezenove" ) ;
   $extensoes = array( 0,
       array(0, "",       ""),
       array(0, "mil",    "mil"),
       array(0, "milh�o", "milh�es"),
       array(0, "bilh�o", "bilh�es"),
       array(0, "trilh�o","trilh�es") ) ;
   $valorForm = trim( number_format($valor,2,".",",") ) ;
   $inicio    = 0 ;
   if ( $valor <= 0 ) {
      return ( $valorExt ) ;
   }
   for ( $conta = 0; $conta <= strlen($valorForm)-1; $conta++ ) {
      if ( strstr(",.",substr($valorForm, $conta, 1)) ) {
         $partes[] = str_pad(substr($valorForm, $inicio, $conta-$inicio),3," ",STR_PAD_LEFT) ;
         if ( substr($valorForm, $conta, 1 ) == "." ) {
            break ;
         }
         $inicio = $conta + 1 ;
      }
   }
   $centavos = substr($valorForm, strlen($valorForm)-2, 2) ;
   if ( !( count($partes) == 1 and intval($partes[0]) == 0 ) ) {
      for ( $conta=0; $conta <= count($partes)-1; $conta++ ) {
         $centena = intval(substr($partes[$conta], 0, 1)) ;
         $dezena  = intval(substr($partes[$conta], 1, 1)) ;
         $unidade = intval(substr($partes[$conta], 2, 1)) ;
         if ( $centena > 0 ) {
            $valorExt .= $centenas[$centena][($dezena+$unidade>0 ? 1 : 2)] . ( $dezena+$unidade>0 ? " e " : "" ) ;
         }
         if ( $dezena > 0 ) {
            if ( $dezena>1 ) {
               $valorExt .= $dezenas[$dezena] . ( $unidade>0 ? " e " : "" ) ;
            } elseif ( $dezena == 1 and $unidade == 0 ) {
               $valorExt .= $dezenas[$dezena] ;
            } else {
               $valorExt .= $excecoes[$unidade] ;
            }
         }
         if ( $unidade > 0 and $dezena != 1 ) {
            $valorExt .= $unidades[$unidade] ;
         }
         if ( intval($partes[$conta]) > 0 ) {
            $valorExt .= " " . $extensoes[(count($partes)-1)-$conta+1][(intval($partes[$conta])>1 ? 2 : 1)] ;
         }
         if ( (count($partes)-1) > $conta and intval($partes[$conta])>0 ) {
            $conta3 = 0 ;
            for ( $conta2 = $conta+1; $conta2 <= count($partes)-1; $conta2++ ) {
               $conta3 += (intval($partes[$conta2])>0 ? 1 : 0) ;
            }
            if ( $conta3 == 1 and intval($centavos) == 0 ) {
               $valorExt .= " e " ;
            } elseif ( $conta3>=1 ) {
               $valorExt .= ", " ;
            }
         }
      }
      if ( count($partes) == 1 and intval($partes[0]) == 1 ) {
         $valorExt .= $moedaSing ;
      } elseif ( count($partes)>=3 and ((intval($partes[count($partes)-1]) + intval($partes[count($partes)-2]))==0) ) {
         $valorExt .= " de " + $moedaPlur ;
      } else {
         $valorExt = trim($valorExt) . " " . $moedaPlur ;
      }
   }
   if ( intval($centavos) > 0 ) {
      $valorExt .= (!empty($valorExt) ? " e " : "") ;
      $dezena  = intval(substr($centavos, 0, 1)) ;
      $unidade = intval(substr($centavos, 1, 1)) ;
      if ( $dezena > 0 ) {
         if ( $dezena>1 ) {
            $valorExt .= $dezenas[$dezena] . ( $unidade>0 ? " e " : "" ) ;
         } elseif ( $dezena == 1 and $unidade == 0 ) {
            $valorExt .= $dezenas[$dezena] ;
         } else {
            $valorExt .= $excecoes[$unidade] ;
         }
      }
      if ( $unidade > 0 and $dezena != 1 ) {
         $valorExt .= $unidades[$unidade] ;
      }
      $valorExt .= " " . ( intval($centavos)>1 ? $centPlur : $centSing ) ;
   }
   return ( $valorExt ) ;
}
/**
 * Descri��o: Retorna o dia de uma data Formato (dd).
 * @author Fabricio Nogueira.
 * Data: 26/06/2010.
 */
function retornaDiaData($data){
    $dia = explode("/",strlen($data)>10?FormataData($data):(strlen($data)==10?$data:null));
    if($dia!=null)
        return $dia[0];
    else
        return false;
}
/**
 * Descri��o: Retorna o M�s de uma data Formato (mm).
 * @author Fabricio Nogueira.
 * Data: 26/06/2010.
 */
function retornaMesData($data){
    $mes = explode("/",strlen($data)>10?FormataData($data):(strlen($data)==10?$data:null));
    if($mes!=null)
        return $mes[1];
    else
        return false;
}
/**
 * Descri��o: Retorna o Ano de uma data Formato (yyyy).
 * @author Fabricio Nogueira.
 * Data: 26/06/2010.
 */
function retornaAnoData($data){
    $ano = explode("/",strlen($data)>10?FormataData($data):(strlen($data)==10?$data:null));
    if($ano!=null)
        return $ano[2];
    else
        return false;
}
/**
 * Descri��o: Escreve o nome do m�s por extenso.
 * @author Fabricio Nogueira.
 * Data: 27/10/2010
 */
function escreveNomeMesPorExtenso($mes){
    switch($mes){
        case 1:return "Janeiro";break;
        case 2:return "Fevereiro";break;
        case 3:return "Mar�o";break;
        case 4:return "Abril";break;
        case 5:return "Maio";break;
        case 6:return "Junho";break;
        case 7:return "Julho";break;
        case 8:return "Agosto";break;
        case 9:return "Setembro";break;
        case 10:return "Outubro";break;
        case 11:return "Novembro";break;
        case 12:return "Dezembro";break;
        default:return "";
    } }
 /**
 * Descri��o: Gera URL gera�ao de graficos GOOGLE CHARTS.
 * @author Rodolfo Bueno.
 * Data: 16/11/2010
 */
function googleCharts( $largura, $altura, $tipo, $arrays, $titulo="", $seqCores="" ) {

    $base_url = "http://chart.apis.google.com/chart?";

    $base_url .= "chs=$largura"."x"."$altura";

    $tipos = array (
            'pizza' => 'p',
            'pizza3d' => 'p3',
            'linha' => 'lc',
            'onda' => 'ls',
            'barra_h' => 'bhs',
            'barra_v' => 'bvs'
    );

    $base_url .= "&cht=".$tipos[$tipo];

    $base_url .= ($titulo=="") ? "" : "&chtt=".urlencode($titulo);

    foreach ( $arrays as $nome => $valor ) {

        if($valor != ""){
            $chd[] = urlencode($valor);
            $chl[] = urlencode($nome." ($valor)");}

    }

    $base_url .= "&chd=t:".join(",",$chd);
    $base_url .= "&chl=".join("|",$chl);
    if($seqCores != ""){
    $base_url .= "&chco=".$seqCores; }
    return $base_url;
}