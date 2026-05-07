
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Foto de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body text-center">

                <!-- FOTO GRANDE -->
                <img 
                    id="previewFoto"
                    <?php if ($isEmpresa): ?>
                    src="<?= $usuario?->getLogoUrl() ?: 'https://via.placeholder.com/200' ?>"
                    <?php else: ?>
                    src="<?= $usuario?->getFotoPerfilUrl() ?: 'https://via.placeholder.com/200' ?>"
                    <?php endif ?>
                    class="img-fluid rounded mb-3"
                >

                <!-- FORM UPLOAD -->
                <form method="POST" enctype="multipart/form-data"
                      action="<?= $isEmpresa 
                    ? BASEURL . '/controller/EmpresaController.php?action=uploadLogo'
                    : BASEURL . '/controller/CandidatoController.php?action=uploadFoto' ?>">

                    <input type="file" name="foto" id="inputFoto" class="form-control mb-2" accept="image/*">

                    <button type="submit" class="btn btn-primary w-100">
                        Atualizar Foto
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>