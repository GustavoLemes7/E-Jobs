<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../util/View.php");
?>

<?php $usuario = $dados['usuario'] ?? null; ?>
<?php $experiencias = $dados['experiencias'] ?? null; ?>
<?php $formacoes = $dados['formacoes'] ?? null; ?>
<?php $isOwnProfile = $dados['isOwnProfile'] ?? null; ?>
<?php $isEmpresa = $dados['isEmpresa'] ?? null; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- HEADER -->
            <div class="card shadow mb-3">
                <div class="card-body d-flex align-items-center">

                    <img 
                        src="<?= $isEmpresa 
                            ? ($usuario?->getLogoUrl() 
                                ? PUBLICURL . $usuario->getLogoUrl() 
                                : 'https://placehold.co/80x80')
                            : ($usuario?->getFotoPerfilUrl() 
                                ? PUBLICURL . $usuario->getFotoPerfilUrl() 
                                : 'https://placehold.co/80x80')
                        ?>"
                        class="rounded-circle"
                        width="80" height="80"
                        style="cursor:pointer"
                        data-toggle="modal"
                        data-target="#fotoModal"
                    >

                    <div class="flex-grow-1 ml-3">
                        <h4 class="mb-1">
                            <?= htmlspecialchars($isEmpresa 
                                ? $usuario?->getNomeFantasia() 
                                : $usuario?->getNomeCompleto()) ?>
                        </h4>

                        <?php if ($isEmpresa): ?>
                            <small class="text-muted">
                                <?= htmlspecialchars($usuario?->getRazaoSocial()) ?>
                            </small>
                        <?php endif; ?>

                        <div class="mt-2">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-toggle="modal"
                                    data-target="#contatoModal">
                                <i class="fas fa-envelope"></i> Contato
                            </button>
                        </div>
                    </div>

                </div>
            </div>


            <!-- SOBRE -->
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Sobre</strong>

                    <?php if ($isOwnProfile): ?>
                        <button class="btn btn-outline-primary btn-sm"
                                data-toggle="modal"
                                data-target="#sobreModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <p>
                        <?= htmlspecialchars(
                            $isEmpresa 
                                ? ($usuario?->getDescricao() ?? 'Descrição não informada')
                                : ($usuario?->getDescricao() ?? 'Adicione uma descrição...')
                        ) ?>
                    </p>
                </div>
            </div>
            
            <?php if (!empty($dados['msgErro'])): ?>
                <div class="alert alert-danger">
                    <?= $dados['msgErro'] ?>
                </div>
            <?php endif; ?>

            <?php if ($isEmpresa): ?>
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Dados da Empresa</strong>

                    <?php if ($isOwnProfile): ?>
                        <button class="btn btn-outline-primary btn-sm"
                                data-toggle="modal"
                                data-target="#dadosEmpresa">
                            <i class="fas fa-edit"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>CNPJ:</strong> <?= $usuario?->getCnpj() ?></li>
                        <li><strong>Inscrição Estadual:</strong> <?= $usuario?->getInscricaoEstadual() ?></li>
                        <li><strong>Data de Abertura:</strong> <?= $usuario?->getDataAbertura() ?></li>
                        <li><strong>Funcionários:</strong> <?= $usuario?->getNumeroFuncionarios() ?></li>
                    </ul>
                </div>
            </div>


            <?php endif; ?>
            
            <?php if (!$isEmpresa): ?>
            <!-- EXPERIÊNCIA -->
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Experiência</strong>

                    <?php if ($isOwnProfile): ?>
                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#experienciaModal">
                            <i class="fas fa-plus"></i> Adicionar
                        </button>
                    <?php endif; ?>
                </div>

                <div class="card-body">

                    <?php if (!empty($experiencias)): ?>

                        <?php foreach ($experiencias as $exp): ?>
                            <div class="mb-3 border-bottom pb-3">

                                <strong><?= htmlspecialchars($exp->getCargo()) ?></strong><br>

                                <span class="text-muted">
                                    <?= htmlspecialchars($exp->getEmpresa()) ?>
                                </span><br>

                                <small class="text-muted">
                                    <?= htmlspecialchars($exp->getDataInicio()) ?> -
                                    <?= htmlspecialchars($exp->getDataFim()) ?>
                                </small>

                                <?php if ($exp->getDescricao()): ?>
                                    <p class="mt-2">
                                        <?= htmlspecialchars($exp->getDescricao()) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($isOwnProfile): ?>
                                    <div class="mt-2">

                                        <!-- EDITAR -->
                                        <button class="btn btn-sm btn-outline-primary"
                    data-toggle="modal"
                    data-target="#editarExperienciaModal"
                    onclick='editarExperiencia(
                        <?= (int)$exp->getId() ?>,
                        <?= json_encode($exp->getCargo()) ?>,
                        <?= json_encode($exp->getEmpresa()) ?>,
                        <?= json_encode($exp->getDataInicio()) ?>,
                        <?= json_encode($exp->getDataFim()) ?>,
                        <?= json_encode($exp->getDescricao()) ?>
                    )'>
                <i class="fas fa-edit"></i> Editar
            </button>

                                        <!-- EXCLUIR -->
                                        <a href="<?= BASEURL ?>/controller/CandidatoController.php?action=deleteExperiencia&id=<?= $exp->getId() ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Deseja excluir esta experiência?')">
                                            <i class="fas fa-trash"></i> Excluir
                                        </a>

                                    </div>
                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="text-muted">Nenhuma experiência cadastrada</p>
                    <?php endif; ?>

                </div>
            </div>

            <!-- FORMAÇÃO -->
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Formação</strong>
                     <?php if ($dados['isOwnProfile']): ?>
                    <button class="btn btn-sm btn-success"
                        data-toggle="modal"
                        data-dismiss="modal"
                        data-target="#formacaoModal">
                        <i class="fas fa-plus"></i> Adicionar
                    </button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($formacoes)): ?>

                        <?php foreach ($formacoes as $form): ?>
                            <div class="mb-3 border-bottom pb-2">

                                <strong><?= htmlspecialchars($form->getCurso()) ?></strong><br>

                                <span class="text-muted">
                                    <?= htmlspecialchars($form->getInstituicao()) ?>
                                </span><br>

                                <small class="text-muted">
                                    <?= htmlspecialchars($form->getDataInicio()) ?> - 
                                    <?= htmlspecialchars($form->getDataFim()) ?>
                                </small>

                                <?php if ($form->getDescricao()): ?>
                                    <p class="mt-1"><?= htmlspecialchars($form->getDescricao()) ?></p>
                                <?php endif; ?>

                                     <?php if ($isOwnProfile): ?>
                                    <div class="mt-2">

                                        <!-- EDITAR -->
                                        <button class="btn btn-sm btn-outline-primary"
                    data-toggle="modal"
                    data-target="#editarFormacaoModal"
                    onclick='editarFormacao(
                        <?= (int)$form->getId() ?>,
                        <?= json_encode($form->getCurso()) ?>,
                        <?= json_encode($form->getInstituicao()) ?>,
                        <?= json_encode($form->getDataInicio()) ?>,
                        <?= json_encode($form->getDataFim()) ?>,
                        <?= json_encode($form->getDescricao()) ?>
                    )'>
                <i class="fas fa-edit"></i> Editar
            </button>

                                        <!-- EXCLUIR -->
                                        <a href="<?= BASEURL ?>/controller/CandidatoController.php?action=deleteFormacao&id=<?= $form->getId() ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Deseja excluir esta formação?')">
                                            <i class="fas fa-trash"></i> Excluir
                                        </a>

                                    </div>
                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="text-muted">Nenhuma formação cadastrada</p>
                    <?php endif; ?>
                </div>
            </div>

                <!-- CURRÍCULO -->
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>Currículo</strong>

                    <?php if ($dados['isOwnProfile']): ?>
                        <button class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#curriculoModal">
                            <i class="fas fa-upload"></i> Atualizar
                        </button>
                    <?php endif; ?>
                </div>

                <div class="card-body">

                    <?php if ($usuario?->getCurriculoUrl()): ?>

                        <p>
                            <i class="fas fa-file-pdf text-danger"></i>
                            <a href="<?= PUBLICURL . $usuario->getCurriculoUrl() ?>" target="_blank">
                                Visualizar currículo
                            </a>
                        </p>

                    <?php else: ?>

                        <p class="text-muted">Nenhum currículo enviado</p>

                        <?php if ($dados['isOwnProfile']): ?>
                            <button class="btn btn-primary btn-sm"
                                    data-toggle="modal"
                                    data-target="#curriculoModal">
                                <i class="fas fa-upload"></i> Enviar currículo
                            </button>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
    render(__DIR__ . "/modals/foto.php", [
        "usuario" => $usuario,
        "isEmpresa" => $isEmpresa
    ]);

    render(__DIR__ . "/modals/contato.php", [
        "usuario" => $usuario,
        "isEmpresa" => $isEmpresa,
        "isOwnProfile" => $isOwnProfile
    ]);

    render(__DIR__ . "/modals/sobre.php", [
        "usuario" => $usuario,
        "isEmpresa" => $isEmpresa
    ]);

    if($isEmpresa){
        render(__DIR__ . "/modals/dados_empresa.php", [
        "usuario" => $usuario,
        "isEmpresa" => $isEmpresa
    ]);
    }


?>
<?php if (!$isEmpresa): ?>

    <?php
    render(__DIR__ . "/modals/experiencia.php", [
        "candidato" => $usuario
    ]);

    render(__DIR__ . "/modals/formacao.php", [
        "candidato" => $usuario
    ]);


    render(__DIR__. "/modals/curriculo.php",[
        "candidato" => $usuario
    ]);
    ?>

<?php endif; ?>


<script src="<?= BASEURL ?>/view/usuario/js/previewFoto.js"></script>
<script src="<?= BASEURL ?>/view/usuario/js/editarExperiencia.js"></script>
<script src="<?= BASEURL ?>/view/usuario/js/editarFormacao.js"></script>
<?php require_once(__DIR__ . "/../include/footer.php"); ?>

