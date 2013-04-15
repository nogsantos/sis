<?php
/**
 * Descrição: Trabalhando com os atributos dos objetos.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
class Resultset {
    private $registros;
    private $linhas;
    private $colunas;
    private $resultados;
    /**
     * Descrição: Setando os valores do objeto.
     */
    function setValores($linhas, $colunas, $vRegistro) {
        $this->resultados = $linhas;
        $this->linhas = $linhas;
        $this->colunas = $colunas;
        $this->registros = $vRegistro;
    }
    /**
     * Descrição: Obtendo os valores do objeto, individualmente.
     */
    function getValores($linha, $coluna) {
        return $this->registros[$linha][$coluna];
    }
    /**
     * Descrição: Obtendo todos os registros de um objeto.
     */
    function getRegistros() {
        return $this->registros;
    }
    /**
     * Descrição: Contando todos os registros de um objeto.
     */
    function getCount() {
        return $this->resultados;
    }
}