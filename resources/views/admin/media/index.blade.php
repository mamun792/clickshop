@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header ">
                    <h5 class="card-title mb-0">Media Management</h5>
                </div>
               

               




                <div class="card-body">
                    {{-- <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Logo Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Logo (150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="logoPreview" src="{{ asset('path/to/logo.png') }}" alt="Logo" class="img-fluid">
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="logoUpload" class="form-label">Upload Logo</label>
                                        <input type="file" name="logo" class="form-control" id="logoUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Favicon Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Favicon (25px*25px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="faviconPreview" src="{{ asset('path/to/favicon.ico') }}" alt="Favicon" class="img-fluid" style="max-width: 50px;">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="faviconUpload" class="form-label">Upload Favicon</label>
                                        <input type="file" class="form-control" name="favicon" id="faviconUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <!-- Loader Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Loader (150px*150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="loaderPreview" src="{{ asset('path/to/loader.gif') }}" alt="Loader" class="img-fluid">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="loaderUpload" class="form-label">Upload Loader</label>
                                        <input type="file" name="loader" class="form-control" id="loaderUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Footer Image Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Footer Image (150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="footerImagePreview" src="{{ asset('path/to/footer_image.png') }}" alt="Footer Image" class="img-fluid">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="footerImageUpload" class="form-label">Upload Footer Image</label>
                                        <input type="file" name="footer_image" class="form-control" id="footerImageUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form> --}}
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Logo Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Logo (150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="logoPreview" src="{{ $media->logo ?? asset('path/to/default/logo.png') }}" alt="Logo" class="img-fluid">
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="logoUpload" class="form-label">Upload Logo</label>
                                        <input type="file" name="logo" class="form-control" id="logoUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Favicon Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Favicon (25px*25px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="faviconPreview" src="{{ $media->favicon ?? asset('path/to/default-favicon.ico') }}" alt="Favicon" class="img-fluid" style="max-width: 50px;">
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="faviconUpload" class="form-label">Upload Favicon</label>
                                        <input type="file" name="favicon" class="form-control" id="faviconUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <!-- Loader Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Loader (150px*150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="loaderPreview" src="{{ $media->loader ?? asset('path/to/default-loader.gif') }}" alt="Loader" class="img-fluid">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="loaderUpload" class="form-label">Upload Loader</label>
                                        <input type="file" name="loader" class="form-control" id="loaderUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Footer Image Section -->
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="mb-3">Footer Image (150px)</h6>
                                    <div class="media-preview mb-3 text-center position-relative">
                                        <img id="footerImagePreview" src="{{ $media->footer_image ?? asset('path/to/default-footer.png') }}" alt="Footer Image" class="img-fluid">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="footerImageUpload" class="form-label">Upload Footer Image</label>
                                        <input type="file" name="footer_image" class="form-control" id="footerImageUpload" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
    


</div>
</div>
</div>

@endsection

@push('scripts')

<script src="{{asset('assets/Admin/media/media.js')}}"></script>

@endpush