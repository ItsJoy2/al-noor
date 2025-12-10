@extends('admin.layouts.app')

@section('content')
<div class="container w-50 bg-warning p-4 rounded">
    <h2>Transfer Settings</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.transfer.settings.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="min_transfer" class="form-label">Minimum Transfer Amount ($)</label>
            <input type="number" step="0.01" name="min_transfer" id="min_transfer"
                   value="{{ old('min_transfer', $settings->min_transfer) }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="max_transfer" class="form-label">Maximum Transfer Amount ($)</label>
            <input type="number" step="0.01" name="max_transfer" id="max_transfer"
                   value="{{ old('max_transfer', $settings->max_transfer) }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" {{ $settings->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$settings->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>
@endsection
