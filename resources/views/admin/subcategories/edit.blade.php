@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Subcategory</h4>
                <p class="card-description">Update the details of the subcategory.</p>

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


    
                <!-- Update Form -->
                <form action="{{route('admin.subcategories.update', $subcategories->id)}}" method="post" class="mx-auto w-75">
                    @csrf
                    @method('PATCH')
    
                    <!-- Subcategory Name -->
                    <div class="form-group mb-4">
                        <label for="name">Subcategory Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                             value="{{$subcategories->name}}">
                       
                    </div>
    
                    <!-- Category Selection -->
                    <div class="form-group mb-4">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <!-- Static categories list for demonstration -->
                            @foreach($categories as $item)
                            <option value="{{$item->id}}"  {{$item->id == $subcategories->category_id ? 'selected' : ''}} > {{$item->name}} </option>
                            @endforeach 
                            
                        </select>
                      
                    </div>
    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    
</div>

@endsection