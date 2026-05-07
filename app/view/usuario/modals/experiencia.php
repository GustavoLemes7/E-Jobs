<div class="modal fade" id="experienciaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="<?= BASEURL ?>/controller/CandidatoController.php?action=insertExperiencia">

                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Experiência</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" name="cargo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Empresa</label>
                        <input type="text" name="empresa" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Data início</label>
                        <input type="date" name="data_inicio" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Data fim</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="editarExperienciaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST"
                action="<?= BASEURL ?>/controller/CandidatoController.php?action=updateExperiencia">

                <input type="hidden" name="id" id="exp_id">

                <div class="modal-header">
                    <h5 class="modal-title">Editar Experiência</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <input type="text" name="cargo" id="exp_cargo" class="form-control mb-2" placeholder="Cargo">

                    <input type="text" name="empresa" id="exp_empresa" class="form-control mb-2" placeholder="Empresa">

                    <input type="date" name="data_inicio" id="exp_inicio" class="form-control mb-2">

                    <input type="date" name="data_fim" id="exp_fim" class="form-control mb-2">

                    <textarea name="descricao" id="exp_desc" class="form-control"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>