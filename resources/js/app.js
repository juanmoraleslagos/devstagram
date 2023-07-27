import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Sube Aquí Tu Imagen",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    // recuperando imagen subida dropzone.
    init: function () {
        // verificar imagen si hay imagen ingresada.
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {}
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

// eventos dropzone.
dropzone.on("success", function (file, response) {
    console.log(response.imagen);
    // Capturando valor input imagen.
    document.querySelector('[name="imagen"]').value = response.imagen;

});

dropzone.on("removedfile", function () {
    console.log('Archivo Eliminado');
});

dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = "";
});

