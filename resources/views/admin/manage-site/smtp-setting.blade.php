@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">SMTP Setting</h4>
        </div>
        <div class="card-body">
            <div class="page-content">
                <div class="container">
                    <h2>Contact Us</h2>
            


                    <form action="{{ route('admin.manage.storeOrUpdateSmtp') }}" method="POST">
                        @csrf
                    
                        <!-- SMTP Service Switch -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="use_smtp" {{ isset($smtp->smtp_host) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Use SMTP Service</label>
                        </div>
                    
                        <!-- SMTP Settings (Only visible if switch is ON) -->
                        <div class="smtp-settings" style="display: {{ isset($smtp->smtp_host) ? 'block' : 'none' }};">
                            <div class="form-group mt-2">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{ $smtp->smtp_host ?? '' }}">
                            </div>

                           
                            <div class="form-group mt-2">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="{{ $smtp->smtp_port ?? '' }}">
                            </div>

                            
                            <div class="form-group mt-2">
                                <label for="smtp_encryption">SMTP Encryption</label>
                                <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                                    <option value="ssl" {{ (isset($smtp) && $smtp->smtp_encryption == 'ssl') ? 'selected' : '' }}>SSL</option>
                                    <option value="tls" {{ (isset($smtp) && $smtp->smtp_encryption == 'tls') ? 'selected' : '' }}>TLS</option>
                                </select>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="smtp_username">SMTP Username</label>
                                <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="{{ $smtp->smtp_username ?? '' }}">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="smtp_password">SMTP Password</label>
                                <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="{{ $smtp->smtp_password ?? '' }}">
                            </div>
                        </div>
                    
                        <!-- Always Visible Fields -->
                        <div class="form-group mt-2">
                            <label for="email_from">Email From</label>
                            <input type="text" class="form-control" id="email_from" name="email_from" value="{{ $smtp->email_from ?? '' }}">
                        </div>
                    
                        <div class="form-group mt-2">
                            <label for="email_from_name">Email From Name</label>
                            <input type="text" class="form-control" id="email_from_name" name="email_from_name" value="{{ $smtp->email_from_name ?? '' }}">
                        </div>
                    
                        <div class="form-group mt-2">
                            <label for="contact_email">Contact Email</label>
                            <input type="text" class="form-control" id="contact_email" name="contact_email" value="{{ $smtp->contact_email ?? '' }}">
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                    
        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('assets/Admin/smtp/smtp.js')}}"></script>

@endpush