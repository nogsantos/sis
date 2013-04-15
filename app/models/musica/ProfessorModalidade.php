<?php
/**
 * Descri��o: Model Intermedi�rio de Modalidades do Professores da Escola de M�sica.
 * @author Fabricio Nogueira.
 * @release Cria��o do arquivo.
 * Data 05/11/2010
 */
class ProfessorModalidade{
    /**
    * Parametros da classe
    */
    private $sSql;
    private $sSqlAux;
    private $sSqlAux2;
    private $numgModalidade;
    private $numgProfessor;
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
     * Descri��o: Set and Get numg modalidade [ obrigat�rio ]
     */
    public function setNumgModalidade($numgModalidade){$this->numgModalidade = $numgModalidade;}
    public function getNumgModalidade(){return $this->numgModalidade;}
    /**
     * Descri��o: Set and Get numg professor [ obrigat�rio ]
     */
    public function setNumgProfessor($numgProfessor){$this->numgProfessor = $numgProfessor;}
    public function getNumgProfessor(){return $this->numgProfessor;}
/*******************************************************************************/
/*                       Cadastros e A��es Diversas                            */
/*******************************************************************************/
/**
 * Descri��o: Cadastrar professores modalidade
 * @author Fabricio Nogueira
 * Data: 07/11/2010
 */
public function cadastrar(){
    $this->sSql = " INSERT INTO mu_professoresmodalidades(numg_modalidade, numg_professor)
                     VALUES( ";
    $this->sSql .= FormataNumeroGravacao($this->getNumgModalidade()).",";
    $this->sSql .= FormataNumeroGravacao($this->getNumgProfessor()).");";
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch(Exception $e){
        $this->oErro->addErro("Fonte: SGM.ProfessorModalidade.cadastrar(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Excluir professores modalidade
 * @author Fabricio Nogueira
 * Data: 12/11/2010
 */
public function excluir(){
    $this->sSql = "delete from mu_professoresmodalidades where numg_modalidade = ".$this->getNumgModalidade()." and numg_professor = ".$this->getNumgProfessor();
    try {
        $this->Oad->conectar();
        $this->Oad->begin();
        $this->Oad->executar($this->sSql);
        $this->Oad->commit();
        $this->Oad->desconectar();
        return true;
    }catch(Exception $e){
        $this->oErro->addErro("Fonte: SGM.ProfessorModalidade.excluir(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->rollback();
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Populando o select com as modalidades n�o cadastradas para o professor
 * @author Fabricio Nogueira
 * Data: 07/11/2010
 */
public function consultaModalidadesNaoCadastradas($numgProfessor){
    $this->sSql = " select distinct m.numg_modalidade, m.desc_modalidade
                    from mu_modalidades m
                    left join mu_professoresmodalidades pm on pm.numg_modalidade = m.numg_modalidade
                    where m.numg_modalidade not in(select numg_modalidade from mu_professoresmodalidades where numg_professor = ".$numgProfessor." )
                    and m.data_bloqueio is null";
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.ProfessorModalidade.consultaModalidadesNaoCadastradas(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Modalidades cadastradas para o professor
 * @author Fabricio Nogueira
 * Data: 07/11/2010
 */
public function consultaModalidadesCadastradas($numgProfessor){
    $this->sSql = " select distinct m.numg_modalidade, m.desc_modalidade
                    from mu_modalidades m
                    left join mu_professoresmodalidades mp on mp.numg_modalidade = m.numg_modalidade
                    where mp.numg_professor = ".$numgProfessor;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    }catch (Exception $e){
        $this->oErro->addErro("Fonte: SGM.ProfessorModalidade.consultaModalidadesCadastradas(); Descri��o: " . $e->getMessage() . "�");
        $this->Oad->desconectar();
        return false;
    }
}
/**
 * Descri��o: Modalidades cadastradas para o professor
 * @author Fabricio Nogueira
 * Data: 07/11/2010
 */
public function consultarProfessoresPorModalidades($numgModalidade){
    $this->sSql = " select distinct pf.numg_professor, p.desc_nomepessoa||' '||p.desc_sobrenomepessoa as nome_professor
                    from ge_pessoas p
                    join mu_professores pf on pf.numg_professor = p.numg_pessoa
                    join mu_professoresmodalidades pm on pm.numg_professor = pf.numg_professor
                    where pm.numg_modalidade = $numgModalidade and desc_status = 'A' " ;
    try {
        $this->Oad->conectar();
        $this->oResultset = $this->Oad->consultar($this->sSql);
        $this->Oad->desconectar();
        return $this->oResultset;
    } catch (Exception $e) {
        $this->Oad->desconectar();
        $this->oErro->addErro("Fonte: SGM.ProfessorModalidade.consultarProfessoresPorModalidades()" . $e->getMessage() . "�");
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
