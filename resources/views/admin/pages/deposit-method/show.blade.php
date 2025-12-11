@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h4 class="card-title mb-0">Deposit Method Details</h4>
            <a href="{{ route('admin.deposit_methods.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card-body">
            <!-- Deposit Method Information -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2" class="text-center">Deposit Method Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{ $method->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type</strong></td>
                            <td>{{ ucfirst(str_replace('_', ' ', $method->type)) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge {{ $method->status ? 'badge-success' : 'badge-danger' }}">
                                    {{ $method->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created At</strong></td>
                            <td>{{ $method->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Deposit Method Details -->
            <div class="mt-5">
                <h4 class="mb-4">Method Details:</h4>
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2" class="text-center">Account / Wallet Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $details = $method->details;
                            $accountNumber = $details['account_number'] ?? $details['account'] ?? null;
                            $walletAddress = $details['wallet_address'] ?? null;
                        @endphp

                        @if($accountNumber)
                            <tr>
                                <td><strong>Account Number</strong></td>
                                <td>
                                    {{ $accountNumber }}
                                    <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy-target="account-number" title="Copy">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <span id="account-number" class="d-none">{{ $accountNumber }}</span>
                                </td>
                            </tr>
                        @endif

                        @if($walletAddress)
                            <tr>
                                <td><strong>Wallet Address</strong></td>
                                <td>
                                    {{ $walletAddress }}
                                    <button class="btn btn-sm btn-outline-secondary copy-btn" data-copy-target="wallet-address" title="Copy">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <span id="wallet-address" class="d-none">{{ $walletAddress }}</span>
                                </td>
                            </tr>
                        @endif

                        <!-- Display Other Dynamic Details -->
                        @foreach ($details as $key => $value)
                            @if ($key !== 'account' && $key !== 'wallet_address')
                                <tr>
                                    <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const copyButtons = document.querySelectorAll('.copy-btn');
            copyButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-copy-target');
                    const textToCopy = document.getElementById(targetId).innerText;
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Method details copied to clipboard!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }).catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to copy!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    });
                });
            });
        });
    </script>
@endsection
