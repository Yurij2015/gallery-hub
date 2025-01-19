glightbox.on('slide_after_load', (slide) => {
    const slideContent = slide.slideNode.querySelector('.gslide-media img');

    if (slideContent) {
        // Ensure the image container is relatively positioned
        slideContent.parentElement.style.position = 'relative';

        // Create a container for the buttons
        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('absolute', 'top-2', 'right-2', 'flex', 'flex-col', 'items-end', 'space-y-1', 'group');

        // Create Like button
        const likeButton = document.createElement('button');
        likeButton.setAttribute('data-modal-target', 'like-modal');
        likeButton.setAttribute('data-modal-toggle', 'like-modal');
        likeButton.classList.add('bg-white', 'p-1', 'rounded-full', 'shadow-md', 'opacity-50', 'group-hover:opacity-100', 'hover:bg-gray-100', 'transition-all', 'transform', 'scale-75', 'hover:scale-100', 'like-btn-preview-slider');
        likeButton.setAttribute('data-id', slide.slideNode.getAttribute('data-id'));
        likeButton.setAttribute('data-object', slide.slideNode.getAttribute('data-object'));
        likeButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 011.406-1.094 4.5 4.5 0 015.68 0l.596.596.596-.596a4.5 4.5 0 015.68 0 4.5 4.5 0 011.406 1.094 4.5 4.5 0 010 5.68l-7.072 7.072a1 1 0 01-1.414 0L4.318 12a4.5 4.5 0 010-5.682z"/>
            </svg>
        `;

        // Create Comment button
        const commentButton = document.createElement('button');
        commentButton.setAttribute('data-modal-target', 'comment-modal-slider');
        commentButton.setAttribute('data-modal-toggle', 'comment-modal-slider');
        commentButton.classList.add('bg-white', 'p-1', 'rounded-full', 'shadow-md', 'opacity-50', 'group-hover:opacity-100', 'hover:bg-gray-100', 'transition-all', 'transform', 'scale-75', 'hover:scale-100', 'comment-btn-preview-slider');
        commentButton.setAttribute('data-id', slide.slideNode.getAttribute('data-id'));
        commentButton.setAttribute('data-object', slide.slideNode.getAttribute('data-object'));
        commentButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2v-2m4-6h4m-4 4h3M5 8h.01M21 8a2 2 0 01-2-2m-4 2a2 2 0 110-4m-6 2a2 2 0 11-4 0m-2 2a2 2 0 00-2-2"/>
            </svg>
        `;

        // Append buttons to the container
        buttonContainer.appendChild(likeButton);
        buttonContainer.appendChild(commentButton);

        // Append the container to the slide content
        slideContent.parentElement.appendChild(buttonContainer);
    }
});

// Show the comment modal in the center and close the slider when the comment button is clicked
document.addEventListener('click', function (e) {
    if (e.target.closest('.comment-btn-preview-slider')) {
        const commentModal = document.getElementById('comment-modal-slider');

        // Close the slider
        glightbox.close();

        // Show the modal in the center
        commentModal.classList.remove('hidden');
        commentModal.style.display = 'flex';
        commentModal.style.justifyContent = 'center';
        commentModal.style.alignItems = 'center';
    }
});

// Hide the comment modal when clicking outside of it
document.addEventListener('click', function (e) {
    const commentModal = document.getElementById('comment-modal-slider');
    if (e.target === commentModal) {
        commentModal.classList.add('hidden');
        commentModal.style.display = 'none';
    }
});

// Close the modal when the close button inside is clicked
document.addEventListener('click', function (e) {
    if (e.target.closest('.close-comment-modal')) {
        const commentModal = document.getElementById('comment-modal-slider');
        commentModal.classList.add('hidden');
        commentModal.style.display = 'none';
    }
});


// Find the modal element
const modalElement = document.getElementById('comment-modal-slider');
// Initialize the modal
new Modal(modalElement);

