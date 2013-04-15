<?php

/**
 * Descri��o: Model Operadores do sistema.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 28/08/2010
 */
class Operador {

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
    private $numgOperador;
    private $nomeOperador;
    private $nomeCompleto;
    private $descSenha;
    private $descEmail;
    private $dataCadastro;
    private $nomeOperadorCad;
    private $dataUltimaAlt;
    private $nomeOperadorAlt;
    private $dataBloqueio;
    private $nomeOperadorBloq;
    private $dataUltimoAcesso;

    /**
     * Construtor.
     * @author Fabricio Nogueira.
     * Data: 28/08/2010.
     */
    function __construct() {
        $oErro = new Erro();
        $Oad = new Oad();
        $this->oResultsetset = new Resultset();
        $this->Oad = $Oad;
        $this->oErro = $oErro;
        $this->oResultset = $this->oResultsetset;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNumgOperador($valor) {
        if (is_numeric($valor)) {
            $this->numgOperador = $valor;
        } else {
            $this->oErro->addErro("ID do operador inv�lido.�");
        }
    }

    function getNumgOperador() {
        return $this->numgOperador;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNomeOperador($valor) {
        if (trim($valor) != "") {
            $this->nomeOperador = $valor;
        } else {
            $this->oErro->addErro("Login de acesso do operador inv�lido.�");
        }
    }

    function getNomeOperador() {
        return $this->nomeOperador;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNomeCompleto($valor) {
        if (trim($valor) != "") {
            $this->nomeCompleto = $valor;
        } else {
            $this->oErro->addErro("Nome completo do operador inv�lido.�");
        }
    }

    function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    /**
     * Descri��o: Set and Get
     */
    function setDescSenha($valor) {
        if (strlen($valor) >= 4) {
            $this->descSenha = $valor;
        } else {
            $this->oErro->addErro("Senha do operador inv�lida. Digite uma senha com no m�nimo 4 d�gitos.�");
        }
    }

    function getDescSenha() {
        return $this->descSenha;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNumrCpf($valor) {
        if (IsCpf($valor)) {
            $this->numrCpf = $valor;
        } else {
            $this->oErro->addErro("CPF do operador inv�lido.�");
        }
    }

    /**
     * Descri��o: Set and Get
     */
    function getDescEmail() {
        return $this->descEmail;
    }

    function setDescEmail($valor) {
        $this->descEmail = $valor;
    }

    /**
     * Descri��o: Set and Get
     */
    function setDataCadastro($valor) {
        $this->dataCadastro = $valor;
    }

    function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNumgOperadorCad($valor) {
        $this->numgOperadorCad = $valor;
    }

    function getNumgOperadorCad() {
        return $this->numgOperadorCad;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNomeOperadorCad($valor) {
        $this->nomeOperadorCad = $valor;
    }

    function getNomeOperadorCad() {
        return $this->nomeOperadorCad;
    }

    /**
     * Descri��o: Set and Get
     */
    function setDataUltimaAlt($valor) {
        $this->dataUltimaAlt = $valor;
    }

    function getDataUltimaAlt() {
        return $this->dataUltimaAlt;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNumgOperadorAlt($valor) {
        $this->numgOperadorAlt = $valor;
    }

    function getNumgOperadorAlt() {
        return $this->numgOperadorAlt;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNomeOperadorAlt($valor) {
        $this->nomeOperadorAlt = $valor;
    }

    function getNomeOperadorAlt() {
        return $this->nomeOperadorAlt;
    }

    /**
     * Descri��o: Set and Get
     */
    function setDataBloqueio($valor) {
        $this->dataBloqueio = $valor;
    }

    function getDataBloqueio() {
        return $this->dataBloqueio;
    }

    /**
     * Descri��o: Set and Get
     */
    function setNomeOperadorBloq($valor) {
        $this->nomeOperadorBloq = $valor;
    }

    function getNomeOperadorBloq() {
        return $this->nomeOperadorBloq;
    }

    /**
     * Descri��o: Set and Get
     */
    function setDataUltimoAcesso($valor) {
        $this->dataUltimoAcesso = $valor;
    }

    function getDataUltimoAcesso() {
        return $this->dataUltimoAcesso;
    }

    /*     * *************************************************************************** */
    /*                       Cadastros e A��es Diversas                            */
    /*     * *************************************************************************** */

    /**
     * Descri��o: seta os dados de um operador pelo seu n� identificador ou pelo seu login.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function setarDadosOperador($vDados) {
        $this->sSql = " select ope.numg_operador, ope.nome_operador, ope.nome_completo, ope.desc_senha, ope.desc_email, ope.data_cadastro, ope1.nome_operador as nome_operadorcad, ope.data_ultimaalt, ope2.nome_operador as nome_operadoralt, ope.data_bloqueio, ope3.nome_operador as nome_operadorbloq, ope.data_ultimoAcesso";
        $this->sSql .= " from se_operadores ope";
        $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = ope.numg_operadorCad";
        $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = ope.numg_operadorAlt";
        $this->sSql .= " left join se_operadores ope3 on ope3.numg_operador = ope.numg_operadorBloq";
        if (is_array($vDados)) {
            if ($vDados[0] != "") {
                $this->sSql .= " where ope.numg_operador = " . $vDados[0];
            } else {
                $this->sSql .= " where ope.nome_operador = '" . addslashes($vDados[1]) . "'";
            }
        } else {
            $this->sSql .= " where ope.numg_operador = " . $vDados;
        }
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.setarDadosOperador(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
        if ($this->oResultset->getCount() > 0) {
            $this->numgOperador = $this->oResultset->getValores(0, numg_operador);
            $this->nomeOperador = $this->oResultset->getValores(0, nome_operador);
            $this->nomeCompleto = $this->oResultset->getValores(0, nome_completo);
            $this->descSenha = Descriptografa($this->oResultset->getValores(0, desc_senha));
            $this->descEmail = $this->oResultset->getValores(0, desc_email);
            $this->dataCadastro = FormataDataHora($this->oResultset->getValores(0, data_cadastro));
            $this->nomeOperadorCad = $this->oResultset->getValores(0, nome_operadorcad);
            $this->dataUltimaAlt = FormataDataHora($this->oResultset->getValores(0, data_ultimaalt));
            $this->nomeOperadorAlt = $this->oResultset->getValores(0, nome_operadoralt);
            $this->dataBloqueio = FormataDataHora($this->oResultset->getValores(0, data_bloqueio));
            $this->nomeOperadorBloq = $this->oResultset->getValores(0, nome_operadorbloq);
            $this->dataUltimoAcesso = FormataDataHora($this->oResultset->getValores(0, data_ultimoacesso));
        }
        return true;
    }

    /**
     * Descri��o: cadastra os dados de um operador.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function cadastrar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " INSERT INTO se_operadores (nome_operador, nome_completo, desc_senha, ";
            $this->sSql .= " desc_email, data_cadastro, numg_operadorCad)";
            $this->sSql .= " values (";
            $this->sSql .= FormataStr($this->getNomeOperador()) . ",";
            $this->sSql .= FormataStr($this->getNomeCompleto()) . ",";
            $this->sSql .= FormataStr(Criptografa($this->getDescSenha())) . ",";
            $this->sSql .= FormataStr($this->getDescEmail()) . ",";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= $this->getNumgOperadorCad() . ")";
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->oResultset = $this->Oad->consultar("select max(numg_operador) from se_operadores");
                $this->setNumgOperador($this->oResultset->getValores(0, max));
                $this->Oad->desconectar();
                return true;
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.cadastrar(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
    }

    /**
     * Descri��o: edita os dados de um operador.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function editar() {
        $this->Oad->conectar();
        $this->pValidaGravacao();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = "UPDATE se_operadores SET";
            $this->sSql .= " nome_operador=" . FormataStr($this->getNomeOperador()) . ",";
            $this->sSql .= " nome_completo=" . FormataStr($this->getNomeCompleto()) . ",";
            $this->sSql .= " desc_senha=" . FormataStr(Criptografa($this->getDescSenha())) . ",";
            $this->sSql .= " desc_email=" . FormataStr($this->getDescEmail()) . ",";
            $this->sSql .= " data_ultimaalt = CURRENT_TIMESTAMP,";
            $this->sSql .= " numg_operadoralt=" . $this->getNumgOperadorAlt();
            $this->sSql .= " WHERE numg_operador = " . $this->getNumgOperador();
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
                return true;
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.editar(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
    }

    /**
     * Descri��o: exclui os dados de um operador.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function excluir($nNumgOperador) {
        $this->Oad->conectar();
        $this->pValidaExclusao($nNumgOperador);
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = "DELETE FROM se_operadores WHERE numg_operador = " . $nNumgOperador;
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
                return true;
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.excluir(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
    }

    /**
     * Descri��o: bloqueia um operador, seta a data de bloqueio e o respons�vel.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function bloquear($vDados) {
        $this->Oad->conectar();
        $this->pValidaBloqueio($vDados[0]);
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $this->sSql = " UPDATE se_operadores SET";
            $this->sSql .= " data_bloqueio = CURRENT_TIMESTAMP,";
            $this->sSql .= " numg_operadorBloq =" . $vDados[1];
            $this->sSql .= " WHERE numg_operador=" . $vDados[0];
            try {
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->Oad->desconectar();
                return true;
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.bloquear(); Descri��o: " . $e->getMessage() . "�");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
    }

    /**
     * Descri��o: desbloqueia um operador.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function desbloquear($nNumgOperador) {
        $this->sSql = "UPDATE se_operadores SET";
        $this->sSql .= " data_bloqueio = null,";
        $this->sSql .= " numg_operadorBloq = null";
        $this->sSql .= " WHERE numg_operador=" . $nNumgOperador;
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.desbloquear(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: atualiza o �ltimo acesso do operador ao sistema.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function editarUltimoAcesso($nNumgOperador) {
        $this->sSql = " UPDATE se_operadores SET";
        $this->sSql .= " data_ultimoAcesso = CURRENT_TIMESTAMP";
        $this->sSql .= " WHERE numg_operador=" . $nNumgOperador;
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.editarUltimoAcesso(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: busca os dados de um operador pelo seu login.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function consultarPorNomeOperador($sNomeOperador) {
        $this->sSql = " select numg_operador, nome_completo, data_bloqueio, desc_senha, data_ultimoacesso ";
        $this->sSql .= " from se_operadores where lower(nome_operador) = lower('" . $sNomeOperador . "')";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            return $this->oResultset;
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.consultarPorNomeOperador(); Descri��o: " . $e->getMessage() . "�");
            return false;
        }
    }

    /**
     * Descri��o: busca os operadores bloqueados.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function consultarBloqueados() {
        $this->sSql = " select ope.numg_operador, ope.nome_completo, ope.data_cadastro";
        $this->sSql .= " from se_operadores ope";
        $this->sSql .= " where not data_bloqueio is null";
        $this->sSql .= " order by nome_operador";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            return $this->oResultset;
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.consultarBloqueados(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: busca os operadores n�o bloqueados.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function consultarNaoBloqueados() {
        $this->sSql = "select ope.numg_operador, ope.nome_completo, ope.data_cadastro";
        $this->sSql .= " from se_operadores ope";
        $this->sSql .= " where data_bloqueio is null";
        $this->sSql .= " order by nome_operador";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.consultarNaoBloqueados(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: busca os dados de um operador pelo seu login.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function consultarOperadores($vDados) {
        $this->sSql = "select ope.numg_operador, ope.nome_completo, ope.desc_email, ope.data_cadastro";
        $this->sSql .= " from se_operadores ope";
        $this->sSql .= " where";
        if (!empty($vDados)) {
            if ($vDados[0] != "") {
                $this->sSql .= " (lower(ope.nome_completo) like lower('%" . $vDados[1] . "%')) and";
            }
            if ($vDados[1] != "" && $vDados[2] != "") {
                $this->sSql .= " (ope.data_nascimento between " . FormataDataConsulta($vDados[1] . " 00:00:00") . " and " . FormataDataConsulta($vDados[2] . " 23:59:59") . ") and";
            }
            if ($vDados[3] != "" && $vDados[4] != "") {
                $this->sSql .= " (ope.data_cadastro between " . FormataDataConsulta($vDados[3] . " 00:00:00") . " and " . FormataDataConsulta($vDados[4] . " 23:59:59") . ") and";
            }
        }
        $this->sSql .= " 1=1";
        $this->sSql .= " order by ope.nome_completo";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.consultarOperadores(); Descri��o: " . $e->getMessage() . "�");
            return false;
        }
    }

    /**
     * Descri��o: envia a senha de acesso (e nome de usu�rio) para o operador via e-mail.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    public function enviarSenha($nNumgOperador) {
        $this->sSql = " select nome_operador, desc_senha, nome_completo, desc_email ";
        $this->sSql .= " from se_operadores where numg_operador = " . $nNumgOperador;
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.enviarSenha(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
        if (!empty($this->oResultset)) {
            $sMens = "Voc� est� recebendo este e-mail porque voc� � um operador do Sistema sis - Miss�o Tocando as Na��es." . chr(13) . chr(13);
            $sMens .= "Abaixo seguem os dados para acesso ao sistema:" . chr(13);
            $sMens .= "Operador: " . $this->oResultset->getValores(0, 0) . chr(13);
            $sMens .= "Senha: " . Descriptografa($this->oResultset->getValores(0, 1)) . chr(13);
            $sMens .= "Atenciosamente," . chr(13) . chr(13);
            $sMens .= "Equipe sis" . chr(13);
            $sMens .= "suporte.sis.setal@gmail.com" . chr(13);
            $sMens .= "www.mtn.org.br";
            try {
                /**
                 * ENVIA E-MAIL COM OS DADOS DE ACESSO AO SISTEMA
                 */
//           EnviaEmail($this->oResultset[0][2],$this->oResultset[0][3],"SBS - Envio de Senha",$sMens);
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.enviarSenha(); Descri��o: " . $e->getMessage() . "�");
                return false;
            }
        }
    }

    /**
     * Descri��o: Consulta Operador por grupo.
     * @author Fabricio Nogueira.
     * Data: 13/09/2010.
     */
    function consultaOperadorPorGrupo($numgGrupo=null) {
        if ($this->oErro->isError()) {
            return false;
        } else {
            $this->sSql = "  SELECT o.numg_operador, o.nome_operador, ";
            $this->sSql .=" o.nome_completo, o.desc_senha, o.desc_email, ";
            $this->sSql .=" o.data_cadastro, o.numg_operadorcad, o.data_ultimaalt, ";
            $this->sSql .=" o.numg_operadoralt, o.data_bloqueio, o.numg_operadorbloq, ";
            $this->sSql .=" o.data_ultimoacesso ";
            $this->sSql .=" FROM se_operadores o ";
            $this->sSql .=" left join se_operadoresgrupos og on og.numg_operador = o.numg_operador ";
            $this->sSql .=" left join se_grupos g on g.numg_grupo = og.numg_grupo ";
            if (!empty($numgGrupo))
                $this->sSql .=" where g.numg_grupo = " . $numgGrupo;
            try {
                $this->Oad->conectar();
                $result = $this->Oad->consultar($this->sSql);
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Operador.consultaOperadorPorGrupo()" . $e->getMessage() . "�");
                $this->Oad->desconectar();
                return false;
            }
            $this->Oad->desconectar();
            return $result;
        }
    }

    /**
     * Descri��o: valida os dados de um operador antes de cadastr�-lo ou edit�-lo.
     * @author Fabricio Nogueira.
     * Data: 30/08/2010.
     */
    private function pValidaGravacao() {
        /**
         * VERIFICA SE ALGUM OPERADOR EST� TENTANDO ALTERAR OS DADOS DO
         */
        if ($this->numgOperador == 1 && $this->numgOperadorAlt != 1) {
            $this->oErro->addErro("Somente o Administrador Geral do Sistema tem permiss�o para alterar dados do operador Geral.�");
        }
        /**
         * NOME_operador
         */
        if (trim($this->nomeOperador) != "") {
            /**
             * SE FOR UMA INCLUS�O
             */
            if ($this->numgOperador == 0) {
                /**
                 * VERIFICA SE J� EXISTE ALGUM REGISTRO CADASTRADO COM O NOME INFORMADO
                 */
                if ($this->Oad->consultar("select numg_operador from se_operadores where lower(nome_operador) = lower('" . trim($this->nomeOperador) . "')")->getCount() > 0) {
                    $this->oErro->addErro("J� existe um Operador cadastrado com o nome " . $this->nomeOperador . ".�");
                }
            } else {
                $this->oResultset = $this->Oad->consultar("select numg_operador from se_operadores where lower(nome_operador) = lower('" . trim($this->nomeOperador) . "')");
                if ($this->oResultset->getCount() > 0) {
                    /**
                     * SE O N� IDENTIFICADOR FOR DIFERENTE, SIGNIFICA QUE J� EXISTE UM REGISTRO COM NOME INFORMADO PARA EDI��O
                     */
                    if ($this->oResultset->getValores(0, 0) != $this->numgOperador) {
                        $this->oErro->addErro("J� existe um Operador cadastrado com o nome " . $this->nomeOperador . ".�");
                    }
                }
            }
        }
    }

    /**
     * Descri��o: consultar todos operadores.
     * @author Fabricio Nogueira.
     * Data: 14/09/2010.
     */
    public function consultarTodosOperadores() {
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar("select numg_operador, nome_completo, data_cadastro,data_bloqueio from se_operadores order by nome_completo");
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.consultarTodosOperadores(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->desconectar();
            return false;
        }
        return $this->oResultset;
    }

    /**
     * Descri��o: valida os dados de um operador antes de exclu�-lo.
     * @author Fabricio Nogueira.
     * Data: 14/09/2010.
     */
    private function pValidaExclusao($nNumgOperador) {
        if ($nNumgOperador == 1) {
            $this->oErro->addErro("N�o � permitido excluir o Administrador Geral do sistema.�");
        }
        if ($this->Oad->consultar("select numg_formulario from se_formularios where numg_operadorCad = " . $nNumgOperador . " or numg_operadorBloq = " . $nNumgOperador)->getCount() > 0) {
            $this->oErro->addErro("Este operador � respons�vel pelo cadastro ou bloqueio de algum formul�rio do sistema. N�o � poss�vel exclu�-lo.�");
        }
        if ($this->Oad->consultar("select numg_grupo from se_grupos where numg_operadorCad = " . $nNumgOperador . " or numg_operadorBloq = " . $nNumgOperador)->getCount() > 0) {
            $this->oErro->addErro("Este operador � respons�vel pelo cadastro ou bloqueio de algum grupo de acesso. N�o � poss�vel exclu�-lo.�");
        }
        if ($this->Oad->consultar("select numg_grupo from se_operadoresgrupos where numg_operador = " . $nNumgOperador)->getCount() > 0) {
            $this->oErro->addErro("Este operador est� vinculado a algum grupo de acesso. N�o � poss�vel exclu�-lo.�");
        }
    }

    /**
     * Descri��o: valida os dados do operador antes de bloque�-lo.
     * @author Fabricio Nogueira.
     * Data: 14/09/2010.
     */
    private function pValidaBloqueio($nNumgOperador) {
        if ($nNumgOperador == 1) {
            $this->oErro->addErro("N�o � permitido bloquear o Administrador Geral do Sistema.�");
        }
    }

    /**
     * Descri��o: altera a senha de um operador
     * @author Fabricio Nogueira.
     * Data: 14/09/2010.
     */
    public function editarSenha($vDados) {
        $this->sSql = " UPDATE se_operadores SET";
        $this->sSql .= " desc_senha = " . FormataStr(Criptografa($vDados[1]));
        $this->sSql .= " WHERE numg_operador=" . $vDados[0];
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Operador.editarSenha(); Descri��o: " . $e->getMessage() . "�");
            $this->Oad->rollback();
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descri��o: gerar relat�rio
     * @author Rodolfo Bueno.
     * Data: 09/10/2010.
     */
    public function consultaRelatorioOperadores($array, $ordem) {
        $this->sSql = "  SELECT o.numg_operador, o.nome_operador, o.nome_completo, o.desc_email, ";
        $this->sSql .=" o.data_cadastro, o.data_bloqueio, g.nome_grupo ";
        $this->sSql .=" FROM se_operadores o ";
        $this->sSql .=" left join se_operadoresgrupos og on og.numg_operador = o.numg_operador ";
        $this->sSql .=" left join se_grupos g on g.numg_grupo = og.numg_grupo where o.numg_operador is not null";

        if ($array[nomeOperador] != "") {
            $this->sSql .=" and lower(o.nome_completo) like '%" . strtolower($array[nomeOperador]) . "%'";
        }

        if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
            $this->sSql .=" and o.data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
        } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and o.data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
        } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and o.data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
        }

        if ($array[status] == "ativos") {
            $this->sSql .= " and o.data_bloqueio is null";
        } else if ($array[status] == "bloq") {
            $this->sSql .= " and o.data_bloqueio is not null";
        }

        if ($array[grupo] != "null") {
            $this->sSql .= " and g.numg_grupo =" .$array[grupo];
        }

        if ($ordem == "nome") {
            $this->sSql .= " order by o.nome_completo";
        } else {
            $this->sSql .= " order by o.data_cadastro";
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