@extends('admin.master')

@section('main-content')
<div class="page-content">

    <div class="row gy-4">
        <div class="col-xxl-6 mx-auto">
            <div class="card mb-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">Update Product to This Campaign</h6>
                </div>

                <div class="card-body">
                    <form method="POST"  action="{{route('admin.promotions.update.product.campain',$product->id)}}" >
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="product_idss" value="{{ $product->id }}">
                        <div class="row gy-3 mb-3">
                            <!-- Product Select -->
                            <div class="col-md-6">
                                <label for="product" class="form-label">Select Product</label>
                                <select class="form-control" id="product" name="product_id">
                                    @foreach ($products as $product)
                                   
                                    <option value="{{ $product->id }}" 
                                        @if ($associatedCampaigns->contains(function($campaign) use ($product) {
                                            return $campaign->pivot->product_id == $product->id;
                                        }) ) 
                                            selected 
                                        @endif>
                                        {{ $product->product_name }}

                                        
                                    </option>
                                @endforeach
                                
                                
                                   
                                </select>
                            </div>
                    
                            <!-- Campaign Select -->
                            <div class="col-md-6">
                                <label for="campaign" class="form-label">Select Campaign</label>
                                <select class="form-control" id="campaign" name="campaign_ids[]">
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}"
                                            @if ($associatedCampaigns->contains('id', $campaign->id)) selected @endif>
                                            {{ $campaign->name }}
                                        </option>
                                    @endforeach

                                   
                                </select>
                                
                                @error('campaign_ids')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="col-md-12 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Update Campaign Associations</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection