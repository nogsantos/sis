<?php
/**
 * Descrição: Modelo com a geração dos erros.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
class Erro {
    private static $sErros = null;
    private static $vErros = null;
    /**
     * Descrição: Seta os erros na seção.
     */
    static function setaErro() {
        $_SESSION['erros'] = self::$sErros;
    }
    /**
     * Descrição: Gera os erros.
     */
    static function geraErro() {
        self::$vErros = split("ß", $_SESSION['erros']);
        for ($i = 0; $i < count(self::$vErros); $i++) {
            if (self::$vErros[$i] <> "") {
                $errcount = $i + 1;
                echo "0$errcount - " . self::$vErros[$i] . "<br>" . chr(13);
            }
        }
        $_SESSION['erros'] = null;
    }
    /**
     * Descrição: Adiciona os erros na seção.
     */
    static function addErro($sErro) {
        $_SESSION['erros'] .= $sErro;
    }
    /**
     * Descrição: Limpa os erros da seção.
     */
    static function limpaErro() {
        $_SESSION['erros'] = null;
    }
    /**
     * Descrição: Verifica se há erros na seção.
     */
    static function isError() {
        if ($_SESSION['erros']){
            return true;
        }
    }
}