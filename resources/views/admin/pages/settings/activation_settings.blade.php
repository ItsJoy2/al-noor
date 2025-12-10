@extends('admin.layouts.app')

@section('content')
<div class="container w-50 bg-warning p-3">
    <h2>Activation Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.activation-settings.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Activation Amount ($)</label>
            <input type="number" step="0.01" name="activation_amount" value="{{ $setting->activation_amount }}" class="form-control">
        </div>

        <div class="mb-3">
            <label> Activation Bonus (Token) <i class="fas fa-info-circle text-secondary"  data-bs-toggle="tooltip" data-bs-placement="right" title="Activation bonus is received when first time activate."> </i> </label>
            <input type="number" step="0.01" name="activation_bonus" value="{{ number_format($setting->activation_bonus, 2, '.', '') }}" class="form-control">
        </div>


        <div class="mb-3">
            <label>Referral Bonus (%)</label>
            <input type="number" step="0.01" name="referral_bonus" value="{{ $setting->referral_bonus }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Activation Duration (Months)</label>
            <input type="number" name="activation_duration_months" min="1" value="{{ $setting->activation_duration_months ?? '' }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>


@endpush
