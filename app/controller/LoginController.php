<?php 
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

require_once __DIR__ . '/../util/config.php';

class LoginController extends Controller {

    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;

    public function __construct() {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();
        
        $this->handleAction();
    }

    protected function login() {
        $this->loadView("login/login.php", []);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logon() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;

        //Validar os campos
        $erros = $this->loginService->validarCampos($email, $senha);
        if(empty($erros)) {

            $usuarioEmail = $this->usuarioDao->findByEmail($email);
            if($usuarioEmail == null){
                $usuario = null;
                $erros = ["Email não cadastrado"];
            }
            else{
                 //Valida o login a partir do banco de dados
                $usuario = $this->usuarioDao->findByLoginSenha($email, $senha);

                if ($usuario) {

                    $resultado = $this->loginService->PosLogin($usuario);

                    if (isset($resultado['erro'])) {
                        $erros = [$resultado['erro']];
                    } else {
                        $this->loginService->salvarUsuarioSessao($usuario);

                        header("Location: " . $resultado['redirect']);
                        exit;
                    }
                }else {
                            $erros = ["Login ou senha informados são inválidos!"];
                }
            }
        }

        //Se há erros, volta para o formulário            
        $msg = implode("<br>", $erros);
        $dados["email"] = $email;
        $dados["senha"] = $senha;

        $this->loadView("login/login.php", $dados, $msg);
    }

     /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logout() {
        $this->loginService->removerUsuarioSessao();

        $this->loadView("login/login.php", [], "", "Usuário deslogado com suscesso!");
    }

}

new LoginController();
