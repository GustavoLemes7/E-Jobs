<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../model/enum/TipoUsuario.php");
require_once(__DIR__ . "/../model/Candidato.php");
require_once(__DIR__ . "/../model/Experiencia.php");
require_once(__DIR__ . "/../model/Formacao.php");
require_once(__DIR__ . "/../dao/CandidatoDAO.php");
require_once(__DIR__ . "/../dao/ExperienciaDAO.php");
require_once(__DIR__ . "/../dao/FormacaoDAO.php");
require_once(__DIR__ . "/../service/CandidatoService.php");

class CandidatoController extends Controller {
    private CandidatoDAO $candidatoDao;
    private ExperienciaDAO $experienciaDao;
    private FormacaoDAO $formacaoDao;
    private CandidatoService $candidato_service;

    public function __construct() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Verifica se é uma candidato
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::CANDIDATO) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $this->candidatoDao = new CandidatoDAO();
        $this->experienciaDao = new ExperienciaDAO();
        $this->formacaoDao = new FormacaoDAO();
        $this->candidato_service = new CandidatoService;
        
        
        $this->handleAction();
    }

    protected function home() {
        $candidatoId = $_SESSION[SESSAO_USUARIO_ID];
        $candidato = $this->candidatoDao->findByUsuarioId($candidatoId);
        
        
        $this->loadView("candidato/home.php", []);
    }

     protected function form(){
        $this->loadView("usuario/form_candidato.php",[]);
    }

    protected function createCandidato(){
        $nome = trim($_POST['nome_completo']) ? trim($_POST['nome_completo']) : NULL;
        $cpf = trim($_POST['cpf']) ?trim($_POST['cpf']) : NULL;
        $data_nascimento = trim($_POST['data_nascimento']) ? trim($_POST['data_nascimento']) : NULL;

        $candidato = new Candidato();

        $candidato->setUsuario_id($_SESSION[SESSAO_USUARIO_ID]);
        $candidato->setNomeCompleto($nome);
        $candidato->setCpf($cpf);
        $candidato->setDataNascimento($data_nascimento);

        $erros = $this->candidato_service->validarDados($candidato);
        if(empty($erros)){
            $cpfValido = $this->candidato_service->validarCPF($candidato->getCpf());

            if($cpfValido){
                try{
                    $this->candidatoDao->createCandidato($candidato);

                    header("Location: " . BASEURL . "/view/home/home.php");
                    exit;

                }catch(Exception $e){
                    header("Location: " . BASEURL . "/view/usuario/form_candidato.php?erro=Erro ao salvar");
                }
            }
        }

        $dados['nome_completo'] = $nome;
        $dados['cpf'] = $cpf;
        $dados['data_nascimento'] = $data_nascimento; 
        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form_candidato.php", $dados, $msgsErro);
        
    }

    public function uploadFoto() {

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

        $dir = __DIR__ . "/../../public/uploads/fotos/";

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $caminho = $dir . $nome;

        move_uploaded_file($arquivo['tmp_name'], $caminho);

        // salvar no banco
        $candidato = $this->candidatoDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        $candidato->setFotoPerfilUrl("/uploads/fotos/" . $nome);

        $this->candidatoDao->update($candidato);

        header("Location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
    }

    public function updateContato()
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $email = $_POST['email_contato'] ?? null;
        $telefone = $_POST['telefone_contato'] ?? null;
        $github = $_POST['github'] ?? null;
        $linkedin = $_POST['linkedin'] ?? null;

        $candidato = $this->candidatoDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        if (!$candidato) {
            header("location: " . BASEURL . "/controller/CandidatoController.php?action=createForm");
            exit;
        }

        $candidato->setEmailContato($email);
        $candidato->setTelefoneContato($telefone);
        $candidato->setGithub($github);
        $candidato->setLinkedin($linkedin);

        try {
            $this->candidatoDao->update($candidato);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar contato: " . $e->getMessage());
        }
    }

      public function updateDescricao()
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $descricao = $_POST['descricao'] ?? null;

        $candidato = $this->candidatoDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        if (!$candidato) {
            header("location: " . BASEURL . "/controller/CandidatoController.php?action=createForm");
            exit;
        }

        $candidato->setDescricao($descricao);

        try {
            $this->candidatoDao->update($candidato);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar contato: " . $e->getMessage());
        }
    }

    public function insertExperiencia(){
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $cargo = $_POST['cargo'] ?? null;
        $empresa = $_POST['empresa'] ?? null;
        $data_inicio = $_POST['data_inicio'] ?? null;
        $data_fim = $_POST['data_fim'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        $candidato = $this->candidatoDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        if (!$candidato) {
            header("location: " . BASEURL . "/controller/CandidatoController.php?action=createForm");
            exit;
        }

        $experiencia = new Experiencia();
        $experiencia->setCandidato_id($candidato->getUsuario_id());
        $experiencia->setEmpresa($empresa);
        $experiencia->setCargo($cargo);
        $experiencia->setDataInicio($data_inicio);
        $experiencia->setDataFim($data_fim);
        $experiencia->setDescricao($descricao);


        try {
            $this->experienciaDao->insert($experiencia);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao inserir experiência: " . $e->getMessage());
        }

    }

    public function updateExperiencia()
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $cargo = $_POST['cargo'] ?? null;
        $empresa = $_POST['empresa'] ?? null;
        $data_inicio = $_POST['data_inicio'] ?? null;
        $data_fim = $_POST['data_fim'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        $experiencia = new Experiencia();
        if(isset($id))
        $experiencia = $this->experienciaDao->findById($id);

        if (!$experiencia) {
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        }

        $experiencia->setId($id);
        $experiencia->setCargo($cargo);
        $experiencia->setEmpresa($empresa);
        $experiencia->setDataInicio($data_inicio);
        $experiencia->setDataFim($data_fim);
        $experiencia->setDescricao($descricao);

        try {
            $this->experienciaDao->update($experiencia);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar contato: " . $e->getMessage());
        }
    }

    public function deleteExperiencia(){
        $id = $_GET['id'];
        $exp = $this->experienciaDao->findById($id);
        if($exp) {
            $this->experienciaDao->deleteById($id);
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        } else
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
    }

    public function insertFormacao(){

        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $curso = $_POST['curso'] ?? null;
        $instituicao = $_POST['instituicao'] ?? null;
        $data_inicio = $_POST['data_inicio'] ?? null;
        $data_fim = $_POST['data_fim'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        $candidato = $this->candidatoDao->findByUsuarioId($_SESSION[SESSAO_USUARIO_ID]);

        if (!$candidato) {
            header("location: " . BASEURL . "/controller/CandidatoController.php?action=createForm");
            exit;
        }

        $formacao = new Formacao();
        $formacao->setCandidato_id($candidato->getUsuario_id());
        $formacao->setInstituicao($instituicao);
        $formacao->setCurso($curso);
        $formacao->setDataInicio($data_inicio);
        $formacao->setDataFim($data_fim);
        $formacao->setDescricao($descricao);


        try {
            $this->formacaoDao->insert($formacao);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao inserir experiência: " . $e->getMessage());
        }
    }

     public function updateFormacao()
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $curso = $_POST['curso'] ?? null;
        $instituicao = $_POST['instituicao'] ?? null;
        $data_inicio = $_POST['data_inicio'] ?? null;
        $data_fim = $_POST['data_fim'] ?? null;
        $descricao = $_POST['descricao'] ?? null;

        $formacao = new Formacao();
        if(isset($id))
        $formacao = $this->formacaoDao->findById($id);

        if (!$formacao) {
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        }

        $formacao->setId($id);
        $formacao->setCurso($curso);
        $formacao->setInstituicao($instituicao);
        $formacao->setDataInicio($data_inicio);
        $formacao->setDataFim($data_fim);
        $formacao->setDescricao($descricao);

        try {
            $this->formacaoDao->update($formacao);

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar contato: " . $e->getMessage());
        }
    }


    public function deleteFormacao(){
        $id = $_GET['id'];
        $exp = $this->formacaoDao->findById($id);
        if($exp) {
            $this->formacaoDao->deleteById($id);
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
        } else
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
            exit;
    }

   public function uploadCurriculo(){

        if (!isset($_FILES['curriculo']) || $_FILES['curriculo']['error'] !== UPLOAD_ERR_OK) {
            die("Erro no upload");
        }

        $arquivo = $_FILES['curriculo'];

        $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

        if ($ext !== 'pdf') {
            die("Apenas PDF permitido");
        }

        $nomeArquivo = uniqid() . ".pdf";

        $caminho = __DIR__ . "/../../public/uploads/curriculos/" . $nomeArquivo;

        move_uploaded_file($arquivo['tmp_name'], $caminho);

        $usuarioId = $_SESSION[SESSAO_USUARIO_ID];

        $candidato = $this->candidatoDao->findByUsuarioId($usuarioId);

        if ($candidato) {
            $candidato->setCurriculoUrl("/uploads/curriculos/" . $nomeArquivo);
            $this->candidatoDao->update($candidato);
        }

        header("Location: " . BASEURL . "/controller/UsuarioController.php?action=viewProfile");
    }
}

new CandidatoController(); 