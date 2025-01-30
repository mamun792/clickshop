@extends('admin.master')

@section('main-content')
<div class="page-content p-4">
    <div class="card shadow-sm border-0">
        <div class="card-header  py-3">
            <h5 class="card-title mb-0 fs-5 fw-medium">Balance Transfer</h5>
        </div>
        <div class="card-body p-4">
            <form id="balanceTransferForm" action="{{ route('admin.account.balance-transfer') }}" method="POST">
                @csrf
                <!-- From Account -->
                <div class="row mb-4 align-items-center">
                    <label for="from_balance" class="col-sm-3 col-form-label fw-medium">From Account</label>
                    <div class="col-sm-9">
                        <select id="from_balance" name="from_balance" class="form-select form-select-lg">
                            <option value="">Select Source Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->total_amount }}">
                                    {{ $account->name }} ({{$account->total_amount }})
                                </option>
                            @endforeach
                        </select>
                        <div id="from_balance_error" class="invalid-feedback d-block"></div>
                    </div>
                </div>

                <!-- To Account -->
                <div class="row mb-4 align-items-center">
                    <label for="to_balance" class="col-sm-3 col-form-label fw-medium">To Account</label>
                    <div class="col-sm-9">
                        <select id="to_balance" name="to_balance" class="form-select form-select-lg">
                            <option value="">Select Destination Account</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->total_amount }}">
                                    {{ $account->name }} ({{ $account->total_amount }})
                                </option>
                            @endforeach
                        </select>
                        <div id="to_balance_error" class="invalid-feedback d-block"></div>
                    </div>
                </div>

                <!-- Amount Fields -->
                <div class="bg-light p-4 rounded-3 mb-4">
                    <!-- Amount -->
                    <div class="row mb-3 align-items-center">
                        <label for="amount" class="col-sm-3 col-form-label fw-medium">Transfer Amount</label>
                        <div class="col-sm-9">
                            <input type="number" id="amount" name="amount"
                                   class="form-control form-control-lg"
                                   placeholder="Enter amount"
                                   value="0">
                            <div id="amount_error" class="invalid-feedback d-block"></div>
                        </div>
                    </div>

                    <!-- Cost -->
                    <div class="row mb-3 align-items-center">
                        <label for="cost" class="col-sm-3 col-form-label fw-medium">Transfer Fee</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="number" id="cost" name="cost"
                                       class="form-control form-control-lg"
                                       placeholder="Enter fee"
                                       value="0">
                                <span class="input-group-text bg-white">%</span>
                            </div>
                            <div id="cost_error" class="invalid-feedback d-block"></div>
                        </div>
                    </div>

                    <!-- Net Amount -->
                    <div class="row align-items-center">
                        <label for="transfer_amount" class="col-sm-3 col-form-label fw-medium">Net Amount</label>
                        <div class="col-sm-9">
                            <input type="number" id="transfer_amount" name="transfer_amount"
                                   class="form-control form-control-lg bg-light"
                                   value="0"
                                   readonly>
                        </div>
                    </div>
                </div>

                <!-- Comment -->
                <div class="row mb-4 align-items-center">
                    <label for="comment" class="col-sm-3 col-form-label fw-medium">Notes</label>
                    <div class="col-sm-9">
                        <textarea id="comment" name="comment"
                                  class="form-control form-control-lg"
                                  rows="2"
                                  placeholder="Add transfer notes"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-5">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-1">
                            <i class="bi bi-arrow-left-right me-2"></i>Confirm Transfer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enhanced validation with real-time feedback
    document.getElementById('balanceTransferForm').addEventListener('submit', function(event) {
        event.preventDefault();
        clearErrors();

        const elements = {
            from: document.getElementById('from_balance'),
            to: document.getElementById('to_balance'),
            amount: document.getElementById('amount'),
            cost: document.getElementById('cost')
        };

        let isValid = true;

        // Validation checks
        if (elements.from.value === elements.to.value) {
            showError('to_balance_error', 'Source and destination accounts must be different');
            isValid = false;
        }

        if (elements.amount.value <= 0 || isNaN(elements.amount.value)) {
            showError('amount_error', 'Please enter a valid transfer amount');
            isValid = false;
        }

        if (parseFloat(elements.from.options[elements.from.selectedIndex]?.dataset.balance) < elements.amount.value) {
            showError('amount_error', 'Insufficient balance in source account');
            isValid = false;
        }

        if (isValid) this.submit();
    });

    // Real-time amount calculation
    function updateTransferAmount() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    const cost = parseFloat(document.getElementById('cost').value) || 0;

    const transferAmount = amount - cost; // Deducting flat cost
    document.getElementById('transfer_amount').value = transferAmount.toFixed(2);
}


    // Helper functions
    function clearErrors() {
        document.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
    }

    function showError(elementId, message) {
        document.getElementById(elementId).innerText = message;
    }

    // Event listeners
    document.getElementById('amount').addEventListener('input', updateTransferAmount);
    document.getElementById('cost').addEventListener('input', updateTransferAmount);
</script>
@endpush
