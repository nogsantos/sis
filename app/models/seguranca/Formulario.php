<?php
/**
 * Descri��o: Model Cadastro de Fomul�rios.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 05/08/2010
 */
class Formulario{
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
    private $numgFormulario;
    private $codgFormulario;
    private $nomeFormulario;
    private $nomeCompleto;
    private $descFormulario;
    private $flagOculto;
    private $numrOrdem;
    private $dataCadastro;
    private $nomeOperadorCad;
    private $dataBloqueio;
    private $nomeOperadorBloq;
    private $numgModulo;
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
    }
    /**
     * Descri��o: Set and Get n�mero gerado do formul�rio [obrigat�rio].
     */
    public function setNumgFormulario($numgFormulario){
        if (is_numeric($numgFormulario)) {
            $this->numgFormulario = $numgFormulario;
        } else {
            $this->oErro->addErro("N� identificador do formul�rio inv�lido.�");
        }
    }
    public function getNumgFormulario(){return $this->numgFormulario;}
    /**
     * Descri��o: Set and Get c�digo do formul�rio [obrigat�rio].
     */
    public function setCodgFormulario($codgFomulario) {
        if (trim($codgFomulario) != "") {
            $this->codgFormulario = $codgFomulario;
        } else {
            $this->oErro->addErro("C�digo do formul�rio inv�lido.�");
        }
    }
    public function getCodgFormulario(){return $this->codgFormulario;}
    /**
     * Descri��o: Set and Get nome do formul�rio [obrigat�rio].
     */
    public function setNomeFormulario($nomeFormulario) {
        if (trim($nomeFormulario) != "") {
            $this->nomeFormulario = $nomeFormulario;
        } else {
            $this->oErro->addErro("Nome do formul�rio inv�lido.�");
        }
    }
    public function getNomeFormulario(){return $this->nomeFormulario;}
    /**
     * Descri��o: Set and Get nome completo do formul�rio [obrigat�rio].
     */
    public function setNomeCompleto($nomeCompleto) {
        if (trim($nomeCompleto) != "") {
            $this->nomeCompleto = $nomeCompleto;
        } else {
            $this->oErro->addErro("Nome completo do formul�rio inv�lido.�");
        }
    }
    public function getNomeCompleto(){return $this->nomeCompleto;}
    /**
     * Descri��o: Set and Get descri��o do formul�rio [obrigat�rio].
     */
    public function setDescFormulario($descFormulario) {
        if (trim($descFormulario) != "") {
            $this->descFormulario = $descFormulario;
        } else {
            $this->oErro->addErro("Descri��o do formul�rio inv�lida.�");
        }
    }
    public function getDescFormulario(){return $this->descFormulario;}
    /**
     * Descri��o: Set and Get flag oculto do formul�rio.
     */
    public function setFlagOculto($flag){$this->flagOculto = $flag;}
    public function getFlagOculto(){return $this->flagOculto;}
    /**
     * Descri��o: Set and Get ordem de apresenta��o do formul�rio [obrigat�rio].
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
     * Descri��o: Set and Get data de cadastro do formul�rio.
     */
    public function setDataCadastro($dataCad){$this->dataCadastro = $dataCad;}
    public function getDataCadastro(){return $this->dataCadastro;}
    /**
     * Descri��o: Set and Get operador de cadastro do formul�rio.
     */
    public function setNumgOperadorCad($numgOperador){$this->numgOperadorCad = $numgOperador;}
    public function getNumgOperadorCad(){return $this->numgOperadorCad;}
    /**
     * Descri��o: Set and Get nome do operador de cadastro do formul�rio.
     */
    public function setNomeOperadorCad($nomeOperador){$this->nomeOperadorCad = $nomeOperador;}
    public function getNomeOperadorCad(){return $this->nomeOperadorCad;}
    /**
     * Descri��o: Set and Get data de bloqueio do formul�rio.
     */
    public function setDataBloqueio($dataBloqueio){$this->dataBloqueio = $dataBloqueio;}
    public function getDataBloqueio(){return $this->dataBloqueio;}
    /**
     * Descri��o: Set and Get nome operador de bloqueio do formul�rio.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq){$this->nomeOperadorBloq = $nomeOperadorBloq;}
    public function getNomeOperadorBloq(){return $this->nomeOperadorBloq;}
    /**
     * Descri��o: Set and Get numgModulo [obrigat�rio].
     */
    public function setNumgModulo($numgModulo){
        if($numgModulo!=""){
            $this->numgModulo = $numgModulo;
        }else{
            $this->oErro->addErro("M�dulo inv�lido.�");
        }
    }
    public function getNumgModulo(){return $this->numgModulo;}
    /**
     * Descri��o: Set and Get codgModulo.
     */
    public function setCodgModulo($codgModulo){$this->codgModulo = $codgModulo;}
    public function getCodgModulo(){return $this->codgModulo;}
/*******************************************************************************/
/*                       Cadastros e A��es Diversas                            */
/*******************************************************************************/
/**
 * Descri��o: seta os dados de um formul�rio pelo seu n� identificador ou c�digo.
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function setarDadosFormulario($numgFormulario){
    $this->sSql = " select form.numg_formulario, form.codg_formulario, form.nome_formulario,
                           form.nome_completo, form.desc_formulario,
                           flag_oculto, form.numr_ordem, form.data_cadastro,
                           ope1.nome_operador, form.data_bloqueio, ope2.nome_operador as operadorbloq, m.codg_modulo, m.numg_modulo";
    $this->sSql .= " from se_formularios form";
    $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = form.numg_operadorCad";
    $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = form.numg_operadorBloq";
    $this->sSql .= " left join se_modulos m on m.numg_modulo = form.numg_modulo";
    $this->sSql .= " where numg_formulario = " . $numgFormulario;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.setarDadosFormulario(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
    if ($this->oResultset->getCount() > 0) {
        $this->numgFormulario = $this->oResultset->getValores(0, numg_formulario);
        $this->codgFormulario = $this->oResultset->getValores(0, codg_formulario);
        $this->nomeFormulario = $this->oResultset->getValores(0, nome_formulario);
        $this->nomeCompleto = $this->oResultset->getValores(0, nome_completo);
        $this->descFormulario = $this->oResultset->getValores(0, desc_formulario);
        $this->flagOculto = $this->oResultset->getValores(0, flag_oculto);
        $this->numrOrdem = $this->oResultset->getValores(0, numr_ordem);
        $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
        $this->nomeOperadorCad = $this->oResultset->getValores(0, nome_operador);
        $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
        $this->nomeOperadorBloq = $this->oResultset->getValores(0, operadorbloq);
        $this->numgModulo = $this->oResultset->getValores(0, numg_modulo);
        $this->codgModulo = $this->oResultset->getValores(0, codg_modulo);
    }
    return true;
}
/**
 * Descri��o: cadastra os dados de um formul�rio
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function cadastrar(){
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if ($this->oErro->isError()){$this->Oad->desconectar();return false;}
    else {
        $this->sSql = " INSERT INTO se_formularios (codg_formulario, nome_formulario, nome_completo,
                                                    desc_formulario, numg_modulo, flag_oculto, numr_ordem,
                                                    data_cadastro, numg_operadorCad) values (";
        $this->sSql .= FormataStr($this->getCodgFormulario()) . ",";
        $this->sSql .= FormataStr($this->getNomeFormulario()) . ",";
        $this->sSql .= FormataStr($this->getNomeCompleto()) . ",";
        $this->sSql .= FormataStr($this->getDescFormulario()) . ",";
        $this->sSql .= $this->getNumgModulo() . ",";
        $this->sSql .= FormataBool($this->getFlagOculto()) . ",";
        $this->sSql .= $this->getNumrOrdem() . ",";
        $this->sSql .= "CURRENT_TIMESTAMP,";
        $this->sSql .= $this->getNumgOperadorCad() . ")";
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->sSqlAux = $this->Oad->consultar("select max(numg_formulario) from se_formularios");
            $this->setNumgFormulario($this->sSqlAux->getValores(0, max));
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Formulario.cadastrar(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    $this->Oad->desconectar();
    return true;
}
/**
 * Descri��o: edita os dados de um formul�rio
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function editar() {
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if (Erro::isError()){$this->Oad->desconectar();return false;}
    else{
        $this->sSql = " UPDATE se_formularios SET";
        $this->sSql .= " codg_formulario=" . FormataStr($this->getCodgFormulario()) . ",";
        $this->sSql .= " nome_formulario=" . FormataStr($this->getNomeFormulario()) . ",";
        $this->sSql .= " nome_completo=" . FormataStr($this->getNomeCompleto()) . ",";
        $this->sSql .= " desc_formulario=" . FormataStr($this->getDescFormulario()) . ",";
        $this->sSql .= " numg_modulo=" . $this->getNumgModulo() . ",";
        $this->sSql .= " flag_oculto=" . FormataBool($this->getFlagOculto()) . ",";
        $this->sSql .= " numr_ordem=" . $this->getNumrOrdem();
        $this->sSql .= " WHERE numg_formulario = " . $this->getNumgFormulario();
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Formulario.editar(); Descri��o: " . $e->getMessage() . "�");
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
 * Data: 05/08/2010.
 */
public function excluir($numgFormulario){
    $this->sSql = "DELETE FROM se_formularios WHERE numg_formulario = " . $numgFormulario;
    try{
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Formulario.excluir(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: bloqueia os dados de um formul�rio, setando a data de bloqueio e o operador respons�vel pelo bloqueio.
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function bloquear($vDados){
    $this->sSql = " UPDATE se_formularios SET";
    $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
    $this->sSql .= " numg_operadorBloq =" . $vDados[1];
    $this->sSql .= " WHERE numg_formulario=" . $vDados[0];
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.bloquear(); Descri��o: " . $e->getMessage() . "�");
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
public function desbloquear($numgFormulario) {
    $this->sSql = " UPDATE se_formularios SET";
    $this->sSql .= " data_bloqueio=null,";
    $this->sSql .= " numg_operadorBloq=null";
    $this->sSql .= " WHERE numg_formulario=" . $numgFormulario;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.desbloquear(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: busca os formul�rios cadastrados
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function consultarFormularios() {
    $this->sSql = " select f.numg_formulario, f.codg_formulario, f.nome_formulario, f.nome_completo, f.flag_oculto,
                           f.data_bloqueio, f.numg_modulo, m.codg_modulo, m.desc_nome, f.numr_ordem
                    from se_formularios f
                    join se_modulos m on m.numg_modulo = f.numg_modulo
                    order by f.numg_modulo, f.numr_ordem";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormularios(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }    
}
/**
 * Descri��o: busca os formul�rios acess�veis a um operador
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function consultarFormsOperador($numgOperador) {
    $this->sSql = " select f.numg_modulo, f.nome_formulario, f.codg_formulario, m.codg_modulo, m.desc_nome
                    from se_formularios f
                    join se_modulos m on m.numg_modulo = f.numg_modulo
                    where flag_oculto = 'f'
                    and f.data_bloqueio is null
                    and f.numg_formulario in(select distinct(f.numg_formulario)
                                                    from se_formularios f
                                                    join se_gruposmodulos gmod on gmod.numg_modulo = f.numg_modulo
                                                    join se_grupos gru on gru.numg_grupo = gmod.numg_grupo
                                                    join se_operadoresgrupos tog on tog.numg_grupo = gru.numg_grupo
                                                    where tog.numg_operador = ".$numgOperador." order by f.numg_formulario)
                    order by m.numr_ordem";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormsOperador(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descri��o: busca os formul�rios acess�veis a um operador
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function consultarFormsAdministrador() {
    $this->sSql = " select f.numg_modulo, f.nome_formulario, f.codg_formulario, m.codg_modulo, m.desc_nome
                    from se_modulos m
                    join se_formularios f on f.numg_modulo = m.numg_modulo
                    where not(f.flag_oculto) and m.data_bloqueio is null and f.data_bloqueio is null
                    order by m.numr_ordem asc ";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormsAdministrador(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descri��o: fun��o de valida��o de formul�rio para um operador.
 * 			O formul�rio em quest�o poder� estar bloqueado ou
 * 			possuir nenhuma fun��o dispon�vel para os grupos ao
 * 			quais o operador pertence.
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
public function validarAcesso($sCodgFormulario, $numgOperador) {
    try {
        $this->Oad->conectar();
        $this->sSqlAux = $this->Oad->consultar("select numg_formulario, nome_completo, data_bloqueio from se_formularios where codg_formulario = '" . $sCodgFormulario . "'");
        $this->Oad->desconectar();
        if ($this->sSqlAux->getCount() == 0) {
            $this->oErro->addErro("Formul�rio n�o identificado!�");
            return false;
            /**
             * ADMINISTRADOR GERAL
             */
        } else if ($numgOperador == 1) {
            /**
             * RETORNA O NOME DO FORMUL�RIO
             */
            return $this->sSqlAux->getValores(0, nome_completo);
        } else {
            if (!is_null($this->sSqlAux->getValores(0, data_bloqueio))) {
                $this->oErro->addErro("Este formul�rio encontra-se bloqueado!�");
                return false;
            }
            return $this->sSqlAux->getValores(0, "nome_completo");
        }
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.validarAcesso(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: valida os dados de um formul�rio antes de cadastr�-lo ou edit�-lo
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
private function pValidaGravacao() {
    /**
     * CODG_formulario
     */
    if (trim($this->codgFormulario) != "") {
        /**
         * SE FOR UMA INCLUS�O
         */
        if ($this->numgFormulario == 0) {
            /**
             * VERIFICA SE J� EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_formulario from se_formularios where lower(codg_formulario) = lower('" . trim($this->codgFormulario) . "')")->getCount() > 0)
                    $this->oErro->addErro("J� existe um Formul�rio cadastrado com o c�digo " . $this->codgFormulario . ".�");
        }
    }else{
        $oResAux = $this->Oad->consultar("select numg_formulario from se_formularios where lower(codg_formulario) = lower('" . trim($this->codgFormulario) . "')");
        if ($oResAux->getCount() > 0) {
            /*
             * Descri��o: SE O N� IDENTifICADOR FOR DifERENTE, SIGNifICA QUE J� EXISTE UM REGISTRO
             *            COM NOME INFORMADO PARA EDI��O
             *
             */
            if ($oResAux->getValores(0, 0) != $this->numgFormulario) {
                $this->oErro->addErro("J� existe um Formul�rio cadastrado com o c�digo " . $this->codgFormulario . ".�");
            }
        }
    }
}
/**
 * Descri��o: Modalidades cadastradas para o professor
 * @author Fabricio Nogueira
 * Data: 07/11/2010
 */
public function consultarFormulariosPorModulo($numgModulo){
    $this->sSql = " select numg_modulo, nome_formulario, codg_formulario
                    from se_formularios where numg_modulo = ".$numgModulo;

    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    } catch (Exception $e) {
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormulariosPorModulo()" . $e->getMessage() . "�");
        return false;
    }
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
