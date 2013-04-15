<?php
/**
 * Descrição: Model Alunos Escola de Música.
 * @author Fabricio Nogueira.
 * @release Criação do arquivo.
 * Data 26/09/2010
 */
require_once("../../models/geral/Pessoa.php");
class Aluno extends Pessoa {
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
    private $numgAluno;
    public  $numrAluno;
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
     * Gets and sets classe alunos
     */
    public function setNumgAluno($numgAluno){$this->numgAluno = $numgAluno;}
    public function getNumgAluno(){return $this->numgAluno;}
    /**
     * Gets and sets
     */
    public function setNumrAluno($numrAluno){
        if($numrAluno=="" || !is_integer($numrAluno))
            $this->numrAluno = $numrAluno;
        else
            $this->oErro->addErro("Número Inválido.ß");
    }
    public function getNumrAluno(){return $this->numrAluno;}
    /**
     * Gets and sets data ativação será usado quando o usuário for desativado e posteriormente reativado.
     *                             por defalt virá com o valor nulo somente sendo preenchido como sitado anteriormente.
     */
    public function setDataAtivacao(){$this->dataAtivacao = "now()";}
    public function getDataAtivacao(){return $this->dataAtivacao;}
    /**
     * Gets and sets data desativação usada quando um aluno for desativado.
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
 * Descição: Setar dados do aluno.
 * @author Fabricio Nogueira
 * Data: 30/09/2010.
 */
public function setarDados($numgAluno=null,$numrAluno=null){
    try {
        $this->sSql = " select numr_aluno, numg_aluno,
            case desc_status
            when 'A' then 'Ativo'
            when 'I' then 'Inativo'
            end as status
            from mu_alunos ";
        if($numgAluno!=null)
            $this->sSql .=  " where numg_aluno = $numgAluno";
        if($numrAluno!=null)
            $this->sSql .=  " where numr_aluno = $numrAluno";
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Aluno.setarDados(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
    if($this->oResultset->getCount()>0){
        $this->numrAluno = $this->oResultset->getValores(0,"numr_aluno");
        $this->descStatus = $this->oResultset->getValores(0,"status");
        parent::setarDados($this->oResultset->getValores(0,"numg_aluno"));
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
        $this->numgAluno = parent::getNumgPessoa();
    }
}
/**
 * Descrição: Cadastrar aluno
 * @author Fabricio Nogueira.
 * Data: 27/09/2010.
 */
public function cadastrar(){
    try{
        if(parent::cadastrar()){
            $numrAluno = $this->geraNumrAluno();
            /**
             * Descriçao: cadastrando na tabela de alunos.
             */
            $this->sSql = "INSERT INTO mu_alunos(numg_aluno, numr_aluno, desc_status )VALUES (".  FormataNumeroGravacao(parent::getNumgPessoa()).",".FormataNumeroGravacao($numrAluno).", 'A' );";
            $this->Oad->conectar();
            $this->Oad->begin();
            $this->Oad->executar($this->sSql);
            $this->Oad->commit();
            $vAux = $this->Oad->consultar("select max(numg_aluno) from mu_alunos");
            $this->numgAluno = $vAux->getValores(0, max);
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
 * Descrição: Edição dos dados do aluno.
 * @author Fabricio Nogueira
 * Data: 01/10/2010
 */
public function editar(){
    try{
        parent::editar($this->getNumgAluno());
        return true;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Pessoa.cadastrar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: Consulta todos alunos cadastrados
 * @author Fabricio Nogueira
 * Data: 03/10/2010
 */
public function consultarAlunos(){
    $this->sSql = " select a.numg_aluno, a.numr_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomealuno,
                           p.numr_dddtelefone, p.numr_telefone, p.numr_dddtelefonecontato,p.numr_telefonecontato,
                           p.numr_dddcelular, p.numr_celular, p.desc_email, case a.desc_status
                                                                            when 'A' then 'Ativo'
                                                                            when 'I' then 'Inativo'
                                                                            end as status
                    from mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno
                    order by a.numg_aluno, p.desc_nomepessoa asc";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Aluno.consultarAlunos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Consulta todos alunos ativos
 * @author Fabricio Nogueira
 * Data: 03/10/2010
 */
public function consultarAlunosAtivos(){
    $this->sSql = " select a.numg_aluno, a.numr_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomealuno,
                           p.numr_dddtelefone, p.numr_telefone, p.numr_dddtelefonecontato,p.numr_telefonecontato,
                           p.numr_dddcelular, p.numr_celular, p.desc_email, case a.desc_status
                                                                            when 'A' then 'Ativo'
                                                                            when 'I' then 'Inativo'
                                                                            end as status
                    from mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno
                    where a.desc_status = 'A'
                    order by a.numg_aluno, p.desc_nomepessoa asc";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: Aluno.consultarAlunos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Desativar o Aluno
 * @author Fabricio Nogueira.
 * Data: 04/10/2010
 */
public function desativar(){
     try{
        $this->sSql = " update mu_alunos set data_desativacao = now(), data_ativacao = null, desc_status = 'I', numg_usuariodesativacao = ".FormataNumeroGravacao($this->getNumgUsuarioDesativacao())."
                        where numg_aluno =  ".FormataNumeroGravacao($this->getNumgAluno()).";";
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Pessoa.desativar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}
/**
 * Descrição: Ativar o Aluno, ou seja reativar um aluno que tenha sido desativado anteriormente.
 * @author Fabricio Nogueira.
 * Data: 04/10/2010
 */
public function ativar(){
     try{
        $this->sSql = " update mu_alunos set data_ativacao = now(), data_desativacao = null, desc_status = 'A', numg_usuarioativacao = ".FormataNumeroGravacao($this->getNumgUsuarioAtivacao())."
                        where numg_aluno =  ".FormataNumeroGravacao($this->getNumgAluno()).";";
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch (Exception $e){
        $this->Oad->rollback();
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: Pessoa.ativar(); Descrição: " . $e->getMessage() . "ß");
        return false;
    }
}

/**
     * Descrição: gerar relatório
     * @author Rodolfo Bueno.
     * Data: 09/10/2010.
     */
    public function consultaRelatorioAlunos($array, $ordem) {
        $this->sSql = "  select a.numr_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nomealuno,
            p.numr_dddtelefone ||'-'|| p.numr_telefone ||' '|| p.numr_dddtelefonecontato ||'-'|| p.numr_telefonecontato
            ||' '|| p.numr_dddcelular ||'-'|| p.numr_celular as telefones, p.desc_email, p.data_cadastro, case a.desc_status
                                                                            when 'A' then 'Ativo'
                                                                            when 'I' then 'Inativo'
                                                                            end as status
                    from mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno where a.numg_aluno is not null";

        if ($array[numrAluno] != "") {
            $this->sSql .=" and a.numr_aluno = $array[numrAluno] ";
        }
        if ($array[nomeAluno] != "") {
            if(strlen($array[nomeAluno])>1){
                $trim = trim($array[nomeAluno]);
                $vNumrAluno = explode("-",$trim);
                $this->sSql .=" and cast(a.numr_aluno as text ) =".FormataStr($vNumrAluno[0]);
            }
        }
        if ($array[dataCadastroIni] != null && $array[dataCadastroFin] == null) {
            $this->sSql .=" and p.data_cadastro >= " . FormataDataConsulta($array[dataCadastroIni]);
        } else if ($array[dataCadastroIni] == null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and p.data_cadastro <= " . FormataDataConsulta($array[dataCadastroFin]);
        } else if ($array[dataCadastroIni] != null && $array[dataCadastroFin] != null) {
            $this->sSql .=" and p.data_cadastro BETWEEN " . FormataDataConsulta($array[dataCadastroIni]) . " and " . FormataDataConsulta($array[dataCadastroFin]);
        }

        if ($array[status] == "A") {
            $this->sSql .= " and a.desc_status = '" .$array[status] . "'";
        } else if ($array[status] == "I") {
            $this->sSql .= " and a.desc_status = '" .$array[status] . "'";
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
            } else if($ordem == "data") {
                $this->sSql .= " order by p.data_cadastro asc";
            } else {
                 $this->sSql .= " order by a.numr_aluno asc";
            }
        } else {
            if ($ordem == "nome") {
                $this->sSql .= " order by p.desc_nomepessoa desc";
            } else if($ordem == "data") {
                $this->sSql .= " order by p.data_cadastro desc";
            } else {
                 $this->sSql .= " order by a.numr_aluno desc";
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
     * Descrição: Consulta -  Gráficos de Alunos
     * @author Rodolfo Bueno.
     * Data: 19/11/2010
     */
   public function geracaoGraficos($dataIni, $dataFin, $tipoData, $tipoGrafico) {
       if($tipoGrafico == "T"){
            $this->sSql = " select p.desc_sexo, a.desc_status ";
        } else if($tipoGrafico == 'X'){
            $this->sSql = " select p.desc_sexo ";
        } else {
            $this->sSql = " select a.desc_status ";
        } 

        $this->sSql .= " from mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno where a.numg_aluno is not null";
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
            $this->oErro->addErro("Fonte: SGM.Aluno.geracaoGraficos(); Descrição: " . $e->getMessage() . "ß");
            $this->Oad->desconectar();
            return false;
        }
    }
/**
* Descrição: Gera o numero do aluno automáticamente.
 * @author Fabricio Nogueira.
 * Data: 23/11/2010.
 */
public function geraNumrAluno(){
    $this->sSql = "select max(numr_aluno) from mu_alunos";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getValores(0,"max") + 1;
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Aluno.geraNumrAluno(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descrição: Consulta autocomplete para selecionar todos os numr dos alunos.
 * @author Fabricio Nogueira
 * Data: 15/12/2010.
 */
public function consultaNumrAlunos($valor){
    $this->sSql = " select numr_aluno as value
                    from mu_alunos
                    where  cast(numr_aluno as text ) like  '%$valor%'";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Aluno.consultaNumrAlunos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/*
 * Descrição: Consulta autocomplete para selecionar todos os numr dos alunos.
 * @author Fabricio Nogueira
 * Data: 15/12/2010.
 */
public function consultaNomeAlunos($valor){
    $this->sSql = " select a.numr_aluno||' - '||p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as value, a.numg_aluno as id
                    from mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno
                    where lower(p.desc_nomepessoa) like lower('%$valor%')";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset->getRegistros();
    } catch (Exception $e) {
        $this->oErro->addErro("Fonte: SGM.Aluno.consultaNomeAlunos(); Descrição: " . $e->getMessage() . "ß");
        $this->Oad->desconectar();
        return false;
    }
}
/*
 * Descrição: Consulta nome aluno por numg.
 * @author Fabricio Nogueira
 * Data: 17/12/2010.
 */
public function consultaNomeAlunosNumg($numgAluno){
    if($numgAluno!=""){
        $this->sSql = " select p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nome_aluno
                        from mu_alunos a
                        left join ge_pessoas p on p.numg_pessoa = a.numg_aluno
                        where a.numg_aluno = $numgAluno";
        try {
            $this->Oad->conectar();
            $this->oResultset = $this->Oad->consultar($this->sSql);
            $this->Oad->desconectar();
            return $this->oResultset->getValores(0,"nome_aluno");
        } catch (Exception $e) {
            $this->oErro->addErro("Fonte: SGM.Aluno.consultaNomeAlunosNumg(); Descrição: " . $e->getMessage() . "ß");
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