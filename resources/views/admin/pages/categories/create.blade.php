@extends('admin.layouts.app')

@section('content')
<div class="p-5">
    <h4>Create New Pair</h4>
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.pages.categories.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
