<?php
/**
 * Descri��o: Classe de conex�o ao banco de dados e execu��o de consultas SQL
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 01/08/2010
 */
require_once('Resultset.php');
class Oad {
    private static $oConexao;
    private static $vResult = array();
    /**
     * Descri��o: abre uma conex�o com o banco de dados.
     */
    static function conectar() {
    /**
     * Banco Local
     */
    $sHost = "127.0.0.1";
    $sUser = "tocandoasnacoes";
    $sSenha = "123456";
    $sBd = "tocandoasnacoes";
    $sPorta = 5432;
        if (!(self::$oConexao = @pg_connect("host=$sHost port=$sPorta dbname=$sBd user=$sUser password=$sSenha"))) {
            throw new Exception("Erro ao conectar no banco de dados do sistema.�");
        }
    }
    /**
     * Descri��o: Fecha a conex�o com o banco de dados.
     */
    static function desconectar() {
        if (!(@pg_close())) {
            throw new Exception("Erro ao fechar o banco de dados do sistema.�");
        }
    }
    /**
     * Descri��o: executa uma query SQL no banco de dados.
     */
    static function executar($sQuery) {
        if (!@pg_query(self::$oConexao, $sQuery)) {
            throw new Exception('Query: ' . $sQuery . ' ' . pg_last_error(self::$oConexao));
        }
    }
    /**
     * Descri��o: busca os dados no banco e armazena em um vetor.
     */
    static function consultar($sQuery) {
        $result = new Resultset();
        if (!($vAux = @pg_query(self::$oConexao, $sQuery))) {
            throw new Exception('Query: ' . $sQuery . ' ' . pg_last_error(self::$oConexao));
        }
        $nRows = pg_numrows($vAux);
        $nCols = pg_numfields($vAux);
        if ($nRows > 0) {
            for ($i = 0; $i <= ($nRows - 1); $i++) {
                self::$vResult[$i] = $vAuxResult = pg_fetch_array($vAux);
            }
        }
        $result->setValores($nRows, $nCols, self::$vResult);
        return $result;
    }
    /**
     * Descri��o: inicia uma transa��o com o banco de dados.
     */
    static function begin() {
        self::executar("BEGIN");
    }
    /**
     * Descri��o: confirma uma transa��o com o banco de dados.
     */
    static function commit() {
        self::executar("COMMIT");
    }
    /**
     * Descri��o: desfaz uma transa��o com o banco de dados.
     */
    static function rollback() {
        self::executar("ROLLBACK");
    }
}
