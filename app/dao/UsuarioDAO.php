<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/CidadeDAO.php");
include_once(__DIR__ . "/../model/Usuario.php");


class UsuarioDAO
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

        $sql = "SELECT * FROM usuarios u";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapUsuarios($result);
    }

    public function listEmpresasPendentes()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u 
                WHERE u.status = 'PENDENTE' 
                AND tipo_usuario_id = 3
                ORDER BY u.user_name";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u" .
            " WHERE u.id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }


    public function findByEmail(string $email)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u" .
            " WHERE u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;
    }


    //Método para buscar um usuário por seu login e senha
   public function findByLoginSenha(string $email, string $senha)
{
    $conn = Connection::getConn();

    $sql = "SELECT u.*, ua.senha 
            FROM usuarios u
            JOIN usuarios_auth ua ON ua.usuario_id = u.id
            WHERE BINARY u.email = :email
              AND ua.provider = 'LOCAL'";

    $stm = $conn->prepare($sql);
    $stm->bindValue(":email", $email);
    $stm->execute();

    $dados = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$dados) {
        return null;
    }

    if (!password_verify($senha, $dados['senha'])) {
        return null;
    }

    $usuario = new Usuario();
    $usuario->setId($dados['id']);
    $usuario->setEmail($dados['email']);
    $usuario->setTelefone($dados['telefone']);
    $usuario->setTipoUsuario($dados['tipo_usuario']);
    $usuario->setStatus($dados['status']);

    return $usuario;
}


    public function insert(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO usuarios (email, status,
         telefone,  tipo_usuario)" .
            " VALUES (:email, :status,:telefone, :tipoUsuario)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("status", $usuario->getStatus());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->execute();
    }


    public function update(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET
                email = :email,
                telefone = :telefone,
                status = :status,
                tipo_usuario = :tipo_usuario

               
            WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("status", $usuario->getStatus());
        $stm->bindValue("tipo_usuario", $usuario->getTipoUsuario());
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    public function definirTipo(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET 
                tipo_usuario = :tipo_usuario
               
            WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("tipo_usuario", $usuario->getTipoUsuario());
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM usuarios WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function aprovarEmpresa(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET status = 'Ativo'" .
            " WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    public function inativarUsuario(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET status = 'INATIVO'" .
            " WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    public function alterarStatus(int $id, string $status)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuario SET status = :status WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindValue("status", $status);
        $stm->bindValue("id", $id);
        $stm->execute();
    }


    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapUsuarios($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['id']);
            $usuario->setEmail($reg['email']);
            $usuario->setStatus($reg['status']);
            $usuario->setTelefone($reg['telefone']);           
            $usuario->setTipoUsuario($reg['tipo_usuario']);
            $usuario->setDataCriacao($reg['data_criacao']);
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}
