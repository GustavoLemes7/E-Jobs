<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow rounded-4">
                
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Editar Usuário
                    </h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST"
                        action="<?= BASEURL ?>/controller/UsuarioController.php?action=saveEdit">

                        <!-- ID oculto -->
                        <input type="hidden" name="id"
                            value="<?= isset($dados['usuario']) ? $dados['usuario']->getId() : '' ?>">

                        <div class="row g-4">

                            <!-- ESQUERDA -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Papel</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-shield"></i>
                                        </span>

                                        <select class="form-select" name="tipoUsuario">
                                            <option value="">Selecione</option>

                                            <?php foreach ($dados["papeis"] as $papel): ?>
                                                <option value="<?= $papel ?>"
                                                    <?= (isset($dados["usuario"]) &&
                                                        $dados["usuario"]->getTipoUsuario() == $papel)
                                                        ? 'selected' : '' ?>>
                                                    <?= ucfirst(strtolower($papel)) ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>

                                        <input type="email"
                                            class="form-control"
                                            name="email"
                                            maxlength="100"
                                            placeholder="Informe o email"
                                            value="<?= isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : '' ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-toggle-on"></i>
                                        </span>

                                        <select class="form-select" name="status">
                                            <option value="">Selecione</option>

                                            <?php foreach($dados["status"] as $status): ?>
                                                <option value="<?= $status ?>"
                                                    <?= (isset($dados["usuario"]) &&
                                                        $dados["usuario"]->getStatus() == $status)
                                                        ? 'selected' : '' ?>>
                                                    <?= $status ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                            </div>

                            <!-- DIREITA -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Telefone</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>

                                        <input type="text"
                                            class="form-control"
                                            id="txtTelefone"
                                            name="telefone"
                                            maxlength="20"
                                            placeholder="(00) 00000-0000"
                                            value="<?= isset($dados["usuario"]) ? $dados["usuario"]->getTelefone() : '' ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Data Criação</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>

                                        <input type="text"
                                            class="form-control"
                                            name="dataCriacao"
                                            readonly
                                            value="<?= isset($dados["usuario"]) ? $dados["usuario"]->getDataCriacao() : '' ?>">
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- mensagens -->
                        <div class="mt-3">
                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                        </div>

                        <!-- botões -->
                        <div class="mt-4 d-flex flex-wrap gap-2">

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>
                                Salvar
                            </button>

                            <button type="reset" class="btn btn-danger">
                                <i class="fas fa-eraser me-1"></i>
                                Limpar
                            </button>

                            <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=list"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Voltar
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
Inputmask("(99) 99999-9999").mask("#txtTelefone");
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>

