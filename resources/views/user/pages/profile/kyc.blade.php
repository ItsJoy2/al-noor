@extends('user.layouts.app')

@section('userContent')

<div class="container mt-4">
    <h4 class="mb-3">KYC Verification</h4>

    {{-- Alert for success/error --}}
    @include('user.layouts.alert')

    @if($kyc)
        @if($kyc->status === 'rejected')
            {{-- Rejected: show admin note --}}
            <div class="alert alert-danger">
                Your KYC was <strong>Rejected</strong>.
                @if($kyc->note)
                    <br><strong>Rejection Note:</strong> {{ $kyc->note }}
                @endif
            </div>

            {{-- Show resubmission form --}}
            <form action="{{ route('user.kyc.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $kyc->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>NID / Passport Number</label>
                        <input type="text" name="nid_passport_number" class="form-control" value="{{ old('nid_passport_number', $kyc->nid_passport_number) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Front Image</label>
                        <input type="file" name="nid_passport_front" class="form-control bg-transparent" accept="image/*" onchange="previewImage(this,'frontPreview')" required>
                        <img id="frontPreview" class="img-thumbnail mt-2" width="200">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Back Image</label>
                        <input type="file" name="nid_back" class="form-control" accept="image/*" onchange="previewImage(this,'backPreview')">
                        <img id="backPreview" class="img-thumbnail mt-2" width="200">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Selfie</label>
                        <input type="file" name="selfie" class="form-control" accept="image/*" onchange="previewImage(this,'selfiePreview')" required>
                        <img id="selfiePreview" class="img-thumbnail mt-2" width="200">
                    </div>
                </div>

                <button class="btn btn-primary mt-2">Resubmit KYC</button>
            </form>

        @else
            {{-- Pending or Approved: no resubmission, show single alert --}}
                <div class="alert {{ $kyc->status === 'approved' ? 'alert-success' : 'alert-info' }}">
                    Your KYC is currently <strong>
                        {{ $kyc->status === 'approved' ? 'Verified' : ucfirst($kyc->status) }}
                    </strong>. You cannot resubmit.
                </div>

            {{-- Show preview only --}}
            <div class="card mb-4">
                <div class="card-header">Your KYC Submission Preview</div>
                <div class="card-body row">

                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong> {{ $kyc->name }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>NID / Passport Number:</strong> {{ $kyc->nid_passport_number }}
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Front Image:</strong><br>
                        @if($kyc->nid_passport_front)
                            <img src="{{ asset('storage/'.$kyc->nid_passport_front) }}" class="img-thumbnail" width="200">
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Back Image:</strong><br>
                        @if($kyc->nid_back)
                            <img src="{{ asset('storage/'.$kyc->nid_back) }}" class="img-thumbnail" width="200">
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Selfie:</strong><br>
                        @if($kyc->selfie)
                            <img src="{{ asset('storage/'.$kyc->selfie) }}" class="img-thumbnail" width="200">
                        @endif
                    </div>

                </div>
            </div>
        @endif

    @else
        {{-- No KYC submitted yet --}}
        <form action="{{ route('user.kyc.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>NID / Passport Number</label>
                    <input type="text" name="nid_passport_number" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Front Image</label>
                    <input type="file" name="nid_passport_front" class="form-control text-dark" accept="image/*" onchange="previewImage(this,'frontPreview')" required>
                    <img id="frontPreview" class="img-thumbnail mt-2 d-none" width="200">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Back Image</label>
                    <input type="file" name="nid_back" class="form-control" accept="image/*" onchange="previewImage(this,'backPreview')">
                    <img id="backPreview" class="img-thumbnail mt-2 d-none" width="200">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Selfie</label>
                    <input type="file" name="selfie" class="form-control" accept="image/*" onchange="previewImage(this,'selfiePreview')" required>
                    <img id="selfiePreview" class="img-thumbnail mt-2 d-none" width="200">
                </div>
            </div>

            <button class="btn btn-primary mt-2">Submit KYC</button>
        </form>
    @endif
</div>

<script>
function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}
</script>

<style>
  input[type="file"] {
    color: #fff;
    background-color: transparent;
    border: 1px solid #444;
    padding: 0.5rem;
    border-radius: 0.375rem;
  }
  input[type="file"]::file-selector-button {
    background-color: #000000;
    color: #727272;
    border: 1px solid #555;
    padding: 0.675rem 0.75rem;
    border-radius: 0.375rem;
    cursor: pointer;
    margin-right: 0.5rem;
    transition: background-color 0.2s;
  }

  input[type="file"]::file-selector-button:hover {
    color: #000000;
  }

  input[type="file"]::file-selector-button::after {
    content: "Choose file";
    color: #000000;
  }
  .img-thumbnail {
    background-color: #000;
    border: 0px solid #141414;
    padding: 2px;
}
</style>

@endsection
