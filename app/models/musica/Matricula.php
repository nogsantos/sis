<?php
/**
 * Descri��o: Model Cadastro de Matriculas.
 * @author Fabricio Nogueira
 * @release
 * Data 26/09/2010
 */
class Matricula {
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
    private $numgMatricula;
    private $numgAluno;
    private $numgModalidade;
    private $dataMatricula;
    private $numgUsuarioMatricula;
    private $numrDiaSemana;
    private $numrHorarios;
    private $numgProfessor;
    /**
     * Construtor.
     * @author Rodolfo Bueno.
     * Data: 26/09/2010.
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
     * Descri��o: Set and Get n�mero gerado do formul�rio [obrigat�rio].
     */
    public function setNumgMatricula($numgMatricula){$this->numgMatricula = $numgMatricula;}
    public function getNumgMatricula(){return $this->numgMatricula;}
    /**
     * Descri��o: Set and Get n�mero do aluno.
     */
    public function setNumgAluno($numgAluno){$this->numgAluno = $numgAluno;}
    public function getNumgAluno(){return $this->numgAluno;}
    /**
     * Descri��o: Set and Get n�mero da modalidade
     */
    public function setNumgModalidade($numgModalidade){$this->numgModalidade = $numgModalidade;}
    public function getNumgModalidade(){return $this->numgModalidade;}
    /**
     * Descri��o: Set and Get data da matricula
     */
    public function setDataMatricula($dataMatricula){$this->dataMatricula = $dataMatricula;}
    public function getDataMatricula(){return $this->dataMatricula;}
    /**
     * Descri��o: Set and Get numero do usu�rio da matricula
     */
    public function setNumgUsuarioMatricula($numgUsuarioMatricula){$this->numgUsuarioMatricula = $numgUsuarioMatricula;}
    public function getNumgUsuarioMatricula(){return $this->numgUsuarioMatricula;}
    /**
     * Descri��o: Set and Get n�mero do dia da semana
     */
    public function setNumrDiaSemana($numrDiaSemana){$this->numrDiaSemana = $numrDiaSemana;}
    public function getNumrDiaSemana(){return $this->numrDiaSemana;}
    /**
     * Descri��o: Set and Get n�mero do hor�rios
     */
    public function setNumrHorarios($numrHorarios){$this->numrHorarios = $numrHorarios;}
    public function getNumrHorarios(){return $this->numrHorarios;}
    /**
     * Descri��o: Set and Get n�mero do professor
     */
    public function setNumgProfessor($numgProfessor){$this->numgProfessor = $numgProfessor;}
    public function getNumgProfessor(){return $this->numgProfessor;}

/*******************************************************************************/
/*                       Cadastros e A��es Diversas                            */
/*******************************************************************************/
/**
 * Descri��o: Consulta horarios dispon�veis por professor.
 * @author Fabricio Nogueira.
 * Data: 20/11/2010.
 * @return  I => Indispon�vel ; D => Dispon�vel
 */
public function consultarHorariosDisponiveisPorProfessor($numgModalidade,$numgProfessor,$numrDiaSemana, $numrHorario) {
    $this->sSql = " select distinct m.numr_horarios, m.numg_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nome_aluno,
                           '('||p.numr_dddtelefone||') '|| p.numr_telefone as telefone,
                           '('||numr_dddcelular||') '||numr_celular as celular
                    from mu_matriculas m
                    inner join mu_modalidades mo on mo.numg_modalidade = m.numg_modalidade
                    left join mu_professoresmodalidades pm on pm.numg_modalidade = mo.numg_modalidade
                    inner join ge_pessoas p on p.numg_pessoa = m.numg_aluno
                    where m.numg_professor = $numgProfessor and m.numr_diasemana = $numrDiaSemana and m.numr_horarios = '$numrHorario'";
//    print_pre($this->sSql);
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Matricula.consultarHorariosDisponiveisPorProfessor(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Consulta alunos n�o matriculados
 * @author Fabricio Nogueira.
 * Data: 20/11/2010.
 */
public function consultarAlunosNaoMatriculados(){
    $this->sSql = " select distinct a.numg_aluno, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nome_aluno
                    from  mu_alunos a
                    left join ge_pessoas p on p.numg_pessoa = a.numg_aluno
                    left join mu_matriculas m on m.numg_aluno = a.numg_aluno
                    where a.desc_status = 'A' and a.numg_aluno not in(select distinct numg_aluno from mu_matriculas )";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Matricula.consultarAlunosNaoMatriculados(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Consulta as modalidades cadastradas para o aluno.
 * @author Fabricio Nogueira.
 * Data: 30/11/2010.
 */
public function modalidadesCadastradasPorAluno($numgAluno){
    $this->sSql = "  select distinct mat.numg_matricula, m.desc_modalidade,numr_diasemana,
                                case mat.numr_diasemana
                                   when 2 then 'Segunda-feira'
                                   when 3 then 'Ter�a-feira'
                                   when 4 then 'Quarta-feira'
                                   when 5 then 'Quinta-feira'
                                   when 6 then 'Sexta-feira'
                                   when 7 then 'S�bado'
                                end as dia_semana,
                     mat.numr_horarios , p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nome_professor, mat.numg_professor
                     from mu_matriculas mat
                     join mu_modalidades m on m.numg_modalidade = mat.numg_modalidade
                     inner join mu_professoresmodalidades pm on pm.numg_modalidade = m.numg_modalidade
                     inner join ge_pessoas p on p.numg_pessoa = mat.numg_professor
                     where mat.numg_aluno = $numgAluno
                     ORDER BY numr_diasemana, desc_modalidade asc  ";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.Matricula.modalidadesCadastradasPorAluno(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: cadastra os dados de uma Matricula.
 * @author Fabricio Nogueira.
 * Data: 20/11/2010.
 */
public function cadastrar(){
    $vNumrSemana = $this->getNumrDiaSemana();
    $vDiaSemanaHorario = array();
    foreach($vNumrSemana as $i => $v){
        $vDiaSemanaHorario = explode("#", $v);
        $this->sSql .= " INSERT INTO mu_matriculas( numg_modalidade, numg_aluno, data_matricula,
                                                    numg_usuariomatricula, numr_diasemana, numr_horarios, numg_professor)
                        VALUES ( ";
        $this->sSql .= "{$this->getNumgModalidade()} ,";
        $this->sSql .= "{$this->getNumgAluno()} ,";
        $this->sSql .= "now() ,";
        $this->sSql .= "{$this->getNumgUsuarioMatricula()} ,";
        $this->sSql .= "{$vDiaSemanaHorario[0]} ,";
        $this->sSql .= FormataStr($vDiaSemanaHorario[1]).",";
        $this->sSql .= "{$this->getNumgProfessor()});";
    }
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch(Exception $e){
        $this->oErro->addErro("Fonte: SGM.Matricula.cadastrar(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Delete o hor�rio da matricula.
 * @author Fabricio Nogueira.
 * Data: 01/12/2010.
 */
public function deletar(){
    $vNumgMatricula = $this->getNumgMatricula();
    foreach($vNumgMatricula as $k =>$v){
        $this->sSql .= " delete from mu_matriculas where numg_matricula = $k;";
    }
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch(Exception $e){
        $this->oErro->addErro("Fonte: SGM.Matricula.cadastrar(); deletar: " . $e->getMessage() . "�");
        $this->Oad->rollback();
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