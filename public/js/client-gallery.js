const gallery = document.querySelector('.gallery');
const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightbox-image');
const closeButton = document.getElementById('close');

// Add event listener to each image
gallery.addEventListener('click', e => {
    if (e.target.classList.contains('gallery-image')) {
        lightboxImage.src = e.target.src;
        lightbox.style.display = 'flex';
    }
});

// Close lightbox when close button is clicked
closeButton.addEventListener('click', () => {
    lightbox.style.display = 'none';
});

// Close lightbox when clicking outside the image
lightbox.addEventListener('click', e => {
    if (e.target === lightbox) {
        lightbox.style.display = 'none';
    }
});


const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);
const projectNamaParam = params.get('project-name');

if (projectNamaParam && params.size > 1) {
    document.getElementById('goBack').addEventListener('click', function () {
        window.history.back();
    });
}
