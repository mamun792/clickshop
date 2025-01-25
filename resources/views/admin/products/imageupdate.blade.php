<!-- gallery-uploader.blade.php -->
<div class="card">
    <div class="card-body">
        <!-- Featured Image Section -->
        <div class="col-md-12">
            @if($product->featured_image)
                <img src="{{ asset($product->featured_image) }}" class="img-fluid mb-2" 
                     style="border: 1px solid gainsboro; width: 150px; height: 100px; border-radius: 5px;" />
            @endif

            <div class="mt-2">
                <label for="featured_image" class="form-label">Featured Image <span class="text-danger fw-bold">*</span></label>
                <small class="text-warning fw-bold d-block">Note: The image must be 2:3 Ratio</small>
                <div class="position-relative">
                    <input type="file" class="form-control" id="featured_image" name="featured_image" 
                           accept="image/*" onchange="previewFeaturedImage(event)">
                    <div id="featured-preview" class="mt-2"></div>
                    @error('featured_image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Gallery Images Section -->
        <div class="row mt-4">
            <h5>Gallery Images</h5>
            <div class="col-md-12">
                <div class="position-relative">
                    <input type="file" class="form-control" name="gallery_images[]" 
                           id="galleryImages" multiple accept="image/*" 
                           onchange="previewGalleryImages()">
                    
                    <!-- Hidden input for existing gallery images -->
                    <input type="hidden" name="gallery_images" id="gallery_images" 
                           value="{{ $product->gallery_images }}">
                    
                    @error('gallery_images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Existing Gallery Preview -->
                <div id="existingGalleryPreview" class="row mt-3"></div>

                <!-- New Upload Preview -->
                <div id="galleryPreview" class="row mt-3"></div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-img-container {
    position: relative;
    margin-bottom: 15px;
}

.gallery-img-container img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
}

.remove-btn:hover {
    background: rgba(200, 35, 51, 1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadExistingGalleryImages();
});

function loadExistingGalleryImages() {
    const galleryInput = document.getElementById('gallery_images');
    const existingPreview = document.getElementById('existingGalleryPreview');
    existingPreview.innerHTML = '';

    try {
        let galleryValue = galleryInput.value
            .replace(/&quot;/g, '"')
            .replace(/\\/g, '');

        galleryValue = galleryValue.replace(/^"+|"+$/g, '');
        const existingImages = JSON.parse(galleryValue);

        if (Array.isArray(existingImages) && existingImages.length > 0) {
            existingImages.forEach((imageUrl, index) => {
                const col = document.createElement('div');
                col.classList.add('col-md-3');
                col.innerHTML = `
                    <div class="gallery-img-container">
                        <img src="${imageUrl}" alt="Gallery Image ${index + 1}">
                        <button type="button" class="remove-btn" 
                                onclick="removeExistingImage(${index})">&times;</button>
                    </div>`;
                existingPreview.appendChild(col);
            });
        }
    } catch (e) {
        console.error('Error parsing gallery images:', e);
    }
}

function previewFeaturedImage(event) {
    const preview = document.getElementById('featured-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="gallery-img-container" style="max-width: 150px">
                    <img src="${e.target.result}" class="img-fluid" alt="Featured Preview">
                    <button type="button" class="remove-btn" onclick="removeFeaturedPreview()">&times;</button>
                </div>`;
        }
        reader.readAsDataURL(file);
    }
}

function removeFeaturedPreview() {
    document.getElementById('featured_image').value = '';
    document.getElementById('featured-preview').innerHTML = '';
}

function previewGalleryImages() {
    const input = document.getElementById('galleryImages');
    const preview = document.getElementById('galleryPreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3');
                    col.innerHTML = `
                        <div class="gallery-img-container">
                            <img src="${e.target.result}" alt="New Image ${index + 1}">
                            <button type="button" class="remove-btn" 
                                    onclick="removeNewImage(this, ${index})">&times;</button>
                        </div>`;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

function removeNewImage(button, index) {
    const galleryInput = document.getElementById('galleryImages');
    const newFileList = new DataTransfer();
    
    // Copy all files except the removed one
    Array.from(galleryInput.files).forEach((file, i) => {
        if (i !== index) {
            newFileList.items.add(file);
        }
    });
    
    galleryInput.files = newFileList.files;
    button.closest('.col-md-3').remove();
}

function removeExistingImage(index) {
    const galleryInput = document.getElementById('gallery_images');
    let existingImages = [];
    
    try {
        let galleryValue = galleryInput.value
            .replace(/&quot;/g, '"')
            .replace(/\\/g, '');
        galleryValue = galleryValue.replace(/^"+|"+$/g, '');
        existingImages = JSON.parse(galleryValue);
        
        // Remove the image at the specified index
        existingImages.splice(index, 1);
        
        // Update the hidden input
        galleryInput.value = JSON.stringify(existingImages);
        
        // Reload the preview
        loadExistingGalleryImages();
    } catch (e) {
        console.error('Error removing existing image:', e);
    }
}

// This function updates the gallery_images hidden input before form submission
function updateGalleryInput() {
    const galleryInput = document.getElementById('gallery_images');
    const newImagesInput = document.getElementById('galleryImages');
    let existingImages = [];
    
    // Get existing images
    try {
        let galleryValue = galleryInput.value
            .replace(/&quot;/g, '"')
            .replace(/\\/g, '');
        galleryValue = galleryValue.replace(/^"+|"+$/g, '');
        existingImages = JSON.parse(galleryValue);
    } catch (e) {
        console.error('Error parsing existing images:', e);
    }
    
    // Create FormData with both existing and new images
    const formData = new FormData();
    
    // Add existing images to formData
    existingImages.forEach((url, index) => {
        formData.append('existing_images[]', url);
    });
    
    // Add new images to formData
    if (newImagesInput.files) {
        Array.from(newImagesInput.files).forEach((file, index) => {
            formData.append('gallery_images[]', file);
        });
    }
    
    return formData;
}

</script>