
<div class="modal fade" id="formacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="<?= BASEURL ?>/controller/CandidatoController.php?action=insertFormacao">

                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Formação</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Curso</label>
                        <input type="text" name="curso" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Instituição</label>
                        <input type="text" name="instituicao" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Data início</label>
                        <input type="date" name="data_inicio" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Data fim (Previsão)</label>
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

<div class="modal fade" id="editarFormacaoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST"
                action="<?= BASEURL ?>/controller/CandidatoController.php?action=updateFormacao">

                <input type="hidden" name="id" id="form_id">

                <div class="modal-header">
                    <h5 class="modal-title">Editar Formação</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <input type="text" name="curso" id="form_curso" class="form-control mb-2" placeholder="Curso">

                    <input type="text" name="instituicao" id="form_instituicao" class="form-control mb-2" placeholder="Instituição">

                    <input type="date" name="data_inicio" id="form_inicio" class="form-control mb-2">

                    <input type="date" name="data_fim" id="form_fim" class="form-control mb-2">

                    <textarea name="descricao" id="form_desc" class="form-control"></textarea>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>