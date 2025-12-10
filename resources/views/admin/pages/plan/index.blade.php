@extends('admin.layouts.app')

@section('content')
    {{-- SweetAlert success message --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Share packages</h4>
            <a href="{{ route('admin.plans.create') }}" class="btn btn-success btn-sm">+ Add New Package</a>
        </div>

        <div class="card-body table-responsive">
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="filter" class="form-control">
                            <option value="">-- Filter Packages --</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Amount</th>
                        <th>Total Shares</th>
                        <th>Per Purchase Limit</th>
                        <th>First Installment</th>
                        <th>Monthly Installment</th>
                        <th>Installment Months</th>
                        <th>Activation Charge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $index => $package)
                        <tr>
                            <td>{{ $index + $packages->firstItem() }}</td>
                            <td>{{ $package->share_name }}</td>
                            <td>${{ number_format($package->amount, 2) }}</td>
                            <td>{{ $package->total_share_quantity }}</td>
                            <td>{{ $package->per_purchase_limit }}</td>
                            <td>${{ number_format($package->first_installment, 2) }}</td>
                            <td>${{ number_format($package->monthly_installment, 2) }}</td>
                            <td>{{ $package->installment_months }}</td>
                            <td>${{ number_format($package->activation_charge, 2) }}</td>
                            <td>
                                <span class="badge {{ $package->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.plans.edit', $package->id) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('admin.plans.destroy', $package->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No packages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $packages->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
    </div>
@endsection
