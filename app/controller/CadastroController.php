<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/UsuarioAuthDAO.php");
require_once(__DIR__ . "/../dao/EstadoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/UsuarioAuth.php");
require_once(__DIR__ . "/../model/enum/Status.php");
require_once(__DIR__ . "/../model/enum/TipoUsuario.php");

class CadastroController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioAuthDAO $usuarioAuthDao;
    private EstadoDAO $estadoDAO;
    private UsuarioService $usuarioService;
    private LoginService $loginService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
    
        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioAuthDao = new UsuarioAuthDAO();
        $this->estadoDAO = new EstadoDAO();
        $this->usuarioService = new UsuarioService();
        $this->loginService = new LoginService();


        $this->handleAction();
    }

    protected function createFormUsuario() {
       
        $this->loadView("usuario/form_usuario.php",[]);
        
    }

    protected function saveUsuario() {
        //Captura os dados do formulário
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
        $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
        
        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuarioAuth = new UsuarioAuth();

  
        $usuario->setTipoUsuario(null);
        $usuario->setEmail($email);
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $usuarioAuth->setSenha($senha);
        $usuario->setTelefone($telefone);
        $usuario->setStatus(Status::ATIVO);

        $usuarioAuth->setUsuario($usuario);
        
        //Validar os dados
        $erros = $this->usuarioService->validarSenha($senha);
        if(empty($erros)){
            $erros = $this->usuarioService->validarDados($usuarioAuth, $confSenha);
            if(empty($erros)){
                $usuarioAuth->setSenha($senhaHash);
                if(empty($erros)){
                $erros = array_merge($erros,$this->usuarioService->validarEmail($usuario->getEmail()));
                }
            }
        }
        if(empty($erros)) {
            //Persiste o objeto
            try {
                $this->usuarioDao->insert($usuario);
               
                $usuarioSalvo = $this->usuarioDao->findByEmail($email);

                if (!$usuarioSalvo) {
                    throw new Exception("Erro ao recuperar usuário");
                }     

                $usuarioAuth->setUsuario($usuarioSalvo);
                $usuarioAuth->setProvider('LOCAL');
                $usuarioAuth->setProvider_id(null);

                $this->usuarioAuthDao->inserir($usuarioAuth);
                $_SESSION[SESSAO_USUARIO_ID] = $usuarioSalvo->getId();
                    
                header("Location: " . BASEURL . "/view/usuario/select_tipo_usuario.php");
                exit;
                  
            } catch (PDOException $e) {
                header("Location: " . BASEURL . "/view/usuario/select_tipo_usuario.php?erro=Erro ao salvar");
                exit;            
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário

        
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
   
        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form_usuario.php", $dados, $msgsErro);
    }

    protected function definirTipo(){
        
        $tipoUsuario = $_POST['tipo'] ?? null;

        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            header('location: ' . HOME_PAGE);
            exit;
        }

        if (!$tipoUsuario) {
            header("Location: " . BASEURL . "/view/usuario/select_tipo_usuario.php?erro=Selecione um tipo");
            exit;
        }

        try{
            $usuario = $this->usuarioDao->findById($_SESSION[SESSAO_USUARIO_ID]);
            
            $usuario->setTipoUsuario($tipoUsuario);
            $this->usuarioDao->definirTipo($usuario);
            //$resultado = $this->loginService->PosLogin($usuario);
            //if (isset($resultado['erro'])) {
                //header("Location: " . $resultado['redirect'] . "&msg=" . urlencode($resultado['erro']));
                //exit;
            //}
            $this->loginService->salvarUsuarioSessao($usuario);
            //header("Location: " . $resultado['redirect']);
            if($tipoUsuario == TipoUsuario::EMPRESA){
                header("Location: " . BASEURL . "/controller/EmpresaController.php?action=form");
                exit;
            }
            elseif($tipoUsuario == TipoUsuario::CANDIDATO){
                header("Location: " . BASEURL . "/controller/HomeController.php?action=form");
                exit;
            }

        }catch(PDOException $e) {
                $erros = ["Erro ao salvar o usuário na base de dados."];                
        }
    }


}


#Criar objeto da classe para assim executar o construtor
new CadastroController();
