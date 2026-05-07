document.getElementById("inputFoto").addEventListener("change", function (e) {
    const file = e.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (event) {
            document.getElementById("previewFoto").src = event.target.result;
        };

        reader.readAsDataURL(file);
    }
});
