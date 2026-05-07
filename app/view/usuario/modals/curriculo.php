<div class="modal fade" id="curriculoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" enctype="multipart/form-data"
                  action="<?= BASEURL ?>/controller/CandidatoController.php?action=uploadCurriculo">

                <div class="modal-header">
                    <h5 class="modal-title">Enviar Currículo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <?php if ($candidato?->getCurriculoUrl()): ?>
                        <p class="mb-2">
                            <strong>Currículo atual:</strong><br>
                            <a href="<?= PUBLICURL . $candidato->getCurriculoUrl() ?>" target="_blank">
                                Visualizar atual
                            </a>
                        </p>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Selecionar arquivo (PDF)</label>
                        <input type="file" name="curriculo" class="form-control" accept=".pdf" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Enviar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>