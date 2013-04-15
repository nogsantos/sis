<?php
/**
 * Descrição: Classe de conexão ao banco de dados e execução de consultas SQL
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
require_once('Resultset.php');
class Oad {
    private static $oConexao;
    private static $vResult = array();
    /**
     * Descrição: abre uma conexão com o banco de dados.
     */
    static function conectar() {
    /**
     * Banco desenvolvimento
     */
//    $sHost = "postgresql03.tocandoasnacoes.com.br";
//    $sUser = "tocandoasnacoes7";
//    $sSenha = "net2161";
//    $sBd = "tocandoasnacoes7";
//    $sPorta = 5432;
    /**
     * Banco testes
     */
     /*$sHost = "postgresql05.tocandoasnacoes.com.br";
    $sUser = "tocandoasnacoes9";
    $sSenha = "Net2161";
    $sBd = "tocandoasnacoes9";
    $sPorta = 5432;*/
    /**
     * Banco Local
     */
    $sHost = "127.0.0.1";
    $sUser = "tocandoasnacoes7";
    $sSenha = "net2161";
    $sBd = "tocandoasnacoes7";
    $sPorta = 5432;
        if (!(self::$oConexao = @pg_connect("host=$sHost port=$sPorta dbname=$sBd user=$sUser password=$sSenha"))) {
            throw new Exception("Erro ao conectar no banco de dados do sistema.ß");
        }
    }
    /**
     * Descrição: Fecha a conexão com o banco de dados.
     */
    static function desconectar() {
        if (!(@pg_close())) {
            throw new Exception("Erro ao fechar o banco de dados do sistema.ß");
        }
    }
    /**
     * Descrição: executa uma query SQL no banco de dados.
     */
    static function executar($sQuery) {
        if (!@pg_query(self::$oConexao, $sQuery)) {
            throw new Exception('Query: ' . $sQuery . ' ' . pg_last_error(self::$oConexao));
        }
    }
    /**
     * Descrição: busca os dados no banco e armazena em um vetor.
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
     * Descrição: inicia uma transação com o banco de dados.
     */
    static function begin() {
        self::executar("BEGIN");
    }
    /**
     * Descrição: confirma uma transação com o banco de dados.
     */
    static function commit() {
        self::executar("COMMIT");
    }
    /**
     * Descrição: desfaz uma transação com o banco de dados.
     */
    static function rollback() {
        self::executar("ROLLBACK");
    }
}