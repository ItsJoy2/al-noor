@extends('admin.layouts.app')

@section('title', 'App Settings')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex align-items-center">
                <i class="fas fa-cog me-2"></i>
                <h5 class="mb-0">App Settings</h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.general.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="app_name" class="form-label">App Name</label>
                        <input type="text" id="app_name" name="app_name"
                            value="{{ old('app_name', $generalSettings->app_name) }}"
                            required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="favicon" class="form-label">Favicon (200x200px)</label>
                        <input type="file" id="favicon" name="favicon" class="form-control">
                        @if(isset($generalSettings->favicon))
                            <div class="mt-2 d-flex align-items-center">
                                <img src="{{ asset('storage/' . $generalSettings->favicon) }}"
                                    alt="Current Favicon" class="img-thumbnail" style="width:32px; height:32px;">
                                <span class="ms-2">Current favicon</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo (300x45px)</label>
                        <input type="file" id="logo" name="logo" class="form-control">
                        @if(isset($generalSettings->logo))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $generalSettings->logo) }}"
                                    alt="Current Logo" class="img-fluid" style="max-width:300px; max-height:45px;">
                                <span class="ms-2">Current logo</span>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Update Settings</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
