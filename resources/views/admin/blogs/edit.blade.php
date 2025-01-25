@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="col-lg-12">
            <div class="card container mx-auto">
               
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Update Blogs</h5>
                        </div>
                        <div class="ms-5">
                            <a href="{{route('blogs.index')}}" class="btn btn-primary px-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                                  </svg>
                                Back
                            </a>

                          


                        </div>
                    </div>
                </div>
                




            </div>

            

            <div class="card container mx-auto mt-5">
               
                <div class="card-body">

                    <div class="">

                        @if ($errors->any())
                           <div class="alert alert-danger">
                                 <ul>
                                   @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        
        
                    </div>
                   
                    <form class="row g-3" action="{{route('blogs.update', $blogs->id)}}" method="post" enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="col-md-12">

                             <!-- Image preview -->
                        <img id="imagePreview" src="{{asset($blogs->image)}}" alt="Image Preview"
                        style="max-height: 200px; margin-top: 10px; border: 1px solid gainsboro; border-radius: 10px">
                            
                        </div>

                        <div class="col-md-6">

                            


                            <label for="input3" class="form-label">Image <span style="color: red; font-weight:bold;">*</span></label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span style="color: red; font-weight:bold;">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title', $blogs->title)}}">
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label">Category <span style="color: red; font-weight:bold;">*</span> </label>
                            <select id="category" class="form-select" name="category_id">
                                <option selected disabled>Choose...</option>

                                @foreach($blog_category as $item)
                                <option value="{{$item->id}}"    {{$item->id == $blogs->category_id ? 'selected' : ''}}    >{{$item->name}}</option>
                                @endforeach 

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tags-input" class="form-label">Tags</label>

                            <input id="tags-input" type="text" name="tags[]"
                            placeholder="Type tags and separate with commas" class="form-control"
                            value="{{ old('tags', implode(',', array_column($blogs->tags, 'value'))) }}">
                        


                        </div>


                        <div class="col-md-12">
                            <label for="editor" class="form-label">Description</label>
                            <textarea class="form-control" id="editor" name="description"
                                rows="3">{{ old('description', $blogs->description) }}</textarea>
                        </div>
                       
                        <div class="col-md-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{old('meta_title', $blogs->meta_title)}}">
                        </div>
                       
                        
                        <div class="col-md-12">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{old('meta_description', $blogs->meta_description)}}</textarea>
                        </div>
                       
                       
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4 w-100">Update</button>
                               
                            </div>
                        </div>
                    </form>

                </div>
                




            </div>



        </div>
        

    </div>
@endsection 

@push('scripts')

<!-----Tag script--->

<script>
    // Initialize Tagify on the input field
    var input = document.querySelector('#tags-input');
    var tagify = new Tagify(input, {
        delimiters: ",", // Comma will separate the tags
        whitelist: [], // No predefined tags (allow custom ones)
    });
</script>

<!---image show script--->

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