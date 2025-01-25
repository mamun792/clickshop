@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="col-lg-12">
            <div class="card container mx-auto">
               
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Update Category</h5>
                        </div>
                        <div class="ms-5">
                            <a href="{{route('blog-category.index')}}" class="btn btn-primary px-5">
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
                   
                   
                    <form class="row g-3" method="post" action="{{route('blog-category.update', $category->id)}}">
                        @csrf

                        @method('PUT')
                    
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name <span style="color: red; font-weight:bold;">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{old('name', $category->name)}}">
                        </div>
                    
                        <div class="col-md-12">
                            <label for="slug" class="form-label">Slug <span style="color: red; font-weight:bold;">*</span></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter Slug" value="{{old('slug', $category->slug)}}">
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

<!-----Name based slug------->

<script>
    $(document).ready(function() {
        $('#name').on('input', function() {
            let nameValue = $(this).val();
            let slug = nameValue.toLowerCase() // Convert to lowercase
                            .replace(/[^a-z0-9\s-]/g, '') // Remove invalid characters
                            .replace(/\s+/g, '-') // Replace spaces with hyphens
                            .replace(/-+/g, '-'); // Remove duplicate hyphens
            $('#slug').val(slug); // Update slug field
        });
    });
</script>

@endpush