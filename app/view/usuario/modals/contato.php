
<div class="modal fade" id="contatoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Informações de Contato</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                
            <?php if ($usuario?->getEmailContato()): ?>

                <!-- EMAIL -->
                <p>
                    <i class="fas fa-envelope"></i>
                    <strong>Email:</strong><br>
                    <a href="mailto:<?= htmlspecialchars($usuario?->getEmailContato()) ?>">
                        <?= htmlspecialchars($usuario?->getEmailContato()) ?>
                    </a>
                </p>
            <?php endif; ?>

            <?php if ($usuario?->getTelefoneContato()): ?>

                    <!-- TELEFONE -->
                    <p>
                        <i class="fa fa-phone"></i>
                        <strong>Telefone Contato:</strong><br>
                        <a href="<?= htmlspecialchars($usuario->getTelefoneContato()) ?>" target="_blank">
                            <?= htmlspecialchars($usuario->getTelefoneContato()) ?>
                        </a>
                    </p>
            <?php endif; ?>

            <?php if(!$isEmpresa): ?>

                <!-- GITHUB -->
                <?php if ($usuario?->getGithub()): ?>
                        <p>
                            <i class="fab fa-github"></i>
                            <strong>GitHub:</strong><br>
                            <a href="<?= htmlspecialchars($usuario->getGithub()) ?>" target="_blank">
                                <?= htmlspecialchars($usuario->getGithub()) ?>
                            </a>
                        </p>
                <?php endif; ?>

                    <!-- LINKEDIN -->
                <?php if ($usuario?->getLinkedin()): ?>
                        <p>
                            <i class="fab fa-linkedin-in"></i>
                            <strong>Linkedin:</strong><br>
                            <a href="<?= htmlspecialchars($usuario->getLinkedin()) ?>" target="_blank">
                                <?= htmlspecialchars($usuario->getLinkedin()) ?>
                            </a>
                        </p>
                <?php endif; ?>

            <?php else: ?>

                <?php if ($usuario?->getSiteUrl()): ?>
                        <p>
                            <i class="fab fa-linkedin-in"></i>
                            <strong>Site:</strong><br>
                            <a href="<?= htmlspecialchars($usuario->getSiteUrl()) ?>" target="_blank">
                                <?= htmlspecialchars($usuario->getSiteUrl()) ?>
                            </a>
                        </p>
                <?php endif; ?>

            <?php endif; ?>

            
            <?php if (!$usuario?->getEmailContato() && !$usuario?->getTelefoneContato()) :?>
            
                <span class="text-muted small">Contato não disponível</span>

                                <!-- BOTÃO ADICIONAR -->
                                <button class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#editarContatoModal">
                                    <i class="fas fa-plus"></i> Adicionar contato
                                </button>

                                

            <?php elseif ($isOwnProfile): ?>      

                                <!-- BOTÃO ADICIONAR -->
                                <button class="btn btn-primary btn-sm"
                                        data-dismiss="modal"
                                        data-toggle="modal"
                                        data-target="#editarContatoModal">
                                    <i class="fas fa-plus"></i> Editar contatos
                                </button>            

            <?php endif; ?>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editarContatoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" 
                action="<?= $isEmpresa 
                    ? BASEURL . '/controller/EmpresaController.php?action=update'
                    : BASEURL . '/controller/CandidatoController.php?action=updateContato' ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Editar Contatos</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <!-- EMAIL -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email_contato" class="form-control"
                            value="<?= htmlspecialchars($usuario?->getEmailContato() ?? '') ?>">
                    </div>

                    <!-- TELEFONE -->
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone_contato" class="form-control"
                            value="<?= htmlspecialchars($usuario?->getTelefoneContato() ?? '') ?>">
                    </div>

                    <?php if (!$isEmpresa): ?>

                        <!-- GITHUB -->
                        <div class="form-group">
                            <label>GitHub</label>
                            <input type="text" name="github" class="form-control"
                                value="<?= htmlspecialchars($usuario?->getGithub() ?? '') ?>">
                        </div>

                        <!-- LINKEDIN -->
                        <div class="form-group">
                            <label>Linkedin</label>
                            <input type="text" name="linkedin" class="form-control"
                                value="<?= htmlspecialchars($usuario?->getLinkedin() ?? '') ?>">
                        </div>

                    <?php else: ?>

                        <!-- SITE -->
                        <div class="form-group">
                            <label>Site</label>
                            <input type="text" name="site" class="form-control"
                                value="<?= htmlspecialchars($usuario?->getSiteUrl() ?? '') ?>">
                        </div>

                    <?php endif; ?>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>