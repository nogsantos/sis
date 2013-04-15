<?php

/**
 * Descri��o: Model Cadastro de Modalidades.
 * @author Rodolfo Bueno.
 * @release
 * Data 26/09/2010
 */
class Modalidade {

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
    private $numgModalidade;
    private $nomeModalidade;
    private $valorModalidade;

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
     * Descri��o: Set and Get n�mero gerado do formul�rio [obrigat�rio].
     */
    public function setNumgModalidade($numgModalidade) {
        if (is_numeric($numgModalidade)) {
            $this->numgModalidade = $numgModalidade;
        } else {
            $this->oErro->addErro("N� identificador da Modalidade inv�lido.�");
        }
    }

    public function getNumgModalidade() {
        return $this->numgModalidade;
    }

    /**
     * Descri��o: Set and Get nome da Modalidade [obrigat�rio].
     */
    public function setNomeModalidade($nomeModalidade) {
        if (trim($nomeModalidade) != "") {
            $this->nomeModalidade = $nomeModalidade;
        } else {
            $this->oErro->addErro("Nome da Modalidade inv�lido.�");
        }
    }

    public function getNomeModalidade() {
        return $this->nomeModalidade;
    }

    /**
     * Descri��o: Set and Get nome do formul�rio [obrigat�rio].
     */
    public function setValorModalidade($valorModalidade) {
        if (trim($valorModalidade) != "") {
            $this->valorModalidade = $valorModalidade;
        } else {
            $this->oErro->addErro("Valor da Modalidade inv�lido.�");
        }
    }

    public function getValorModalidade() {
        return $this->valorModalidade;
    }

    /**
     * Descri��o: Set and Get data de cadastro da Modalidade.
     */
    public function setDataCadastro($dataCad) {
        $this->dataCadastro = $dataCad;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Descri��o: Set and Get operador de cadastro da Modalidade.
     */
    public function setNumgOperadorCad($numgOperador) {
        $this->numgOperadorCad = $numgOperador;
    }

    public function getNumgOperadorCad() {
        return $this->numgOperadorCad;
    }

    /**
     * Descri��o: Set and Get nome do operador de cadastro da Modalidade.
     */
    public function setNomeOperadorCad($nomeOperador) {
        $this->nomeOperadorCad = $nomeOperador;
    }

    public function getNomeOperadorCad() {
        return $this->nomeOperadorCad;
    }

    /**
     * Descri��o: Set and Get data de bloqueio da Modalidade
     */
    public function setDataBloqueio($dataBloqueio) {
        $this->dataBloqueio = $dataBloqueio;
    }

    public function getDataBloqueio() {
        return $this->dataBloqueio;
    }

    /**
     * Descri��o: Set and Get nome operador de bloqueio da Modalidade.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq) {
        $this->nomeOperadorBloq = $nomeOperadorBloq;
    }

    public function getNomeOperadorBloq() {
        return $this->nomeOperadorBloq;
    }

    /*     * **************************************************************************** */
    /*                       Cadastros e A��es Diversas                            */
    /*     * **************************************************************************** */

    /**
     * Descri��o: seta os dados de uma modalidade pelo seu n� identificador ou c�digo.
     * @author Fabricio Nogueira.
     * Data: 05/08/2010.
     */
    public function setarDadosFormulario($numgModalidade) {
        $this->sSql = " select mod.numg_modalidade, mod.desc_modalidade, mod.valr_modalidade,
                          mod.data_bloqueio, mod.data_cadastro, ope1.nome_operador as usuariocadastro,
                          ope2.nome_operador as usuariobloqueio";
        $this->sSql .= " from mu_modalidades mod";
        $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = mod.numg_usuariocadastro";
        $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = mod.numg_usuariobloqueio";
        $this->sSql .= " where numg_modalidade = " . $numgModalidade;
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.setarDadosFormulario(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
        if ($this->oResultset->getCount() > 0) {
            $this->numgModalidade = $this->oResultset->getValores(0, numg_modalidade);
            $this->nomeModalidade = $this->oResultset->getValores(0, desc_modalidade);
            $this->valorModalidade = $this->oResultset->getValores(0, valr_modalidade);
            $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
            $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
            $this->nomeOperadorCad = $this->oResultset->getValores(0, usuariocadastro);
            $this->nomeOperadorBloq = $this->oResultset->getValores(0, usuariobloqueio);
        }
        return true;
    }

    /**
     * Descri��o: cadastra os dados de uma modalidade.
     * @author Rodolfo Bueno.
     * Data: 26/09/2010.
     */
    public function cadastrar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " INSERT INTO mu_modalidades (desc_modalidade, valr_modalidade, data_cadastro, numg_usuariocadastro) values (";
            $this->sSql .= FormataStr($this->getNomeModalidade()) . ",";
            $this->sSql .= FormataValorGravacao($this->getValorModalidade()) . ",";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= $this->getNumgOperadorCad() . ")";
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->sSqlAux = $this->Oad->consultar("select max(numg_modalidade) from mu_modalidades");
                $this->setNumgModalidade($this->sSqlAux->getValores(0, max));
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Modalidade.cadastrar(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        $this->Oad->desconectar();
        return true;
    }

    /**
     * Descri��o: edita os dados de uma modalidade
     * @author Rodolfo Bueno
     * Data: 26/09/2010.
     */
    public function editar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if (Erro::isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " UPDATE mu_modalidades SET";
            $this->sSql .= " desc_modalidade=" . FormataStr($this->getNomeModalidade()) . ",";
            $this->sSql .= " valr_modalidade=" . FormataValorGravacao($this->getValorModalidade());
            $this->sSql .= " WHERE numg_modalidade = " . $this->getNumgModalidade();
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Modalidade.editar(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        return true;
    }

    /**
     * Descri��o: exclui a modalidade
     * @author Fabricio Nogueira.
     * Data: 05/08/2010.
     */
    public function excluir($numgModalidade) {
        $this->validarExclusao($numgModalidade);if ($this->oErro->isError()){return false;}
        else {
            $this->sSql = "DELETE FROM mu_modalidades WHERE numg_modalidade = " . $numgModalidade;
            try {
                $this->Oad->conectar();
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Modalidade.excluir(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        return true;
    }

    /**
     * Descri��o: Consulta todas modalidades cadastrados
     * @author Fabricio Nogueira.
     * Data: 05/08/2010.
     */
    public function consultarModalidades() {
        $this->sSql = " select m.numg_modalidade, m.desc_modalidade, m.valr_modalidade, m.data_bloqueio, m.numg_usuariobloqueio
                    from mu_modalidades m order by m.numg_modalidade";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.consultarModalidades(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }
    /**
     * Descri��o: Consulta todas modalidades cadastradas n�o bloqueadas.
     * @author Fabricio Nogueira.
     * Data: 30/10/2010.
     */
    public function consultarModalidadesNaoBloqueadas() {
        $this->sSql = " select m.numg_modalidade, m.desc_modalidade, m.valr_modalidade, m.data_bloqueio, m.numg_usuariobloqueio
                        from mu_modalidades m
                        where m.data_bloqueio is null
                        order by m.numg_modalidade";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.consultarModalidadesNaoBloqueadas(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: gerar relat�rio
     * @author Rodolfo Bueno.
     * Data: 03/10/2010.
     */
    public function consultaRelatorioModalidades($array, $ordem) {
        $this->sSql = "select numg_modalidade, desc_modalidade, valr_modalidade, data_bloqueio, numg_usuariobloqueio, data_cadastro";
        $this->sSql .= " from mu_modalidades where numg_modalidade is not null";
        if ($array[descModalidade] != "") {
            $this->sSql .=" and lower(desc_modalidade) like '%" . strtolower($array[descModalidade]) . "%'";
        }
        if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
            $this->sSql .=" and data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
        } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
        } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
        }
        if ($ordem == "desc") {
            $this->sSql .= " order by desc_modalidade";
        } else {
            $this->sSql .= " order by valr_modalidade";
        }
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.gerar(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: valida os dados de uma modalidade antes de cadastr�-lo ou edit�-lo
     * @author Rodolfo Bueno
     * Data: 26/09/2010
     */
    private function pValidaGravacao() {
        /**
         * nome_modalidade
         */
        if (trim($this->nomeModalidade) != "") {
            /**
             * SE FOR UMA INCLUS�O
             */
            if ($this->getNumgModalidade() == "") {
                /**
                 * VERIFICA SE J� EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
                 */
                if ($this->Oad->consultar("select numg_modalidade from mu_modalidades where lower(desc_modalidade) = lower('" . trim($this->getNomeModalidade()) . "')")->getCount() > 0)
                    $this->oErro->addErro("J� existe uma Modalidade cadastrada com o c�digo " . $this->nomeModalidade . ".�");
            }
        else {
            $oResAux = $this->Oad->consultar("select numg_modalidade from mu_modalidades where lower(desc_modalidade) = lower('" . trim($this->getNomeModalidade()) . "') and valr_modalidade = ".FormataValorGravacao($this->getValorModalidade())."");
            if ($oResAux->getCount() > 0) {
                /*
                 * Descri��o: SE O N� IDENTifICADOR FOR DifERENTE, SIGNifICA QUE J� EXISTE UM REGISTRO
                 *            COM NOME INFORMADO PARA EDI��O
                 *
                 */
                if ($oResAux->getValores(0, 0) != $this->numgFormulario) {
                    $this->oErro->addErro("J� existe uma Modalidade cadastrada com o c�digo " . $this->nomeModalidade . ".�"); }
                }
            }
        } 
    }

    public function bloquear($vDados) {
        $this->sSql = " UPDATE mu_modalidades SET";
        $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
        $this->sSql .= " numg_usuariobloqueio =" . $vDados[1];
        $this->sSql .= " WHERE numg_modalidade=" . $vDados[0];
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.bloquear(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: desbloqueia um formul�rio
     * @author Fabricio Nogueira.
     * Data: 05/08/2010.
     */
    public function desbloquear($numgModalidade) {
        $this->sSql = " UPDATE mu_modalidades SET";
        $this->sSql .= " data_bloqueio=null,";
        $this->sSql .= " numg_usuariobloqueio=null";
        $this->sSql .= " WHERE numg_modalidade=" . $numgModalidade;
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.desbloquear(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

        /**
     * Descri��o: Consulta -  Gr�ficos de Alunos
     * @author Rodolfo Bueno.
     * Data: 19/11/2010
     */
   public function geracaoGraficos($dataIni, $dataFin, $tipoGrafico) {
       if($tipoGrafico == "T"){
            $this->sSql = " select valr_modalidade, data_bloqueio ";
        } else if($tipoGrafico == 'V'){
            $this->sSql = " select valr_modalidade ";
        } else {
            $this->sSql = " select data_bloqueio ";
        }

        $this->sSql .= " from mu_modalidades where numg_modalidade is not null";
        if ($dataIni != null && $dataFin == null) {
            $this->sSql .=" and data_cadastro >= " . FormataDataConsulta($dataIni);
        } else if ($dataIni == null && $dataFin != null) {
            $this->sSql .=" and data_cadastro <= " . FormataDataConsulta($dataFin);
        } else if ($dataIni != null && $dataFin != null) {
            $this->sSql .=" and data_cadastro BETWEEN " . FormataDataConsulta($dataIni) . " and " . FormataDataConsulta($dataFin);
        }

        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.consultarModalidadesNaoBloqueadas(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: valida os dados de modalidade antes de exclui-la
     * @author Rodolfo Bueno.
     * Data: 26/09/2010.
     */
//private function pValidaExclusao($numgFormulario) {
    //   if ($this->Oad->consultar("select numg_funcao from se_funcoes where numg_formulario = " . $numgFormulario)->getCount() > 0)
    //      $this->oErro->addErro("Este formul�rio est� vinculado a alguma fun��o. N�o � poss�vel exclu�-lo.�");
//}

/**
 * Descri��o: Valida a exclus�o da modalidade via ajax.
 * @author Fabricio Nogueira.
 * Data: 15/12/2010
 */
public function validarExclusao($numgModalidade){
    $this->sSql = " select p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as professor
                    from mu_professoresmodalidades pm
                    join mu_professores pf on pf.numg_professor = pm.numg_professor
                    join ge_pessoas p on p.numg_pessoa = pf.numg_professor
                    where pm.numg_modalidade = {$numgModalidade}";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        if($this->oResultset->getCount()>0)
            return $this->oErro->addErro("A modalidade n�o pode ser exclu�da pois est� vinculada a um professor.");
        else
            return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Modalidade.validarExclusao(); Descri��o: " . $e->getMessage() . "�");
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
