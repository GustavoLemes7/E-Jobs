<?php
require_once __DIR__ . '/../dao/UsuarioAuthDAO.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once(__DIR__ . "/../model/UsuarioAuth.php");
require_once(__DIR__ . "/../model/enum/Status.php");
class AuthService {

    public function loginComGoogle($googleUser) {

        $google_id = $googleUser['id'];
        $email = $googleUser['email'];

        $authDAO = new UsuarioAuthDAO();
        $usuarioDAO = new UsuarioDAO();

        // 1. Já existe login Google?
        $auth = $authDAO->buscarPorProvider('google', $google_id);

        if ($auth) {
            return $usuarioDAO->findById($auth['usuario_id']);
        }

        // 2. Já existe usuário com esse email?
        $usuario = $usuarioDAO->findByEmail($email);

        if (!$usuario) {
            $usuario = new Usuario();
            $usuario->setEmail($email);
            $usuario->setStatus(Status::ATIVO);
            $usuarioDAO->insert($usuario);
            $usuario = $usuarioDAO->findByEmail($email);
        }

        // 3. Vincula Google
        
        $usuarioAuth = new UsuarioAuth();
        $usuarioAuth->setUsuario($usuario);
        $usuarioAuth->setProvider('GOOGLE');
        $usuarioAuth->setProvider_id($google_id);
        $usuarioAuth->setSenha(null);
        $authDAO->inserir($usuarioAuth);

        return $usuario;
    }
}