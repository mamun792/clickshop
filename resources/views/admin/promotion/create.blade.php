@extends('admin.master')

@section('main-content')
<div class="page-content">
<div class="card col-md-6 mx-auto">
    <div class="card-header">
        <h6 class="card-title mb-0">Create Campaign</h6>
    </div>
    <div class="card-body">

        <form action="{{ route('admin.promotions.store') }}" method="POST">
            @csrf
            <div class="row gy-3">
                <div class="col-12">
                    <label for="name">Campaign Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" placeholder="Enter campaign name"
                        value="{{ old('name') }}">
                  
                </div>

                <div class="col-12">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                        name="start_date" id="start_date" value="{{ old('start_date') }}">
                   
                   
                </div>

                <div class="col-12">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                    
                </div>

                <div class="col-12">
                    <label for="discount">Discount</label>
                    <input type="text" class="form-control @error('discount') is-invalid @enderror"
                        id="discount" name="discount" placeholder="Enter Discount .. Eg: 20% , 200" step="0.01"
                        value="{{ old('discount') }}">
                   
                </div>

          

               
            </div>
            <br>
            <button type="submit" class="btn btn-primary w-100 ">Add Campaign</button>
        </form>

    </div>
</div>
</div>

@endsection