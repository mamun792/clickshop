@extends('admin.master')

@section('main-content')
<div class="page-content">


    <div class="row">
        <div class="card" id="purchaseFormDiv">
            <div class="container-fluid px-4">
                <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
                    {{-- Header --}}
                    <div class="card-header bg-gradient-primary text-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                        <a href="{{ url()->previous() }}" class="btn btn-light btn-sm d-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back
                        </a>
                        <h5 class="mb-0 fw-bold">Update Purchased Items</h5>
                    </div>

                    <div class="card-body p-4">
                        @forelse ($products as $product)
                        <form action="{{ route('admin.purchase.update.purchase') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="product-section mb-4 border rounded-lg p-3 bg-white shadow-sm">
                                {{-- Product Header --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="w-75">
                                        <h6 class="mb-1 fw-bold text-primary text-truncate">
                                            <i class="fas fa-cube me-2"></i>
                                            {{ $product->product_name }}
                                            <span class="badge bg-primary ms-2">
                                                {{ $product->product_code }}
                                            </span>
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted">
                                                Base Price:
                                                <span class="text-success fw-bold">
                                                    {{ number_format($product->price, 2) }}
                                                </span>
                                            </small>
                                            <span class="mx-2">|</span>
                                            <small class="text-muted">
                                                Total Variations: {{ $product->attributes->count() }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success fs-6 py-2 px-3">
                                            <i class="fas fa-coins me-2"></i>
                                            {{ number_format($product->price, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                {{-- Attributes Table --}}
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center text-uppercase text-primary bg-light" style="width: 25%">Attribute</th>
                                                <th class="text-center text-uppercase text-primary bg-light" style="width: 20%">Variant</th>
                                                <th class="text-center text-uppercase text-primary bg-light" style="width: 20%">Quantity</th>
                                                <th class="text-center text-uppercase text-primary bg-light" style="width: 20%">Unit Price</th>
                                                <th class="text-center text-uppercase text-primary bg-light" style="width: 15%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($product->attributes as $attribute)
                                                <tr class="attribute-row">
                                                    <td class="text-center fw-medium text-secondary">
                                                        {{ $attribute->attribute->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info ">
                                                            {{ $attribute->option->name }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-inline-flex align-items-center">
                                                            <input type="hidden" name="attribute_ids[]" value="{{ $attribute->id }}">
                                                            <input type="number"
                                                                   value="{{ $attribute->quantity }}"
                                                                   class="form-control form-control-lg input-quantity text-center"
                                                                   name="quantities[]"
                                                                   min="1"
                                                                   style="width: 100px"
                                                                   required>
                                                            <span class="mx-2 text-muted d-none d-md-inline">×</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group input-group-lg" style="width: 150px">
                                                            <span class="input-group-text bg-transparent border-end-0">৳</span>
                                                            <input type="number"
                                                                   value="{{ number_format($attribute->price, 2) }}"
                                                                   class="form-control border-start-0 text-end calculate-total"
                                                                   name="prices[]"
                                                                   step="0.01"
                                                                   min="0.01"
                                                                   required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center fw-bold text-success fs-5">
                                                        ৳<span class="attribute-total">{{ number_format($attribute->quantity * $attribute->price, 2) }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        <i class="fas fa-exclamation-circle me-2"></i>
                                                        No attributes found for this product
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <div class="card-footer bg-white p-4 d-flex justify-content-end border-top">
                                <button type="submit" class="btn btn-primary btn-lg  py-3">
                                    <i class="fas fa-save me-2"></i>
                                    Update {{ $product->product_name }}
                                </button>
                            </div>
                        </form>
                        @empty
                            <div class="alert alert-primary text-center py-4" role="alert">
                                <i class="fas fa-box-open fa-2x mb-3"></i>
                                <h4 class="alert-heading">No Purchased Products Found</h4>
                                <p>Start by adding products to your inventory.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate totals when quantity or price changes
    document.querySelectorAll('.calculate-total').forEach(input => {
        input.addEventListener('input', function() {
            const row = this.closest('.attribute-row');
            const quantity = row.querySelector('input[name="quantities[]"]').value;
            const price = row.querySelector('input[name="prices[]"]').value;
            const totalCell = row.querySelector('.attribute-total');

            const total = (parseFloat(quantity) || 0) * (parseFloat(price) || 0);
            totalCell.textContent = total.toFixed(2);

            updateSubtotal(row.closest('form'));
        });
    });

    function updateSubtotal(form) {
        let subtotal = 0;
        form.querySelectorAll('.attribute-row').forEach(row => {
            const total = parseFloat(row.querySelector('.attribute-total').textContent) || 0;
            subtotal += total;
        });

        const productId = form.querySelector('input[name="product_id"]').value;
        const subtotalElement = form.querySelector(`#subtotal-${productId}`);
        if(subtotalElement) {
            subtotalElement.textContent = subtotal.toFixed(2);
        }
    }
});
</script>
@endpush
