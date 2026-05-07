<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/CidadeDAO.php");
include_once(__DIR__ . "/../model/Empresa.php");
include_once(__DIR__ . "/../model/enum/TipoUsuario.php");

class EmpresaDAO
{

    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM empresas e ORDER BY e.nome_fantasia";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapEmpresas($result);
    }

    public function findByUsuarioId(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM empresas e" .
            " WHERE e.usuario_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapEmpresas($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("Candidato.findById()" .
            " - Erro: mais de um candidato encontrado.");
    }

    public function findByCNPJ(string $cpf)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM Empresas e" .
            " WHERE e.cnpj = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$cpf]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapEmpresas($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;
    }



    public function insert(Empresa $usuario)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO empresas (usuario_id, nome_fantasia, razao_social, descricao, cnpj, inscricao_estadual, 
                data_abertura, logo_url, site, numero_funcionarios, telefone_contato, email_contato)" .
        " VALUES (:usuario_id,:nome_fantasia, :razao_social, :descricao, :cnpj, :inscricao_estadual, :data_abertura,
                :logo_url, :site, :numero_funcionarios, :telefone_contato, :email_contato)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("usuario_id", $usuario->getUsuario_id());
        $stm->bindValue("nome_fantasia", $usuario->getNomeFantasia());
        $stm->bindValue("razao_social", $usuario->getRazaoSocial());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("cnpj", $usuario->getCnpj());
        $stm->bindValue("inscricao_estadual", $usuario->getInscricaoEstadual());
        $stm->bindValue("data_abertura", $usuario->getDataAbertura());
        $stm->bindValue("logo_url", $usuario->getLogoUrl());
        $stm->bindValue("site", $usuario->getSiteUrl());
        $stm->bindValue("numero_funcionarios", $usuario->getNumeroFuncionarios());
        $stm->bindValue("telefone_contato", $usuario->getTelefoneContato());
        $stm->bindValue("email_contato", $usuario->getEmailContato());
        $stm->execute();
    }


    public function update(Empresa $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE empresas SET 
                nome_fantasia = :nome_fantasia,
                razao_social = :razao_social,
                descricao = :descricao,
                inscricao_estadual = :inscricao_estadual,
                data_abertura = :data_abertura,
                logo_url = :logo_url,
                site = :site,
                numero_funcionarios = :numero_funcionarios,
                telefone_contato = :telefone_contato,
                email_contato = :email_contato
               
            WHERE usuario_id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome_fantasia", $usuario->getNomeFantasia());
        $stm->bindValue("razao_social", $usuario->getRazaoSocial());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("inscricao_estadual", $usuario->getInscricaoEstadual());
        $stm->bindValue("data_abertura", $usuario->getDataAbertura());
        $stm->bindValue("logo_url", $usuario->getLogoUrl());
        $stm->bindValue("site", $usuario->getSiteUrl());
        $stm->bindValue("numero_funcionarios", $usuario->getNumeroFuncionarios());
        $stm->bindValue("telefone_contato", $usuario->getTelefoneContato());
        $stm->bindValue("email_contato", $usuario->getEmailContato());
        $stm->bindValue("id", $usuario->getUsuario_id());
        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM empresas WHERE usuario_id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

   

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapEmpresas($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Empresa();
            $usuario->setUsuario_id($reg['usuario_id']);
            $usuario->setNomeFantasia($reg['nome_fantasia']);
            $usuario->setRazaoSocial($reg['razao_social']);
            $usuario->setDescricao($reg['descricao']);
            $usuario->setCnpj($reg['cnpj']);
            $usuario->setInscricaoEstadual($reg['inscricao_estadual']);
            $usuario->setDataAbertura($reg['data_abertura']);
            $usuario->setLogoUrl($reg['logo_url']);
            $usuario->setSiteUrl($reg['site']);
            $usuario->setNumeroFuncionarios($reg['numero_funcionarios']);
            $usuario->setTelefoneContato($reg['telefone_contato']);
            $usuario->setEmailContato($reg['email_contato']);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}
