@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">All Deposit Methods</h4>
            <a href="{{ route('admin.deposit_methods.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Method
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Account Number / Wallet Address</th>
                    {{-- <th>Created At</th> --}}
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($methods as $index => $method)
                    <tr>
                        <td>{{ $index + $methods->firstItem() }}</td>
                        <td>{{ $method->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $method->type)) }}</td>
                        <td class="d-flex align-items-center">
                            @php
                                // Access the 'details' array directly
                                $accountNumber = $method->details['account_number'] ?? $method->details['account'] ?? 'N/A';
                                $walletAddress = $method->details['wallet_address'] ?? 'N/A';
                            @endphp
                            <span id="account-wallet-{{ $method->id }}">
                                {{ $accountNumber !== 'N/A' ? $accountNumber : $walletAddress }}
                            </span>
                            <button class="btn btn-sm copy-btn ms-2" data-copy-target="account-wallet-{{ $method->id }}" title="Copy Account Number / Wallet Address">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                        <td>
                            <span class="badge {{ $method->status ? 'badge-success' : 'badge-danger' }}">
                                {{ $method->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        {{-- <td>{{ $method->created_at?->format('Y-m-d H:i') }}</td> --}}
                        <td>
                            <a href="{{ route('admin.deposit_methods.edit', $method->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.deposit_methods.show', $method->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.deposit_methods.destroy', $method->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this method?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Deposit Methods found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $methods->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
    </div>
@endsection

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
                        text: 'Account number or wallet address copied!',
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
