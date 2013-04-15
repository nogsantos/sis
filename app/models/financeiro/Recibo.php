<?php

/**
 * Descrição: Model Cadastro de Recibos.
 * @author Rodolfo Bueno.
 * @release
 * Data 17/10/2010
 */
class Recibo {

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
    private $numgRecibo;
    private $numrRecibo;
    private $dataEmissao;
    private $valrRecibo;
    private $descReferente;
    private $numgProfessor;
    private $descObs;
    private $dataCadastro;
    private $numgOperadorCad;
    private $descStatus;
    private $dataReemissao;
    private $numgOperadorRem;
    private $dataCancelamento;
    private $numgOperadorCanc;
    private $descTipo;
    private $numgAluno;
    private $numrcpfcnpjEmi;
    private $descEmitente;
    private $numrcpfcnpjRec;
    private $descRecebido;
    private $numgReferente;
    private $nomePessoa;
    private $numrCpnpj;


    /**
     * Construtor.
     * @author Rodolfo Bueno.
     * Data: 17/10/2010.
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
     * Descrição: Set and Get número gerado do recibo [obrigatório].
     */
    public function setNumgRecibo($numgRecibo) {
        if (is_numeric($numgRecibo)) {
            $this->numgRecibo = $numgRecibo;
        } else {
            $this->oErro->addErro("N° identificador do Recibo inválido.ß");
        }
    }

    public function getNumgRecibo() {
        return $this->numgRecibo;
    }

    /**
     * Descrição: Set and Get número do recibo [obrigatório].
     */
    public function setNumrRecibo($numrRecibo) {
        if ($numrRecibo == "" || !is_integer($numrRecibo))
            $this->numrRecibo = $numrRecibo;
        else
            $this->oErro->addErro("Número do Recibo Inválido.ß");
    }

    public function getNumrRecibo() {
        return $this->numrRecibo;
    }

    /**
     * Descrição: Set and Get data de emissão do Recibo [obrigatório].
     */
    public function setDataEmissao($dataEmissao) {
        if ($dataEmissao != "") {
            $this->dataEmissao = $dataEmissao;
        } else {
            $this->oErro->addErro("Data de emissão Inválida.ß");
        }
    }

    public function getDataEmissao() {
        return $this->dataEmissao;
    }

    /**
     * Descrição: Set and Get descricão da referencia do recibo [obrigatório].
     */
    public function setDescReferente($descReferente) {
        if (trim($descReferente) != "") {
            $this->descReferente = $descReferente;
        } else {
            $this->oErro->addErro("Campo 'Referente' inválido.ß");
        }
    }

    public function getDescReferente() {
        return $this->descReferente;
    }

    /**
     * Descrição: Set and Get valor do recibo [obrigatório].
     */
    public function setValrRecibo($valrRecibo) {
        $this->valrRecibo = $valrRecibo;
    }

    public function getValrRecibo() {
        return $this->valrRecibo;
    }

    /**
     * Descrição: Set and Get observações do recibo.
     */
    public function setDescObs($descObs) {
        $this->descObs = $descObs;
    }

    public function getDescObs() {
        return $this->descObs;
    }

    /**
     * Descrição: Set and Get status do recibo.
     */
    public function setDescStatus($descStatus) {
        $this->descStatus = $descStatus;
    }

    public function getDescStatus() {
        return $this->descStatus;
    }

    /**
     * Descrição: Set and Get numero gerado do professor emitente do recibo. (TIPO DO RECIBO: PROFESSOR)
     */
    public function setNumgProfessor($numgProfessor) {
        if (trim($numgProfessor) != "") {
            $this->numgProfessor = $numgProfessor;
        } else {
            $this->oErro->addErro("Emitente inválido.ß");
        }
    }

    public function getNumgProfessor() {
        return $this->numgProfessor;
    }

     /**
     * Descrição: Set and Get nome do professor emitente do recibo.
     */
    public function setNomeProfessor($nomeProfessor) {
        if (trim($nomeProfessor) != "") {
            $this->nomeProfessor = $nomeProfessor;
        } else {
            $this->oErro->addErro("Nome do professor inválido.ß");
        }
    }

    public function getNomeProfessor() {
        return $this->nomeProfessor;
    }

    /**
     * Descrição: Set and Get numero gerado do aluno. (TIPO DO RECIBO: ALUNO)
     */
    public function setNumgAluno($numgAluno) {
        if (trim($numgAluno) != "") {
            $this->numgAluno = $numgAluno;
        } else {
            $this->oErro->addErro("Emitente inválido.ß");
        }
    }

    public function getNumgAluno() {
        return $this->numgAluno;
    }

    /**
     * Descrição: Set and Get data de cadastro do Recibo.
     */
    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Descrição: Set and Get operador de cadastro do Recibo.
     */
    public function setNumgOperadorCad($numgOperador) {
        $this->numgOperadorCad = $numgOperador;
    }

    public function getNumgOperadorCad() {
        return $this->numgOperadorCad;
    }

    /**
     * Descrição: Set and Get nome do operador de cadastro da Recibo.
     */
    public function setNomeOperadorCad($nomeOperador) {
        $this->nomeOperadorCad = $nomeOperador;
    }

    public function getNomeOperadorCad() {
        return $this->nomeOperadorCad;
    }

    /**
     * Descrição: Set and Get data de reemissao do Recibo.
     */
    public function setDataReemissao($dataReemissao) {
        $this->dataReemissao = $dataReemissao;
    }

    public function getDataReemissao() {
        return $this->dataReemissao;
    }

    /**
     * Descrição: Set and Get operador reemissao do Recibo.
     */
    public function setNumgOperadorRem($numgOperador) {
        $this->numgOperadorRem = $numgOperador;
    }

    public function getNumgOperadorRem() {
        return $this->numgOperadorRem;
    }

    /**
     * Descrição: Set and Get nome do operador de reemissao do Recibo.
     */
    public function setNomeOperadorRem($nomeOperador) {
        $this->nomeOperadorRem = $nomeOperador;
    }

    public function getNomeOperadorRem() {
        return $this->nomeOperadorRem;
    }

    /**
     * Descrição: Set and Get data de cancelamento de Recibo.
     */
    public function setDataCancelamento($dataCancelamento) {
        $this->dataCancelamento = $dataCancelamento;
    }

    public function getDataCancelamento() {
        return $this->dataCancelamento;
    }

    /**
     * Descrição: Set and Get operador de cancelamento de Recibo.
     */
    public function setNumgOperadorCanc($numgOperador) {
        $this->numgOperadorCanc = $numgOperador;
    }

    public function getNumgOperadorCanc() {
        return $this->numgOperadorCanc;
    }

    /**
     * Descrição: Set and Get nome do operador de cancelamento do Recibo.
     */
    public function setNomeOperadorCanc($nomeOperador) {
        $this->nomeOperadorCanc = $nomeOperador;
    }

    public function getNomeOperadorCanc() {
        return $this->nomeOperadorCanc;
    }

    /**
     * Descrição: Set and Get TIPO do recibo. (Três tipos: P - Professor, A - Alunos e V - Avulsos)
     */
    public function setDescTipo($descTipo) {
        $this->descTipo = $descTipo;
    }

    public function getDescTipo() {
        return $this->descTipo;
    }

        /**
     * Descrição: Set and Get cpf/cnpj do emitente do recibo (tipo: AVULSO).
     */
    public function setNumrCpfCnpjEmi($numrcpfcnpjEmi) {
        $this->numrcpfcnpjEmi = $numrcpfcnpjEmi;
    }

    public function getNumrCpfCnpjEmi() {
        return $this->numrcpfcnpjEmi;
    }

        /**
     * Descrição: Set and Get nome do emitente (Tipo: AVULSO).
     */
    public function setDescEmitente($descEmitente) {
        $this->descEmitente = $descEmitente;
    }

    public function getDescEmitente() {
        return $this->descEmitente;
    }

    /**
     * Descrição: Set and Get cpf/cnpj de quem está efetuando o pagamento (tipo: AVULSO).
     */
    public function setNumrCpfCnpjRec($numrcpfcnpjRec) {
        $this->numrcpfcnpjRec = $numrcpfcnpjRec;
    }

    public function getNumrCpfCnpjRec() {
        return $this->numrcpfcnpjRec;
    }

    /**
     * Descrição: Set and Get nome de quem está efetuando o pagamento (Tipo: AVULSO).
     */
    public function setDescRecebido($descRecebido) {
        $this->descRecebido = $descRecebido;
    }

    public function getDescRecebido() {
        return $this->descRecebido;
    }

    /**
     * Descrição: Set and Get numero gerado da referencia.
     */
    public function setNumgReferente($numgReferente) {
        if (trim($numgReferente) != "") {
            $this->numgReferente = $numgReferente;
        } else {
            $this->oErro->addErro("Referencia inválido.ß");
        }
    }

    public function getNumgReferente() {
        return $this->numgReferente;
    }


    public function setNomePessoa($nomePessoa){$this->nomePessoa = $nomePessoa;}
    public function getNomePessoa(){return $this->nomePessoa;}
    public function setNumrCpfCnpj($numrCpfCnpj){$this->numrCpnpj = $numrCpfCnpj;}
    public function getNumrCpfCnpj(){return $this->numrCpnpj;}

    
    /*     * **************************************************************************** */
    /*                       Cadastros e Ações Diversas                            */
    /*     * **************************************************************************** */

    /**
     * Descrição: seta os dados de um recibo pelo seu nº identificador ou código.
     * @author Rodolfo Bueno.
     * Data: 18/10/2010.
     */
    public function setarDados( $numgRecibo=null, $tipo=null,$numrRecibo=null) {
        $this->sSql = " select rec.numg_recibo, rec.numr_recibo, rec.data_emissao, rec.valr_recibo, ope2.nome_operador as usuarioreemissao,
                          rec.desc_referente, rec.desc_obs, rec.data_cadastro, rec.data_cancelamento, ope3.nome_operador as usuariocanc,
                          ope1.nome_operador as usuariocadastro, case rec.desc_status
                                                                 when 'E' then 'Emitido'
                                                                 when 'R' then 'Reemitido'
                                                                 when 'C' then 'Cancelado'
                                                                 end as status, rec.data_reemissao, rec.desc_tipo, rec.numg_referente";

            if ($tipo == "P") {
                 $this->sSql .= " ,rec.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomeprofessor, p.numr_cpfcnpj
                     as cpfprofessor";
            } else if($tipo == "V"){
                 $this->sSql .= " ,rec.numr_cpfcnpjemi, rec.desc_emitente, rec.numr_cpfcnpjrec, rec.desc_recebido";
            } else {
                $this->sSql .= " ,rec.numg_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomealuno, p.numr_cpfcnpj as cpfaluno";
            }
            
        $this->sSql .= " from fi_recibos rec";
        $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = rec.numg_usuariocadastro";
        $this->sSql .= " left join se_operadores ope2 on ope2.numg_operador = rec.numg_usuarioreemissao";
        $this->sSql .= " left join se_operadores ope3 on ope3.numg_operador = rec.numg_usuariocanc";

            if ($tipo == "P") {
                $this->sSql .= " inner join mu_professores prof on prof.numg_professor = rec.numg_professor";
                $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = prof.numg_professor";
            } else if($tipo == "A"){
                $this->sSql .= " inner join mu_alunos alu on alu.numg_aluno = rec.numg_aluno";
                $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = alu.numg_aluno";
            }
        if($numgRecibo != null)
            $this->sSql .= " where rec.numg_recibo = " . $numgRecibo;
        if($numrRecibo != null)
            $this->sSql .= " where rec.numr_recibo = " . $numrRecibo;

        if($tipo != null){
            $this->sSql .= " and rec.desc_tipo= '".$tipo."'";
        }
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Recibo.setarDados(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
        if ($this->oResultset->getCount() > 0) {
            $this->numgRecibo = $this->oResultset->getValores(0, numg_recibo);
            $this->numrRecibo = $this->oResultset->getValores(0, numr_recibo);
            $this->dataEmissao = FormataData($this->oResultset->getValores(0, data_emissao));
            $this->valrRecibo = $this->oResultset->getValores(0, valr_recibo);
            $this->descReferente = $this->oResultset->getValores(0, desc_referente);
            $this->descObs = $this->oResultset->getValores(0, desc_obs);
            $this->dataCadastro = FormataData($this->oResultset->getValores(0, data_cadastro));
            $this->nomeOperadorCad = $this->oResultset->getValores(0, usuariocadastro);
            $this->descStatus = $this->oResultset->getValores(0, status);
            $this->dataReemissao = FormataData($this->oResultset->getValores(0, data_reemissao));
            $this->nomeOperadorRem = $this->oResultset->getValores(0, usuarioreemissao);
            $this->dataCancelamento = FormataData($this->oResultset->getValores(0, data_cancelamento));
            $this->nomeOperadorCanc = $this->oResultset->getValores(0, usuariocanc);
            $this->descTipo = $this->oResultset->getValores(0, desc_tipo);
            $this->numgReferente = $this->oResultset->getValores(0, numg_referente);
            if ($tipo == "P") {
                $this->numgProfessor = $this->oResultset->getValores(0, numg_professor);
                $this->nomePessoa = $this->oResultset->getValores(0, nomeprofessor);
                $this->numrCpnpj = $this->oResultset->getValores(0, cpfprofessor);
            } else if($tipo == "V"){
                $this->numrcpfcnpjEmi = $this->oResultset->getValores(0, numr_cpfcnpjemi);
                $this->descEmitente = $this->oResultset->getValores(0, desc_emitente);
                $this->numrcpfcnpjRec = $this->oResultset->getValores(0, numr_cpfcnpjrec);
                $this->descRecebido = $this->oResultset->getValores(0, desc_recebido);
            } else {
                $this->numgAluno = $this->oResultset->getValores(0, numg_aluno);
                $this->nomePessoa = $this->oResultset->getValores(0, nomealuno);
                $this->numrCpnpj = $this->oResultset->getValores(0, cpfaluno);
            }

        }
        return true;
    }

    /**
     * Descrição: cadastra o recibo.
     * @author Rodolfo Bueno.
     * Data: 18/10/2010.
     */
    public function cadastrar() {
        $this->Oad->conectar();
        if ($this->oErro->isError()) {
            $this->Oad->desconectar();
            return false;
        } else {
            $numrRecibo = $this->geraNumrRecibo();
            $this->sSql = " INSERT INTO fi_recibos (numr_recibo, data_emissao, valr_recibo, desc_referente,
                          desc_obs, data_cadastro, desc_status, numg_usuariocadastro, desc_tipo, numg_referente,";
            if ($this->getDescTipo() == "P") {
                $this->sSql .=  " numg_professor ) values (";
            } else if($this->getDescTipo() == "A"){
                $this->sSql .= " numg_aluno ) values (";
            } else {
                $this->sSql .= " numr_cpfcnpjemi, desc_emitente, numr_cpfcnpjrec, desc_recebido ) values (";
            }
                
            $this->sSql .= FormataNumeroGravacao($numrRecibo) . ",";
            $this->sSql .= FormataDataGravacao($this->getDataEmissao()) . ",";
            $this->sSql .= FormataValorGravacao($this->getValrRecibo()) . ",";
            $this->sSql .= FormataStr($this->getDescReferente()) . ",";
            $this->sSql .= FormataStr($this->getDescObs()) . ",";
            $this->sSql .= "CURRENT_TIMESTAMP,";
            $this->sSql .= "'E',";
            $this->sSql .= $this->getNumgOperadorCad(). ",";
            $this->sSql .= FormataStr($this->getDescTipo()).",";
            $this->sSql .= FormataNumeroGravacao($this->getNumgReferente()) . ",";

            if ($this->getDescTipo() == "P") {
                $this->sSql .= FormataNumeroGravacao($this->getNumgProfessor()) . ")";
            } else if($this->getDescTipo() == "A"){
                $this->sSql .= FormataNumeroGravacao($this->getNumgAluno()) . ")";
            } else {
                $this->sSql .= FormataStr($this->getNumrCpfCnpjEmi()) . ",";
                $this->sSql .= FormataStr($this->getDescEmitente()) . ",";
                $this->sSql .= FormataStr($this->getNumrCpfCnpjRec()) . ",";
                $this->sSql .= FormataStr($this->getDescRecebido()) . ")";
            }
            
            try {
                $this->Oad->conectar();
                $this->Oad->begin();
                $this->Oad->executar($this->sSql);
                $this->Oad->commit();
                $this->sSqlAux = $this->Oad->consultar("select max(numg_recibo) from fi_recibos");
                $this->setNumgRecibo($this->sSqlAux->getValores(0, max));
            } catch (Exception $e) {
                $this->oErro->addErro("Fonte: SGM.Recibo.cadastrar(); Descrição: " . $e->getMessage() . "ß");
                $this->Oad->rollback();
                $this->Oad->desconectar();
                return false;
            }
        }
        $this->Oad->desconectar();
        return true;
    }

    /**
     * Descrição: busca os recibos cadastrados (GRID)
     * @author Rodolfo Bueno.
     * Data: 19/10/2010.
     */
    public function consultarRecibos($tipo) {
        $this->sSql = " select rec.numg_recibo, rec.numr_recibo, rec.data_emissao, rec.valr_recibo,
                          rec.desc_referente, rec.desc_obs, rec.data_cadastro, ope1.nome_operador as usuariocadastro,
                          case rec.desc_status
                         when 'E' then 'Emitido'
                         when 'R' then 'Reemitido'
                         when 'C' then 'Cancelado'
                         end as status, rec.desc_tipo";
        if ($tipo == "P") {
             $this->sSql .= " ,rec.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomepessoa";
        } else if($tipo == "A"){
             $this->sSql .= " ,rec.numg_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomepessoa";
        } else{
             $this->sSql .= " ,rec.numr_cpfcnpjemi, rec.desc_emitente, rec.numr_cpfcnpjrec, rec.desc_recebido";
        }
        
        $this->sSql .= " from fi_recibos rec";
        $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = rec.numg_usuariocadastro";
        if ($tipo == "P") {
            $this->sSql .= " inner join mu_professores prof on prof.numg_professor = rec.numg_professor";
            $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = prof.numg_professor";
        } else if($tipo == "A"){
            $this->sSql .= " inner join mu_alunos alu on alu.numg_aluno = rec.numg_aluno";
            $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = alu.numg_aluno";
        }
        $this->sSql .= " where rec.desc_tipo = '". $tipo . "'";
        $this->sSql .= " order by rec.numg_recibo desc LIMIT 20";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Formulario.consultarRecibos(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }

    /**
     * Descrição: Reemitir um recibo.
     * @author Rodolfo Bueno.
     * Data: 20/10/2010
     */
    public function reemitir() {
        try {
            $this->sSql = " update fi_recibos set data_reemissao = now(), desc_status = 'R', numg_usuarioreemissao = " . FormataNumeroGravacao($this->getNumgOperadorRem()) . "
                        where numg_recibo =  " . FormataNumeroGravacao($this->getNumgRecibo()) . ";";
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->Oad->rollback();
            $this->Oad->desconectar();
            $this->oErro->addErro("Fonte: Recibo.reemitir(); Descrição: " . $e->getMessage() . "ß");
            return false;
        }
    }

    /**
     * Descrição: Cancelar um recibo.
     * @author Rodolfo Bueno.
     * Data: 20/10/2010
     */
    public function cancelar() {
        try {
            $this->sSql = " update fi_recibos set desc_status = 'C', data_cancelamento = now(), numg_usuariocanc = " . FormataNumeroGravacao($this->getNumgOperadorCanc()) . "
                where numg_recibo =  " . FormataNumeroGravacao($this->getNumgRecibo()) . ";";
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->Oad->rollback();
            $this->Oad->desconectar();
            $this->oErro->addErro("Fonte: Recibo.cancelar(); Descrição: " . $e->getMessage() . "ß");
            return false;
        }
    }

     /**
     * Descrição: Consulta -  Relatório de Recibos
     * @author Rodolfo Bueno.
     * Data: 30/10/2010
     */
    public function consultaRelatorioRecibos($array, $ordem) {
    $this->sSql = "  select rec.numg_recibo, rec.numr_recibo, rec.data_emissao, rec.valr_recibo,
                      rec.desc_referente, rec.desc_obs, rec.data_cadastro, ope1.nome_operador as usuariocadastro,
                      case rec.desc_status
                     when 'E' then 'Emitido'
                     when 'R' then 'Reemitido'
                     when 'C' then 'Cancelado'
                     end as status, rec.desc_tipo ";

    if ($array[tipo] == "P") {
         $this->sSql .= " ,rec.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomeprofessor";
    } else if($array[tipo] == "A"){
         $this->sSql .= " ,rec.numg_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomealuno";
    } else{
         $this->sSql .= " , rec.desc_emitente, rec.desc_recebido";
    }

    $this->sSql .= " from fi_recibos rec";
    $this->sSql .= " inner join se_operadores ope1 on ope1.numg_operador = rec.numg_usuariocadastro";
    if ($array[tipo] == "P") {
        $this->sSql .= " inner join mu_professores prof on prof.numg_professor = rec.numg_professor";
        $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = prof.numg_professor";
    } else if($array[tipo] == "A"){
        $this->sSql .= " inner join mu_alunos alu on alu.numg_aluno = rec.numg_aluno";
        $this->sSql .= " left join ge_pessoas p on p.numg_pessoa = alu.numg_aluno";
    }
    $this->sSql .= " where rec.numg_recibo is not null";

    if ($array[numrRecibo] != "") {
        $this->sSql .= " and rec.numr_recibo = " .$array[numrRecibo];
    }

    if ($array[tipo] != "" && $array[tipo] != "T") {
        $this->sSql .= " and rec.desc_tipo = '" .$array[tipo] . "'";
    }

    if ($array[tipo] == "P" || $array[tipo] == "A") {
        if ($array[numrCpfCnpjEmi] != ""){
            $this->sSql .=" and p.numr_cpfcnpj = '" .$array[numrCpfCnpjEmi] . "'";
        }
        if($array[nomeEmitente] != ""){
            $this->sSql .=" and lower(p.desc_nomepessoa) like '%" . strtolower($array[nomeEmitente]) . "%' or
            lower(p.desc_sobrenomepessoa) like '%" . strtolower($array[nomeEmitente]) . "%'";
        }
        if($array[nomeDevedor] != ""){
            $this->sSql .=" and lower(p.desc_nomepessoa) like '%" . strtolower($array[nomeDevedor]) . "%' or
            lower(p.desc_sobrenomepessoa) like '%" . strtolower($array[nomeDevedor]) . "%'";
        }
        if ($array[numrCpfCnpjDev] != ""){
            $this->sSql .=" and p.numr_cpfcnpj = '" .$array[numrCpfCnpjDev] . "'";
        }
    }

    if ($array[tipo] == "V") {
        if($array[nomeEmitente] != ""){
            $this->sSql .=" and lower(rec.desc_emitente) like '%" . strtolower($array[nomeEmitente]) . "%'";
        }
        if($array[nomeDevedor] != ""){
            $this->sSql .=" and lower(rec.desc_recebido) like '%" . strtolower($array[nomeDevedor]) . "%'";
        }
        if ($array[numrCpfCnpjEmi] != "")  {
            $this->sSql .=" and rec.numr_cpfcnpjemi = '" .$array[numrCpfCnpjEmi] . "'";
        }
        if ($array[numrCpfCnpjDev] != "")  {
            $this->sSql .=" and rec.numr_cpfcnpjrec = '" .$array[numrCpfCnpjDev] . "'";
        }
    }

    if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
        $this->sSql .=" and rec.".$array[tipoData]." >= " . FormataDataConsulta($array[dataCadastroIni]);
    } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
        $this->sSql .=" and rec.".$array[tipoData]." <= " . FormataDataConsulta($array[dataCadastroFin]);
    } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
        $this->sSql .=" and rec.".$array[tipoData]." BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
    }

    if ($array[status] == "E") {
        $this->sSql .= " and rec.desc_status = '" .$array[status] . "'";
    } else if ($array[status] == "R") {
        $this->sSql .= " and rec.desc_status = '" .$array[status] . "'";
    } else if ($array[status] == "C") {
        $this->sSql .= " and rec.desc_status = '" .$array[status] . "'";
    }

    if ($array[tipoOrdem] != ""){
        if ($ordem == "num") {
            $this->sSql .= " order by rec.numr_recibo ".$array[tipoOrdem];
        } else {
            $this->sSql .= " order by rec.".$array[tipoData]." ".$array[tipoOrdem];
        }
     }

        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.gerar(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }


    /**
     * Descrição: Consulta -  Gráficos de Recibos
     * @author Rodolfo Bueno.
     * Data: 17/11/2010
     */
   public function geracaoGraficos($dataIni, $dataFin, $tipoData, $tipoGrafico) {
       if($tipoGrafico == "T"){
            $this->sSql = " select valr_recibo, desc_status, desc_tipo ";
        } else if($tipoGrafico == 'S'){
            $this->sSql = " select desc_status ";
        } else if($tipoGrafico == 'P'){
            $this->sSql = " select desc_tipo ";
        } else {
            $this->sSql = " select valr_recibo ";
        }

        $this->sSql .= " from fi_recibos where numg_recibo is not null ";
        if ($dataIni != null && $dataFin == null) {
            $this->sSql .=" and ".$tipoData." >= " . FormataDataConsulta($dataIni);
        } else if ($dataIni == null && $dataFin != null) {
            $this->sSql .=" and ".$tipoData." <= " . FormataDataConsulta($dataFin);
        } else if ($dataIni != null && $dataFin != null) {
            $this->sSql .=" and ".$tipoData." BETWEEN " . FormataDataConsulta($dataIni) . " and " . FormataDataConsulta($dataFin);
        }

        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset;
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Modalidade.consultarModalidadesNaoBloqueadas(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }
/**
* Descrição: Gera o numero do recibo automáticamente.
 * @author Fabricio Nogueira.
 * Data: 17/12/2010.
 */
public function geraNumrRecibo(){
    $this->sSql = "select max(numr_recibo) from fi_recibos";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getValores(0,"max") + 1;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Recibo.geraNumrRecibo(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
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