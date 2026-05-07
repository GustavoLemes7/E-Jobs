<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/CidadeDAO.php");
include_once(__DIR__ . "/../model/Candidato.php");


class CandidatoDAO
{
    private CidadeDAO $cidadeDAO;

    public function __construct()
    {

        $this->cidadeDAO = new CidadeDAO;
    }

    //Método para listar os usuários a partir da base de dados
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM candidatos c ORDER BY u.primeiro_nome";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapCandidatos($result);
    }

    public function findByUsuarioId(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM candidatos c" .
            " WHERE c.usuario_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapCandidatos($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("Candidato.findById()" .
            " - Erro: mais de um candidato encontrado.");
    }

    public function findByCPF(string $cpf)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM candidatos c" .
            " WHERE c.cpf = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$cpf]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapCandidatos($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;
    }



    public function insert(Candidato $usuario)
    {
        // $conn = Connection::getConn();

        // $sql = "INSERT INTO candidatos (usuario_id, nome_completo, cpf, genero, descricao, curriculo_url,
        //         foto_perfil_url, data_nascimento, linkedin, github, escolaridade, experiencia, habilidades,
        //         telefone_contato, email_contato)" .
        //     " VALUES (:usuario_id, :nome_completo, :cpf, :genero, :descricao, :curriculo_url,
        //         :foto_perfil_url, :data_nascimento, :linkedin, :github, :escolaridade, :experiencia, :habilidades,
        //         :telefone_contato, :email_contato)";

        // $stm = $conn->prepare($sql);
        // $stm->bindValue("usuario_id", $usuario->getUsuario_id());
        // $stm->bindValue("nome_completo", $usuario->getNomeCompleto());
        // $stm->bindValue("cpf", $usuario->getCpf());
        // $stm->bindValue("genero", $usuario->getGenero());
        // $stm->bindValue("descricao", $usuario->getDescricao());
        // $stm->bindValue("curriculo_url", $usuario->getCurriculoUrl());
        // $stm->bindValue("foto_perfil_url", $usuario->getFotoPerfilUrl());
        // $stm->bindValue("data_nascimento", $usuario->getDataNascimento());
        // $stm->bindValue("linkedin", $usuario->getLinkedin());
        // $stm->bindValue("github", $usuario->getGithub());
        // $stm->bindValue("escolaridade", $usuario->getEscolaridade());
        // $stm->bindValue("experiencia", $usuario->getExperiencia());
        // $stm->bindValue("habilidades", $usuario->getHabilidades());
        // $stm->bindValue("telefone_contato", $usuario->getTelefoneContato());
        // $stm->bindValue("email_contato", $usuario->getEmailContato());
        // $stm->execute();
    }

    public function createCandidato(Candidato $usuario){
        $conn = Connection::getConn();

        $sql = "INSERT INTO candidatos (usuario_id, nome_completo, cpf, data_nascimento)" .
            " VALUES (:usuario_id, :nome_completo, :cpf, :data_nascimento)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("usuario_id", $usuario->getUsuario_id());
        $stm->bindValue("nome_completo", $usuario->getNomeCompleto());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("data_nascimento", $usuario->getDataNascimento());
        $stm->execute();
        
    }


    public function update(Candidato $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE candidatos SET 
                nome_completo = :nome_completo,
                descricao = :descricao,
                curriculo_url = :curriculo_url,
                foto_perfil_url = :foto_perfil_url,
                data_nascimento = :data_nascimento,
                linkedin = :linkedin,
                github = :github,
                telefone_contato = :telefone_contato,
                email_contato = :email_contato
               
            WHERE usuario_id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome_completo", $usuario->getNomeCompleto());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("curriculo_url", $usuario->getCurriculoUrl());
        $stm->bindValue("foto_perfil_url", $usuario->getFotoPerfilUrl());
        $stm->bindValue("data_nascimento", $usuario->getDataNascimento());
        $stm->bindValue("linkedin", $usuario->getLinkedin());
        $stm->bindValue("github", $usuario->getGithub());
        $stm->bindValue("telefone_contato", $usuario->getTelefoneContato());
        $stm->bindValue("email_contato", $usuario->getEmailContato());
        $stm->bindValue("id", $usuario->getUsuario_id());
        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM candidatos WHERE usuario_id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

   

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapCandidatos($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Candidato();
            $usuario->setUsuario_id($reg['usuario_id']);
            $usuario->setNomeCompleto($reg['nome_completo']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setDescricao($reg['descricao'] ?? null);
            $usuario->setCurriculoUrl($reg['curriculo_url'] ?? null);
            $usuario->setFotoPerfilUrl($reg['foto_perfil_url'] ?? null);
            $usuario->setDataNascimento($reg['data_nascimento']);
            $usuario->setLinkedin($reg['linkedin'] ?? null);           
            $usuario->setGithub($reg['github'] ?? null);
            $usuario->setHabilidades($reg['habilidades'] ?? null);
            $usuario->setTelefoneContato($reg['telefone_contato'] ?? null);
            $usuario->setEmailContato($reg['email_contato'] ?? null);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}
