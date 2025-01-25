@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="card mt-3 col-md-6">
        <div class="card-header">

            <h5 class="mb-3">{{ isset($siteInfo) ? 'Edit Site' : 'Create Site' }}</h5>
            <p class="mb-4">
                {{ isset($siteInfo) ? 'Update your site\'s basic information.' : 'Create your site\'s basic information.' }}
            </p>

        </div>

        <div class="card-body">
            <form action="{{ isset($siteInfo) ? route('admin.manage.storeOrUpdate') : route('admin.manage.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                @if (isset($siteInfo))
                    @method('PUT')
                @endif
  
            
                        <!-- Facebook URL -->
                        <div class="col-md-6 mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" id="facebook_url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                                value="{{ old('facebook_url', $siteInfo->facebook_url ?? '') }}">
                            @error('facebook_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- TikTok URL -->
                        <div class="col-md-6 mb-3">
                            <label for="tiktok_url" class="form-label">TikTok URL</label>
                            <input type="url" id="tiktok_url" name="tiktok_url" class="form-control @error('tiktok_url') is-invalid @enderror"
                                value="{{ old('tiktok_url', $siteInfo->tiktok_url ?? '') }}">
                            @error('tiktok_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- YouTube URL -->
                        <div class="col-md-6 mb-3">
                            <label for="youtube_url" class="form-label">YouTube URL</label>
                            <input type="url" id="youtube_url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror"
                                value="{{ old('youtube_url', $siteInfo->youtube_url ?? '') }}">
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Instagram URL -->
                        <div class="col-md-6 mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="url" id="instagram_url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                                value="{{ old('instagram_url', $siteInfo->instagram_url ?? '') }}">
                            @error('instagram_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- X (formerly Twitter) URL -->
                        <div class="col-md-6 mb-3">
                            <label for="x_url" class="form-label">X (formerly Twitter) URL</label>
                            <input type="url" id="x_url" name="x_url" class="form-control @error('x_url') is-invalid @enderror"
                                value="{{ old('x_url', $siteInfo->x_url ?? '') }}">
                            @error('x_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Facebook Login Option -->
                        <div class="col-md-6 mb-3">
                            <label for="enable_facebook_login" class="form-label">Enable Facebook Login</label>
                            <input type="checkbox" id="enable_facebook_login" name="enable_facebook_login" class="form-check-input"
                                value="1" {{ old('enable_facebook_login', $siteInfo->enable_facebook_login ?? false) ? 'checked' : '' }}>
                        </div>
                        
                        <!-- Google Login Option -->
                        <div class="col-md-6 mb-3">
                            <label for="enable_google_login" class="form-label">Enable Google Login</label>
                            <input type="checkbox" id="enable_google_login" name="enable_google_login" class="form-check-input"
                                value="1" {{ old('enable_google_login', $siteInfo->enable_google_login ?? false) ? 'checked' : '' }}>
                        </div>
                        

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

        </div>

    </div>
@endsection