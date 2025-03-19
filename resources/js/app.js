<<<<<<< HEAD
import './bootstrap';
=======
import Dropzone from 'dropzone';
import '../css/app.css'; // Asegúrate de importar el archivo CSS

Dropzone.autoDiscover = false; 

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif", 
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo', 
    maxFiles: 1,
    uploadMultiple: false,
})

>>>>>>> 31b97d83b9227992673e7cd3d786bb108a6f023f
