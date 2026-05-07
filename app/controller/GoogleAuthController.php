<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../util/config.php';
require_once(__DIR__ . "/../service/LoginService.php");

use Google\Client;
use Google\Service\Oauth2;

require_once '../service/AuthService.php';

class GoogleAuthController {

    private LoginService $loginService;

    public function __construct() {
    
        $this->loginService = new LoginService();
    }


    private function getClient() {
        $client = new Client();

        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

        $client->addScope("email");
        $client->addScope("profile");

        return $client;
    }

    public function redirect() {
        $client = $this->getClient();

        header('Location: ' . $client->createAuthUrl());
        exit;
    }

    public function callback() {

        $client = $this->getClient();

        if (!isset($_GET['code'])) {
            die("Erro no login com Google");
        }

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (isset($token['error'])) {
            die("Erro ao autenticar");
        }

        $client->setAccessToken($token['access_token']);

        $google_oauth = new Oauth2($client);
        $google_account = $google_oauth->userinfo->get();

        $googleUser = [
            'id' => $google_account->id,
            'email' => $google_account->email,
            'name' => $google_account->name
        ];

        $authService = new AuthService();
        $usuario = $authService->loginComGoogle($googleUser);

        $resultado = $this->loginService->PosLogin($usuario);

        if (isset($resultado['erro'])) {
            header("Location: " . $resultado['redirect'] . "&msg=" . urlencode($resultado['erro']));
            exit;
        }

        if($resultado['salvarSessao'] == true){
            $this->loginService->salvarUsuarioSessao($usuario);
        }
        
        header("Location: " . $resultado['redirect']);
        exit;
            }
}