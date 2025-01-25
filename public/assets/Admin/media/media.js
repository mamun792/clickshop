function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(previewId).nextElementSibling.style.display = 'inline-block'; 
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(previewId, inputId, placeholder = 'path/to/default.png') {
    document.getElementById(previewId).src = placeholder; 
    document.getElementById(inputId).value = ''; 
    document.getElementById(previewId).nextElementSibling.style.display = 'none'; 
}

// Event listeners for each file input
document.getElementById('logoUpload').addEventListener('change', function() {
    previewImage(this, 'logoPreview');
});

document.getElementById('faviconUpload').addEventListener('change', function() {
    previewImage(this, 'faviconPreview');
});

document.getElementById('loaderUpload').addEventListener('change', function() {
    previewImage(this, 'loaderPreview');
});

document.getElementById('footerImageUpload').addEventListener('change', function() {
    previewImage(this, 'footerImagePreview');
});
