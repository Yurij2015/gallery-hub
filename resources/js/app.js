import './bootstrap';

import 'flowbite';
import './dark-mode';
import '../css/style.css';
import './sidebar';

import Alpine from 'alpinejs';
import Inputmask from "inputmask";

window.Alpine = Alpine;

Alpine.start();

import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';
import Swal from 'sweetalert2';
import Dropzone from "dropzone";

 const glightbox = GLightbox({
    selector: '.glightbox',
    touchNavigation: true,
    loop: true,
    closeButton: true,
    zoomable: true,
});

Dropzone.autoDiscover = false;

window.glightbox = glightbox;
window.Swal = Swal;
window.Dropzone = Dropzone;
