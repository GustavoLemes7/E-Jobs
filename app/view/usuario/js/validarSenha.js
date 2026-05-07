const senhaInput = document.getElementById("senha");
const form = document.querySelector("form");
const rules = document.getElementById("password-rules");

let tentouEnviar = false;

// Quando tenta enviar
form.addEventListener("submit", function (e) {
    const senha = senhaInput.value;

    if (!validarSenha(senha)) {
        e.preventDefault(); // bloqueia envio
        tentouEnviar = true;
        rules.classList.remove("d-none");
        atualizarChecklist(senha);
    }
});

// Atualiza enquanto digita (só depois da primeira tentativa)
senhaInput.addEventListener("input", function () {
    if (!tentouEnviar) return;

    atualizarChecklist(senhaInput.value);
});

// Validação geral
function validarSenha(senha) {
    return senha.length >= 8 &&
        /[A-Z]/.test(senha) &&
        /[a-z]/.test(senha) &&
        /[0-9]/.test(senha) &&
        /[^A-Za-z0-9]/.test(senha);
}

// Atualiza checklist
function atualizarChecklist(senha) {
    validarItem("length", senha.length >= 8);
    validarItem("upper", /[A-Z]/.test(senha));
    validarItem("lower", /[a-z]/.test(senha));
    validarItem("number", /[0-9]/.test(senha));
    validarItem("special", /[^A-Za-z0-9]/.test(senha));
}

function validarItem(id, ok) {
    const el = document.getElementById(id);
    if (!el) return;

    const textoBase = el.getAttribute("data-text");

    if (ok) {
        el.classList.remove("text-danger");
        el.classList.add("text-success");
        el.innerHTML = `<i class="fas fa-check me-1"></i> ${textoBase}`;
    } else {
        el.classList.remove("text-success");
        el.classList.add("text-danger");
        el.innerHTML = `<i class="fas fa-times me-1"></i> ${textoBase}`;
    }
}

document.querySelectorAll(".toggle-senha").forEach(function (botao) {

    botao.addEventListener("click", function () {

        const input = this.closest(".input-group").querySelector("input");
        const tipo = input.getAttribute("type");

        if (tipo === "password") {
            input.setAttribute("type", "text");
            this.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.setAttribute("type", "password");
            this.innerHTML = '<i class="fas fa-eye"></i>';
        }

    });

});