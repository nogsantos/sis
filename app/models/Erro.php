<?php
/**
 * Descri��o: Modelo com a gera��o dos erros.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 01/08/2010
 */
class Erro {
    private static $sErros = null;
    private static $vErros = null;
    /**
     * Descri��o: Seta os erros na se��o.
     */
    static function setaErro() {
        $_SESSION['erros'] = self::$sErros;
    }
    /**
     * Descri��o: Gera os erros.
     */
    static function geraErro() {
        self::$vErros = split("�", $_SESSION['erros']);
        for ($i = 0; $i < count(self::$vErros); $i++) {
            if (self::$vErros[$i] <> "") {
                $errcount = $i + 1;
                echo "0$errcount - " . self::$vErros[$i] . "<br>" . chr(13);
            }
        }
        $_SESSION['erros'] = null;
    }
    /**
     * Descri��o: Adiciona os erros na se��o.
     */
    static function addErro($sErro) {
        $_SESSION['erros'] .= $sErro;
    }
    /**
     * Descri��o: Limpa os erros da se��o.
     */
    static function limpaErro() {
        $_SESSION['erros'] = null;
    }
    /**
     * Descri��o: Verifica se h� erros na se��o.
     */
    static function isError() {
        if ($_SESSION['erros']){
            return true;
        }
    }
}