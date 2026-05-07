<div class="modal fade" id="dadosEmpresa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="<?= BASEURL ?>/controller/EmpresaController.php?action=update">

                <div class="modal-header">
                    <h5 class="modal-title">Atualizar dados</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <!-- CNPJ -->
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control" id="cnpj"
                            value="<?= htmlspecialchars($old['cnpj'] ?? $usuario?->getCnpj() ?? '') ?>">
                    </div>

                    <!-- INSCRIÇÃO ESTADUAL -->
                    <div class="form-group">
                        <label>Inscrição Estadual</label>
                        <input type="text" name="inscricao_estadual" class="form-control"
                            value="<?= htmlspecialchars($old['inscricao_estadual'] ?? $usuario?->getInscricaoEstadual() ?? '') ?>">
                    </div>

                    <!-- DATA ABERTURA -->
                    <div class="form-group">
                        <label>Data de Abertura</label>
                        <input type="date" name="data_abertura" class="form-control"
                            value="<?= htmlspecialchars($old['data_abertura'] ?? $usuario?->getDataAbertura() ?? '') ?>">
                    </div>

                    <!-- FUNCIONÁRIOS -->
                    <div class="form-group">
                        <label>Número de Funcionários</label>
                        <input type="number" name="numero_funcionarios" class="form-control"
                            value="<?= htmlspecialchars($old['numero_funcionarios'] ?? $usuario?->getNumeroFuncionarios() ?? '') ?>">
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
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>
<script>
    Inputmask("99.999.999/9999-99").mask("#cnpj");
    Inputmask("(99) 99999-9999").mask("#txtTelefone");
</script>