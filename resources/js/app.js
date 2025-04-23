import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzoneElement = document.querySelector('#dropzone');

if (dropzoneElement) {
    const dropzone = new Dropzone(dropzoneElement, {
        dictDefaultMessage: 'Sube aquí tu imagen',
        acceptedFiles: ".png, .jpg, .jpeg, .gif", 
        addRemoveLinks: true,
        dictRemoveFile: 'Borrar Archivo', 
        maxFiles: 1,
        uploadMultiple: false,
        init: function () {
            const inputImagen = document.querySelector('[name="imagen"]');
            if (inputImagen && inputImagen.value.trim()) {
                const imagenPublicada = {
                    size: 1234,
                    name: inputImagen.value
                };
                this.options.addedfile.call(this, imagenPublicada);
                this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);
                imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
            }
        }
    });

    dropzone.on("success", function (file, response) {
        document.querySelector('[name="imagen"]').value = response.imagen;
    });

    dropzone.on('removedfile', function () {
        document.querySelector('[name="imagen"]').value = "";
    });
}
