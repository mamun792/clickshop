@extends('admin.master')

@section('main-content')
<div class="page-content">
  


    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                 <h6>Incomplete Order</h6>
                



               
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="table-responsive">



                     @include('admin.orders.incomplete_table')



                    </div>

                </div>
            </div>
        </div>
    </div>









</div>



</div>
@endsection

@push('scripts')

<script src="{{asset('assets/Admin/order/order.js')}}"></script>

@endpush