<?php
/**
 * Descrição: Model Cadastro de Modulos.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 01/08/2010
 */
class Modulo{
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
    private $numgModulo;
    private $codgModulo;
    private $descModulo;
    private $numgOperadorCad;
    private $nomeOperadorCad;
    private $dataBloqueio;
    private $dataCadastro;
    private $numgOperadorBloq;
    private $nomeOperadorBloq;
    private $numrOrdem;
    private $descNome;
   /**
    * Construtor.
    * @author Fabricio Nogueira.
    * Data: 01/08/2010.
    */
    function __construct(){
        $oErro = new Erro();
        $Oad = new Oad();
        $oResultset = new Resultset();
        $this->Oad = $Oad;
        $this->oErro = $oErro;
        $this->oResultset = $oResultset;
    }
    /**
     * Descrição: Set and Get número gerado do modulo [obrigatório].
     */
    public function setNumgModulo($numgModulo){
        if (is_numeric($numgModulo)) {
            $this->numgModulo = $numgModulo;
        } else {
            $this->oErro->addErro("N° identificador do módulo inválido.ß");
        }
    }
    public function getNumgModulo(){return $this->numgModulo;}
    /**
     * Descrição: Set and Get código do formulário [obrigatório].
     */
    public function setCodgModulo($codgModulo) {
        if (trim($codgModulo) != "") {
            $this->codgModulo = $codgModulo;
        } else {
            $this->oErro->addErro("Código do Módulo inválido.ß");
        }
    }
    public function getCodgModulo(){return $this->codgModulo;}
    /**
     * Descrição: Set and Get nome do formulário [obrigatório].
     */
    public function setDescNome($descNome) {
        if (trim($descNome) != "") {
            $this->descNome = $descNome;
        } else {
            $this->oErro->addErro("Nome inválido.ß");
        }
    }
    public function getDescNome(){return $this->descNome;}
    /**
     * Descrição: Set and Get descrição do formulário [obrigatório].
     */
    public function setDescModulo($descModulo) {
        if (trim($descModulo) != "") {
            $this->descModulo = $descModulo;
        } else {
            $this->oErro->addErro("Descrição do módulo inválida.ß");
        }
    }
    public function getDescModulo(){return $this->descModulo;}
    /**
     * Descrição Set and Get orderm de apresentação do modulo no menu.
     */
    public function setNumrOrdem($ordem) {
        if (is_numeric($ordem)){
            $this->numrOrdem = $ordem;
        } else {
            $this->oErro->addErro("Ordem de apresentação do formulário inválida.ß");
        }
    }
    public function getNumrOrdem(){return $this->numrOrdem;}
    /**
     * Descrição: Set and Get data de cadastro.
     */
    public function setDataCadastro($dataCad){$this->dataCadastro = $dataCad;}
    public function getDataCadastro(){return $this->dataCadastro;}
    /**
     * Descrição: Set and Get operador de cadastro do formulário.
     */
    public function setNumgOperadorCad($numgOperador){$this->numgOperadorCad = $numgOperador;}
    public function getNumgOperadorCad(){return $this->numgOperadorCad;}
    /**
     * Descrição: Set and Get operador de bloqueio.
     */
    public function setNumgOperadorbloq($numgOperador){$this->numgOperadorBloq = $numgOperador;}
    public function getNumgOperadorbloq(){return $this->numgOperadorBloq;}
    /**
     * Descrição: Set and Get nome do operador de cadastro.
     */
    public function setNomeOperadorCad($nomeOperador){$this->nomeOperadorCad = $nomeOperador;}
    public function getNomeOperadorCad(){return $this->nomeOperadorCad;}
    /**
     * Descrição: Set and Get data de bloqueio.
     */
    public function setDataBloqueio($dataBloqueio){$this->dataBloqueio = $dataBloqueio;}
    public function getDataBloqueio(){return $this->dataBloqueio;}
    /**
     * Descrição: Set and Get nome operador de bloqueio.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq){$this->nomeOperadorBloq = $nomeOperadorBloq;}
    public function getNomeOperadorBloq(){return $this->nomeOperadorBloq;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descrição: seta os dados.
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function setarDados($numgModulo){
    $this->sSql = " SELECT m.numg_modulo, m.codg_modulo, m.desc_modulo, m.numg_operadorcad, m.data_bloqueio,
                           m.data_cadastro, m.numg_operadorbloq, m.numr_ordem,
                           ope1.nome_operador, ope2.nome_operador as operadorbloq, desc_nome";
    $this->sSql .= " FROM se_modulos m";
    $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = m.numg_operadorCad";
    $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = m.numg_operadorBloq";
    $this->sSql .= " where numg_modulo = " . $numgModulo;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: Modulo.setarDadosFormulario(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    if ($this->oResultset->getCount() > 0) {
        $this->numgModulo = $this->oResultset->getValores(0, numg_modulo);
        $this->codgModulo = $this->oResultset->getValores(0, codg_modulo);
        $this->descModulo = $this->oResultset->getValores(0, desc_modulo);
        $this->numrOrdem = $this->oResultset->getValores(0, numr_ordem);
        $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
        $this->nomeOperadorCad = $this->oResultset->getValores(0, nome_operador);
        $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
        $this->nomeOperadorBloq = $this->oResultset->getValores(0, operadorbloq);
        $this->descNome = $this->oResultset->getValores(0, desc_nome);
    }
    return true;
}
/**
 * Descrição: cadastra os dados de um formulário
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function cadastrar(){
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if ($this->oErro->isError()){$this->Oad->desconectar();return false;}
    else {
        $this->sSql = " INSERT INTO se_modulos(codg_modulo, desc_modulo, numg_operadorcad, data_cadastro, numr_ordem, desc_nome) VALUES (";
        $this->sSql .= FormataStr($this->getCodgModulo()) . ",";
        $this->sSql .= FormataStr($this->getDescModulo()) . ",";
        $this->sSql .= $this->getNumgOperadorCad() . ",";
        $this->sSql .= $this->getDataCadastro(). ",";
        $this->sSql .= $this->getNumrOrdem().",";
        $this->sSql .= FormataStr($this->getDescNome()).")";
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->sSqlAux = $this->Oad->consultar(" select max(numg_modulo) from se_modulos ");
            $this->setNumgModulo($this->sSqlAux->getValores(0, max));
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: Modulo.cadastrar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }  
}
/**
 * Descrição: edita os dados de um formulário
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function editar() {
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if (Erro::isError()){$this->Oad->desconectar();return false;}
    else{
        $this->sSql = " UPDATE se_modulos SET ";
        $this->sSql .= " codg_modulo = " . FormataStr($this->getCodgModulo()) . ",";
        $this->sSql .= " desc_modulo = " . FormataStr($this->getDescModulo()) . ",";
        $this->sSql .= " desc_nome = " . FormataStr($this->getDescNome()) . ",";
        $this->sSql .= " numr_ordem = " . $this->getNumrOrdem();
        $this->sSql .= " WHERE numg_modulo = " . $this->getNumgModulo();
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: Modulo.editar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    return true;
}
/**
 * Descrição: exclui os dados de um formulário
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function excluir($numgModulo){
    $this->Oad->conectar();
    $this->pValidaExclusao($numgModulo);
    if ($this->oErro->isError()){$this->Oad->desconectar();return false;}
    else {
        $this->sSql = "DELETE FROM se_modulos WHERE numg_modulo = " . $numgModulo;
        try{
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
        }catch (Exception $e){
            $this->oErro->addErro("Fonte: Modulo.excluir(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    return true;
}
/**
 * Descrição: bloqueia os dados de um formulário, setando a data de bloqueio e o operador responsável pelo bloqueio.
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function bloquear($vDados){
    $this->sSql = " UPDATE se_modulos SET";
    $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
    $this->sSql .= " numg_operadorBloq =" . $vDados[numgOperador];
    $this->sSql .= " WHERE numg_modulo=" . $vDados[numgModulo];
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: Modulo.bloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: desbloqueia um formulário
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function desbloquear($numgModulo) {
    $this->sSql = " UPDATE se_modulos SET";
    $this->sSql .= " data_bloqueio=null,";
    $this->sSql .= " numg_operadorBloq=null";
    $this->sSql .= " WHERE numg_modulo=" . $numgModulo;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: Modulo.desbloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca todos módulos cadastrados
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
public function consultarModulos() {
    $this->sSql = " select numg_modulo, codg_modulo, desc_modulo, numg_operadorcad, data_bloqueio, data_cadastro, numg_operadorbloq, numr_ordem, desc_nome";
    $this->sSql .= " from se_modulos order by numr_ordem";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: Modulo.consultarModulos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: valida os dados de um formulário antes de cadastrá-lo ou editá-lo
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
private function pValidaGravacao() {
    /**
     * CODG_formulario
     */
    if (trim($this->codgModulo) != "") {
        /**
         * SE FOR UMA INCLUSÃO
         */
        if ($this->numgModulo == 0) {
            /**
             * VERIFICA SE JÁ EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_modulo from se_modulos where lower(codg_modulo) = lower('" . trim($this->codg_modulo) . "')")->getCount() > 0)
                    $this->oErro->addErro("Já existe um Módulo cadastrado com o código " . $this->codgModulo . ".ß");
        }
    }else{
        $oResAux = $this->Oad->consultar("select numg_modulo from se_modulos where lower(codg_modulo) = lower('" . trim($this->codgModulo) . "')");
        if ($oResAux->getCount() > 0) {
            /*
             * Descrição: SE O Nº IDENTifICADOR FOR DifERENTE, SIGNifICA QUE JÁ EXISTE UM REGISTRO
             *            COM NOME INFORMADO PARA EDIÇÃO
             *
             */
            if ($oResAux->getValores(0, 0) != $this->numgModulo) {
                $this->oErro->addErro("Já existe um Módulo cadastrado com o código " . $this->codgModulo . ".ß");
            }
        }
    }
}
/**
 * Descrição: valida os dados de um formulário antes de excluí-lo
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
private function pValidaExclusao($numgModulo){
    if ($this->Oad->consultar("select numg_modulo from se_formularios where numg_modulo = " . $numgModulo)->getCount() > 0)
        $this->oErro->addErro("Este Módulo está vinculado a algum formulário. Não é possível excluí-lo.ß");
    if ($this->Oad->consultar("select numg_modulo from se_gruposmodulos where numg_modulo = " . $numgModulo)->getCount() > 0)
        $this->oErro->addErro("Este Módulo está vinculado a algum grupo. Não é possível excluí-lo.ß");
}
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
