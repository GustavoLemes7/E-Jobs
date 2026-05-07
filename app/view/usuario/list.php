<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Usuários</h3>

<div class="container">
    <div class="row">
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabUsuarios" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Papel</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Data Criação</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $usu): ?>
                        <tr>
                            <td><?php echo $usu->getId(); ?></td>
                            <td><?= $usu->getEmail(); ?></td>
                            <td><?= $usu->getTipoUsuario(); ?></td>
                            <td><?=  $usu->getTelefone(); ?></td>
                            <td><?= $usu->getStatus(); ?></td>
                            <td><?= $usu->getDataCriacao(); ?></td>
                            <td><a class="btn btn-primary" 
                                href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $usu->getId() ?>">
                                Alterar</a> 
                            </td>
                            <td><a class="btn btn-danger" 
                                onclick="return confirm('Você realmente deseja inativar o usuário?');"
                                href="<?= BASEURL ?>/controller/UsuarioController.php?action=inativarUsuario&id=<?= $usu->getId() ?>">
                                Inativar</a> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
