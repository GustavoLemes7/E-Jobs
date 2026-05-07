function editarFormacao(id, curso, instituicao, inicio, fim, descricao) {
    document.getElementById("form_id").value = id;
    document.getElementById("form_curso").value = curso;
    document.getElementById("form_instituicao").value = instituicao;
    document.getElementById("form_inicio").value = inicio;
    document.getElementById("form_fim").value = fim ? fim : "";
    document.getElementById("form_desc").value = descricao ? descricao : "";
}