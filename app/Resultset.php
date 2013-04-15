<?php
/**
 * Descri��o: Trabalhando com os atributos dos objetos.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 01/08/2010
 */
class Resultset {
    private $registros;
    private $linhas;
    private $colunas;
    private $resultados;
    /**
     * Descri��o: Setando os valores do objeto.
     */
    function setValores($linhas, $colunas, $vRegistro) {
        $this->resultados = $linhas;
        $this->linhas = $linhas;
        $this->colunas = $colunas;
        $this->registros = $vRegistro;
    }
    /**
     * Descri��o: Obtendo os valores do objeto, individualmente.
     */
    function getValores($linha, $coluna) {
        return $this->registros[$linha][$coluna];
    }
    /**
     * Descri��o: Obtendo todos os registros de um objeto.
     */
    function getRegistros() {
        return $this->registros;
    }
    /**
     * Descri��o: Contando todos os registros de um objeto.
     */
    function getCount() {
        return $this->resultados;
    }
}