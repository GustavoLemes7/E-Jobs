function editarExperiencia(id, cargo, empresa, inicio, fim, descricao) {
    document.getElementById("exp_id").value = id;
    document.getElementById("exp_cargo").value = cargo;
    document.getElementById("exp_empresa").value = empresa;
    document.getElementById("exp_inicio").value = inicio;
    document.getElementById("exp_fim").value = fim ? fim : "";
    document.getElementById("exp_desc").value = descricao ? descricao : "";
}