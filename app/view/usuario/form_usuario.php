<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Cadastro</h4>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="<?= BASEURL ?>/controller/CadastroController.php?action=saveUsuario">

                        <!-- EMAIL -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input class="form-control" type="email" name="email"
                                    placeholder="Informe o email" required />
                            </div>
                        </div>

                        <!-- SENHA -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Senha:</label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>

                                <input class="form-control" 
                                    type="password" 
                                    id="senha" 
                                    name="senha"
                                    placeholder="Informe a senha" 
                                    required />

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-senha">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CONFIRMAR SENHA -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Confirmar Senha:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>

                                <input class="form-control" 
                                    type="password" 
                                    id="conf_senha" 
                                    name="conf_senha"
                                    placeholder="Confirme a senha" 
                                    required />

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary toggle-senha">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- TELEFONE -->
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Telefone:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input class="form-control" type="text" id="txtTelefone" name="telefone"
                                    placeholder="Informe o telefone" />
                            </div>
                        </div>

                        <!-- MENSAGENS -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                            </div>
                        </div>

                        <!-- BOTÕES -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="fas fa-save me-1"></i> Salvar
                                </button>
                                <button type="reset" class="btn btn-danger me-2">
                                    <i class="fas fa-eraser me-1"></i> Limpar
                                </button>
                                <a class="btn btn-secondary"
                                    href="<?= BASEURL ?>/controller/HomeController.php?action=home">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                            </div>
                        </div>

                       <!-- DIVIDER -->
                        <div class="text-center my-3">
                            <span class="text-muted">ou</span>
                        </div>

                        <!-- GOOGLE BUTTON -->
                        <div class="d-grid">
                            <a href="<?= BASEURL ?>/auth/google_login.php" class="btn btn-outline-dark d-flex align-items-center justify-content-center">
                                <img src="https://developers.google.com/identity/images/g-logo.png" 
                                    style="width:18px; margin-right:10px;">
                                Continuar com Google
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

<script src="<?= BASEURL ?>/view/usuario/js/validarSenha.js"></script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>