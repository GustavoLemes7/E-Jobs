<?php
#Nome do arquivo: LoginService.php
#Objetivo: classe service para Login

require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/TipoUsuario.php");

class LoginService {

    public function validarCampos(?string $email, ?string $senha) {
        $arrayMsg = array();

        //Valida o campo nome
        if(! $email)
            array_push($arrayMsg, "O campo [Login] é obrigatório.");

        //Valida o campo login
        if(! $senha)
            array_push($arrayMsg, "O campo [Senha] é obrigatório.");

        return $arrayMsg;
    }

    public function salvarUsuarioSessao(Usuario $usuario) {
        //Habilitar o recurso de sessão no PHP nesta página
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //Setar usuário na sessão do PHP
        $_SESSION[SESSAO_USUARIO_ID]   = $usuario->getId();
        $_SESSION[SESSAO_USUARIO_PAPEL] = $usuario->getTipoUsuario();
        $_SESSION['usuario'] = $usuario;

    }
    

    public function removerUsuarioSessao() {
        //Habilitar o recurso de sessão no PHP nesta página
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //Remover variáveis
        session_unset();

        //Destroi a sessão 
        session_destroy();
    }

    public function PosLogin(Usuario $usuario): array {

    // STATUS
    if ($usuario->getStatus() === Status::PENDENTE) {
        return ['redirect' => LOGIN_PAGE,
                'erro' => 'Aguardando aprovação do admin!'];
    }

    if ($usuario->getStatus() === Status::INATIVO) {
        return ['redirect' => LOGIN_PAGE,
                'erro' => 'Usuário está inativo!'];
    }

    if ($usuario->getTipoUsuario() === null) {
        $_SESSION[SESSAO_USUARIO_ID] = $usuario->getId();
        return [
            'redirect' => BASEURL . "/view/usuario/select_tipo_usuario.php",
            'salvarSessao' => false // 👈 NÃO salva ainda
        ];
    }

    switch ($usuario->getTipoUsuario()) {
        case TipoUsuario::CANDIDATO:
            return [
                'redirect' => HOME_PAGE,
                'salvarSessao' => true
            ];

        case TipoUsuario::ADMINISTRADOR:
            return [
                'redirect' => BASEURL . "/controller/AdminController.php?action=home",
                'salvarSessao' => true
            ];

        case TipoUsuario::EMPRESA:
            return [
                'redirect' => BASEURL . "/controller/EmpresaController.php?action=home",
                'salvarSessao' => true
            ];

        default:
            return [
                'redirect' => HOME_PAGE,
                'salvarSessao' => true
            ];
    }
}

}