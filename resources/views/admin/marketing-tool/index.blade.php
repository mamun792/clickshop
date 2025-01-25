@extends('admin.master')

@section('main-content')
<div class="page-content">

    <h4 class="card-title mb-3">Marketing Tools</h4>


    <div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Add Marketing Tool</h4>
        <a href="{{ route('admin.marketing-tools.create') }}" class="btn btn-primary">Add New Tool</a>
    </div>
</div>


    <div class="row">
        @foreach ($groupedTools as $toolType => $tools)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $toolType }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($tools as $tool)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3 logo text-center">
                                                <img 
                                                    src="{{ asset('uploads/' . $tool->name . '.png') }}" 
                                                    alt="{{ $tool->name }}" 
                                                    class="img-fluid">
                                            </div>
                                            <p><strong>Identifier:</strong> {{ $tool->identifier }}</p>
                                            <p><strong>Script:</strong></p>
                                            <textarea class="form-control" readonly>{{ $tool->script }}</textarea>
                                            <div class="mt-3 text-center">
                                                <a href="{{ route('admin.marketing-tools.edit', $tool) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('admin.marketing-tools.destroy', $tool) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
