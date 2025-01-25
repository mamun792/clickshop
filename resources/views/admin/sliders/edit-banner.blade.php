@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Banner Images</h4>
                    <p class="card-description">Update and  manage your hero and sidebar images.</p>

                    <!-- Form for uploading images -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <form action="{{ route('admin.sliders.banner.update', $banner->id) }}" enctype="multipart/form-data"
                                method="POST" class="p-3 border border-1 rounded">
                              @csrf
                              @method('PATCH') 
                          
                              <!-- Display Current Image -->
                              <label for="banner_slider2" class="mb-1 font-weight-bold">Current Sidebar Slider Image:</label>
                              <div class="mb-3">
                                  <img src="{{ $banner->image_path }}" alt="Current Slider Image" class="img-fluid rounded" 
                                       style="max-width: 100%; height: auto; object-fit: cover;">
                              </div>
                          
                              <!-- Image Upload Field -->
                              <label for="banner_slider2" class="mb-1 font-weight-bold">Upload New Sidebar Slider Image:</label>
                              <div class="input-group mb-3">
                                  <input type="file" name="image_path" id="banner_slider2" class="form-control"
                                         onchange="previewImage(event, 'slider1Preview')">
                              </div>
                          
                              <!-- Image Preview for New Upload -->
                              <div id="imagePreviewContainer" class="d-none">
                                  <img id="slider1Preview" class="img-fluid mb-3"
                                       style="max-width: 100%; height: auto; object-fit: cover;">
                                  <button type="button" id="removeImageBtn" class="btn btn-warning"
                                          onclick="removePreview()">Remove Image</button>
                              </div>
                          
                              <!-- Submit Button -->
                              <button type="submit" class="btn btn-primary btn-block">Upload</button>
                          </form>
                          
                        </div>


                    </div>

                 

                  

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/Admin/slider/slider.js') }}"></script>
@endpush