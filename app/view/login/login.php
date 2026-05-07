<?php
# Objetivo: página de login
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/login/login.css">

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h4>Bem-vindo ao E-Jobs</h4>
            <p class="text-muted">Faça login para continuar</p>
        </div>

        <?php include_once(__DIR__ . "/../include/msg.php") ?>

        <form id="frmLogin" class="login-form" action="./LoginController.php?action=logon" method="POST">
            <div class="form-group">
                <label for="txtLogin">
                    <i class="fas fa-envelope me-2"></i>Email
                </label>
                <input type="text" class="form-control" name="email" id="txtLogin"
                    placeholder="Informe seu email"
                    value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
            </div>

            <div class="form-group">
                <label for="txtSenha">
                    <i class="fas fa-lock me-2"></i>Senha
                </label>
                <input type="password" class="form-control" name="senha" id="txtSenha"
                    placeholder="Informe sua senha"
                    value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar
            </button>
        </form>

        <div class="login-footer">
            <p>Não tem uma conta? <a href="<?= BASEURL ?>/controller/CadastroController.php?action=createFormUsuario">Cadastre-se</a></p>
        </div>

        <div class="divider">
            <span>ou</span>
        </div>

        <div id="customBtn" class="google-btn">
            <img src="https://developers.google.com/identity/images/g-logo.png" class="google-icon">
            <span>Entrar com Google</span>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>

<script>
document.getElementById("customBtn").addEventListener("click", function() {
    window.location.href = "<?= BASEURL ?>/auth/google_login.php";
});
</script>