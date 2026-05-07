<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card shadow border-0 rounded-4">
                
                <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Cadastro de Empresa
                    </h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST"
                        action="<?= BASEURL ?>/controller/EmpresaController.php?action=save">

                        <!-- DADOS PRINCIPAIS -->
                        <h6 class="text-muted mb-3">Dados da Empresa</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nome Fantasia</label>
                                <input type="text" name="nome_fantasia" class="form-control shadow-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Razão Social</label>
                                <input type="text" name="razao_social" class="form-control shadow-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">CNPJ</label>
                                <input type="text" id="cnpj" name="cnpj" class="form-control shadow-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Inscrição Estadual</label>
                                <input type="text" name="inscricao_estadual" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Data de Abertura</label>
                                <input type="date" name="data_abertura" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Número de Funcionários</label>
                                <input type="number" name="numero_funcionarios" class="form-control shadow-sm">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- CONTATO -->
                        <h6 class="text-muted mb-3">Contato</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email_contato" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Telefone</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" id="txtTelefone" name="telefone_contato" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Site</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="url" name="site" class="form-control" placeholder="https://">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- DESCRIÇÃO -->
                        <h6 class="text-muted mb-3">Sobre a Empresa</h6>

                        <div class="mb-3">
                            <textarea name="descricao" class="form-control shadow-sm" rows="4"
                                placeholder="Descreva sua empresa..."></textarea>
                        </div>

                        <!-- MENSAGENS -->
                        <div class="mb-3">
                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                        </div>

                        <!-- BOTÕES -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= HOME_PAGE ?>" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>

                            <button type="submit" class="btn btn-success px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Salvar Empresa
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- INPUTMASK -->
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
<script>
    Inputmask("99.999.999/9999-99").mask("#cnpj");
    Inputmask("(99) 99999-9999").mask("#txtTelefone");
</script>
<?php
require_once(__DIR__ . "/../include/footer.php");
?>