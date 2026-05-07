<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CandidatoDAO.php");
require_once(__DIR__ . "/../dao/EmpresaDAO.php");
require_once(__DIR__ . "/../dao/EstadoDAO.php");
require_once(__DIR__ . "/../dao/ExperienciaDAO.php");
require_once(__DIR__ . "/../dao/FormacaoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

class UsuarioController extends Controller {

    private UsuarioDAO $usuarioDao;
    private CandidatoDAO $candidatoDao;
    private EmpresaDAO $empresaDao;
    private EstadoDAO $estadoDAO;
    private ExperienciaDAO $experienciaDAO;
    private FormacaoDAO $formacaoDAO;
    private UsuarioService $usuarioService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->usuarioDao = new UsuarioDAO();
        $this->estadoDAO = new EstadoDAO();
        $this->usuarioService = new UsuarioService();
        $this->candidatoDao = new CandidatoDAO();
        $this->empresaDao = new EmpresaDAO();
        $this->experienciaDAO = new ExperienciaDAO();
        $this->formacaoDAO = new FormacaoDAO();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $usuarios = $this->usuarioDao->list();
        $dados["lista"] = $usuarios;

        $this->loadView("usuario/list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function listEmpresasPendentes(string $msgErro = "", string $msgSucesso = "") {
        $usuarios = $this->usuarioDao->listEmpresasPendentes();
        $dados["lista"] = $usuarios;

        $this->loadView("usuario/listEmpresas.php", $dados,  $msgErro, $msgSucesso);
    }


    protected function edit() {
        $usuario = $this->findUsuarioById();
        if($usuario) {
            $dados["id"] = $usuario->getId();
            $dados["usuario"] = $usuario;
            $dados["papeis"] = TipoUsuario::getAllAsArray();
            $dados["status"] = Status::getAllAsArray(); 

            $this->loadView("usuario/form.php", $dados);
        } else
            $this->list("Usuário não encontrado.");
    }

    protected function viewProfile() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Get user ID from URL if provided, otherwise use logged in user's ID
        $usuarioId = isset($_GET['id']) ? $_GET['id'] : $_SESSION[SESSAO_USUARIO_ID];
        $usuarioTipo = isset($_GET['tipo']) ? $_GET['tipo'] : $_SESSION[SESSAO_USUARIO_PAPEL];

        if($usuarioTipo == TipoUsuario::CANDIDATO){
            $usuario = $this->candidatoDao->findByUsuarioId($usuarioId);

            if ($usuario) {
            $dados["usuario"] = $usuario;
            $dados["isOwnProfile"] = ($usuarioId == $_SESSION[SESSAO_USUARIO_ID]);
            $dados["experiencias"] = $this->experienciaDAO->findByUsuarioId($usuarioId);
            $dados["formacoes"] = $this->formacaoDAO->findByUsuarioId($usuarioId);
            $dados["isEmpresa"] = FALSE;
            $this->loadView("usuario/profile.php", $dados);
            } else {
                header("location: " . BASEURL . "/controller/LoginController.php?action=login");
                exit;
            }
        }
        elseif ($usuarioTipo == TipoUsuario::EMPRESA){
            $usuario = $this->empresaDao->findByUsuarioId($usuarioId);
            if ($usuario) {
            $dados["usuario"] = $usuario;
            $dados["isOwnProfile"] = ($usuarioId == $_SESSION[SESSAO_USUARIO_ID]);
            $dados["isEmpresa"] = TRUE;
            $this->loadView("usuario/profile.php", $dados);
            } else {
                header("location: " . BASEURL . "/controller/LoginController.php?action=login");
                exit;
            }
        }
       
    }


    protected function saveProfile() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $usuarioId = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($usuarioId);
        
        if (!$usuario) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Captura apenas os dados básicos do perfil
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $documento = trim($_POST['documento']) ? trim($_POST['documento']) : NULL;
        $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;

        // Validações básicas
        $erros = array();
        if (!$nome) array_push($erros, "O campo Nome é obrigatório.");
        if (!$email) array_push($erros, "O campo Email é obrigatório.");
        if (!$documento) array_push($erros, "O campo Documento é obrigatório.");
        if (!$telefone) array_push($erros, "O campo Telefone é obrigatório.");

        if (!empty($erros)) {
            $dados["usuario"] = $usuario;
            $this->loadView("usuario/profile_edit.php", $dados, implode("<br>", $erros));
            return;
        }

        // Atualiza apenas os campos básicos
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setDocumento($documento);
        $usuario->setTelefone($telefone);

        try {
            $this->usuarioDao->update($usuario);
            $_SESSION[SESSAO_USUARIO_NOME] = $nome;
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        } catch (PDOException $e) {
            $dados["usuario"] = $usuario;
            $this->loadView("usuario/profile_edit.php", $dados, "Erro ao salvar as alterações.");
        }
    }

    protected function saveEdit() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $usuarioId = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($usuarioId);
        
        if (!$usuario) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Captura apenas os dados básicos do perfil
        $id = isset($_POST['id']) ? (int)$_POST['id'] : $_SESSION[SESSAO_USUARIO_ID];
        $papel = isset($_POST['tipoUsuario']) ? trim($_POST['tipoUsuario']) : null;
        $email = isset($_POST['email']) ? trim($_POST['email']) : NULL;
        $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
        $status = isset($_POST['status']) ? trim($_POST['status']) : NULL;

        // Validações básicas
        $erros = array();
        if (!$papel) array_push($erros, "O campo Papel é obrigatório.");
        if (!$email) array_push($erros, "O campo Email é obrigatório.");
        if (!$status) array_push($erros, "O campo Status é obrigatório.");

        if (!empty($erros)) {
            $dados["usuario"] = $usuario;
            $this->loadView("usuario/form.php", $dados, implode("<br>", $erros));
            return;
        }

        // Atualiza apenas os campos básicos
        $usuario->setId($id);
        $usuario->setTipoUsuario($papel);
        $usuario->setEmail($email);
        $usuario->setStatus($status);
        $usuario->setTelefone($telefone);

        try {
            $this->usuarioDao->update($usuario);
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
            exit;
        } catch (PDOException $e) {
            $dados["usuario"] = $usuario;
            $this->loadView("usuario/profile_edit.php", $dados, "Erro ao salvar as alterações.");
        }

        $dados["usuario"] = $usuario;
        $dados["status"] = Status::getAllAsArray(); 
        $dados["papeis"] = TipoUsuario::getAllAsArray();

        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form.php", $dados, $msgsErro);
    }

    // protected function save() {
    //     //Captura os dados do formulário
    //     $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
    //     $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
    //     $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
    //     $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
    //     $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
    //     $documento = trim($_POST['documento']) ? trim($_POST['documento']) : NULL;
    //     $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
    //     $estadoId = isset($_POST['estado']) && is_numeric($_POST['estado']) && (int)$_POST['estado'] > 0 ? (int)$_POST['estado'] : NULL;
    //     $estado = $estadoId !== null ? $this->estadoDAO->findById($estadoId) : NULL;
    //     $cidadeId = isset($_POST['cidade']) && is_numeric($_POST['cidade']) && (int)$_POST['cidade'] > 0 ? (int)$_POST['estado'] : NULL;
    //     $cidade = $cidadeId !== null ? $this->cidadeDAO->findById($cidadeId) : NULL;
    //     $endLogradouro = trim($_POST['endLogradouro']) ? trim($_POST['endLogradouro']) : NULL;
    //     $endBairro = trim($_POST['endBairro']) ? trim($_POST['endBairro']) : NULL;
    //     $endNumero = trim($_POST['endNumero']) ? trim($_POST['endNumero']) : NULL;
    //     $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
    //     $status = trim($_POST['status']) ? trim($_POST['status']) : NULL;
    //     $idTipoUsuario = isset($_POST['tipoUsuario']) && is_numeric($_POST['tipoUsuario']) ? (int)$_POST['tipoUsuario'] : NULL;

    //     //Cria objeto Usuario
    //     $usuario = new Usuario();
    //     $usuario->setNome($nome);
    //     $usuario->setEmail($email);
    //     $usuario->setSenha($senha);
    //     $usuario->setDocumento($documento);
    //     $usuario->setDescricao($descricao);
    //     $usuario->setCidade($cidade);
    //     $usuario->setEndLogradouro($endLogradouro);
    //     $usuario->setEndBairro($endBairro);
    //     $usuario->setEndNumero($endNumero);
    //     $usuario->setTelefone($telefone);
    //     $usuario->setStatus($status);
    //     $usuario->setTipoUsuario($tipoUsuario);

    //     //Validar os dados
    //     $erros = $this->usuarioService->validarDados($usuario, $confSenha);
    //     if(empty($erros)) {
    //         //Persiste o objeto
    //         try {
    //             if($dados["id"] == 0){ //Inserindo
    //                 $this->usuarioDao->insert($usuario);
    //             } else { //Alterando
    //                 $usuario->setId($dados["id"]);
    //                 $this->usuarioDao->update($usuario);
    //             }

    //             //TODO - Enviar mensagem de sucesso
    //             $msg = "Usuário salvo com sucesso.";
    //             $this->list("", $msg);
    //             exit;
    //         } catch (PDOException $e) {
    //             $erros = "[Erro ao salvar o usuário na base de dados.]";                
    //         }
    //     }

    //     //Se há erros, volta para o formulário
        
    //     //Carregar os valores recebidos por POST de volta para o formulário

        
    //     $dados["usuario"] = $usuario;
    //     $dados["confSenha"] = $confSenha;
    //     $dados["estados"] = $this->estadoDAO->list();
    //     $dados["status"] = Status::getAllAsArray(); 
    //     $dados["papeis"] = $this->tipoUsuarioDAO->list();

    //     $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
    //     $this->loadView("usuario/form.php", $dados, $msgsErro);
    // }

    protected function delete() {
        $usuario = $this->findUsuarioById();
        if($usuario) {
            $this->usuarioDao->deleteById($usuario->getId());
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=listEmpresasPendentes");
        } else
            $this->listEmpresasPendentes("Usuario não econtrado!");
    }

     protected function inativarUsuario() {
        $usuario = $this->findUsuarioById();
        if($usuario) {
            $this->usuarioDao->inativarUsuario($usuario);

            $this->list();
        } else
            $this->list("Usuário não encontrado.");
    }

    protected function aprovarEmpresa() {
        $usuario = $this->findUsuarioById();
        if($usuario) {
            $this->usuarioDao->aprovarEmpresa($usuario);

            $this->listEmpresasPendentes();
        } else
            $this->listEmpresasPendentes("Usuário não encontrado.");
    }

    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $usuario = $this->usuarioDao->findById($id);
        return $usuario;
    }

}


#Criar objeto da classe para assim executar o construtor
new UsuarioController();
