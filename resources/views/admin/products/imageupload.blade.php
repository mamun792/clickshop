<!-- image-uploader.blade.php -->
<div class="card">
    <div class="card-body">
        <!-- Featured Image Section -->
        <div class="col-md-12 mt-2">
            <label for="featured_image" class="form-label">Featured Image <span class="text-danger fw-bold">*</span></label>
            <small class="text-warning fw-bold d-block">Note: The image must be 2:3 Ratio</small>

            <div class="position-relative">
                <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*" onchange="previewFeaturedImage(event)">

                <div id="featured-image-preview" class="mt-2" style="display: none;">
                    <img id="featured-img" src="#" alt="Featured Image Preview" class="img-fluid" style="max-height: 200px; width: auto;">
                    <button type="button" onclick="removeFeaturedImage()" class="btn btn-danger btn-sm mt-2">Remove Image</button>
                </div>

                @error('featured_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Gallery Images Section -->
        <div class="row mt-4">
            <div class="col-12">
                <h5>Gallery Images</h5>
                <div class="position-relative">
                    <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" multiple accept="image/*" onchange="handleGalleryImages(event)">

                    <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-3"></div>

                    @error('gallery_images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-preview-item {
    position: relative;
    display: inline-block;
    margin: 5px;
}

.gallery-preview-item img {
    max-height: 150px;
    width: auto;
    border-radius: 4px;
}

.remove-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.remove-btn:hover {
    background: #c82333;
}
</style>

<script>
// Featured Image Handling
function previewFeaturedImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('featured-image-preview');
        const img = document.getElementById('featured-img');
        img.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}

function removeFeaturedImage() {
    const input = document.getElementById('featured_image');
    const preview = document.getElementById('featured-image-preview');
    input.value = '';
    preview.style.display = 'none';
}

// Gallery Images Handling
let galleryFiles = new DataTransfer();

function handleGalleryImages(event) {
    const newFiles = Array.from(event.target.files);
    const input = document.getElementById('gallery_images');
    
    // Add new files to existing files
    newFiles.forEach(file => {
        galleryFiles.items.add(file);
    });
    
    // Update input files
    input.files = galleryFiles.files;
    
    // Update preview
    updateGalleryPreview();
}

function updateGalleryPreview() {
    const previewContainer = document.getElementById('gallery-preview');
    previewContainer.innerHTML = ''; // Clear existing previews
    
    Array.from(galleryFiles.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'gallery-preview-item';
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Gallery Preview ${index + 1}">
                <button type="button" class="remove-btn" onclick="removeGalleryImage(${index})">&times;</button>
            `;
            previewContainer.appendChild(previewItem);
        }
        reader.readAsDataURL(file);
    });
}

function removeGalleryImage(index) {
    const newDataTransfer = new DataTransfer();
    const input = document.getElementById('gallery_images');
    
    // Rebuild files list excluding the removed file
    Array.from(galleryFiles.files)
        .filter((_, i) => i !== index)
        .forEach(file => newDataTransfer.items.add(file));
    
    // Update stored files
    galleryFiles = newDataTransfer;
    input.files = galleryFiles.files;
    
    // Update preview
    updateGalleryPreview();
}
</script>