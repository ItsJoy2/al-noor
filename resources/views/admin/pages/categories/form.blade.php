{{-- form fields for category --}}
<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category->name ?? '') }}" required>
    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror

    @if (!empty($category->image))
        <img src="{{ asset('public/storage/' . $category->image) }}" alt="Pair Image"
             style="width:40px; height:40px; object-fit:cover; margin-top:5px;">
    @endif
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror">
        <option value="active" {{ old('status', $category->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ old('status', $category->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
