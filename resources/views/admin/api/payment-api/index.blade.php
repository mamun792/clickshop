@extends('admin.master')

@section('main-content')
<div class="page-content">

    <div class="row g-4">

      

        <div class="col-md-3">
            <div class="card">

                <div class="card-body">


                    <div class="d-flex justify-content-center">
                        <img class="img-fluid " style="height: 50px" src="{{asset('uploads/bKash.png')}}" />
                    </div>
    
    
    
                    <div class="d-flex flex-column align-items-center">
                        <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select Bkash </p>
    
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1"
                                style="cursor: pointer">
    
                        </div>
                    </div>
    
    
    
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Bkash Username</label>
                        <input type="text" class="form-control" id="input1">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="input2" class="form-label">Bkash Password</label>
                        <input type="text" class="form-control" id="input2" >
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="input2" class="form-label">Bkash API Key</label>
                        <input type="text" class="form-control" id="input2" >
                    </div>


                    <div class="col-md-12 mt-2">
                        <label for="input2" class="form-label">Bkash Secret Key</label>
                        <input type="text" class="form-control" id="input2" >
                    </div>

                   


    
                    <button class="btn btn-primary w-100 mt-3 mb-5">Submit</button>
    
                </div>


            </div>
           

        </div>

        <div class="col-md-3">
            <div class="card">

                <div class="card-body">


                    <div class="d-flex justify-content-center">
                        <img class="img-fluid " style="height: 100px" src="{{asset('uploads/aamarpay.png')}}" />
                    </div>
    
    
    
                    <div class="d-flex flex-column align-items-center">
                        <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select AamarPay </p>
    
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1"
                                style="cursor: pointer">
    
                        </div>
                    </div>
    
    
    
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Store ID</label>
                        <input type="text" class="form-control" id="input1">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="input2" class="form-label">Signature Key</label>
                        <input type="text" class="form-control" id="input2" >
                    </div>

                  

                   


    
                    <button class="btn btn-primary w-100 mt-3 mb-5">Submit</button>
    
                </div>


            </div>
           

        </div>

        <div class="col-md-3">
            <div class="card">

                <div class="card-body">


                    <div class="d-flex justify-content-center">
                        <img class="img-fluid " style="height: 100px" src="{{asset('uploads/SSL.png')}}" />
                    </div>
    
    
    
                    <div class="d-flex flex-column align-items-center">
                        <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select SSL-Commerz </p>
    
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault1"
                                style="cursor: pointer">
    
                        </div>
                    </div>
    
    
    
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Store ID</label>
                        <input type="text" class="form-control" id="input1">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="input2" class="form-label">Signature Key</label>
                        <input type="text" class="form-control" id="input2" >
                    </div>

                  

                   


    
                    <button class="btn btn-primary w-100 mt-3 mb-5">Submit</button>
    
                </div>


            </div>
           

        </div>



    </div>




</div>
@endsection