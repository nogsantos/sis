<?php

/**
 * Descri��o: Model Cadastro de Logs.
 * @author Rodolfo Bueno.
 * @release
 * Data 26/09/2010
 */
class Log {

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
    private $numgLog;
    private $descFormulario;
    private $descricao;
    private $descTipoAcao;
    private $dataCadastro;
    private $descUsuario;


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
     * Descri��o: Set and Get n�mero gerado do log.
     */
    public function setNumgLog($numgLog) {
        if (is_numeric($numgLog)) {
            $this->numgLog = $numgLog;
        } else {
            $this->oErro->addErro("N� identificador do Log inv�lido.�");
        }
    }

    public function getNumgLog() {
        return $this->numgLog;
    }

    /**
     * Descri��o: Set and Get nome do Formul�rio.
     */
    public function setDescFormulario($descFormulario) {
        if (trim($descFormulario) != "") {
            $this->descFormulario = $descFormulario;
        } else {
            $this->oErro->addErro("Descri��o do formul�rio inv�lida!.�");
        }
    }

    public function getDescFormulario() {
        return $this->descFormulario;
    }

    /**
     * Descri��o: Set and Get descri�ao da acao.
     */
    public function setDescricao($descricao) {
        if (trim($descricao) != "") {
            $this->descricao = $descricao;
        } else {
            $this->oErro->addErro("Descri��o do log inv�lida.�");
        }
    }

    public function getDescricao() {
        return $this->descricao;
    }

     /**
     * Descri��o: Set and Get tipo da A�ao.
     */
    public function setDescTipoAcao($tipoAcao) {
        if (trim($tipoAcao) != "") {
            $this->descTipoAcao = $tipoAcao;
        } else {
            $this->oErro->addErro("Descri��o da A��o inv�lida.�");
        }
    }

    public function getDescTipoAcao() {
        return $this->descTipoAcao;
    }

    /**
     * Descri��o: Set and Get data de cadastro da Log.
     */
    public function setDataCadastro($dataCad) {
        $this->dataCadastro = $dataCad;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Descri��o: Set and Get nome do operador de cadastro da Log.
     */
    public function setDescUsuario($nomeUsuario) {
        if (trim($nomeUsuario) != "") {
            $this->descUsuario = $nomeUsuario;
        } else {
            $this->oErro->addErro("Nome do usu�rio inv�lido.�");
        }
    }

    public function getDescUsuario() {
        return $this->descUsuario;
    }

    /*     * **************************************************************************** */
    /*                       Cadastros e A��es Diversas                            */
    /*     * **************************************************************************** */

    /**
     * Descri��o: cadastra os dados de uma Log.
     * @author Rodolfo Bueno.
     * Data: 13/11/2010.
     */
    public function cadastrar($numgModulo, $nomeFormulario, $descricao, $acao, $nomeUsuario) {
        $this->Oad->conectar();
    //    $this->pValidaGravacao();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " INSERT INTO se_logs (numg_modulo, desc_formulario, descricao, desc_tipoacao, datahora_cadastro, data_cadastro, desc_usuario) values (";
            $this->sSql .= FormataNumeroGravacao($numgModulo) . ",";
            $this->sSql .= FormataStr($nomeFormulario) . ",";
            $this->sSql .= FormataStr($descricao) . ",";
            $this->sSql .= FormataStr($acao) . ",";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= FormataStr($nomeUsuario) . ")";
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->sSqlAux = $this->Oad->consultar("select max(numg_log) from se_logs");
                $this->setNumgLog($this->sSqlAux->getValores(0, max));
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Log.cadastrar(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        $this->Oad->desconectar();
        return true;
    }

    /**
     * Descri��o: gerar relat�rio
     * @author Rodolfo Bueno.
     * Data: 03/10/2010.
     */
    public function relatorioLogs($array) {
        $this->sSql = "select numg_log, desc_formulario, descricao, desc_tipoacao, data_cadastro, datahora_cadastro, desc_usuario";
        $this->sSql .= " from se_logs where numg_log is not null";

        if ($array[codgFormulario] != "") {
            $this->sSql .=" and lower(desc_formulario) like '%" . strtolower($array[codgFormulario]) . "%'";
        }

        if ($array[acao] != "") {
            $this->sSql .=" and lower(desc_tipoacao) like '%" . strtolower($array[acao]) . "%'";
        }

        if ($array[codgModulo] != "" && $array[codgModulo] != "nulo") {
            $this->sSql .=" and numg_modulo = " . $array[codgModulo];
        }
        
        if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
            $this->sSql .=" and data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
        } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
        } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
        }

        $this->sSql .= " order by ". $array[ordem] ." ". $array[ordemTipo];

        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Log.gerar(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

   
    /**
     * Descri��o: Destrutor.
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
