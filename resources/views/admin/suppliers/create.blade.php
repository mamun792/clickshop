@extends('admin.master')

@section('main-content')

<div class="page-content">


    <div class="row">
        <div class="col-xl-8">

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Create Supplier</h5>
                    <form class="row g-3" method="post" action="{{route('admin.suppliers.store')}}">
                        @csrf
                        <div class="col-md-6">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                placeholder="Enter supplier name" value="{{ old('supplier_name') }}">
                            @if ($errors->has('supplier_name'))
                            <span class="text-danger">{{ $errors->first('supplier_name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                placeholder="Enter company name" value="{{ old('company_name') }}" required>
                            @if ($errors->has('company_name'))
                            <span class="text-danger">{{ $errors->first('company_name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label for="company_phone" class="form-label">Company Phone</label>
                            <input type="tel" class="form-control" id="company_phone" name="company_phone"
                                placeholder="0178...." required value="{{ old('company_phone') }}">
                            @if ($errors->has('company_phone'))
                            <span class="text-danger">{{ $errors->first('company_phone') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label for="company_address" class="form-label">Company Address</label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="4"
                                placeholder="Enter company address">

                                {{ old('company_address') }}

                                @if ($errors->has('company_address'))
                                <span class="text-danger">{{ $errors->first('company_address') }}</span>
                                @endif
                            </textarea>
                        </div>




                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-5 btn-sm">Create Supplier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>




        </div>
    </div>



</div>

@endsection