<div class="modal fade" id="sobreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <?php
            $action = $isEmpresa 
                ? 'EmpresaController.php?action=update'
                : 'CandidatoController.php?action=updateDescricao';
            ?>

            <form method="POST" action="<?= BASEURL ?>/controller/<?= $action ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Atualizar descrição</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <!-- Descrição -->
                    <div class="form-group">
                       <textarea name="descricao" rows="5" class="form-control"><?= htmlspecialchars(trim($usuario?->getDescricao() ?? '')) ?></textarea>
            
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