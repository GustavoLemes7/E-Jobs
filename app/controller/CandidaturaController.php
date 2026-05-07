<?php 
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once(__DIR__ . "/../dao/CandidatoDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../dao/ExperienciaDAO.php");
require_once(__DIR__ . "/../dao/FormacaoDAO.php");
require_once (__DIR__ . "/../model/enum/StatusCandidatura.php");




class CandidaturaController extends Controller {
 
    private VagaDAO $vagaDao;
    private UsuarioDAO $usuarioDao;
    private CandidatoDAO $candidatoDao;
    private CandidaturaDAO $candidaturaDao;
    private ExperienciaDAO $experienciaDao;
    private FormacaoDAO $formacaoDao;


    public function __construct()
    {
        if(! $this->usuarioLogado())
            exit;

        $this->vagaDao = new VagaDAO();
        $this->candidatoDao = new CandidatoDAO();
        $this->candidaturaDao = new CandidaturaDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->experienciaDao = new ExperienciaDAO();
        $this->formacaoDao = new FormacaoDAO();
        $this -> handleAction();
    }


    protected function candidatar() {
        
        $vaga = $this->findVagaById();
        if(! $vaga) {
            echo "Vaga não encontrada!";
            exit;
        } 

        $candidatoId = $_SESSION[SESSAO_USUARIO_ID];
        $candidato = $this->candidatoDao->findByUsuarioId($candidatoId);


        /*

        $candidaturaExistente = $this->candidaturaDao->findByCandidatoAndVaga($candidatoId, $vaga->getId());
        if ($candidaturaExistente) {
            $this->viewVagas();
            return;
        }

        */

        if($_SESSION[SESSAO_USUARIO_PAPEL] == TipoUsuario::CANDIDATO){
            $candidatura = new Candidatura();
            $candidatura->setCandidato($candidato)
                    ->setVaga($vaga)
                    ->setStatus(StatusCandidatura::EM_ANDAMENTO);

            try {
                $this->candidaturaDao->insert($candidatura);

                header("location: " . BASEURL . "/controller/VagaController.php?action=viewVagas&id=" . $vaga->getId());
            } catch (Exception $e) {
                echo "Erro ao realizar candidatura: " . $e->getMessage();
            }
        } else {
            $msgErro = urlencode("Apenas candidatos podem se candidatar a vagas.");
            header("location: " . BASEURL . "/controller/VagaController.php?action=viewVagas&id=" . $vaga->getId() . "&erro=$msgErro");
        }
    }

    protected function listarCandidatos(string $msgErro = "", string $msgSucesso = "") {
        // Verifica se é uma empresa
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::EMPRESA) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if (!$vaga) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        // Verifica se a vaga pertence à empresa logada
        if ($vaga->getEmpresa()->getUsuario_id() != $_SESSION[SESSAO_USUARIO_ID]) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $candidaturas = $this->candidaturaDao->findByVaga($vaga->getId());
        $dados["vaga"] = $vaga;
        $dados["lista"] = $candidaturas;
        
        $this->loadView("vaga/candidatos_list.php", $dados, $msgErro, $msgSucesso);
    }

    private function findVagaById() {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $vaga = $this->vagaDao->findById($id);
        return $vaga;
    }

    protected function viewCandidato() {
        // Apenas empresas podem ver perfil de candidatos
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::EMPRESA) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        if (!isset($_GET['id'])) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $candidato = $this->candidatoDao->findByUsuarioId($_GET['id']);
        $experiencia = $this->experienciaDao->findByUsuarioId($_GET['id']);
        $formacao = $this->formacaoDao->findByUsuarioId($_GET['id']);
        if (!$candidato) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $dados['usuario'] = $candidato;
        $dados['experiencias'] = $experiencia;
        $dados['formacoes'] = $formacao;
        $dados["isOwnProfile"] = ($_GET['id'] == $_SESSION[SESSAO_USUARIO_ID]);

        $this->loadView("usuario/profile.php", $dados);
    }

}

new CandidaturaController();