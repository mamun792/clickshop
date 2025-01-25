function previewImage(event, previewId) {
    const file = event.target.files[0];
    const previewElement = document.getElementById(previewId);
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const removeImageBtn = document.getElementById('removeImageBtn');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewElement.src = e.target.result;
            imagePreviewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}




// Function to remove the preview image
function removePreview() {
    const previewElement = document.getElementById('slider1Preview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const inputFile = document.getElementById('banner_slider2');

    // Clear the file input and hide the preview
    inputFile.value = '';
    previewElement.src = '';
    imagePreviewContainer.classList.add('d-none');
}
