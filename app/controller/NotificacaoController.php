<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/NotificacaoDAO.php");
require_once(__DIR__ . "/../dao/usuarioDAO.php");
require_once(__DIR__ . "/../model/Notificacao.php");



class NotificacaoApiController extends ApiController{

    private NotificacaoDAO $notificacaoDao;
    private UsuarioDAO $usuarioDao;

    public function __construct()
    {
        $allowedActions = ["listar", "detalhes"];

        $usuario = $_SESSION[SESSAO_USUARIO_ID];

        if (!$usuario) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }
        $this->notificacaoDao = new NotificacaoDAO();
        $this->handleAction();
    }

    protected function listar()
    {
        
        $idDestino = $_SESSION[SESSAO_USUARIO_ID];
        

        if (!$idDestino) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        return  $this->notificacaoDao->list($idDestino);

       
        }

      
     protected function detalhes()
    {
        $id = $_GET["id"] ?? null;

        if (!$id || !ctype_digit((string)$id)) {
            $this->jsonResponse(["success" => false, "errors" => ["ID de notificação não informado ou inválido."]], 400);
            return;
        }

        $notificacao = $this->notificacaoDao->findById((int)$id);

        if (!$notificacao) {
            $this->jsonResponse(["success" => false, "errors" => ["Notificacão não encontrada."]], 404);
            return;
        }


        $response[] = [
                'id'         => $notificacao->getId(),
                'id_origem'     => $notificacao->getOrigem()->getId(),
                'nome_origem'     => $notificacao->getOrigem()->getNome(),
                'id_destino'     => $notificacao->getDestino()->getId(),
                'nome_destino'     => $notificacao->getDestino()->getNome(),
                'tipo' => $notificacao->getTipo(),
                'mensagem'    => $notificacao->getMensagem(),
                'id_vaga'     => $notificacao->getVaga()->getId(),
                'titulo_vaga'     => $notificacao->getVaga()->getTitulo(),
                'lida'    => $notificacao->getLida(),
                'data_criacao'  => $notificacao->getDataCriacao(),
                
            ];

        echo json_encode([
            "success" => true,
            "notificacoes" => $response
        ]);

    }

    protected function excluirNotificacao()
    {
        $idNotificacao = $_POST["id_notificacao"] ?? null;

        if (!$idNotificacao) {
            echo json_encode([
                'success' => false,
                'message' => 'ID da candidatura não informado.'
            ]);
            return;
        }
        $delete = $this->notificacaoDao->deleteById($idNotificacao);
        echo json_encode([
            'success' => $delete,
            'message' => $delete
                ? 'Notificacao excluida com sucesso.'
                : 'Nenhuma candidatura encontrada com esse ID.'
        ]);
    }

    protected function marcarLido()
    {
    
        $id = $_POST["id_notificacao"] ?? null;
      

        if (!$id) {
            echo json_encode(["success" => false, "errors" => ["ID inválido"]]);
            return;
        }

        $ok = $this->notificacaoDao->marcarLido($id);
    

        if ($ok) {
            echo json_encode(["success" => true, "message" => "Lida"]);
        } else {
            echo json_encode(["success" => false, "errors" => ["Erro ao marcar como lida"]]);
        }
    }


}

new NotificacaoApiController();