<?php
require_once __DIR__ . '/../../vendor/autoload.php';

# Carrega .env PRIMEIRO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

//Configuração de erro no PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Banco de dados (AGORA usando .env)
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

//Base URL
define('BASEURL', '/E-Jobs/app');

define("PUBLICURL", "http://localhost/E-Jobs/public");

//Nome do sistema
define('APP_NAME', $_ENV['APP_NAME']);

//Rotas
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');
define('EMPRESAHOME_PAGE', BASEURL . '/controller/EmpresaController.php?action=home');
define('ADMINHOME_PAGE', BASEURL . '/controller/AdminController.php?action=home');

//Sessão
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_PAPEL', "usuarioLogadoPapel");