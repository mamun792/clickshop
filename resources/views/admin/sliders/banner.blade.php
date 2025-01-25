@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Banner Images</h4>
                    <p class="card-description">Upload and manage your hero and sidebar images.</p>

                    <!-- Form for uploading images -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <form action="{{ route('admin.sliders.banner.store') }}" enctype="multipart/form-data"
                                method="post" class="p-3 border border-1 rounded">
                                @csrf

                                <label for="banner_slider2" class="mb-1 font-weight-bold">Upload Sidebar Slider
                                    Image:</label>
                                <div class="input-group mb-3">
                                    <input type="file" name="image_path" id="banner_slider2" class="form-control"
                                        onchange="previewImage(event, 'slider1Preview')">

                                </div>
                                @error('image_path')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror



                                <!-- Image Preview -->
                                <div id="imagePreviewContainer" class="d-none">
                                    <img id="slider1Preview" class="img-fluid mb-3"
                                        style="max-width: 100%; height: auto; object-fit: cover;">
                                    <button type="button" id="removeImageBtn" class="btn btn-warning"
                                        onclick="removePreview()">Remove Image</button>
                                       
                                </div>
                                <small class="text-warning font-weight-bold d-block">Note: The image must be exactly 1900x560 pixels.</small>

                                <button type="submit" class="btn btn-primary btn-block mt-1">Upload</button>
                            </form>
                        </div>


                    </div>

                    <hr class="mt-3 border-2 border-dark">

                    <div class="row mt-5">


                        @foreach($banners as $key => $banner)
                        <div class="col-md-6 mb-4">
                            <h6>Uploaded Sidebar Slider Image {{ $key + 1 }}</h6>
                            <table id="csidebar-slider{{ $key + 1 }}-table" class="table table-striped table-bordered table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ $banner->image_path }}" alt="Slider Image" class="img-fluid rounded" style="max-width: 120px; height: 56px; object-fit: cover;">
                                        </td>
                                        <td>

                                            <a href="{{ route('admin.sliders.banner.edit',$banner->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                  </svg>
                                            </a>



                                            <button type="button" class="btn btn-danger deleteButton btn-sm"
                                            data-url=" {{ route('admin.sliders.banner.destroy',$banner->id) }} ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                            </svg>
                                        </button>


                                        <form id="deleteForm" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/Admin/slider/slider.js') }}"></script>
@endpush
