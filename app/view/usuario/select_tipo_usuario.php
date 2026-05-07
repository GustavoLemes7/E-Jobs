<?php
require_once(__DIR__ . "/../include/header.php");
?>
<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}
.main-content {
    flex: 1;
}
</style>
<div class="main-content">
    <div class="container" style="max-width: 600px; margin-top: 50px;">
        <h3 class="text-center mb-4">Como você quer usar o E-Jobs?</h3>

        <div class="row">

            <!-- CANDIDATO -->
            <div class="col-md-6">
                <div class="card text-center p-3">
                    <h4>👤</h4>
                    <h5>Candidato</h5>
                    <p>Quero encontrar um emprego</p>

                    <form method="POST" action="../../controller/CadastroController.php?action=definirTipo">
                        <input type="hidden" name="tipo" value="CANDIDATO">
                        <button class="btn btn-primary w-100">Sou Candidato</button>
                    </form>
                </div>
            </div>

            <!-- EMPRESA -->
            <div class="col-md-6">
                <div class="card text-center p-3">
                    <h4>🏢</h4>
                    <h5>Empresa</h5>
                    <p>Quero contratar pessoas</p>

                    <form method="POST" action="../../controller/CadastroController.php?action=definirTipo">
                        <input type="hidden" name="tipo" value="EMPRESA">
                        <button class="btn btn-success w-100">Sou Empresa</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php require_once(__DIR__ . "/../include/footer.php"); ?>