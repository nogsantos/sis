<?php
/**
 * Descrição: Model Professores Escola de Música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 08/10/2010
 */
require_once("../../models/geral/Pessoa.php");
class Professor extends Pessoa {
   /**
    * Parametros da classe
    */
    private $sSql;
    private $sSqlAux;
    private $sSqlAux2;
    /**
     * Herança do construtor classe pessoa.
     */
    public function __construct(){parent:: __construct();}
    /**
     * parametros
     */
    private $numgProfessor;
    public  $descTipo;
    public  $descNomePessoa;
    public  $descSobreNomePessoa;
    public  $descSexo;
    public  $numrCpfCnpj;
    public  $numrCarteiraIdentidade;
    public  $descOrgaoExpeditor;
    public  $numrDddTelefone;
    public  $numrTelefone;
    public  $numrDddTelefoneContato;
    public  $numrTelefoneContato;
    public  $numrDddCelular;
    public  $numrCelular;
    public  $descNacionalidade;
    public  $descNaturalidade;
    public  $descEndereco;
    public  $numrEndereco;
    public  $descBairro;
    public  $descComplemento;
    public  $numrCep;
    public  $siglUf;
    public  $numgMunicipio;
    public  $descObservacao;
    public  $nomeUsuarioCadastro;
    public  $dataCadastro;
    public  $dataNascimento;
    public  $descEmail;
    public  $numgUsuarioCadastro;
    public  $numgUsuarioAlteracao;
    public  $descStatus;
    public  $dataAtivacao;
    public  $dataDesativacao;
    public  $numgUsuarioAtivacao;
    public  $numgUsuarioDesativacao;
    /**
     * Gets and sets classe professores
     */
    public function setNumgProfessor($numgProfessor){$this->numgProfessor = $numgProfessor;}
    public function getNumgProfessor(){return $this->numgProfessor;}
    /**
     * Gets and sets data ativação será usado quando o usuário for desativado e posteriormente reativado.
     *                             por defalt virá com o valor nulo somente sendo preenchido como sitado anteriormente.
     */
    public function setDataAtivacao(){$this->dataAtivacao = "now()";}
    public function getDataAtivacao(){return $this->dataAtivacao;}
    /**
     * Gets and sets data desativação usada quando um professor for desativado.
     */
    public function setDataDesativacao(){$this->dataDesativacao = "now()";}
    public function getDataDesativacao(){return $this->dataDesativacao;}
    /**
     * Gets and sets
     */
    public function setNumgUsuarioAtivacao(){$this->numgUsuarioAtivacao = $_SESSION["NUMG_OPERADOR"];}
    public function getNumgUsuarioAtivacao(){return $this->numgUsuarioAtivacao;}
    /**
     * Gets and sets
     */
    public function setNumgUsuarioDesativacao(){$this->numgUsuarioDesativacao = $_SESSION["NUMG_OPERADOR"];}
    public function getNumgUsuarioDesativacao(){return $this->numgUsuarioDesativacao;}
    /**
     * Descrição: polimorfismo classe pessoa
     */
    public function setDescTipo($descTipo){parent::setDescTipo($descTipo);}
    public function setDescNomePessoa($descNomePessoa){parent::setDescNomePessoa($descNomePessoa);}
    public function setDescSobreNomePessoa($descSobreNomePessoa){parent::setDescSobreNomePessoa ($descSobreNomePessoa);}
    public function setDescSexo($descSexo){parent::setDescSexo ($descSexo);}
    public function setNumrCpfcnpj($numrCpfcnpj){parent::setNumrCpfcnpj($numrCpfcnpj);}
    public function setNumrCarteiraIdentidade($numrCarteiraIdentidade){parent::setNumrCarteiraIdentidade ($numrCarteiraIdentidade);}
    public function setDescOrgaoExpedidor($descOrgaoExpedidor){parent::setDescOrgaoExpedidor ($descOrgaoExpedidor);}
    public function setNumrDddTelefone($numrDddTelefone){parent::setNumrDddTelefone ($numrDddTelefone);}
    public function setNumrTelefone($numrTelefone){parent::setNumrTelefone ($numrTelefone);}
    public function setNumrDddTelefoneContato($numrDddTelefoneContato){parent::setNumrDddTelefoneContato ($numrDddTelefoneContato);}
    public function setNumrTelefoneContato($numrTelefoneContato){parent::setNumrTelefoneContato ($numrTelefoneContato);}
    public function setNumrDddCelular($numrDddCelular){parent::setNumrDddCelular ($numrDddCelular);}
    public function setNumrCelular($numrCelular){parent::setNumrCelular ($numrCelular);}
    public function setDescNacionalidade($descNacionalidade){parent::setDescNacionalidade($descNacionalidade);}
    public function setDescNaturalidade($descNaturalidade){parent::setDescNaturalidade($descNaturalidade);}
    public function setDescEndereco($descEndereco){parent::setDescEndereco($descEndereco);}
    public function setNumrEndereco($numrEndereco){parent::setNumrEndereco($numrEndereco);}
    public function setDescBairro($descBairro){parent::setDescBairro ($descBairro);}
    public function setDescComplemento($descComplemento){parent::setDescComplemento ($descComplemento);}
    public function setNumgMunicipio($numgMunicipio){parent::setNumgMunicipio ($numgMunicipio);}
    public function setDescObservacao($descObservacao){parent::setDescObservacao ($descObservacao);}
    public function setDataNascimento($dataNascimento){parent::setDataNascimento($dataNascimento);}
    public function setNumgUsuarioCadastro($numgUsuarioCadastro){parent::setNumgUsuarioCadastro ($numgUsuarioCadastro);}
    public function setNumgUsuarioAlteracao($numgUsuarioAlteracao){parent::setNumgUsuarioAlteracao($numgUsuarioAlteracao);}
    public function setNumrCep($numrCep){parent::setNumrCep($numrCep);}
    public function setSiglUf($siglUf){parent::setSiglUf ($siglUf);}
    public function setDescEmail($descEmail){parent::setDescEmail($descEmail);}

    public function getDescStatus(){return $this->descStatus;}
/*******************************************************************************/
/*                       Cadastros e Ações Diversas                            */
/*******************************************************************************/
/**
 * Descição: Setar dados.
 * @author Fabricio Nogueira
 * Data: 08/10/2010
 */
public function setarDados($numgProfessor){
    try {
        $this->sSql = " select case desc_status
                               when 'A' then 'Ativo'
                               when 'I' then 'Inativo'
                               end as status
                               from mu_professores where numg_professor = ".$numgProfessor;
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.cadastrar(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    if($this->oResultset->getCount()>0){
        $this->descStatus = $this->oResultset->getValores(0,"status");
        parent::setarDados($numgProfessor);
        $this->descTipo = parent::getDescTipo();
        $this->descNomePessoa = parent::getDescNomePessoa();
        $this->descSobreNomePessoa = parent::getDescSobreNomePessoa();
        $this->descSexo = parent::getDescSexo();
        $this->numrCpfCnpj = parent::getNumrCpfcnpj();
        $this->numrCarteiraIdentidade = parent::getNumrCarteiraIdentidade();
        $this->descOrgaoExpeditor = parent::getDescOrgaoExpedidor();
        $this->numrDddTelefone = parent::getNumrDddTelefone();
        $this->numrTelefone = parent::getNumrTelefone();
        $this->numrDddTelefoneContato = parent::getNumrDddTelefoneContato();
        $this->numrTelefoneContato = parent::getNumrTelefoneContato();
        $this->numrDddCelular = parent::getNumrDddCelular();
        $this->numrCelular = parent::getNumrCelular();
        $this->descNacionalidade = parent::getDescNacionalidade();
        $this->descNaturalidade = parent::getDescNaturalidade();
        $this->descEndereco = parent::getDescEndereco();
        $this->numrEndereco = parent::getNumrEndereco();
        $this->descBairro = parent::getDescBairro();
        $this->descComplemento = parent::getDescComplemento();
        $this->numrCep = parent::getNumrCep();
        $this->siglUf = parent::getSiglUf();
        $this->numgMunicipio = parent::getNumgMunicipio();
        $this->descObservacao = parent::getDescObservacao();
        $this->nomeUsuarioCadastro = parent::getNomeUsuarioCadastro();
        $this->dataCadastro = parent::getDataCadastro();
        $this->dataNascimento = parent::getDataNascimento();
        $this->descEmail = parent::getDescEmail();
        $this->numgProfessor = parent::getNumgPessoa();
    }
}
/**
 * Descrição: Cadastrar
 * @author Fabricio Nogueira.
 * Data: 08/10/2010
 */
public function cadastrar(){
    try{
        if(parent::cadastrar()){
            $this->sSql = "INSERT INTO mu_professores(numg_professor, desc_status )VALUES(".FormataNumeroGravacao(parent::getNumgPessoa()).",'A');";
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $vAux = $this->Oad->consultar("select max(numg_professor) from mu_professores");
            $this->numgProfessor = $vAux->getValores(0, max);
            $this->Oad->desconectar();
            return true;
        }
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Pessoa.cadastrar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: Edição
 * @author Fabricio Nogueira
 * Data: 08/10/2010
 */
public function editar(){
    try{
        parent::editar($this->getNumgProfessor());
        return true;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.Editar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: Consulta todos professores cadastrados
 * @author Fabricio Nogueira
 * Data: 08/10/2010
 */
public function consultarProfessores(){
    $this->sSql = " select prof.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomeprofessor,
                           p.numr_dddtelefone, p.numr_telefone, p.numr_dddtelefonecontato,p.numr_telefonecontato,
                           p.numr_dddcelular, p.numr_celular, p.desc_email, case prof.desc_status
                                                                            when 'A' then 'Ativo'
                                                                            when 'I' then 'Inativo'
                                                                            end as status
                    from mu_professores prof
                    left join ge_pessoas p on p.numg_pessoa = prof.numg_professor
                    order by prof.numg_professor, p.desc_nomepessoa asc";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Professor.consultarProfessores(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Consulta todos professores não bloqueados
 * @author Fabricio Nogueira
 * Data: 17/11/2010
 */
public function consultarProfessoresNaoBloqueados(){
    $this->sSql = " select prof.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomeprofessor,
                           p.numr_dddtelefone, p.numr_telefone, p.numr_dddtelefonecontato,p.numr_telefonecontato,
                           p.numr_dddcelular, p.numr_celular, p.desc_email, case prof.desc_status
                                                                            when 'A' then 'Ativo'
                                                                            when 'I' then 'Inativo'
                                                                            end as status
                    from mu_professores prof
                    left join ge_pessoas p on p.numg_pessoa = prof.numg_professor
                    where prof.desc_status = 'A'
                    order by prof.numg_professor, p.desc_nomepessoa asc";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Professor.consultarProfessoresNaoBloqueados(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Desativar
 * @author Fabricio Nogueira.
 * Data: 08/10/2010
 */
public function desativar(){
     try{
        $this->sSql = " update mu_professores set data_desativacao = now(), data_ativacao = null, desc_status = 'I', numg_usuariodesativacao = ".FormataNumeroGravacao($this->getNumgUsuarioDesativacao())."
                        where numg_professor =  ".FormataNumeroGravacao($this->getNumgProfessor()).";";
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Professor.desativar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: Ativar, ou seja reativar um professor que tenha sido desativado anteriormente.
 * @author Fabricio Nogueira.
 * Data: 08/10/2010
 */
public function ativar(){
     try{
        $this->sSql = " update mu_professores set data_ativacao = now(), data_desativacao = null, desc_status = 'A', numg_usuarioativacao = ".FormataNumeroGravacao($this->getNumgUsuarioAtivacao())."
                        where numg_professor =  ".FormataNumeroGravacao($this->getNumgProfessor()).";";
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Professor.ativar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: gerar relatório
 * @author Rodolfo Bueno.
 * Data: 11/10/2010.
 */
public function consultaRelatorioProfessores($array, $ordem) {
    $this->sSql = "  select p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomeprofessor,
        p.numr_dddtelefone ||'-'|| p.numr_telefone ||' '|| p.numr_dddtelefonecontato ||'-'|| p.numr_telefonecontato
        ||' '|| p.numr_dddcelular ||'-'|| p.numr_celular as telefones, p.desc_email, p.data_cadastro, case prof.desc_status
                                                                                                        when 'A' then 'Ativo'
                                                                                                        when 'I' then 'Inativo'
                                                                                                        end as status
                from mu_professores prof
                left join ge_pessoas p on p.numg_pessoa = prof.numg_professor where prof.numg_professor is not null";

    if ($array[nomeProfessor] != "") {
        $this->sSql .=" and lower(p.desc_nomepessoa) like '%" . strtolower($array[nomeProfessor]) . "%' or
            lower(p.desc_sobrenomepessoa) like '%" . strtolower($array[nomeProfessor]) . "%'";
    }

    if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
        $this->sSql .=" and p.data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
    } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
        $this->sSql .=" and p.data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
    } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
        $this->sSql .=" and p.data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
    }

    if ($array[status] == "A") {
        $this->sSql .= " and prof.desc_status = '" .$array[status] . "'";
    } else if ($array[status] == "I") {
        $this->sSql .= " and prof.desc_status = '" .$array[status] . "'";
    }

    if ($array[numrCpfCnpj] != "") {
        $this->sSql .= " and p.numr_cpfcnpj = '" .$array[numrCpfCnpj] . "'";
    }

    if ($array[numrDdd] != "") {
        $this->sSql .= " and p.numr_dddtelefone = '" .$array[numrDdd] . "' or p.numr_dddcelular = '" .$array[numrDdd] . "' or p.numr_dddtelefonecontato = '" .$array[numrDdd] . "'";
    }

     if ($array[numrTel] != "") {
        $this->sSql .= " and p.numr_telefone = '" .$array[numrTel] . "' or p.numr_celular = '" .$array[numrTel] . "' or p.numr_telefonecontato = '" .$array[numrTel] . "'";
    }

    if ($array[tipo] == "asc"){
        if ($ordem == "nome") {
            $this->sSql .= " order by p.desc_nomepessoa asc";
        } else {
            $this->sSql .= " order by p.data_cadastro asc";
        }
    } else {
         if ($ordem == "nome") {
            $this->sSql .= " order by p.desc_nomepessoa desc";
        } else {
            $this->sSql .= " order by p.data_cadastro desc";
        }
    }

    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Professor.consultaRelatorioProfessores(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Consulta Alunos do professor por modalidade.
 * @author Fabricio Nogueira.
 * Data: 04/12/2010.
 */
public function consultarAlunosProfessor($numgModalidade,$numgProfessor,$numrDiaSemana, $numrHorario) {
    $this->sSql = " select distinct numg_aluno, p.desc_nomepessoa||' '||desc_sobrenomepessoa as nome_aluno
                    from mu_matriculas m
                    join mu_modalidades mo on mo.numg_modalidade = m.numg_modalidade
                    join mu_professoresmodalidades pm on pm.numg_modalidade = mo.numg_modalidade
                    join ge_pessoas p on p.numg_pessoa = m.numg_aluno
                    where mo.numg_modalidade = $numgModalidade
                    and m.numg_professor = $numgProfessor
                    and m.numr_diasemana = $numrDiaSemana
                    and m.numr_horarios = '$numrHorario'";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Professor.consultarAlunosProfessor(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/*
 * Descrição: Consulta autocomplete para selecionar todos os numr dos professores.
 * @author Fabricio Nogueira
 * Data: 15/12/2010.
 */
public function consultaNomeProfessor($valor){
    $this->sSql = " select pe.desc_nomepessoa||' '||pe.desc_sobrenomepessoa as value, p.numg_professor as id
                    from mu_professores p
                    left join ge_pessoas pe on pe.numg_pessoa = p.numg_professor
                    where lower(pe.desc_nomepessoa) like lower('%$valor%')";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Professor.consultaNomeProfessor(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/*
 * Descrição: Consulta todos os numr dos professores.
 * @author Fabricio Nogueira
 * Data: 17/12/2010.
 */
public function consultaNomeProfessorNumg($numgProfessor){
    if($numgProfessor!=""){
        $this->sSql = " select pe.desc_nomepessoa||' '||pe.desc_sobrenomepessoa as nome_professor
                        from mu_professores p
                        left join ge_pessoas pe on pe.numg_pessoa = p.numg_professor
                        where p.numg_professor = $numgProfessor";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset->getValores(0,"nome_professor");
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Professor.consultaNomeProfessorNumg(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }
}
/**
 * Descrição: Destrutor.
 */
public function __destruct(){
    unset($this->Oad);
    unset($this->oErro);
    unset($this->oResultset);
    unset($this->sSql);
    unset($this->sSqlAux);
    unset($this->sSqlAux2);
}
}