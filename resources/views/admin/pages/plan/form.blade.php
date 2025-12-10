{{-- $package may or may not be set --}}
<div class="form-group">
    <label>Share Name</label>
    <input type="text" name="share_name" class="form-control @error('share_name') is-invalid @enderror"
           value="{{ old('share_name', $plan->share_name ?? '') }}" required>
    @error('share_name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Amount (৳)</label>
    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
           value="{{ old('amount', isset($plan) ? number_format((float)$plan->amount, 2, '.', '') : '0.00') }}" required>
    @error('amount')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Total Share Quantity</label>
    <input type="number" name="total_share_quantity" class="form-control @error('total_share_quantity') is-invalid @enderror"
           value="{{ old('total_share_quantity', $plan->total_share_quantity ?? 0) }}" required>
    @error('total_share_quantity')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Per Purchase Limit</label>
    <input type="number" name="per_purchase_limit" class="form-control @error('per_purchase_limit') is-invalid @enderror"
           value="{{ old('per_purchase_limit', $plan->per_purchase_limit ?? 0) }}" required>
    @error('per_purchase_limit')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>First Installment (৳)</label>
    <input type="number" step="0.01" name="first_installment" class="form-control @error('first_installment') is-invalid @enderror"
           value="{{ old('first_installment', isset($plan) ? number_format((float)$plan->first_installment, 2, '.', '') : '0.00') }}">
    @error('first_installment')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Monthly Installment (৳)</label>
    <input type="number" step="0.01" name="monthly_installment" class="form-control @error('monthly_installment') is-invalid @enderror"
           value="{{ old('monthly_installment', isset($plan) ? number_format((float)$plan->monthly_installment, 2, '.', '') : '0.00') }}">
    @error('monthly_installment')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Installment Months</label>
    <input type="number" name="installment_months" class="form-control @error('installment_months') is-invalid @enderror"
           value="{{ old('installment_months', $plan->installment_months ?? 0) }}">
    @error('installment_months')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Activation Charge (৳)</label>
    <input type="number" step="0.01" name="activation_charge" class="form-control @error('activation_charge') is-invalid @enderror"
           value="{{ old('activation_charge', isset($plan) ? number_format((float)$plan->activation_charge, 2, '.', '') : '0.00') }}">
    @error('activation_charge')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="active" {{ old('status', $plan->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $plan->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
