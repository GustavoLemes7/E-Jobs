<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../model/Empresa.php");
require_once(__DIR__ . "/../model/enum/TipoUsuario.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/EmpresaDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../service/EmpresaService.php");

class EmpresaController extends Controller {
    private UsuarioDAO $usuarioDao;
    private EmpresaDAO $empresaDao;
    private VagaDAO $vagaDao;
    private EmpresaService $empresaService;

    public function __construct() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Verifica se é uma empresa
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::EMPRESA) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $this->usuarioDao = new UsuarioDAO();
        $this->empresaDao = new EmpresaDAO();
        $this->vagaDao = new VagaDAO();
        $this->empresaService = new EmpresaService();
        
        $this->handleAction();
    }

    protected function home() {
        $empresaId = $_SESSION[SESSAO_USUARIO_ID];
        $empresa = $this->empresaDao->findByUsuarioId($empresaId);
        
        // Busca todas as vagas da empresa
        $vagas = $this->vagaDao->findByEmpresa($empresaId);
        
        // Filtra apenas vagas ativas
        $vagasAtivas = array_filter($vagas, function($vaga) {
            return $vaga->getStatus() == 'Ativo';
        });
        
        // Pega as 5 vagas ativas mais recentes
        $vagasDestaque = array_slice($vagasAtivas, 0, 5);
        
        $dados = [
            'empresa' => $empresa,
            'total_vagas' => count($vagasAtivas),
            'vagas_destaque' => $vagasDestaque
        ];
        
        $this->loadView("empresa/home.php", $dados);
    }

    protected function form(){
        $this->loadView("usuario/form_empresa.php",[]);
    }

    protected function save(){

        $usuarioId = $_SESSION[SESSAO_USUARIO_ID] ?? null;

        if (!$usuarioId) {
            header("Location: " . LOGIN_PAGE);
            exit;
        }
        
        $nome_fantasia = trim($_POST['nome_fantasia']) ? trim($_POST['nome_fantasia']) : NULL;
        $razao_social = trim($_POST['razao_social']) ? trim($_POST['razao_social']) : NULL;
        $cnpj = trim($_POST['cnpj']) ? trim($_POST['cnpj']) : NULL;
        $inscricao_estadual = trim(($_POST['inscricao_estadual'])) ? trim($_POST['inscricao_estadual']) : NULL;
        $data_abertura = trim($_POST['data_abertura']) ? trim($_POST['data_abertura']) : NULL;
        $site = trim($_POST['site']) ? trim($_POST['site']) : NULL;
        $numero_funcionarios = trim($_POST['numero_funcionarios']) ? trim($_POST['numero_funcionarios']) : NULL;
        $telefone_contato = trim($_POST['telefone_contato']) ? trim($_POST['telefone_contato']) : NULL;
        $email_contato = trim($_POST['email_contato']) ? trim($_POST['email_contato']) : NULL;
        $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;

        $empresa = new Empresa();
        $empresa->setUsuario_id($usuarioId);
        $empresa->setNomeFantasia($nome_fantasia);
        $empresa->setRazaoSocial($razao_social);
        $empresa->setCnpj($cnpj);
        $empresa->setInscricaoEstadual($inscricao_estadual);
        $empresa->setDataAbertura($data_abertura);
        $empresa->setSiteUrl($site);
        $empresa->setNumeroFuncionarios($numero_funcionarios);
        $empresa->setTelefoneContato($telefone_contato);
        $empresa->setEmailContato($email_contato);
        $empresa->setDescricao($descricao);
        $empresa->setLogoUrl(NULL);

        $erros = $this->empresaService->validarDados($empresa);

        if(empty($erros)){
            $erros = $this->empresaService->validarCNPJ($empresa->getCnpj());
            
            if(empty($erros)){
                try{
                    $this->empresaDao->insert($empresa);

                    header("Location: " . BASEURL . "/view/empresa/home.php");
                    exit;

                }catch(Exception $e){
                    header("Location: " . BASEURL . "/view/usuario/form_empresa.php?erro=Erro ao salvar");
                    exit; 
                }
            }
        }

        $dados['nome_fantasia'] = $nome_fantasia;
        $dados['razao_social'] = $razao_social;
        $dados['cnpj'] = $cnpj;
        $dados['inscricao_estadual'] = $inscricao_estadual;
        $dados['site'] = $site;
        $dados['numero_funcionarios'] = $numero_funcionarios;
        $dados['descricao'] = $descricao; 
        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form_empresa.php", $dados, $msgsErro);
    }

      public function update()
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $email_contato = $_POST['email_contato'] ?? null;
        $telefone_contato = $_POST['telefone_contato'] ?? null;
        $site = $_POST['site'] ?? null;
        $descricao = $_POST['descricao'] ?? null;
        $cnpj = $_POST['cnpj'] ?? null;
        $inscricao_estadual = $_POST['inscricao_estadual'] ?? null;
        $data_abertura = $_POST['data_abertura'] ?? null;
        $numero_funcionarios = $_POST['numero_funcionarios'] ?? null;

        $empresa = $this->empresaDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        if (!$empresa) {
            header("location: " . BASEURL . "/controller/CandidatoController.php?action=createForm");
            exit;
        }

        if($email_contato)
            $empresa->setEmailContato($email_contato);

        if($telefone_contato)
            $empresa->setTelefoneContato($telefone_contato);

        if($site)
            $empresa->setSiteUrl($site);

        if($descricao)
            $empresa->setDescricao($descricao);

        if($cnpj)
            $empresa->setCnpj($cnpj);

        if($inscricao_estadual)
            $empresa->setInscricaoEstadual($inscricao_estadual);

        if($data_abertura)
            $empresa->setDataAbertura($data_abertura);

        if($numero_funcionarios)
            $empresa->setNumeroFuncionarios($numero_funcionarios);

        $erros = [];

        if ($cnpj && !$this->empresaService->isCnpjValido($cnpj)) {
            $erros[] = "CNPJ inválido";
        }

        $empresaExistente = null;

        if ($cnpj) {
            $empresaExistente = $this->empresaDao->findByCNPJ($cnpj);
        }

        if ($cnpj && $empresaExistente && $empresaExistente->getUsuario_id() != $empresa->getUsuario_id()) {
            $erros[] = "Já existe uma empresa com esse CNPJ";
        }

        if(empty($erros)){

        try {
            $this->empresaDao->update($empresa);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar contato: " . $e->getMessage());
        }
        }
        
        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $dados['usuario'] = $empresa;
        $dados['msgErro'] = $msgsErro;
        $dados['isEmpresa'] = true;
        $dados['isOwnProfile'] = true;

        $this->loadView("usuario/profile.php", $dados);
       
        
    }

    public function uploadLogo() {

        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
            header("Location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        }

        $arquivo = $_FILES['foto'];

        $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

        $permitidas = ['jpg','jpeg','png'];

        if (!in_array($ext, $permitidas)) {
            die("Formato inválido");
        }

        $nome = uniqid() . "." . $ext;

        $dir = __DIR__ . "/../../public/uploads/logos/";

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $caminho = $dir . $nome;

        move_uploaded_file($arquivo['tmp_name'], $caminho);

        // salvar no banco
        $empresa = $this->empresaDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        $empresa->setLogoUrl("/uploads/logos/" . $nome);

        $this->empresaDao->update($empresa);

        header("Location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
    }
}

new EmpresaController(); 