<?php
/**
 * Descrição: Model Municípios.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 28/08/2010
 */
class Municipio {
   /**
    * Parametros da classe
    */
    private $sSql;
    private $sSqlAux;
    private $sSqlAux2;
    protected $oErro;
    protected $Oad;
    protected $oResultset;
    /**
     * Paramentros
     */
    protected $numgMunicipio;
    protected $nomeMunicipio;
    protected $siglUf;
    protected $flagCapital;
    /**
    * Construtor.
    * @author Fabricio Nogueira.
    * Data: 27/08/2010.
    */
    function __construct(){
        $oErro = new Erro();
        $Oad = new Oad();
        $oResultset = new Resultset();
        $this->Oad = $Oad;
        $this->oErro = $oErro;
        $this->oResultset = $oResultset;
        $this->numgMunicipio = null;
        $this->nomeMunicipio = "";
        $this->siglUf = "";
        $this->flagCapital = 'f';
    }
    /**
     * Descrição: Set and Get
     */
    public function setNumgMunicipio($numgMunicipio) {
        if (is_numeric($numgMunicipio)) {
            $this->numgMunicipio = $numgMunicipio;
        } else {
            $this->oErro->addErro("Código de Município Inválido.ß");
        }
    }
    public function getNumgMunicipio(){return $this->numgMunicipio;}
    /**
     * Descrição: Set and Get
     */
    public function setNomeMunicipio($nomeMunicipio){
        if ($nomeMunicipio == "") {
            $this->oErro->addErro("Nome de Município Inválido.ß");
        } else {
            $this->nomeMunicipio = $nomeMunicipio;
        }
    }
    public function getNomeMunicipio(){return $this->nomeMunicipio;}
    /**
     * Descrição: Set and Get
     */
    public function setSiglUf($siglUf) {
        if (($siglUf == "") || (strlen($siglUf) > 2)) {
            $this->oErro->addErro("Unidade Federativa inválida.ß");
        } else {
            $this->siglUf = $siglUf;
        }
    }public function getSiglUf(){return $this->siglUf;}
    /**
     * Descrição: Set and Get
     */
    public function setFlagCapital($valor){
        if ($valor == "")
            $this->flagCapital = 'f';
        else
            $this->flagCapital = $valor;
    }
    public function getFlagCapital(){return $this->flagCapital;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descrição: Seta os dados pelo seu nº identificador
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function setarDadosMunicipio($nNumgMunicipio) {
    $this->sSql = "SELECT";
    $this->sSql .= " numg_municipio, nome_municipio, sigl_uf, flag_capital";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " WHERE";
    $this->sSql .= " numg_municipio = " . $nNumgMunicipio;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Municipio.setarDadosMunicipio()" . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    if($this->oResultset->getCount()>0){
        $this->numgMunicipio = $this->oResultset->getValores(0, numg_municipio);
        $this->nomeMunicipio = $this->oResultset->getValores(0, nome_municipio);
        $this->siglUf = $this->oResultset->getValores(0, sigl_uf);
        $this->flagCapital = $this->oResultset->getValores(0, flag_capital);
    }
    return true;
}
/**
 * Descrição: armazena os dados do municipio no banco de dados
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function cadastrar() {
    $this->sSql = " INSERT INTO ge_municipios";
    $this->sSql .= " (nome_municipio, sigl_uf, flag_capital)";
    $this->sSql .= " VALUES (";
    $this->sSql .= FormataStr($this->nomeMunicipio) . ",";
    $this->sSql .= FormataStr($this->siglUf) . ",";
    $this->sSql .= FormataBool($this->flagCapital) . ")";
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->numgMunicipio = $this->Oad->consultar("select max(numg_municipio) from ge_municipios")->getValores(0, max);
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.Municipio.cadastrar()" . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: atualiza os dados de um dado municipio no banco de dados.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function editar() {
    $this->sSql = " UPDATE ge_municipios SET";
    $this->sSql .= " nome_municipio = " . FormataStr($this->nomeMunicipio) . ",";
    $this->sSql .= " sigl_uf = " . FormataStr($this->siglUf) . ",";
    $this->sSql .= " flag_capital = " . FormataBool($this->flagCapital);
    $this->sSql .= " WHERE numg_municipio = " . $this->numgMunicipio;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        return true;
    } catch (Exception $e) {
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.Municipio.editar()" . $e->getMessage() . "ß");
        return false;
    }

}
/**
 * Descrição: exclui um municipio no banco de dados.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function excluir($numgMunicipio) {
    $this->sSql = "DELETE FROM ge_municipios";
    $this->sSql .= " WHERE";
    $this->sSql .= " numg_municipio = " . $numgMunicipio;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        return true;
    } catch (Exception $e) {
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.Municipio.excluir()" . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: retorna um Resultset contendo os dados encontrados na busca.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultarPorUf($siglUf) {
    $this->sSql = "SELECT ";
    $this->sSql .= " numg_municipio, nome_municipio, sigl_uf, flag_capital";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " WHERE lower(sigl_uf) = lower(" . FormataStr($siglUf) . ")";
    $this->sSql .= " ORDER BY flag_capital desc, nome_municipio";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    } catch (Exception $e) {
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.Municipio.consultarPorUf()" . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: retorna um Resultset contendo os dados encontrados na busca.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultarPorNome($nomeMunicipio) {
    $this->sSql = "SELECT";
    $this->sSql .= " numg_municipio, nome_municipio, sigl_uf";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " WHERE";
    $this->sSql .= " lower(nome_municipio) LIKE lower('%" . addslashes($nomeMunicipio) . "%')";
    $this->sSql .= " ORDER BY nome_municipio";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Municipio.consultarPorNome()" . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca os municípios pelo nome e uf informados.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultarPorNomeUf($sNomeMunicipio, $sSiglUf) {
    $this->sSql = "SELECT numg_municipio, nome_municipio, sigl_uf";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " WHERE lower(nome_municipio) LIKE lower('%" . addslashes($sNomeMunicipio) . "%') and lower(sigl_uf) = lower('" . $sSiglUf . "')";
    $this->sSql .= " ORDER BY nome_municipio";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Municipio.consultarPorNomeUf()" . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca os municípios cadastrados
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultarMunicipios() {
    $this->sSql = " SELECT numg_municipio, nome_municipio, sigl_uf, flag_capital";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " ORDER BY flag_capital desc, nome_municipio";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Municipio.consultarMunicipios()" . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca os municípios que são capitais
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultarCapitais() {
    $this->sSql = " SELECT numg_municipio, nome_municipio, sigl_uf";
    $this->sSql .= " FROM ge_municipios";
    $this->sSql .= " WHERE flag_capital = 't'";
    $this->sSql .= " ORDER BY sigl_uf, nome_municipio";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Municipio.consultarCapitais()" . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: valida os dados de um municipio antes de cadastrá-lo ou editá-lo.
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
private function pValidaGravacao() {
    /**
     * NOME_municipio
     */
    if (trim($this->nomeMunicipio) != "") {
        /**
         * SE FOR UMA INCLUSÃO
         */
        if ($this->numgMunicipio == 0) {
            /**
             * VERIFICA SE JÁ EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_municipio from ge_municipios where lower(nome_municipio) = lower('" . trim($this->nomeMunicipio) . "')")->getCount() > 0) {
                $this->oErro->addErro("Já existe um Municipio cadastrado com o nome " . $this->nomeMunicipio . ".ß");
            }
        } else {
            $oResAux = $this->Oad->consultar("select numg_municipio from ge_municipios where lower(nome_municipio) = lower('" . trim($this->nomeMunicipio) . "')");
            if ($oResAux->getCount() > 0) {
                /**
                 * SE O Nº IDENTifICADOR FOR DifERENTE, SIGNifICA QUE JÁ EXISTE UM REGISTRO COM NOME INFORMADO PARA EDIÇÃO
                 */
                if ($oResAux->getValores(0, 0) != $this->numgMunicipio) {
                    $this->oErro->addErro("Já existe um Municipio cadastrado com o nome " . $this->nomeMunicipio . ".ß");
                }
            }
        }
    }
}
private function pValidaExclusao($nNumgMunicipio){}
/**
 * Descrição: Destrutor.
 */
function __destruct(){
    unset($this->Oad);
    unset($this->oErro);
    unset($this->oResultset);
    unset($this->sSql);
    unset($this->sSqlAux);
    unset($this->sSqlAux2);
}
}