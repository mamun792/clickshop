@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="col-lg-12">
            <div class="card container mx-auto">
                <div class="card-header">
                    <h5 class="card-title mb-0">Brand Management</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" name="company" class="form-control"
                                            placeholder="Enter Brand Name">

                                        @error('company')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="file" name="photo" class="form-control">

                                        @error('photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-success radius-8">Upload</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                    <div class="table-responsive mt-5 w-75 mx-auto">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <!-- Dynamically render brand photo -->
                                                {{-- <img src="{{ $brand->photo ?? '' }}" width="80px"
                                                    class="me-3 radius-8">
                                                <div> --}}

                                                    <img src="{{ $brand->photo ?? '' }}" width="80" height="80"
                                                    class="me-3  shadow-sm">
                                               <div>
                                                    <h6 class="mb-0">{{ $brand->company }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                    class="btn btn-success radius-8 d-flex align-items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                      </svg>
                                                </a>

                                                {{-- <!-- Delete button -->
                                                <form action="{{ route('admin.brands.destroy', $brand->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger radius-8 d-flex align-items-center gap-2">
                                                        <iconify-icon icon="mdi:delete"></iconify-icon>Delete

                                                    </button>
                                                </form> --}}

                                                <button type="button" class="btn btn-danger deleteButton btn-sm"
                                                    data-url="{{ route('admin.brands.destroy', $brand->id) }}">
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

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
