@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Edit Deposit Method</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.deposit_methods.update', $method->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Method Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $method->name) }}" required>
            </div>

            <div class="form-group">
                <label for="type">Method Type</label>
                <select name="type" id="method-type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <option value="mobile_banking" {{ old('type', $method->type) == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                    <option value="bank" {{ old('type', $method->type) == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="crypto" {{ old('type', $method->type) == 'crypto' ? 'selected' : '' }}>Crypto</option>
                </select>
            </div>

            <div id="details-container">
                <!-- Fields injected dynamically -->
            </div>

            <div class="form-group mt-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $method->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$method->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Method</button>
        </form>
    </div>
</div>

<script>
    const detailsContainer = document.getElementById('details-container');
    const methodType = document.getElementById('method-type');
    const oldDetails = @json($method->details ?? []);

    function renderFields(type) {
        detailsContainer.innerHTML = '';

        if(type === 'mobile_banking') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Account Number / Wallet</label>
                    <input type="text" name="details[account]" class="form-control" value="${oldDetails.account ?? ''}" required>
                </div>
                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="details[name]" class="form-control" value="${oldDetails.name ?? ''}" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="details[description]" class="form-control" rows="3" placeholder="Provide details or description about this mobile banking method">${oldDetails.description ?? ''}</textarea>
                </div>
            `;
        } else if(type === 'bank') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" name="details[bank_name]" class="form-control" value="${oldDetails.bank_name ?? ''}" required>
                </div>
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" name="details[account_number]" class="form-control" value="${oldDetails.account_number ?? ''}" required>
                </div>
                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="details[account_holder]" class="form-control" value="${oldDetails.account_holder ?? ''}" required>
                </div>
            `;
        } else if(type === 'crypto') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Wallet Address</label>
                    <input type="text" name="details[wallet_address]" class="form-control" value="${oldDetails.wallet_address ?? ''}" required>
                </div>
            `;
        }
    }

    methodType.addEventListener('change', function() {
        renderFields(this.value);
    });

    // Prepopulate the fields based on the selected type
    if(methodType.value) {
        renderFields(methodType.value);
    } else if(oldDetails) {
        // If there's no pre-selected value (fallback), determine based on oldDetails
        renderFields(@json($method->type));
    }
</script>
@endsection
