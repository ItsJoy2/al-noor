@extends('user.layouts.app')

@section('userContent')

<div class="page-header">
    <h3 class="page-title">My Profile</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>
</div>

<div class="row">


                @include('user.layouts.alert')

    {{-- Profile Summary & Edit Form --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                {{-- Profile Image Upload --}}
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="text-center position-relative mb-4">
                        <label for="profileImageInput" class="cursor-pointer position-relative d-inline-block">
                            <img
                                src="{{ $user->image ? asset('storage/' . $user->image) : url('assets/profile-icon.png') }}"
                                alt="Profile Image"
                                id="profilePreview"
                                class="rounded-circle shadow bg-secondary border {{ $user->is_active == 1 ? 'border-success' : 'border-secondary' }}"
                                width="130"
                                height="130"
                                style="object-fit: cover; border-width: 3px !important;"
                                onerror="this.src='{{ url('public/assets/profile-icon.png') }}'"
                            >
                            <div class="position-absolute bg-dark text-white rounded-circle" style="bottom: 0; right: 0; padding: 5px 8px; cursor: pointer;">
                                <i class="mdi mdi-camera"></i>
                            </div>
                        </label>
                        <input type="file" name="image" id="profileImageInput" class="d-none" accept="image/*">
                        @error('image') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>



                    {{-- Referral Link --}}
                    <div class="form-group">
                        <label>Referral Link</label>
                        <div class="input-group input-group-sm">
                            <input type="text" readonly class="form-control text-white" value="{{ url('/register?ref=' . $user->refer_code) }}" style="background: none">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-copy" type="button" data-copy="{{ url('/register?ref=' . $user->refer_code) }}">Copy</button>
                            </div>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control text-white">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     {{-- Email --}}
                    <div class="form-group">
                        <label>Email</label>
                        <input readonly type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control text-white" style="background: none">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Mobile --}}
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control text-white">
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control text-white">
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Birthday --}}
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}" class="form-control text-white">
                        @error('birthday') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- NID/Passport --}}
                    <div class="form-group">
                        <label>NID or Passport</label>
                        <input type="text" name="nid_or_passport" value="{{ old('nid_or_passport', $user->nid_or_passport) }}" class="form-control text-white">
                        @error('nid_or_passport') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-3">Change Password</h5>

                <form action="{{ route('user.changePassword') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control text-white">
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control text-white">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control text-white">
                    </div>

                    <button type="submit" class="btn btn-warning mt-2">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

    <script>
        document.querySelectorAll('.btn-copy').forEach(button => {
            button.addEventListener('click', function () {
                const text = this.getAttribute('data-copy');
                navigator.clipboard.writeText(text).then(() => {
                    this.innerText = 'Copied!';
                    setTimeout(() => this.innerText = 'Copy', 2000);
                });
            });
        });

        document.getElementById('profileImageInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('profilePreview');
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

@endpush
