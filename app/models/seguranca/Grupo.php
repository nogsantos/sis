<?php
/**
 * Descrição: model Cadastro de grupos.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 28/08/2010
 */
class Grupo {
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
    private $numgGrupo;
    private $nomeGrupo;
    private $descGrupo;
    private $dataCadastro;
    private $nomeOperadorCad;
    private $dataBloqueio;
    private $nomeOperadorBloq;
    private $numgModulo;
   /**
    * Construtor.
    * @author Fabricio Nogueira.
    * Data: 28/08/2010.
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
     * Descrição: Set and Get numg grupos [ obrigatório ]
     */
    function setNumgGrupo($valor) {
        if (is_numeric($valor)) {
            $this->numgGrupo = $valor;
        } else {
            $this->oErro->addErro("N° identificador do grupo inválido.ß");
        }
    }
    function getNumgGrupo() {return $this->numgGrupo;}
    /**
     * Descrição: Set and Get nome grupos [ obrigatório ]
     */
    function setNomeGrupo($valor) {
        if (trim($valor) != "") {
            $this->nomeGrupo = $valor;
        } else {
            $this->oErro->addErro("Nome do grupo inválido.ß");
        }
    }
    function getNomeGrupo() {return $this->nomeGrupo;}
    /**
     * Descrição: Set and Get descrição grupos [ obrigatório ]
     */
    function setDescGrupo($valor) {
        if (trim($valor) != "") {
            $this->descGrupo = $valor;
        } else {
            $this->oErro->addErro("Descrição do grupo inválida.ß");
        }
    }
    function getDescGrupo(){return $this->descGrupo;}
    /**
     * Descrição: Set and Get data cadastro grupos
     */
    function setDataCadastro($valor) {$this->dataCadastro = $valor;}
    function getDataCadastro(){return $this->dataCadastro;}
    /**
     * Descrição: Set and Get numg operador cadastro
     */
    function setNumgOperadorCad($valor){$this->numgOperadorCad = $valor;}
    function getNumgOperadorCad(){return $this->numgOperadorCad;}
    /**
     * Descrição: Set and Get nome operador cadastro
     */
    function setNomeOperadorCad($valor){$this->nomeOperadorCad = $valor;}
    function getNomeOperadorCad(){return $this->nomeOperadorCad;}
    /**
     * Descrição: Set and Get data bloquei grupo
     */
    function setDataBloqueio($valor){$this->dataBloqueio = $valor;}
    function getDataBloqueio(){return $this->dataBloqueio;}
    /**
     * Descrição: Set and Get numg operador bloqueio
     */
    function setNumgOperadorBloq($valor){$this->numgOperadorBloq = $valor;}
    function getNumgOperadorBloq(){return $this->numgOperadorBloq;}
    /**
     * Descrição: Set and Get nome operador bloqueio
     */
    function setNomeOperadorBloq($valor){$this->nomeOperadorBloq = $valor;}
    function getNomeOperadorBloq(){return $this->nomeOperadorBloq;}
    /**
     * Descrição: Set and Get numg modulo
     */
    function setNumgModulo($numgModulo){$this->numgModulo = $numgModulo;}
    function getNumgModulo(){return $this->numgModulo;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descrição: seta os dados do grupo pelo seu nº identificador.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function setarDadosGrupo($numgGrupo) {
    $this->sSql = "select gru.nome_grupo, gru.desc_grupo, gru.data_cadastro, ope1.nome_operador, gru.data_bloqueio, ope2.nome_operador as nomeoperadorcad";
    $this->sSql .= " from se_grupos gru";
    $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = gru.numg_operadorCad";
    $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = gru.numg_operadorBloq";
    $this->sSql .= " where numg_grupo = " . $numgGrupo;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.setarDadosGrupo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
    return false;
    }
    if ($this->oResultset->getCount() > 0) {
        $this->numgGrupo = $numgGrupo;
        $this->nomeGrupo = $this->oResultset->getValores(0,nome_grupo );
        $this->descGrupo = $this->oResultset->getValores(0, desc_grupo);
        $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
        $this->nomeOperadorCad = $this->oResultset->getValores(0, nome_operador);
        $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
        $this->nomeOperadorBloq = $this->oResultset->getValores(0, nomeoperadorcad);
    }
}
/**
 * Descrição: cadastra os dados de um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function cadastrar() {
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if ($this->oErro->isError()){$this->Oad->desconectar();return false;}
    else {
        $this->sSql = " INSERT INTO se_grupos (nome_grupo, desc_grupo, data_cadastro, numg_operadorCad) values (";
        $this->sSql .= FormataStr($this->getNomeGrupo()) . ",";
        $this->sSql .= FormataStr($this->getDescGrupo()) . ",";
        $this->sSql .= "CURRENT_TIMESTAMP,";
        $this->sSql .= $this->getNumgOperadorCad() . ")";
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->oResultset = $this->Oad->consultar("select max(numg_grupo) from se_grupos");
            $this->numgGrupo = $this->oResultset->getValores(0, max);
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Grupo.cadastrar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    $this->Oad->desconectar();
    return true;
}
/**
 * Descrição: edita os dados de um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function editar() {
    $this->Oad->conectar();
    $this->pValidaGravacao();
    if ($this->oErro->isError()) {$this->Oad->desconectar();return false;}
    else {
        $this->sSql = " UPDATE se_grupos SET";
        $this->sSql .= " nome_grupo=" . FormataStr($this->getNomeGrupo()) . ",";
        $this->sSql .= " desc_grupo=" . FormataStr($this->getDescGrupo());
        $this->sSql .= " WHERE numg_grupo = " . $this->getNumgGrupo();
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Grupo.editar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    $this->Oad->desconectar();
    return true;
}
/**
 * Descrição: exclui os dados de um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function excluir($numgGrupo) {
    $this->Oad->conectar();
    $this->pValidaExclusao($numgGrupo);
    if ($this->oErro->isError()){$this->Oad->desconectar();return false;}
    else {
        $this->sSql = "DELETE FROM se_grupos WHERE numg_grupo = " . $numgGrupo;
        try {
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Grupo.excluir(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }
    $this->Oad->desconectar();
    return true;
}
/**
 * Descrição: bloqueia um grupo de acesso, setando a data de bloqueio e o responsável.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function bloquear($vDados) {
    $this->sSql = " UPDATE se_grupos SET";
    $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
    $this->sSql .= " numg_operadorBloq = " . $vDados[1];
    $this->sSql .= " WHERE numg_grupo=" . $vDados[0];
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.bloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: desbloqueia um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function desbloquear($numgGrupo) {
    $this->sSql = " UPDATE se_grupos SET";
    $this->sSql .= " data_bloqueio = null,";
    $this->sSql .= " numg_operadorBloq = null";
    $this->sSql .= " WHERE numg_grupo=" . $numgGrupo;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.desbloquear(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: cadastra um operador para um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function cadastrarOperadorGrupo($vDados) {
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar("INSERT INTO se_operadoresGrupos (numg_operador, numg_grupo) values (" . $vDados[0] . "," . $vDados[1] . ")");
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.cadastrarOperadorGrupo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: exclui um operador de um grupo de acesso.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function excluirOperadorGrupo($vDados) {
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar("DELETE FROM se_operadoresGrupos WHERE numg_operador = " . $vDados[0] . " and numg_grupo = " . $vDados[1]);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.excluirOperadorGrupo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: cadastra um grupo de acesso a um modulo.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function cadastrarGrupoModulo($vDados) {
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar("INSERT INTO se_gruposmodulos (numg_modulo, numg_grupo) values (" . $vDados[0] . "," . $vDados[1] . ")");
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.cadastrarGrupoModulo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: exclui um grupo de acesso a um modulo.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function excluirGrupoModulo($vDados) {
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar("DELETE FROM se_gruposmodulos WHERE numg_modulo = " . $vDados[0] . " and numg_grupo = " . $vDados[1]);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Grupo.excluirGrupoModulo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: busca os grupos de acesso aos quais o operador pertence
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposOperador($vDados) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo in (select numg_grupo from se_operadoresGrupos where numg_operador = " . $vDados[0] . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposOperador(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os grupos de acesso de um prestador aos quais o operador não pertence
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposNaoOperador($vDados) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo not in (select numg_grupo from se_operadoresGrupos where numg_operador = " . $vDados[0] . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposNaoOperador(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os grupos de acesso cadastrados.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGrupos() {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo, desc_grupo, data_bloqueio from se_grupos order by nome_grupo");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGrupos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os grupos que tem acesso a uma função.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposFuncao($vDados) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo in (select numg_grupo from se_gruposFuncoes where numg_funcao = " . $vDados[0] . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposFuncao(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os grupos de acesso que não tem acesso a função.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposNaoFuncao($vDados) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo not in (select numg_grupo from se_gruposFuncoes where numg_funcao = " . $vDados[0] . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposNaoFuncao(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: Grupos cadastrados ao modulo
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposCadastrados($numgModulo) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo in (select numg_grupo from se_gruposModulos where numg_modulo = " . $numgModulo . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposCadastrados(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: busca os grupos não cadastrados
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
public function consultarGruposDisponiveis($numgModulo) {
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar("select numg_grupo, nome_grupo from se_grupos where numg_grupo not in (select numg_grupo from se_gruposModulos where numg_modulo = " . $numgModulo . ")");
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Grupo.consultarGruposDisponiveis(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    return $this->oResultset;
}
/**
 * Descrição: valida os dados de um grupo antes de cadastrá-lo ou editá-lo.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
private function pValidaGravacao() {
    if (trim($this->nomeGrupo) != "") {
        /**
         * SE FOR UMA INCLUSÃO
         */
        if ($this->numgGrupo == 0) {
            /**
             * VERIFICA SE JÁ EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
             */
            if ($this->Oad->consultar("select numg_grupo from se_grupos where nome_grupo = '" . trim($this->nomeGrupo) . "'")->getCount() > 0) {
                $this->oErro->addErro("Já existe um Grupo de Acesso cadastrado com o nome " . $this->nomeGrupo . " para este operador.ß");
            }
        } else {
            $oResAux = $this->Oad->consultar("select numg_grupo from se_grupos where nome_grupo = '" . trim($this->nomeGrupo) . "'");
            if ($oResAux->getCount() > 0) {
                /**
                 * SE O Nº IDENTifICADOR FOR DifERENTE, SIGNifICA QUE JÁ EXISTE UM REGISTRO
                 * COM NOME INFORMADO PARA EDIÇÃO
                 */
                if ($oResAux->getValores(0, 0) != $this->numgGrupo) {
                    $this->oErro->addErro("Já existe um Grupo de Acesso cadastrado com o nome " . $this->nomeGrupo . " para este operador.ß");
                }
            }
        }
    }
}
/**
 * Descrição: valida um grupo de acesso antes de excluí-lo.
 * @author Fabricio Nogueira.
 * Data: 30/08/2010.
 */
private function pValidaExclusao($numgGrupo) {
    $res = $this->Oad->consultar("select numg_modulo from se_gruposmodulos where numg_grupo = " . $numgGrupo);
    if ($res->getCount()>0)
        $this->oErro->addErro("Este grupo está vinculado a algum modulo. Não é possível excluí-lo.ß");
    else{
        $res = $this->Oad->consultar("select numg_operador from se_operadoresgrupos where numg_grupo = " . $numgGrupo);
        if ($res->getCount()>0)
            $this->oErro->addErro("Este grupo está vinculado a algum operador. Não é possível excluí-lo.ß");
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