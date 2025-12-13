@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Title --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">KYC Review</h4>
        <a href="{{ route('admin.kyc.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">

        {{-- LEFT: User & KYC Info --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">User Information</h6>

                    <table class="table table-sm table-borderless mb-4">
                        <tr>
                            <th class="text-muted">Name</th>
                            <td>{{ $kyc->user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Email</th>
                            <td>{{ $kyc->user->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Mobile</th>
                            <td>{{ $kyc->user->mobile }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Submitted</th>
                            <td>{{ $kyc->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Current Status</th>
                            <td>
                                <span class="badge
                                    {{ $kyc->status === 'approved' ? 'bg-success' :
                                       ($kyc->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($kyc->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <h6 class="fw-bold mb-2">Document Info</h6>
                    <p class="mb-1">
                        <strong>NID / Passport No:</strong><br>
                        {{ $kyc->nid_passport_number }}
                    </p>

                    @if($kyc->note)
                        <div class="alert alert-light border mt-3">
                            <small class="text-muted">Admin Note</small>
                            <div>{{ $kyc->note }}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="col-lg-8">

            {{-- Documents --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">KYC Documents</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-2 text-center bg-light">
                                <small class="text-muted d-block mb-1">NID / Passport Front</small>
                                <a href="{{ asset('storage/'.$kyc->nid_passport_front) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$kyc->nid_passport_front) }}"
                                         class="img-fluid rounded"
                                         style="max-height: 220px; object-fit: contain;">
                                </a>
                            </div>
                        </div>

                        @if($kyc->nid_back)
                        <div class="col-md-6">
                            <div class="border rounded p-2 text-center bg-light">
                                <small class="text-muted d-block mb-1">NID Back</small>
                                <a href="{{ asset('storage/'.$kyc->nid_back) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$kyc->nid_back) }}"
                                         class="img-fluid rounded"
                                         style="max-height: 220px; object-fit: contain;">
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <div class="border rounded p-2 text-center bg-light">
                                <small class="text-muted d-block mb-1">Selfie</small>
                                <a href="{{ asset('storage/'.$kyc->selfie) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$kyc->selfie) }}"
                                         class="img-fluid rounded"
                                         style="max-height: 220px; object-fit: contain;">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Action --}}
            <div class="card shadow-sm">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">KYC Action</h6>

                    @if($kyc->status === 'approved')
                        <div class="alert alert-success">
                            <i class="fas fa-lock me-1"></i>
                            This KYC is already approved and cannot be modified.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.kyc.update', $kyc->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status"
                                    class="form-select"
                                    {{ $kyc->status === 'approved' ? 'disabled' : '' }}>
                                <option value="pending" {{ $kyc->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $kyc->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $kyc->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Admin Note</label>
                            <textarea name="note"
                                      rows="4"
                                      class="form-control"
                                      {{ $kyc->status === 'approved' ? 'readonly' : '' }}
                                      placeholder="Reason / remarks...">{{ old('note', $kyc->note) }}</textarea>
                        </div>

                        @if($kyc->status !== 'approved')
                            <button class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Update KYC
                            </button>
                        @endif
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
