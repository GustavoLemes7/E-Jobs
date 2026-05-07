<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Candidatura.php");
include_once(__DIR__ . "/../model/Candidato.php");
require_once(__DIR__ . "/../model/Cargo.php");

class CandidaturaDAO
{

    public function findByCandidatoAndVaga($candidatoId, $vagaId)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM candidaturas WHERE candidato_id = :candidato_id AND vaga_id = :vaga_id";
        $stm = $conn->prepare($sql);
        $stm->bindValue("candidato_id", $candidatoId);
        $stm->bindValue("vaga_id", $vagaId);
        $stm->execute();
        $result = $stm->fetchAll();
        $candidaturas = $this->mapCandidaturas($result);

        if ($candidaturas)
            return $candidaturas[0];

        return null;
    }

    public function insert(Candidatura $candidatura)
    {
        $conn = Connection::getConn();
        $sql = "INSERT INTO candidaturas (candidato_id, vaga_id, data_candidatura, status)" .
            " VALUES (:candidato_id, :vaga_id, now(), :status)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("candidato_id", $candidatura->getCandidato()->getUsuario_id());
        $stm->bindValue("vaga_id", $candidatura->getVaga()->getId());
        $stm->bindValue("status", $candidatura->getStatus());


        $stm->execute();
    }

    private function mapCandidaturas($result)
    {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();
            $candidatura->setId($dado['id']);

            $candidato = new Candidato();
            $candidato->setUsuario_id($dado['candidato_id']);
            $candidatura->setCandidato($candidato);

            $vaga = new Vaga();
            $vaga->setId($dado['vaga_id']);
            $candidatura->setVaga($vaga);

            $candidatura->setDataCandidatura($dado['data_candidatura']);
            $candidatura->setStatus($dado['status']);

            array_push($candidaturas, $candidatura);
        }
        return $candidaturas;
    }

    public function findByCandidato($candidatoId)
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
                    c.*, 
                    c.id AS candidatura_id, 
                    c.status AS candidatura_status, 
                    v.*, 
                    e.nome_fantasia AS nome_fantasia, 
                    car.nome as cargo_nome 
                FROM candidaturas c 
                JOIN vagas v ON c.vaga_id = v.id 
                JOIN empresas e ON v.empresa_id = e.usuario_id 
                JOIN cargos car ON v.cargos_id = car.id 
                WHERE c.candidato_id = :candidato_id 
                ORDER BY c.data_candidatura DESC";

        $stm = $conn->prepare($sql);
        $stm->bindValue("candidato_id", $candidatoId);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapCandidaturasComVaga($result);
    }

    private function mapCandidaturasComVaga($result)
    {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();
            $candidatura->setId($dado['candidatura_id']);

            $candidato = new Candidato();
            $candidato->setUsuario_id($dado['candidato_id']);
            $candidatura->setCandidato($candidato);

            $vaga = new Vaga();
            $vaga->setId($dado['vaga_id']);
            $vaga->setTitulo($dado['titulo']);
            $vaga->setModalidade($dado['modalidade']);
            $vaga->setHorario($dado['horario']);
            $vaga->setRegime($dado['regime']);
            $vaga->setSalario($dado['salario']);
            $vaga->setDescricao($dado['descricao']);
            $vaga->setRequisitos($dado['requisitos']);
            $vaga->setStatus($dado['status']);

            $empresa = new Empresa();
            $empresa->setUsuario_id($dado['empresa_id']);
            $empresa->setNomeFantasia($dado['nome_fantasia']);
            $vaga->setEmpresa($empresa);

            $cargo = new Cargo();
            $cargo->setId($dado['cargos_id']);
            $cargo->setNome($dado['cargo_nome']);
            $vaga->setCargo($cargo);

            $candidatura->setVaga($vaga);
            $candidatura->setDataCandidatura($dado['data_candidatura']);
            $candidatura->setStatus($dado['candidatura_status']);

            array_push($candidaturas, $candidatura);
        }
        return $candidaturas;
    }

    public function findByVaga(int $vagaId)
    {
        $conn = Connection::getConn();

        $sql = "SELECT c.*, u.nome_completo, u.email_contato, u.telefone_contato
                FROM candidaturas c 
                JOIN candidatos u ON c.candidato_id = u.usuario_id
                WHERE c.vaga_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$vagaId]);
        $result = $stm->fetchAll();

        return $this->mapCandidaturasComCandidato($result);
    }

    public function aprovar($idCandidatura)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE candidaturas SET status = 'Aprovado' WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $idCandidatura, PDO::PARAM_INT);

        return $stm->execute();
    }



    private function mapCandidaturasComCandidato($result)
    {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();

            $candidatura->setId($dado['id']);

            $candidato = new Candidato();
            $candidato->setUsuario_id($dado['candidato_id']);
            $candidato->setNomeCompleto($dado['nome_completo']);
            $candidato->setTelefoneContato($dado['telefone_contato']);
            $candidato->setEmailContato($dado['email_contato']);
            $candidatura->setCandidato($candidato);

            $vaga = new Vaga();
            $vaga->setId($dado['vaga_id']);
            $candidatura->setVaga($vaga);

            $candidatura->setDataCandidatura($dado['data_candidatura']);
            $candidatura->setStatus($dado['status']);

            array_push($candidaturas, $candidatura);
        }
        return $candidaturas;
    }

    public function listByVaga($idVaga)
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
                c.id AS candidatura_id,
                c.status AS candidatura_status,
                u.id AS usuario_id,
                u.nome, 
                u.email, 
                u.telefone, 
                u.descricao
            FROM candidaturas c
            INNER JOIN usuario u ON u.id = c.candidato_id
            WHERE c.vaga_id = :idVaga";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":idVaga", $idVaga, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "DELETE FROM candidatura WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    public function alterarStatus($idCandidatura, $status)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE candidatura 
            SET status = :status 
            WHERE id = :id";

        $stm = $conn->prepare($sql);
        return $stm->execute([
            ":status" => $status,
            ":id" => $idCandidatura
        ]);
    }

    public function findById($id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
                    c.*, 
                    u.primeiro_nome AS candidato_primeiro_nome,
                    u.segundo_nome AS candidato_segundo_nome,
                    u.email_contato AS candidato_email,
                    u.telefone_contato AS candidato_telefone,
                    v.titulo AS vaga_titulo,
                    v.empresa_id,
                    e.razao_social AS empresa_nome,
                    e.email_contato AS empresa_email
                FROM candidaturas c
                INNER JOIN candidatos u ON u.id = c.candidato_id
                INNER JOIN vaga v ON v.id = c.vaga_id
                INNER JOIN empresas e ON e.id = v.empresa_id
                WHERE c.id = :id
                LIMIT 1";


        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();

        $dado = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$dado) {
            return null;
        }

        $candidatura = new Candidatura();
        $candidatura->setId($dado['id']);

        $candidato = new Candidato();
        $candidato->setUsuario_id($dado['candidato_id']);
        $candidato->setNomeCompleto($dado['candidato_nome_completo']);
        $candidato->setEmailContato($dado['candidato_email']);
        $candidato->setEmailContato($dado['candidato_telefone']);
        $candidatura->setCandidato($candidato);

        $empresa = new Empresa();
        $empresa->setUsuario_id($dado['empresa_id']);
        $empresa->setNomeFantasia($dado['empresa_nome']);
        $empresa->setEmailContato($dado['empresa_email']);
        

        $vaga = new Vaga();
        $vaga->setId($dado['vaga_id']);
        $vaga->setTitulo($dado['vaga_titulo']);
        $vaga->setEmpresa($empresa);
        $candidatura->setVaga($vaga);

        $candidatura->setDataCandidatura($dado['data_candidatura']);
        $candidatura->setStatus($dado['status']);

        return $candidatura;
    }
}
