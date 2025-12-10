@extends('admin.layouts.app')

@section('content')
<div class="p-5">
    <h4>Edit Pair</h4>
    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pages.categories.form', ['category' => $category])
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
