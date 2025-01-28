@extends('admin.master')

@section('main-content')
<div class="page-content">
 

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Balance Transfer</h5>
        </div>
        <div class="card-body">
            <form id="balanceTransferForm" action="{{ route('admin.account.balance-transfer') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="from_balance" class="col-sm-2 col-form-label">From</label>
                    <div class="col-sm-10">
                        <select id="from_balance" name="from_balance" class="form-select">
                            <option value="">Select Balance</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}">{{ $account->name }} ({{ $account->balance }})</option>
                            @endforeach
                        </select>
                        <div id="from_balance_error" class="text-danger"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="to_balance" class="col-sm-2 col-form-label">To</label>
                    <div class="col-sm-10">
                        <select id="to_balance" name="to_balance" class="form-select" >
                            <option value="">Select Balance</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}">{{ $account->name }} ({{ $account->balance }})</option>
                            @endforeach
                        </select>
                        <div id="to_balance_error" class="text-danger"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                    <div class="col-sm-10">
                        <input type="number" id="amount" name="amount" class="form-control" value="0" >
                        <div id="amount_error" class="text-danger"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="cost" class="col-sm-2 col-form-label">Cost </label>
                    <div class="col-sm-10">
                        <input type="number" id="cost" name="cost" class="form-control" value="0" >
                        <div id="cost_error" class="text-danger"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="transfer_amount" class="col-sm-2 col-form-label">Transfer Amount</label>
                    <div class="col-sm-10">
                        <input type="number" id="transfer_amount" name="transfer_amount" class="form-control" value="0" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="comment" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-10">
                        <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Transfer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    // Validate form on submit
    document.getElementById('balanceTransferForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Reset error messages
    document.getElementById('from_balance_error').innerText = '';
    document.getElementById('to_balance_error').innerText = '';
    document.getElementById('amount_error').innerText = '';
    document.getElementById('cost_error').innerText = '';

    // Get form data
    const fromBalanceSelect = document.getElementById('from_balance');
    const toBalanceSelect = document.getElementById('to_balance');
    const amount = parseFloat(document.getElementById('amount').value);
    const cost = parseFloat(document.getElementById('cost').value);

    const fromBalanceId = fromBalanceSelect.value;
    const toBalanceId = toBalanceSelect.value;

    const fromBalance = fromBalanceSelect.options[fromBalanceSelect.selectedIndex]?.dataset.balance;
    const toBalance = toBalanceSelect.options[toBalanceSelect.selectedIndex]?.dataset.balance;

    let isValid = true;

    // 1. From and To balance should not be the same
    if (fromBalanceId === toBalanceId) {
        document.getElementById('to_balance_error').innerText = 'The "From" and "To" balances cannot be the same.';
        isValid = false;
    }

    // 2. Check if the amount is valid and positive
    if (isNaN(amount) || amount <= 0) {
        document.getElementById('amount_error').innerText = 'Please enter a valid amount greater than zero.';
        isValid = false;
    }

    // 3. Check if the transfer amount is valid based on the balance of the "From" account
    if (parseFloat(fromBalance) < amount) {
        document.getElementById('amount_error').innerText = 'Insufficient balance to transfer.';
        isValid = false;
    }

    // If form is valid, proceed with the transfer
    if (isValid) {
        this.submit(); // Submit the form
    }
});




    // Update transfer amount based on amount and cost percentage
    document.getElementById('amount').addEventListener('input', updateTransferAmount);
    document.getElementById('cost').addEventListener('input', updateTransferAmount);

    function updateTransferAmount() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const cost = parseFloat(document.getElementById('cost').value) || 0;

        const transferAmount = amount - cost ;
        document.getElementById('transfer_amount').value = transferAmount.toFixed(2);
    }
</script>


@endpush
