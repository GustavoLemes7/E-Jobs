<?php
include_once(__DIR__ . "/../connection/Connection.php");

class UsuarioAuthDAO {



    // 🔍 Buscar por provider (google, local, etc)
    public function buscarPorProvider($provider, $provider_id) {

        $conn = Connection::getConn();
        $sql = "SELECT * FROM usuarios_auth WHERE provider = :provider AND provider_id = :provider_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":provider", $provider);
        $stmt->bindValue(":provider_id", $provider_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function inserir(UsuarioAuth $usuarioAuth) {

        $conn = Connection::getConn();

        $sql = "INSERT INTO usuarios_auth 
                (usuario_id, provider, provider_id, senha)
                VALUES (:usuario_id, :provider, :provider_id, :senha)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":usuario_id", $usuarioAuth->getUsuario()->getId());
        $stmt->bindValue(":provider", $usuarioAuth->getProvider());
        $stmt->bindValue(":provider_id", $usuarioAuth->getProvider_id());
        $stmt->bindValue(":senha", $usuarioAuth->getSenha());

        return $stmt->execute();
    }

}