<?php
/**
 * Descrição: Model Cadastro de Fomulários.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
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
     * Descrição: Set and Get número gerado do formulário [obrigatório].
     */
    public function setNumgFormulario($numgFormulario){
        if (is_numeric($numgFormulario)) {
            $this->numgFormulario = $numgFormulario;
        } else {
            $this->oErro->addErro("N° identificador do formulário inválido.ß");
        }
    }
    public function getNumgFormulario(){return $this->numgFormulario;}
    /**
     * Descrição: Set and Get código do formulário [obrigatório].
     */
    public function setCodgFormulario($codgFomulario) {
        if (trim($codgFomulario) != "") {
            $this->codgFormulario = $codgFomulario;
        } else {
            $this->oErro->addErro("Código do formulário inválido.ß");
        }
    }
    public function getCodgFormulario(){return $this->codgFormulario;}
    /**
     * Descrição: Set and Get nome do formulário [obrigatório].
     */
    public function setNomeFormulario($nomeFormulario) {
        if (trim($nomeFormulario) != "") {
            $this->nomeFormulario = $nomeFormulario;
        } else {
            $this->oErro->addErro("Nome do formulário inválido.ß");
        }
    }
    public function getNomeFormulario(){return $this->nomeFormulario;}
    /**
     * Descrição: Set and Get nome completo do formulário [obrigatório].
     */
    public function setNomeCompleto($nomeCompleto) {
        if (trim($nomeCompleto) != "") {
            $this->nomeCompleto = $nomeCompleto;
        } else {
            $this->oErro->addErro("Nome completo do formulário inválido.ß");
        }
    }
    public function getNomeCompleto(){return $this->nomeCompleto;}
    /**
     * Descrição: Set and Get descrição do formulário [obrigatório].
     */
    public function setDescFormulario($descFormulario) {
        if (trim($descFormulario) != "") {
            $this->descFormulario = $descFormulario;
        } else {
            $this->oErro->addErro("Descrição do formulário inválida.ß");
        }
    }
    public function getDescFormulario(){return $this->descFormulario;}
    /**
     * Descrição: Set and Get flag oculto do formulário.
     */
    public function setFlagOculto($flag){$this->flagOculto = $flag;}
    public function getFlagOculto(){return $this->flagOculto;}
    /**
     * Descrição: Set and Get ordem de apresentação do formulário [obrigatório].
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
     * Descrição: Set and Get data de cadastro do formulário.
     */
    public function setDataCadastro($dataCad){$this->dataCadastro = $dataCad;}
    public function getDataCadastro(){return $this->dataCadastro;}
    /**
     * Descrição: Set and Get operador de cadastro do formulário.
     */
    public function setNumgOperadorCad($numgOperador){$this->numgOperadorCad = $numgOperador;}
    public function getNumgOperadorCad(){return $this->numgOperadorCad;}
    /**
     * Descrição: Set and Get nome do operador de cadastro do formulário.
     */
    public function setNomeOperadorCad($nomeOperador){$this->nomeOperadorCad = $nomeOperador;}
    public function getNomeOperadorCad(){return $this->nomeOperadorCad;}
    /**
     * Descrição: Set and Get data de bloqueio do formulário.
     */
    public function setDataBloqueio($dataBloqueio){$this->dataBloqueio = $dataBloqueio;}
    public function getDataBloqueio(){return $this->dataBloqueio;}
    /**
     * Descrição: Set and Get nome operador de bloqueio do formulário.
     */
    public function setNomeOperadorBloq($nomeOperadorBloq){$this->nomeOperadorBloq = $nomeOperadorBloq;}
    public function getNomeOperadorBloq(){return $this->nomeOperadorBloq;}
    /**
     * Descrição: Set and Get numgModulo [obrigatório].
     */
    public function setNumgModulo($numgModulo){
        if($numgModulo!=""){
            $this->numgModulo = $numgModulo;
        }else{
            $this->oErro->addErro("Módulo inválido.ß");
        }
    }
    public function getNumgModulo(){return $this->numgModulo;}
    /**
     * Descrição: Set and Get codgModulo.
     */
    public function setCodgModulo($codgModulo){$this->codgModulo = $codgModulo;}
    public function getCodgModulo(){return $this->codgModulo;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descrição: seta os dados de um formulário pelo seu nº identificador ou código.
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
        $this->oErro->addErro("Fonte: SGM.Formulario.setarDadosFormulario(); Descrição: " . $e->getMessage() . "ß");
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
 * Descrição: cadastra os dados de um formulário
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
            $this->oErro->addErro("Fonte: SGM.Formulario.cadastrar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    $this->Oad->desconectar();
    return true;
}
/**
 * Descrição: edita os dados de um formulário
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
            $this->oErro->addErro("Fonte: SGM.Formulario.editar(); Descrição: " . $e->getMessage() . "ß");
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
        $this->oErro->addErro("Fonte: SGM.Formulario.excluir(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: bloqueia os dados de um formulário, setando a data de bloqueio e o operador responsável pelo bloqueio.
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
        $this->oErro->addErro("Fonte: SGM.Formulario.bloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: desbloqueia um formulário
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
        $this->oErro->addErro("Fonte: SGM.Formulario.desbloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca os formulários cadastrados
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
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormularios(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }    
}
/**
 * Descrição: busca os formulários acessíveis a um operador
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
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormsOperador(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os formulários acessíveis a um operador
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
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormsAdministrador(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: função de validação de formulário para um operador.
 * 			O formulário em questão poderá estar bloqueado ou
 * 			possuir nenhuma função disponível para os grupos ao
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
            $this->oErro->addErro("Formulário não identificado!ß");
            return false;
            /**
             * ADMINISTRADOR GERAL
             */
        } else if ($numgOperador == 1) {
            /**
             * RETORNA O NOME DO FORMULÁRIO
             */
            return $this->sSqlAux->getValores(0, nome_completo);
        } else {
            if (!is_null($this->sSqlAux->getValores(0, data_bloqueio))) {
                $this->oErro->addErro("Este formulário encontra-se bloqueado!ß");
                return false;
            }
            return $this->sSqlAux->getValores(0, "nome_completo");
        }
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Formulario.validarAcesso(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: valida os dados de um formulário antes de cadastrá-lo ou editá-lo
 * @author Fabricio Nogueira.
 * Data: 05/08/2010.
 */
private function pValidaGravacao() {
    /**
     * CODG_formulario
     */
    if (trim($this->codgFormulario) != "") {
        /**
         * SE FOR UMA INCLUSÃO
         */
        if ($this->numgFormulario == 0) {
            /**
             * VERIFICA SE JÁ EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_formulario from se_formularios where lower(codg_formulario) = lower('" . trim($this->codgFormulario) . "')")->getCount() > 0)
                    $this->oErro->addErro("Já existe um Formulário cadastrado com o código " . $this->codgFormulario . ".ß");
        }
    }else{
        $oResAux = $this->Oad->consultar("select numg_formulario from se_formularios where lower(codg_formulario) = lower('" . trim($this->codgFormulario) . "')");
        if ($oResAux->getCount() > 0) {
            /*
             * Descrição: SE O Nº IDENTifICADOR FOR DifERENTE, SIGNifICA QUE JÁ EXISTE UM REGISTRO
             *            COM NOME INFORMADO PARA EDIÇÃO
             *
             */
            if ($oResAux->getValores(0, 0) != $this->numgFormulario) {
                $this->oErro->addErro("Já existe um Formulário cadastrado com o código " . $this->codgFormulario . ".ß");
            }
        }
    }
}
/**
 * Descrição: Modalidades cadastradas para o professor
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
        $this->oErro->addErro("Fonte: SGM.Formulario.consultarFormulariosPorModulo()" . $e->getMessage() . "ß");
        return false;
    }
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
