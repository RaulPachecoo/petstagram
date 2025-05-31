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

document.addEventListener('DOMContentLoaded', () => {
    const postForm = document.getElementById('postForm');
    const errorContainer = document.getElementById('error-container');
    const errorMessages = document.getElementById('error-messages');

    if (postForm) {
        postForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(postForm);
            const action = postForm.getAttribute('action');
            errorMessages.innerHTML = '';
            errorContainer.classList.add('hidden');

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        for (const field in data.errors) {
                            data.errors[field].forEach(error => {
                                const p = document.createElement('p');
                                p.textContent = error;
                                errorMessages.appendChild(p);
                            });
                        }
                        errorContainer.classList.remove('hidden');
                    } else {
                        console.error('Error inesperado:', data);
                    }
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } catch (error) {
                console.error('Error al enviar el formulario:', error);
            }
        });
    }
});



document.addEventListener('DOMContentLoaded', function () {
    function initLivewireHooks() {
        if (typeof Livewire !== 'undefined') {
            scrollToBottom();

            Livewire.hook('message.processed', () => {
                setTimeout(scrollToBottom, 200);

                // Nueva línea: Emitir evento Livewire para marcar como leídos si el chat está activo
                Livewire.dispatch('mark-as-read-if-active');
            });

            window.addEventListener('message-sent', () => {
                setTimeout(scrollToBottom, 300);
            });

            window.addEventListener('receiver-changed', () => {
                setTimeout(scrollToBottom, 300);
            });

        } else {
            setTimeout(initLivewireHooks, 100);
        }
    }

    function scrollToBottom() {
        const container = document.getElementById('chat-container');
        if (container) {
            container.scrollTo({
                top: container.scrollHeight,
                behavior: 'auto'
            });
        }
    }

    initLivewireHooks();
});



