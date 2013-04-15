<?php

/**
 * Descrição: Cadastro de referências.
 * @author Rodolfo Bueno.
 * @release
 * Data 01/11/2010
 */
class referente {

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
    private $numgReferente;
    private $descReferente;
    private $descCodigo;

    /**
     * Construtor.
     * @author Rodolfo Bueno.
     * Data: 26/09/2010.
     */
    function __construct() {
        $oErro = new Erro();
        $Oad = new Oad();
        $oResultset = new Resultset();
        $this->Oad = $Oad;
        $this->oErro = $oErro;
        $this->oResultset = $oResultset;
    }

    /**
     * Descrição: Set and Get número gerado da referencia [obrigatório].
     */
    public function setNumgReferente($numgReferente) {
        if (is_numeric($numgReferente)) {
            $this->numgReferente = $numgReferente;
        } else {
            $this->oErro->addErro("N° identificador da Referência inválido.ß");
        }
    }

    public function getNumgReferente() {
        return $this->numgReferente;
    }

    /**
     * Descrição: Set and Get descrição da referencia [obrigatório].
     */
    public function setDescReferente($descReferente) {
        if (trim($descReferente) != "") {
            $this->descReferente = $descReferente;
        } else {
            $this->oErro->addErro("Descrição da referência inválida.ß");
        }
    }

    public function getDescReferente() {
        return $this->descReferente;
    }

    /**
     * Descrição: Set and Get código da referencia [obrigatório].
     */
    public function setDescCodigo($descCodigo) {
        if (trim($descCodigo) != "") {
            $this->descCodigo = $descCodigo;
        } else {
            $this->oErro->addErro("Código da Referência inválida.ß");
        }
    }

    public function getDescCodigo() {
        return $this->descCodigo;
    }

    /**
     * Descrição: Set and Get data de cadastro da Referencia.
     */
    public function setDataCadastro($dataCad) {
        $this->dataCadastro = $dataCad;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Descrição: Set and Get operador de cadastro da Referencia.
     */
    public function setNumgOperadorCad($numgOperador) {
        $this->numgOperadorCad = $numgOperador;
    }

    public function getNumgOperadorCad() {
        return $this->numgOperadorCad;
    }

    /**
     * Descrição: Set and Get nome do operador de cadastro da Referencia.
     */
    public function setNomeOperadorCad($nomeOperador) {
        $this->nomeOperadorCad = $nomeOperador;
    }

    public function getNomeOperadorCad() {
        return $this->nomeOperadorCad;
    }

    /**
     * Descrição: Set and Get data de bloqueio da Referencia.
     */
    public function setDataBloqueio($dataBloqueio) {
        $this->dataBloqueio = $dataBloqueio;
    }

    public function getDataBloqueio() {
        return $this->dataBloqueio;
    }

    /**
     * Descrição: Set and Get nome operador de bloqueio da Referencia.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq) {
        $this->nomeOperadorBloq = $nomeOperadorBloq;
    }

    public function getNomeOperadorBloq() {
        return $this->nomeOperadorBloq;
    }

    /*     * **************************************************************************** */
    /*                       Cadastros e Ações Diversas                            */
    /*     * **************************************************************************** */

    /**
     * Descrição: seta os dados de uma referencia pelo seu nº identificador ou código.
     * @author Rodolfo Bueno.
     * Data: 01/11/2010.
     */
    public function setarDadosReferencia($numgReferente) {
        $this->sSql = " select ref.numg_referente, ref.desc_codigo, ref.desc_referente, ref.data_bloqueio, ref.data_cadastro,
                        ope1.nome_operador as usuariocadastro, ope2.nome_operador as usuariobloqueio";
        $this->sSql .= " from fi_referente ref";
        $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = ref.numg_usuariocadastro";
        $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = ref.numg_usuariobloqueio";
        $this->sSql .= " where numg_referente = " . $numgReferente;
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Referente.setarDadosReferencia(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
        if ($this->oResultset->getCount() > 0) {
            $this->numgReferente = $this->oResultset->getValores(0, numg_referente);
            $this->descCodigo = $this->oResultset->getValores(0, desc_codigo);
            $this->descReferente = $this->oResultset->getValores(0, desc_referente);
            $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
            $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
            $this->nomeOperadorCad = $this->oResultset->getValores(0, usuariocadastro);
            $this->nomeOperadorBloq = $this->oResultset->getValores(0, usuariobloqueio);
        }
        return true;
    }

    /**
     * Descrição: cadastra os dados.
     * @author Rodolfo Bueno.
     * Data: 01/11/2010.
     */
    public function cadastrar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " INSERT INTO fi_referente (desc_codigo, desc_referente, data_cadastro, numg_usuariocadastro) values (";
            $this->sSql .= FormataStr($this->getDescCodigo()) . ",";
            $this->sSql .= FormataStr($this->getDescReferente()) . ",";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= $this->getNumgOperadorCad() . ")";
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->sSqlAux = $this->Oad->consultar("select max(numg_referente) from fi_referente");
                $this->setNumgReferente($this->sSqlAux->getValores(0, max));
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.referente.cadastrar(); Descrição: " . $e->getMessage() . "ß");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        $this->Oad->desconectar();
        return true;
    }

    /**
     * Descrição: edita os dados de uma referência.
     * @author Rodolfo Bueno
     * Data: 01/11/2010.
     */
    public function editar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if (Erro::isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " UPDATE fi_referente SET";
            $this->sSql .= " desc_codigo = ".FormataStr($this->getDescCodigo()).", desc_referente =" . FormataStr($this->getDescReferente());
            $this->sSql .= " WHERE numg_referente =" . $this->getNumgReferente();
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.referente.editar(); Descrição: " . $e->getMessage() . "ß");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        return true;
    }

    /**
     * Descrição: exclui a referência.
     * @author Rodolfo Bueno.
     * Data: 01/11/2010.
     */
    public function excluir($numgReferente) {
        $this->Oad->conectar();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = "DELETE FROM fi_referente WHERE numg_referente = " . $numgReferente;
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.referente.excluir(); Descrição: " . $e->getMessage() . "ß");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        return true;
    }

    /**
     * Descrição: busca as referências cadastradas.
     * @author Rodolfo Bueno.
     * Data: 01/11/2010.
     */
    public function consultarReferencias() {
        $this->sSql = " select numg_referente, desc_codigo, desc_referente, data_bloqueio, numg_usuariobloqueio
                    from fi_referente order by numg_referente";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.referente.consultarReferentes(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }

        /**
     * Descrição: busca as referências ATIVAS.
     * @author Rodolfo Bueno.
     * Data: 01/11/2010.
     */
    public function consultarReferenciasAtivas() {
        $this->sSql = " select numg_referente, desc_codigo, desc_referente
                    from fi_referente where data_bloqueio is null order by numg_referente";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.referente.consultarReferentes(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }

     /**
     * Descrição: busca as referências cadastradas.
     * @author Rodolfo Bueno.
     * Data: 24/10/2010.
     */
    public function consultarPorNumg($numgRef) {
        $this->sSql = " select desc_referente from fi_referente where numg_referente=".$numgRef;
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset->getRegistros();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.referente.consultarPorNumg(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descrição: gerar relatório
     * @author Rodolfo Bueno.
     * Data: 03/10/2010.
     */
//    public function consultaRelatorioreferentes($array, $ordem) {
//        $this->sSql = "select numg_referente, desc_referente, valr_referente, data_bloqueio, numg_usuariobloqueio, data_cadastro";
//        $this->sSql .= " from mu_referentes where numg_referente is not null";
//        if ($array[descreferente] != "") {
//            $this->sSql .=" and lower(desc_referente) like '%" . strtolower($array[descreferente]) . "%'";
//        }
//        if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
//            $this->sSql .=" and data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
//        } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
//            $this->sSql .=" and data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
//        } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
//            $this->sSql .=" and data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
//        }
//        if ($ordem == "desc") {
//            $this->sSql .= " order by desc_referente";
//        } else {
//            $this->sSql .= " order by valr_referente";
//        }
//        try {
//            $this->Oad->conectar();
//            $this->oResultset = $this->Oad->consultar($this->sSql);
//            $this->Oad->desconectar();
//            return $this->oResultset;
//        } catch (Exception $e) {
//            $this->oErro->addErro("Fonte: SGM.referente.gerar(); Descrição: " . $e->getMessage() . "ß");
//            $this->Oad->desconectar();
//            return false;
//        }
//    }


    /**
     * Descrição: Bloqueia uma referência.
     * @author Rodolfo Bueno.
     * Data: 24/10/2010.
     */
    public function bloquear($vDados) {
        $this->sSql = " UPDATE fi_referente SET";
        $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
        $this->sSql .= " numg_usuariobloqueio =" . $vDados[1];
        $this->sSql .= " WHERE numg_referente=" . $vDados[0];
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.referente.bloquear(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descrição: Desbloqueia uma referência.
     * @author Rodolfo Bueno.
     * Data: 24/10/2010.
     */
    public function desbloquear($numgReferente) {
        $this->sSql = " UPDATE fi_referente SET";
        $this->sSql .= " data_bloqueio = null,";
        $this->sSql .= " numg_usuariobloqueio = null";
        $this->sSql .= " WHERE numg_referente=" . $numgReferente;
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.referente.desbloquear(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descrição: valida os dados de uma referencia antes de cadastrá-lo ou editá-la
     * @author Rodolfo Bueno
     * Data: 02/11/2010
     */
    private function pValidaGravacao() {
        if (trim($this->descCodigo) != "") {
            /**
             * SE FOR UMA INCLUSÃO
             */
            if ($this->numgReferente == 0) {
                /**
                 * VERIFICA SE JÁ EXISTE ALGUM REGISTRO CADASTRADO COM A DESCRICAO INFORMADA
                 */
                if ($this->Oad->consultar("select numg_referente from fi_referente where lower(desc_codigo) = lower('" . trim($this->descCodigo) . "')")->getCount() > 0)
                    $this->oErro->addErro("Já existe uma Referência cadastrada com o código: " . $this->descCodigo . ".ß");
            } else {
            $oResAux = $this->Oad->consultar("select numg_referente from fi_referente where lower(desc_codigo) = lower('" . trim($this->descCodigo) . "') and numg_referente != ".$this->getNumgReferente());
            if ($oResAux->getCount() > 0) {
                /*
                 * Descrição: SE O Nº IDENTifICADOR FOR DIfERENTE, SIGNifICA QUE JÁ EXISTE UM REGISTRO
                 *            COM A DESCRICAO INFORMADA PARA EDIÇÃO
                 *
                 */
                if ($oResAux->getValores(0, 0) != $this->numgFormulario) {
                    $this->oErro->addErro("Já existe uma Referência cadastrada com o código: " . $this->descCodigo . ".ß");
                }
            }
          }
       }
    }
    
    /**
     * Descrição: Destrutor.
     */
    function __destruct() {
        unset($this->Oad);
        unset($this->oErro);
        unset($this->oResultset);
        unset($this->sSql);
        unset($this->sSqlAux);
        unset($this->sSqlAux2);
    }

}
