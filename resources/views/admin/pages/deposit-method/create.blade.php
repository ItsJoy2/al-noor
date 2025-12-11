@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Add Deposit Method</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.deposit_methods.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Method Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="type">Method Type</label>
                <select name="type" id="method-type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <option value="mobile_banking" {{ old('type') == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                    <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>Crypto</option>
                </select>
            </div>

            <!-- Dynamic Details -->
            <div id="details-container">
                <!-- Fields will be injected here based on type -->
            </div>

            <div class="form-group mt-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save Method</button>
        </form>
    </div>
</div>
<script>
    const detailsContainer = document.getElementById('details-container');
    const methodType = document.getElementById('method-type');

    function renderFields(type) {
        detailsContainer.innerHTML = '';

        if(type === 'mobile_banking') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Account Number / Wallet</label>
                    <input type="text" name="details[account]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="details[name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="details[description]" class="form-control" rows="3" placeholder="Provide details or description about this mobile banking method"></textarea>
                </div>
            `;
        } else if(type === 'bank') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" name="details[bank_name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" name="details[account_number]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Account Holder Name</label>
                    <input type="text" name="details[account_holder]" class="form-control" required>
                </div>
            `;
        } else if(type === 'crypto') {
            detailsContainer.innerHTML = `
                <div class="form-group">
                    <label>Wallet Address</label>
                    <input type="text" name="details[wallet_address]" class="form-control" required>
                </div>
            `;
        }
    }

    methodType.addEventListener('change', function() {
        renderFields(this.value);
    });

    // prepopulate if old value exists
    if(methodType.value) {
        renderFields(methodType.value);
    }
</script>
@endsection
