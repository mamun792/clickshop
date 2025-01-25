  
@extends('admin.master')

@section('main-content')

<div class="page-content">

    <div class="">
        <div class="main-body">
            <div class="row">


                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if($user_info->image)
                                <img src="{{asset($user_info->image)}}" alt="Admin" id="profileImagePreview" class="rounded-circle p-1 bg-primary" width="200">
                                @else
                               

                                <img src="@avatar($user_info->image,$user_info->name)" alt="Admin" id="profileImagePreview" class="rounded-circle p-1 bg-primary" width="200">
                                @endif
                                <div class="mt-3">
                                    <h4>Personal Info</h4>


                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Full Name</h6>
                                    <span class="text-secondary">{{$user_info->name}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Email</h6>
                                    <span class="text-secondary">{{$user_info->email}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Phone Number</h6>
                                    <span class="text-secondary">{{$user_info?->addresses[0]->phone ?? 'N/A'}}</span>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">City</h6>
                                    <span class="text-secondary">{{$user_info?->addresses[0]->city ?? 'N/A'}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Address</h6>
                                    <span class="text-secondary">{{$user_info?->addresses[0]->address ?? 'N/A'}}</span>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">


                   


                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-primary" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                            </div>
                                            <div class="tab-title">Home</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false" tabindex="-1">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                            </div>
                                            <div class="tab-title">Profile</div>
                                        </div>
                                    </a>
                                </li>
                               
                            </ul>
                            <div class="tab-content py-3">
                                <div class="tab-pane fade active show" id="primaryhome" role="tabpanel">

                                    <form class="row g-3" method="post" action="{{route('profileUpdate')}}" enctype="multipart/form-data">

                                        {{@csrf_field()}}
                                        <div class="col-md-12">
                                            <label for="input13" class="form-label">Profile Image</label>
                                            <div class="position-relative input-icon">
                                                <input type="file" name="image" class="form-control" id="profileImageInput">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-image"></i></span>
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="fullname" class="form-label">Full Name</label>
                                            <div class="position-relative input-icon">
                                                <input type="text" class="form-control" name="name" id="fullname" value="{{ old('name', auth()->user()->name) }}">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-user"></i></span>
                                            </div>

                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="position-relative input-icon">
                                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-envelope"></i></span>
                                            </div>

                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="position-relative input-icon">
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user_info?->addresses[0]->phone ?? 'N/A'  ) }}">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-phone"></i></span>
                                            </div>

                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <div class="position-relative input-icon">
                                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user_info?->addresses[0]->city ?? 'N/A') }}">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-buildings"></i></span>
                                            </div>
                                            @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-12">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" id="address" name="address" placeholder="Address ..." rows="3" >{{ old('address', $user_info?->addresses[0]->address ?? ''  ) }}</textarea>
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4 w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                                    </svg>
                                                    Submit
                                                </button>
                                            </div>
                                        </div>

                                       


                                    
                                    </form>


                                </div>
                                <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                    
                                    <form class="row g-3" method="post" action="{{route('passwordUpdate')}}">
                                        {{ @csrf_field() }}
                                        <!-- Change Password Fields -->
                                        <div class="col-md-12">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <div class="position-relative input-icon">
                                                <input type="password" class="form-control" name="current_password" id="current_password">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-lock"></i></span>
                                            </div>

                                            @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror


                                        </div>
                                        <div class="col-md-6">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <div class="position-relative input-icon">
                                                <input type="password" class="form-control" name="new_password" id="new_password" >
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-lock"></i></span>
                                            </div>

                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror


                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <div class="position-relative input-icon">
                                                <input type="password" class="form-control" name="new_password_confirmation" id="confirm_password">
                                                <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-lock-alt"></i></span>
                                            </div>

                                            @error('new_password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror


                                        </div>
                                        
                                        <div class="col-md-12 mt-3">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4 w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                                    </svg>
                                                    Submit
                                                </button>
                                            </div>
                                        </div>


                                    </form>


                                </div>
                               
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#profileImageInput').change(function(event) {
          
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();

              
                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                };

             
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    });

</script>
@endpush