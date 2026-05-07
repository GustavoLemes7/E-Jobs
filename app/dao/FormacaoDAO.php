<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Formacao.php");


class FormacaoDAO
{

    public function __construct()
    {
    }
  
     public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM formacoes f" .
            " WHERE f.id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $formacoes =   $this->mapFormacoes($result); 

        return $formacoes[0];
    }

    public function findByUsuarioId(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM formacoes f" .
            " WHERE f.candidato_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        return  $this->mapFormacoes($result);    

    }


    public function insert(Formacao $formacao)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO formacoes (candidato_id, instituicao, curso, data_inicio, data_fim, descricao)" .
                " VALUES (:candidato_id, :instituicao, :curso, :data_inicio, :data_fim, :descricao)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("candidato_id", $formacao->getCandidato_id());
        $stm->bindValue("instituicao", $formacao->getInstituicao());
        $stm->bindValue("curso", $formacao->getCurso());
        $stm->bindValue("data_inicio", $formacao->getDataInicio());
        $stm->bindValue("data_fim", $formacao->getDataFim());
        $stm->bindValue("descricao", $formacao->getDescricao());
        $stm->execute();
    }

    public function update(Formacao $formacao)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE formacoes SET 
                instituicao = :instituicao,
                curso = :curso,
                data_inicio = :data_inicio,
                data_fim = :data_fim,
                descricao = :descricao
               
               
            WHERE id = :id";

        $stm = $conn->prepare($sql);
         $stm->bindValue("instituicao", $formacao->getInstituicao());
        $stm->bindValue("curso", $formacao->getCurso());
        $stm->bindValue("data_inicio", $formacao->getDataInicio());
        $stm->bindValue("data_fim", $formacao->getDataFim());
        $stm->bindValue("descricao", $formacao->getDescricao());
        $stm->bindValue("id", $formacao->getId());
        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM formacoes WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

   

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapFormacoes($result)
    {
        $formacoes = array();
        foreach ($result as $reg) {
            $formacao = new Formacao();
            $formacao->setId($reg['id']);
            $formacao->setCandidato_id($reg['candidato_id']);
            $formacao->setInstituicao($reg['instituicao'] ?? null);
            $formacao->setCurso($reg['curso']);
            $formacao->setDataInicio($reg['data_inicio']);
            $formacao->setDataFim($reg['data_fim'] ?? null);
            $formacao->setDescricao($reg['descricao'] ?? null);
            array_push($formacoes, $formacao);
        }

        return $formacoes;
    }
}
