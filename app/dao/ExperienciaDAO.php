<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Experiencia.php");


class ExperienciaDAO
{
     public function __construct()
    {
    }

     public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM experiencias e" .
            " WHERE e.id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $experiencias =  $this->mapExperiencias($result);  

        return $experiencias[0]; 

    }  

    public function findByUsuarioId(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM experiencias e" .
            " WHERE e.candidato_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        return  $this->mapExperiencias($result);

    }


    public function insert(Experiencia $experiencia)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO experiencias (candidato_id, cargo, empresa, data_inicio, data_fim, descricao)" .
                " VALUES (:candidato_id, :cargo, :empresa, :data_inicio, :data_fim, :descricao)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("candidato_id", $experiencia->getCandidato_id());
        $stm->bindValue("cargo", $experiencia->getCargo());
        $stm->bindValue("empresa", $experiencia->getEmpresa());
        $stm->bindValue("data_inicio", $experiencia->getDataInicio());
        $stm->bindValue("data_fim", $experiencia->getDataFim());
        $stm->bindValue("descricao", $experiencia->getDescricao());
        $stm->execute();
    }

    public function update(Experiencia $experiencia)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE experiencias SET 
                cargo = :cargo,
                empresa = :empresa,
                data_inicio = :data_inicio,
                data_fim = :data_fim,
                descricao = :descricao
               
               
            WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("cargo", $experiencia->getCargo());
        $stm->bindValue("empresa", $experiencia->getEmpresa());
        $stm->bindValue("data_inicio", $experiencia->getDataInicio());
        $stm->bindValue("data_fim", $experiencia->getDataFim());
        $stm->bindValue("descricao", $experiencia->getDescricao());
        $stm->bindValue("id", $experiencia->getId());
        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM experiencias WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

   

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapExperiencias($result)
    {
        $experiencias = array();
        foreach ($result as $reg) {
            $experiencia = new Experiencia();
            $experiencia->setId($reg['id']);
            $experiencia->setCandidato_id($reg['candidato_id']);
            $experiencia->setCargo($reg['cargo'] ?? null);
            $experiencia->setEmpresa($reg['empresa']);
            $experiencia->setDataInicio($reg['data_inicio']);
            $experiencia->setDataFim($reg['data_fim'] ?? null);
            $experiencia->setDescricao($reg['descricao'] ?? null);
            array_push($experiencias, $experiencia);
        }

        return $experiencias;
    }
}
