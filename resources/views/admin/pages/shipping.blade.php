@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class=" mt-3">
        <div class="card">
            <div class="card-header">
                <h6>{{ $page->exists ? 'Edit' : 'Create' }} Shipping & Delivery  Page</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pages.store', $page->type) }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label for="content" class="form-label">Page Content</label>
                        <textarea name="content" rows="5" class="summernote form-control @error('content') is-invalid @enderror">{{ old('content', $page->content) }}</textarea>
                        
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
    
                    <button type="submit" class="btn btn-primary btn-block">Save Page</button>
                </form>
            </div>
        </div>
    

    </div>
</div>

@endsection