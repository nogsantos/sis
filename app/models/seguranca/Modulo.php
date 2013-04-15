<?php
/**
 * Descri��o: Model Cadastro de Modulos.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
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
     * Descri��o: Set and Get n�mero gerado do modulo [obrigat�rio].
     */
    public function setNumgModulo($numgModulo){
        if (is_numeric($numgModulo)) {
            $this->numgModulo = $numgModulo;
        } else {
            $this->oErro->addErro("N� identificador do m�dulo inv�lido.�");
        }
    }
    public function getNumgModulo(){return $this->numgModulo;}
    /**
     * Descri��o: Set and Get c�digo do formul�rio [obrigat�rio].
     */
    public function setCodgModulo($codgModulo) {
        if (trim($codgModulo) != "") {
            $this->codgModulo = $codgModulo;
        } else {
            $this->oErro->addErro("C�digo do M�dulo inv�lido.�");
        }
    }
    public function getCodgModulo(){return $this->codgModulo;}
    /**
     * Descri��o: Set and Get nome do formul�rio [obrigat�rio].
     */
    public function setDescNome($descNome) {
        if (trim($descNome) != "") {
            $this->descNome = $descNome;
        } else {
            $this->oErro->addErro("Nome inv�lido.�");
        }
    }
    public function getDescNome(){return $this->descNome;}
    /**
     * Descri��o: Set and Get descri��o do formul�rio [obrigat�rio].
     */
    public function setDescModulo($descModulo) {
        if (trim($descModulo) != "") {
            $this->descModulo = $descModulo;
        } else {
            $this->oErro->addErro("Descri��o do m�dulo inv�lida.�");
        }
    }
    public function getDescModulo(){return $this->descModulo;}
    /**
     * Descri��o Set and Get orderm de apresenta��o do modulo no menu.
     */
    public function setNumrOrdem($ordem) {
        if (is_numeric($ordem)){
            $this->numrOrdem = $ordem;
        } else {
            $this->oErro->addErro("Ordem de apresenta��o do formul�rio inv�lida.�");
        }
    }
    public function getNumrOrdem(){return $this->numrOrdem;}
    /**
     * Descri��o: Set and Get data de cadastro.
     */
    public function setDataCadastro($dataCad){$this->dataCadastro = $dataCad;}
    public function getDataCadastro(){return $this->dataCadastro;}
    /**
     * Descri��o: Set and Get operador de cadastro do formul�rio.
     */
    public function setNumgOperadorCad($numgOperador){$this->numgOperadorCad = $numgOperador;}
    public function getNumgOperadorCad(){return $this->numgOperadorCad;}
    /**
     * Descri��o: Set and Get operador de bloqueio.
     */
    public function setNumgOperadorbloq($numgOperador){$this->numgOperadorBloq = $numgOperador;}
    public function getNumgOperadorbloq(){return $this->numgOperadorBloq;}
    /**
     * Descri��o: Set and Get nome do operador de cadastro.
     */
    public function setNomeOperadorCad($nomeOperador){$this->nomeOperadorCad = $nomeOperador;}
    public function getNomeOperadorCad(){return $this->nomeOperadorCad;}
    /**
     * Descri��o: Set and Get data de bloqueio.
     */
    public function setDataBloqueio($dataBloqueio){$this->dataBloqueio = $dataBloqueio;}
    public function getDataBloqueio(){return $this->dataBloqueio;}
    /**
     * Descri��o: Set and Get nome operador de bloqueio.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq){$this->nomeOperadorBloq = $nomeOperadorBloq;}
    public function getNomeOperadorBloq(){return $this->nomeOperadorBloq;}
/*******************************************************************************/
/*                       Cadastros e A��es Diversas                            */
/*******************************************************************************/
/**
 * Descri��o: seta os dados.
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
        $this->oErro->addErro("Fonte: Modulo.setarDadosFormulario(); Descri��o: " . $e->getMessage() . "�");
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
 * Descri��o: cadastra os dados de um formul�rio
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
            $this->oErro->addErro("Fonte: Modulo.cadastrar(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }  
}
/**
 * Descri��o: edita os dados de um formul�rio
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
            $this->oErro->addErro("Fonte: Modulo.editar(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    return true;
}
/**
 * Descri��o: exclui os dados de um formul�rio
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
            $this->oErro->addErro("Fonte: Modulo.excluir(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    return true;
}
/**
 * Descri��o: bloqueia os dados de um formul�rio, setando a data de bloqueio e o operador respons�vel pelo bloqueio.
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
        $this->oErro->addErro("Fonte: Modulo.bloquear(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: desbloqueia um formul�rio
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
        $this->oErro->addErro("Fonte: Modulo.desbloquear(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: busca todos m�dulos cadastrados
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
        $this->oErro->addErro("Fonte: Modulo.consultarModulos(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descri��o: valida os dados de um formul�rio antes de cadastr�-lo ou edit�-lo
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
private function pValidaGravacao() {
    /**
     * CODG_formulario
     */
    if (trim($this->codgModulo) != "") {
        /**
         * SE FOR UMA INCLUS�O
         */
        if ($this->numgModulo == 0) {
            /**
             * VERIFICA SE J� EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_modulo from se_modulos where lower(codg_modulo) = lower('" . trim($this->codg_modulo) . "')")->getCount() > 0)
                    $this->oErro->addErro("J� existe um M�dulo cadastrado com o c�digo " . $this->codgModulo . ".�");
        }
    }else{
        $oResAux = $this->Oad->consultar("select numg_modulo from se_modulos where lower(codg_modulo) = lower('" . trim($this->codgModulo) . "')");
        if ($oResAux->getCount() > 0) {
            /*
             * Descri��o: SE O N� IDENTifICADOR FOR DifERENTE, SIGNifICA QUE J� EXISTE UM REGISTRO
             *            COM NOME INFORMADO PARA EDI��O
             *
             */
            if ($oResAux->getValores(0, 0) != $this->numgModulo) {
                $this->oErro->addErro("J� existe um M�dulo cadastrado com o c�digo " . $this->codgModulo . ".�");
            }
        }
    }
}
/**
 * Descri��o: valida os dados de um formul�rio antes de exclu�-lo
 * @author Fabricio Nogueira.
 * Data: 01/08/2010.
 */
private function pValidaExclusao($numgModulo){
    if ($this->Oad->consultar("select numg_modulo from se_formularios where numg_modulo = " . $numgModulo)->getCount() > 0)
        $this->oErro->addErro("Este M�dulo est� vinculado a algum formul�rio. N�o � poss�vel exclu�-lo.�");
    if ($this->Oad->consultar("select numg_modulo from se_gruposmodulos where numg_modulo = " . $numgModulo)->getCount() > 0)
        $this->oErro->addErro("Este M�dulo est� vinculado a algum grupo. N�o � poss�vel exclu�-lo.�");
}
/**
 * Descri��o: Destrutor.
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
