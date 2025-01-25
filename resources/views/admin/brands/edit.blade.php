@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="row">
            <div class="col-lg-6 mx-auto grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Brand Information Update </h4>
                        <!-- Form starts here -->
                        <form action="{{ route('admin.brands.update',$brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                        
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="company" value="{{ $brand->company }}" class="form-control">
                                            @error('company')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="file" name="photo" class="form-control">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            
                                            <img src="{{ $brand->photo }}" alt="Brand Image" class="img-thumbnail">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        
                       
                    </div>
                </div>
            </div>
        </div>
        

    </div>
@endsection