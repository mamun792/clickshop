@extends('admin.master')

@section('main-content')

<div class="page-content">

    <h1>Edit Marketing Tool</h1>

    <form action="{{ route('admin.marketing-tools.update', $marketingTool) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <select name="name" id="name" class="form-control">
                <option value="Facebook Pixel" {{ $marketingTool->name == 'Facebook Pixel' ? 'selected' : '' }}>Facebook Pixel</option>
                <option value="Google Analytics" {{ $marketingTool->name == 'Google Analytics' ? 'selected' : '' }}>Google Analytics</option>
                <option value="Google Tag Manager" {{ $marketingTool->name == 'Google Tag Manager' ? 'selected' : '' }}>Google Tag Manager</option>
                <option value="Domain Verification" {{ $marketingTool->name == 'Domain Verification' ? 'selected' : '' }}>Domain Verification</option>
            </select>

          
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="identifier" class="form-label">Identifier</label>
            <input type="text" class="form-control" name="identifier" id="identifier" value="{{ $marketingTool->identifier }}">
            @error('identifier')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="script" class="form-label">Script</label>
            <textarea class="form-control" name="script" id="script">{{ $marketingTool->script }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>

@endsection