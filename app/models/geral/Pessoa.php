<?php
/**
 * Descrição: Model Pessoa.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 28/08/2010
 */
abstract class Pessoa {
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
    protected $numgPessoa;
    private $descNomePessoa;
    private $descSobreNomePessoa;
    private $dataNascimento;
    private $descSexo;
    private $descEndereco;
    private $numrEndereco;
    private $descBairro;
    private $descComplemento;
    private $numrCep;
    private $siglPais;
    private $numrDddTelefone;
    private $numrTelefone;
    private $numrDddFax;
    private $numrFax;
    private $descObservacao;
    private $dataCadastro;
    private $numgUsuarioCadastro;
    private $dataUltimaAlteracao;
    private $numgUsuarioAlteracao;
    private $descTipo;
    private $numgMunicipio;
    private $descNomePai;
    private $descNomeMae;
    private $descNaturalidade;
    private $descNacionalidade;
    private $descOrgaoExpedidor;
    private $descEstadoCivil;
    private $numrFilhos;
    private $numrDddCelular;
    private $numrCelular;
    private $numrDddTelefoneContato;
    private $numrTelefoneContato;
    private $numrCarteiraIdentidade;
    private $siglUf; /*essa proprieade no banco está na tabela pr_municipios*/
    private $descNomeMunicipio; /*essa proprieade no banco está na tabela pr_municipios*/
    private $numrCpfcnpj;
    private $descEmail;
    private $nomeOperador;/*essa proprieade no banco está na tabela se_operadores*/
    private $nomeUsuarioCadastro;/*essa proprieade no banco está na tabela se_operadores*/
    /**
    * Construtor.
    * @author Fabricio Nogueira.
    * Data: 27/08/2010.
    */
    public function __construct(){
        $oErro = new Erro();
        $Oad = new Oad();
        $oResultset = new Resultset();
        $this->Oad = $Oad;
        $this->oErro = $oErro;
        $this->oResultset = $oResultset;
    }
    /**
     * Descrição: Set and Get numg pessoa [ obrigatório ]
     */
    public function setNumgPessoa($numgPessoa) {
        if(is_int($numgPessoa) && $numgPessoa!=""){
            $this->numgPessoa = $numgPessoa;
        }else{
            $this->oErro->addErro("ID Pessoa Inválido.ß");
        }
    }
    public function getNumgPessoa(){return $this->numgPessoa;}
    /**
     * Descrição: Set and Get nome pessoa [ obrigatório ]
     */
    public function setDescNomePessoa($descNomePessoa) {
        if($descNomePessoa!=""){
            $this->descNomePessoa = $descNomePessoa;
        }else{
            $this->oErro->addErro("Nome Pessoa Inválido.ß");
        }
    }
    public function getDescNomePessoa(){return $this->descNomePessoa;}
    /**
     * Descrição: Set and Get sobre nome pessoa
     */
    public function setDescSobreNomePessoa($descSobreNomePessoa) {
        if($descSobreNomePessoa!=""){
            $this->descSobreNomePessoa = $descSobreNomePessoa;
        }else{
            $this->descSobreNomePessoa = "";
        }
    }
    public function getDescSobreNomePessoa(){return $this->descSobreNomePessoa;}
    /**
     * Descrição: Set and Get data de nascimento nome pessoa
     */
    public function setDataNascimento($dataNascimento) {
        if($dataNascimento!=""){
            $this->dataNascimento = $dataNascimento;
        }else{
            $this->dataNascimento = "";
        }
    }
    public function getDataNascimento(){return FormataData($this->dataNascimento);}
    /**
     * Descrição: Set and Get sexo pessoa [ M or F]
     */
    public function setDescSexo($descSexo) {
        if($descSexo!=""){
            $this->descSexo = $descSexo;
        }else{
            $this->descSexo = "";
        }
    }
    public function getDescSexo(){return $this->descSexo;}
    /**
     * Descrição: Set and Get endereço pessoa.
     */
    public function setDescEndereco($descEndereco) {
        if($descEndereco!=""){
            $this->descEndereco = $descEndereco;
        }else{
            $this->descEndereco = "";
        }
    }
    public function getDescEndereco(){return $this->descEndereco;}
    /**
     * Descrição: Set and Get desc Bairro.
     */
    public function setDescBairro($descBairro) {
        if($descBairro!=""){
            $this->descBairro = $descBairro;
        }else{
            $this->descBairro = "";
        }
    }
    public function getDescBairro(){return $this->descBairro;}
    /**
     * Descrição: Set and Get numero endereço pessoa.
     */
    public function setNumrEndereco($numrEndereco) {
        if($numrEndereco!=""){
            $this->numrEndereco = $numrEndereco;
        }else{
            $this->numrEndereco = "";
        }
    }
    public function getNumrEndereco(){return $this->numrEndereco;}
    /**
     * Descrição: Set and Get complemento endereço pessoa.
     */
    public function setDescComplemento($descComplemento) {
        if($descComplemento!=""){
            $this->descComplemento = $descComplemento;
        }else{
            $this->descComplemento = "";
        }
    }
    public function getDescComplemento(){return $this->descComplemento;}
    /**
     * Descrição: Set and Get cep pessoa.
     */
    public function setNumrCep($numrCep) {
        if ($numrCep!="") {
            $this->numrCep = $numrCep;
        } else {
            $this->numrCep = "";
        }
    }
    public function getNumrCep(){return $this->numrCep;}
    /**
     * Descrição: Set and Get sigla país pessoa.
     */
    public function setSiglPais($siglPais) {
        if ($siglPais!="") {
            $this->siglPais = $siglPais;
        } else {
            $this->siglPais = "";
        }
    }
    public function getSiglPais(){return $this->siglPais;}
    /**
     * Descrição: Set and Get ddd telefone.
     */
    public function setNumrDddTelefone($numrDddTelefone) {
        if ($numrDddTelefone!="") {
            $this->numrDddTelefone = $numrDddTelefone;
        } else {
            $this->numrDddTelefone = "";
        }
    }
    public function getNumrDddTelefone(){return $this->numrDddTelefone;}
    /**
     * Descrição: Set and Get telefone.
     */
    public function setNumrTelefone($numrTelefone) {
        if ($numrTelefone!="") {
            $this->numrTelefone = $numrTelefone;
        } else {
            $this->numrTelefone = "";
        }
    }
    public function getNumrTelefone(){return $this->numrTelefone;}
    /**
     * Descrição: Set and Get ddd fax.
     */
    public function setNumrDddFax($numrDddFax) {
        if ($numrDddFax!="") {
            $this->numrDddFax = $numrDddFax;
        } else {
            $this->numrDddFax = "";
        }
    }
    public function getNumrDddFax(){return $this->numrDddFax;}
    /**
     * Descrição: Set and Get telefone.
     */
    public function setNumrFax($numrFax) {
        if ($numrFax!="") {
            $this->numrFax = $numrFax;
        } else {
            $this->numrFax = "";
        }
    }
    public function getNumrFax(){return $this->numrFax;}
    /**
     * Descrição: Set and Get Observação.
     */
    public function setDescObservacao($descObservacao) {
        if ($descObservacao!="") {
            $this->descObservacao = $descObservacao;
        } else {
            $this->descObservacao = "";
        }
    }
    public function getDescObservacao(){return $this->descObservacao;}
    /**
     * Descrição: Set and Get data cadastro.
     */
    public function setDataCadastro($dataCadastro){$this->dataCadastro = $dataCadastro;}
    public function getDataCadastro(){return FormataData($this->dataCadastro);}
    /**
     * Descrição: Set and Get usuário cadastro.
     */
    public function setNumgUsuarioCadastro($numgUsuarioCadastro) {
        if ($numgUsuarioCadastro!="") {
            $this->numgUsuarioCadastro = $numgUsuarioCadastro;
        } else {
            $this->numgUsuarioCadastro = "";
        }
    }
    public function getNumgUsuarioCadastro(){return $this->numgUsuarioCadastro;}
    public function setNomeUsuarioCadastro($nomeUsuarioCadastro){$this->nome = $nomeUsuarioCadastro;}
    public function getNomeUsuarioCadastro(){return $this->nomeUsuarioCadastro;}
    /**
     * Descrição: Set and Get data ultima alteração da pessoa.
     */
    public function setDataUltimaAlteracao($dataUltimaAlteracao) {
        if ($dataUltimaAlteracao!="") {
            $this->dataUltimaAlteracao = $dataUltimaAlteracao;
        } else {
            $this->dataUltimaAlteracao = "";
        }
    }
    public function getDataUltimaAlteracao(){return $this->dataUltimaAlteracao;}
    /**
     * Descrição: Set and Get data usuário alteração da pessoa.
     */
    public function setNumgUsuarioAlteracao($numgUsuarioAlteracao) {
        if ($numgUsuarioAlteracao!="") {
            $this->numgUsuarioAlteracao = $numgUsuarioAlteracao;
        } else {
            $this->numgUsuarioAlteracao = "";
        }
    }
    public function getNumgUsuarioAlteracao(){return $this->numgUsuarioAlteracao;}
    /**
     * Descrição: Set and Get Desc tipo pessoa[
     *                             AS - Aluno seminário,
     *                             AM - Aluno Missões,
     *                             EM - Aluno Música,
     *                             PS - professor Seminário,
     *                             PM - Professor Musica ].
     */
    public function setDescTipo($descTipo) {
        if ($descTipo!="") {
            $this->descTipo = $descTipo;
        } else {
            $this->descTipo = "";
        }
    }
    public function getDescTipo(){return $this->descTipo;}
    /**
     * Descrição: Set and Get nome pai.
     */
    public function setDescNomePai($descNomePai) {
        if ($descNomePai!="") {
            $this->descNomePai = $descNomePai;
        } else {
            $this->descNomePai = "";
        }
    }
    public function getDescNomePai(){return $this->descNomePai;}
    /**
     * Descrição: Set and Get nome mãe.
     */
    public function setDescNomeMae($descNomeMae) {
        if ($descNomeMae!="") {
            $this->descNomeMae = $descNomeMae;
        } else {
            $this->descNomeMae = "";
        }
    }
    public function getDescNomeMae(){return $this->descNomeMae;}
    /**
     * Descrição: Set and Get naturalidade.
     */
    public function setDescNaturalidade($descNaturalidade) {
        if ($descNaturalidade!="") {
            $this->descNaturalidade = $descNaturalidade;
        } else {
            $this->descNaturalidade = "";
        }
    }
    public function getDescNaturalidade(){return $this->descNaturalidade;}
    /**
     * Descrição: Set and Get nacionalidade.
     */
    public function setDescNacionalidade($descNacionalidade) {
        if ($descNacionalidade!="") {
            $this->descNacionalidade = $descNacionalidade;
        } else {
            $this->descNacionalidade = "";
        }
    }
    public function getDescNacionalidade(){return $this->descNacionalidade;}
    /**
     * Descrição: Set and Get orgão expeditor identidade.
     */
    public function setDescOrgaoExpedidor($descOrgaoExpedidor) {
        if ($descOrgaoExpedidor!="") {
            $this->descOrgaoExpedidor = strtoupper($descOrgaoExpedidor);
        } else {
            $this->descOrgaoExpedidor = "";
        }
    }
    public function getDescOrgaoExpedidor(){return $this->descOrgaoExpedidor;}
    /**
     * Descrição: Set and Get Estado civil.
     */
    public function setDescEstadoCivil($descEstadoCivil) {
        if ($descEstadoCivil!="") {
            $this->descEstadoCivil = $descEstadoCivil;
        } else {
            $this->descEstadoCivil = "";
        }
    }
    public function getDescEstadoCivil(){return $this->descEstadoCivil;}
    /**
     * Descrição: Set and Get quantidade de filhos.
     */
    public function setNumrFilhos($numrFilhos) {
        if ($numrFilhos!="") {
            $this->numrFilhos = $numrFilhos;
        } else {
            $this->numrFilhos = "";
        }
    }
    public function getNumrFilhos(){return $this->numrFilhos;}
    /**
     * Descrição: Set and Get DDD Celular.
     */
    public function setNumrDddCelular($numrDddCelular) {
        if ($numrDddCelular!="") {
            $this->numrDddCelular = $numrDddCelular;
        } else {
            $this->numrDddCelular = "";
        }
    }
    public function getNumrDddCelular(){return $this->numrDddCelular;}
    /**
     * Descrição: Set and Get Celular.
     */
    public function setNumrCelular($numrCelular) {
        if ($numrCelular!="") {
            $this->numrCelular = $numrCelular;
        } else {
            $this->numrCelular = "";
        }
    }
    public function getNumrCelular(){return $this->numrCelular;}
    /**
     * Descrição: Set and Get ddd telefone contato.
     */
    public function setNumrDddTelefoneContato($numrDddTelefoneContato){
        if($numrDddTelefoneContato!=""){
            $this->numrDddTelefoneContato = $numrDddTelefoneContato;
        }else{
            $this->numrDddTelefoneContato = "";
        }
    }
    public function getNumrDddTelefoneContato(){return $this->numrDddTelefoneContato;}
    /**
     * Descrição: Set and Get telefone contato.
     */
    public function setNumrTelefoneContato($numrTelefoneContato){
        if($numrTelefoneContato!=""){
            $this->numrTelefoneContato = $numrTelefoneContato;
        }else{
            $this->numrTelefoneContato = "";
        }
    }
    public function getNumrTelefoneContato(){return $this->numrTelefoneContato;}
    /**
     * Descrição: Set and Get numero carteira identidade.
     */
    public function setNumrCarteiraIdentidade($numrCarteiraIdentidade){
        if($numrCarteiraIdentidade!=""){
            $this->numrCarteiraIdentidade = $numrCarteiraIdentidade;
        }else{
            $this->numrCarteiraIdentidade = "";
        }
    }
    public function getNumrCarteiraIdentidade(){return $this->numrCarteiraIdentidade;}
    /**
     * Descrição: Set and Get numero cpf ou cnpj.
     */
    public function setNumrCpfcnpj($valor) {
        if ($valor != "") {
            $this->numrCpfcnpj = $valor;
        } else {
            $this->numrCpfcnpj = "";
        }
    }
    public function getNumrCpfcnpj(){return $this->numrCpfcnpj;}
    /**
     * Descrição: Get cpf ou cnpj formatado.
     */
    public function getNumrCpfcnpjformatado() {
        if (strlen($this->numrCpfcnpj) == 11) {
            return substr($this->numrCpfcnpj, 0, 3) . "." . substr($this->numrCpfcnpj, 3, 3) . "." . substr($this->numrCpfcnpj, 6, 3) . "-" . substr($this->numrCpfcnpj, 9, 2);
        } elseif (strlen($this->numrCpfcnpj) == 14)
            return substr($this->numrCpfcnpj, 0, 2) . "." . substr($this->numrCpfcnpj, 2, 3) . "." . substr($this->numrCpfcnpj, 5, 3) . "/" . substr($this->numrCpfcnpj, 8, 4) . "-" . substr($this->numrCpfcnpj, 12, 2);
    }
    /**
     * Descrição: set and Get Nome municipio.
     */
    public function setDescNomeMunicipio($descNomeMunicipio){$this->descNomeMunicipio = $descNomeMunicipio;}
    public function getDescNomeMunicipio(){return $this->descNomeMunicipio;}
    /**
     * Descrição: set and Get sigla UF.
     */
    public function setSiglUf($siglUf) {
        if ($siglUf != "") {
            $this->siglUf = $siglUf;
        } else {
            $this->siglUf = "";
        }
    }
    public function getSiglUf(){return $this->siglUf;}
    /**
     * Descrição: set and Get numg municipio.
     */
    public function setNumgMunicipio($numgMunicipio) {
        if ($numgMunicipio != "") {
            $this->numgMunicipio = $numgMunicipio;
        } else {
            $this->numgMunicipio = "";
        }
    }
    public function getNumgMunicipio(){return $this->numgMunicipio;}
    /**
     * Descrição: set and Get desc Email.
     */
    public function setDescEmail($descEmail) {
        if ($descEmail != "") {
            $this->descEmail = $descEmail;
        } else {
            $this->descEmail = "";
        }
    }
    public function getDescEmail(){return $this->descEmail;}
    /**
     * Descrição: set and Get nome Operador.
     */
    public function setNomeOperador($nomeOperador){$this->nomeOperador = $nomeOperador;}
    public function getNomeOperador(){return $this->nomeOperador;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descrição: Seta os dados de uma pessoa pelo seu nº identificador
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function setarDados($numgPessoa) {
    $this->sSql = "SELECT p.numg_pessoa, p.numr_cpfcnpj, p.desc_nomepessoa, p.desc_sobrenomepessoa,";
    $this->sSql .= " p.desc_email, p.data_nascimento, p.desc_sexo, p.desc_endereco, p.numr_endereco,";
    $this->sSql .= " p.desc_bairro, p.desc_complemento, p.numr_cep, p.sigl_pais, p.numr_dddtelefone, ";
    $this->sSql .= " p.numr_telefone, p.numr_dddfax, p.numr_fax, p.desc_observacao, p.data_cadastro, ";
    $this->sSql .= " p.data_ultimaalteracao, p.numg_usuarioalteracao, p.desc_tipo, p.numg_municipio,";
    $this->sSql .= " p.desc_nomepai, p.desc_nomemae, p.desc_naturalidade, p.desc_orgaoexpedidor, ";
    $this->sSql .= " p.desc_estadocivil, p.numr_filhos, numr_dddcelular, p.numr_celular, ";
    $this->sSql .= " p.numr_dddtelefonecontato, p.numr_telefonecontato, p.numr_carteiraidentidade,";
    $this->sSql .= " o.nome_operador as usuarioalteracao, oc.nome_operador as usuariocadastro,";
    $this->sSql .= " m.nome_municipio, m.sigl_uf, desc_nacionalidade";
    $this->sSql .= " FROM ge_pessoas p";
    $this->sSql .= " left join ge_municipios m on m.numg_municipio = p.numg_municipio";
    $this->sSql .= " left join se_operadores o on o.numg_operador = p.numg_usuarioalteracao";
    $this->sSql .= " left join se_operadores oc on oc.numg_operador = p.numg_usuariocadastro";
    $this->sSql .= " WHERE p.numg_pessoa = " . $numgPessoa;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.setarDados(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    if ($this->oResultset->getCount() > 0) {
        $this->numgPessoa = $this->oResultset->getValores(0, numg_pessoa);
        $this->descNomePessoa = $this->oResultset->getValores(0, desc_nomepessoa);
        $this->descSobreNomePessoa = $this->oResultset->getValores(0, desc_sobrenomepessoa);
        $this->dataNascimento = $this->oResultset->getValores(0, data_nascimento);
        $this->descSexo = $this->oResultset->getValores(0, desc_sexo);
        $this->descEndereco = $this->oResultset->getValores(0, desc_endereco);
        $this->numrEndereco = $this->oResultset->getValores(0, numr_endereco);
        $this->descBairro = $this->oResultset->getValores(0, desc_bairro);
        $this->descComplemento = $this->oResultset->getValores(0, desc_complemento);
        $this->numrCep = $this->oResultset->getValores(0, numr_cep);
        $this->siglPais = $this->oResultset->getValores(0, sigl_pais);
        $this->numrDddTelefone = $this->oResultset->getValores(0, numr_dddtelefone);
        $this->numrTelefone = $this->oResultset->getValores(0, numr_telefone);
        $this->numrDddFax = $this->oResultset->getValores(0, numr_dddfax);
        $this->numrFax = $this->oResultset->getValores(0, numr_fax);
        $this->descObservacao = $this->oResultset->getValores(0, desc_observacao);
        $this->dataCadastro = $this->oResultset->getValores(0, data_cadastro);
        $this->dataUltimaAlteracao = $this->oResultset->getValores(0, data_ultimaalteracao);
        $this->numgUsuarioAlteracao = $this->oResultset->getValores(0, numg_usuarioalteracao);
        $this->nomeOperador = $this->oResultset->getValores(0, usuarioalteracao);
        $this->nomeUsuarioCadastro = $this->oResultset->getValores(0, usuariocadastro);
        $this->descTipo = $this->oResultset->getValores(0, desc_tipo);
        $this->numgMunicipio = $this->oResultset->getValores(0, numg_municipio);
        $this->descNomeMunicipio = $this->oResultset->getValores(0, nome_municipio);
        $this->siglUf = $this->oResultset->getValores(0, sigl_uf);
        $this->descNomePai = $this->oResultset->getValores(0, desc_nomepai);
        $this->descNomeMae = $this->oResultset->getValores(0, desc_nomemae);
        $this->descNaturalidade = $this->oResultset->getValores(0, desc_naturalidade);
        $this->descOrgaoExpedidor = $this->oResultset->getValores(0, desc_orgaoexpedidor);
        $this->descEstadoCivil = $this->oResultset->getValores(0, desc_estadocivil);
        $this->numrFilhos = $this->oResultset->getValores(0, numr_filhos);
        $this->numrDddCelular = $this->oResultset->getValores(0, numr_dddcelular);
        $this->numrCelular = $this->oResultset->getValores(0, numr_celular);
        $this->numrDddTelefoneContato = $this->oResultset->getValores(0, numr_dddtelefonecontato);
        $this->numrTelefoneContato = $this->oResultset->getValores(0, numr_telefonecontato);
        $this->numrCarteiraIdentidade = $this->oResultset->getValores(0, numr_carteiraidentidade);
        $this->numrCpfcnpj = $this->oResultset->getValores(0, numr_cpfcnpj);
        $this->descEmail= $this->oResultset->getValores(0, desc_email);
        $this->descNacionalidade = $this->oResultset->getValores(0, desc_nacionalidade);
    }
    return $this->oResultset;
}
/**
 * Descrição: cadastra os dados de uma pessoa
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
protected function cadastrar() {
    $this->pValidaGravacao("C");if (Erro::isError()){return false;}
    else{
        $this->sSql = " INSERT INTO ge_pessoas( numr_cpfcnpj, desc_nomepessoa, desc_sobrenomepessoa,
                                                desc_email, data_nascimento, desc_sexo,desc_endereco,
                                                numr_endereco,desc_bairro,desc_complemento,numr_cep,
                                                sigl_pais,numr_dddtelefone,numr_telefone,numr_dddfax,
                                                numr_fax,desc_observacao,data_cadastro,numg_usuariocadastro,
                                                desc_tipo,numg_municipio,desc_nomepai,desc_nomemae,
                                                desc_naturalidade,desc_orgaoexpedidor,desc_estadocivil,
                                                numr_filhos,numr_dddcelular,numr_celular,numr_dddtelefonecontato,
                                                numr_telefonecontato,numr_carteiraidentidade,desc_nacionalidade
                        )VALUES( ";
        $this->sSql .= FormataStr($this->getNumrCpfcnpj()).",";
        $this->sSql .= FormataStr($this->getDescNomePessoa()).",";
        $this->sSql .= FormataStr($this->getDescSobreNomePessoa()).",";
        $this->sSql .= FormataStr($this->getDescEmail()).",";
        $this->sSql .= FormataDataGravacao($this->getDataNascimento()).",";
        $this->sSql .= FormataStr($this->getDescSexo()).",";
        $this->sSql .= FormataStr($this->getDescEndereco()).",";
        $this->sSql .= FormataStr($this->getNumrEndereco()).",";
        $this->sSql .= FormataStr($this->getDescBairro()).",";
        $this->sSql .= FormataStr($this->getDescComplemento()).",";
        $this->sSql .= FormataStr($this->getNumrCep()).",";
        $this->sSql .= FormataStr($this->getSiglPais()).",";
        $this->sSql .= FormataStr($this->getNumrDddTelefone()).",";
        $this->sSql .= FormataStr($this->getNumrTelefone()).",";
        $this->sSql .= FormataStr($this->getNumrDddFax()).",";
        $this->sSql .= FormataStr($this->getNumrFax()).",";
        $this->sSql .= FormataStr($this->getDescObservacao()).",";
        $this->sSql .= "now(),";
        $this->sSql .= FormataNumeroGravacao($this->getNumgUsuarioCadastro()).",";
        $this->sSql .= FormataStr($this->getDescTipo()).",";
        $this->sSql .= FormataNumeroGravacao($this->getNumgMunicipio()).",";
        $this->sSql .= FormataStr($this->getDescNomePai()).",";
        $this->sSql .= FormataStr($this->getDescNomeMae()).",";
        $this->sSql .= FormataStr($this->getDescNaturalidade()).",";
        $this->sSql .= FormataStr($this->getDescOrgaoExpedidor()).",";
        $this->sSql .= FormataStr($this->getDescEstadoCivil()).",";
        $this->sSql .= FormataNumeroGravacao($this->getNumrFilhos()).",";
        $this->sSql .= FormataStr($this->getNumrDddCelular()).",";
        $this->sSql .= FormataStr($this->getNumrCelular()).",";
        $this->sSql .= FormataStr($this->getNumrDddTelefoneContato()).",";
        $this->sSql .= FormataStr($this->getNumrTelefoneContato()).",";
        $this->sSql .= FormataStr($this->getNumrCarteiraIdentidade()).",";
        $this->sSql .= FormataStr($this->getDescNacionalidade())."";
        $this->sSql .= ")";
        try{
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $vAux = $this->Oad->consultar("select max(numg_pessoa) from ge_pessoas");
            $this->numgPessoa = $vAux->getValores(0, max);
            $this->Oad->desconectar();
            return true;
        }catch (Exception $e){
            $this->Oad->rollback();
            $this->Oad->desconectar();
            $this->oErro->addErro("Fonte: Pessoa.cadastrar(); Descrição: " . $e->getMessage() . "ß");
            return false;
        }
    }
}
/**
 * Descrição: edita os dados de uma pessoa
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
protected function editar($numgPessoa){
    $this->pValidaGravacao("E",$numgPessoa);if (Erro::isError()){return false;}
    else{
        $this->sSql = " UPDATE ge_pessoas SET ";
        $this->sSql .= " numr_cpfcnpj = ".FormataStr($this->getNumrCpfcnpj()).",";
        $this->sSql .= " desc_nomepessoa = ".FormataStr($this->getDescNomePessoa()).",";
        $this->sSql .= " desc_sobrenomepessoa = ".FormataStr($this->getDescSobreNomePessoa()).",";
        $this->sSql .= " desc_email = ".FormataStr($this->getDescEmail()).",";
        $this->sSql .= " data_nascimento = ".FormataDataGravacao($this->getDataNascimento()).",";
        $this->sSql .= " desc_sexo = ".FormataStr($this->getDescSexo()).",";
        $this->sSql .= " desc_endereco = ".FormataStr($this->getDescEndereco()).",";
        $this->sSql .= " numr_endereco = ".FormataStr($this->getNumrEndereco()).",";
        $this->sSql .= " desc_bairro = ".FormataStr($this->getDescBairro()).",";
        $this->sSql .= " desc_complemento = ".FormataStr($this->getDescComplemento()).",";
        $this->sSql .= " numr_cep = ".FormataStr($this->getNumrCep()).",";
        $this->sSql .= " sigl_pais = ".FormataStr($this->getSiglPais()).",";
        $this->sSql .= " numr_dddtelefone = ".FormataStr($this->getNumrDddTelefone()).",";
        $this->sSql .= " numr_telefone = ".FormataStr($this->getNumrTelefone()).",";
        $this->sSql .= " numr_dddfax = ".FormataStr($this->getNumrDddFax()).",";
        $this->sSql .= " numr_fax = ".FormataStr($this->getNumrFax()).",";
        $this->sSql .= " desc_observacao = ".FormataStr($this->getDescObservacao()).",";
        $this->sSql .= " data_ultimaalteracao = now(),";
        $this->sSql .= " desc_tipo = ".FormataStr($this->getDescTipo()).",";
        $this->sSql .= " numg_municipio = ".$this->getNumgMunicipio().",";
        $this->sSql .= " desc_nomepai = ".FormataStr($this->getDescNomePai()).",";
        $this->sSql .= " desc_nomemae = ".FormataStr($this->getDescNomeMae()).",";
        $this->sSql .= " desc_naturalidade = ".FormataStr($this->getDescNaturalidade()).",";
        $this->sSql .= " desc_orgaoexpedidor = ".FormataStr($this->getDescOrgaoExpedidor()).",";
        $this->sSql .= " desc_estadocivil = ".FormataStr($this->getDescEstadoCivil()).",";
        $this->sSql .= " numr_filhos = ".FormataNumeroGravacao($this->getNumrFilhos()).",";
        $this->sSql .= " numr_dddcelular = ".FormataStr($this->getNumrDddCelular()).",";
        $this->sSql .= " numr_celular = ".FormataStr($this->getNumrCelular()).",";
        $this->sSql .= " numr_dddtelefonecontato = ".FormataStr($this->getNumrDddTelefoneContato()).",";
        $this->sSql .= " numr_telefonecontato = ".FormataStr($this->getNumrTelefoneContato()).",";
        $this->sSql .= " numr_carteiraidentidade = ".FormataStr($this->getNumrCarteiraIdentidade()).",";
        $this->sSql .= " numg_usuarioalteracao = ".  FormataNumeroGravacao($this->getNumgUsuarioAlteracao()).",";
        $this->sSql .= " desc_nacionalidade = ".FormataStr($this->getDescNacionalidade())."";
        $this->sSql .= " WHERE numg_pessoa = ".$numgPessoa.";";
        try {
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $this->Oad->desconectar();
            return true;
        } catch (Exception $e) {
            $this->Oad->rollback();
            $this->Oad->desconectar();
            $this->oErro->addErro("Fonte: Pessoa.editar(); Descrição: " . $e->getMessage() . "ß");
            return false;
        }
    }
}
/**
 * Descrição: exclui os dados de uma pessoa
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
protected function excluir($numgPessoa) {
    $this->sSql = "DELETE FROM pr_pessoas WHERE numg_pessoa = " . $numgPessoa;
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Pessoa.excluir(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: consulta o nome da pessoa a partir do numg
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
public function consultaPorNumg($numgPessoa) {
    $this->sSql = " select ";
    $this->sSql .= " nome_pessoa from pr_pessoas";
    $this->sSql .= " WHERE numg_pessoa =" . $numgPessoa;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.consultaPorNumg(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Valida gravação dos dados[ verfica se já há uma pessoa cadastrada com o cpf informado ]
 *            passando como parametro o tipo de pessoa e o número do cpf
 * @author Fabricio Nogueira
 * Data: 06/10/2010
 */
public function validaGravacaoDuplicidadeCpf($tipoPessoa, $numrCpf){
    $this->sSql = "select desc_nomepessoa, numr_cpfcnpj from ge_pessoas where desc_tipo = '" . $tipoPessoa . "' AND lower(numr_cpfcnpj) = '".$numrCpf."'";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.validaGravacaoDuplicidadeCpf(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}

/**
 * Descrição: valida os dados de uma pessoa antes de cadastrá-la ou editá-la
 * @param $acao => C - Cadastrar ; E - Editar
 * @author Fabricio Nogueira.
 * Data: 13/09/2010.
 */
private function pValidaGravacao($acao,$numgPessoa=null) {
    try {
        $this->Oad->conectar();
        if ($acao=="C"){
            $result = $this->Oad->consultar("select numr_cpfcnpj, desc_nomepessoa||' '||desc_sobrenomepessoa as nomepessoa from ge_pessoas where desc_tipo = '" . $this->getDescTipo() . "' AND lower(numr_cpfcnpj) = '" . trim(strtolower($this->getNumrCpfcnpj())) . "'");
            if ($result->getCount() > 0) {
                $this->oErro->addErro("Já existe uma pessoa de nome: <b>\"".$result->getValores(0,'nomepessoa')."\"</b> cadastrada com este CPF.ß");
            }
        }else if($acao=="E"){
            $result = $this->Oad->consultar("select numr_cpfcnpj, desc_nomepessoa||' '||desc_sobrenomepessoa as nomepessoa from ge_pessoas where lower(numr_cpfcnpj) = '" . trim(strtolower($this->getNumrCpfcnpj())) . "'" . " AND numg_pessoa <> $numgPessoa ");
            if ($result->getCount()>0) {
                $this->oErro->addErro("Já existe uma pessoa de nome: <b>\"".$result->getValores(0,'nomepessoa')."\"</b> cadastrada com este CPF.ß");
            }
        }
        $this->Oad->desconectar();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: Pessoa.pValidaGravacao(); Descrição: " . $e->getMessage() . "ß");
    }
}
}