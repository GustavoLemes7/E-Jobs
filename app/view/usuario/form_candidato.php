<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <div class="card shadow-lg border-0 rounded-4">
                
                <!-- HEADER -->
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i> Cadastro de Candidato
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST"
                        action="<?= BASEURL ?>/controller/CandidatoController.php?action=createCandidato">

                        <!-- NOME -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome Completo</label>
                                <input type="text" name="nome_completo" class="form-control" required>
                            </div>

                        
                        </div>

                        <!-- CPF -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control" required>
                            </div>

                        </div>

                        <!-- DATA NASCIMENTO -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control">
                        </div>

                  

                        <!-- MENSAGENS -->
                        <div class="mb-3">
                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                        </div>

                        <!-- BOTÕES -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= HOME_PAGE ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Voltar
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Salvar
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MÁSCARAS -->
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
<script>
    Inputmask("999.999.999-99").mask("#cpf");
    Inputmask("(99) 99999-9999").mask("#telefone");
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>