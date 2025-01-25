@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Category</h4>
                <p class="card-description">Update the details of the category.</p>

                @if($category->image)
                <img style="max-width: 200px;margin-bottom:50px" id="imagePreview" src="{{ asset($category->image) }}"
                    alt="Category Image">
                @else

                <!-- Static Image -->
                <img src="https://via.placeholder.com/80" alt="Electronics" class="img-fluid" style="max-width: 80px;">

                @endif

                 {{-- all error --}}
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                         @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
                 @endif

                 

                <!-- Static Form Data -->
                <form action="{{route('admin.categories.update', $category->id)}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Static Category Name -->
                    <div class="form-group mb-3">
                        <label for="name">Category Name</label>
                        <input type="text"  name="name" class="form-control"
                            value="{{$category->name}}">
                    </div>



                    <div class="form-group mb-3">
                        <label for="image">Category Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                        @endif




                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>


</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $('#image').change(function (e) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>

@endpush