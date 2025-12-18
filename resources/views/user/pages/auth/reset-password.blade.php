<!DOCTYPE html>
<html lang="en">
<head>
    @php
        use App\Models\GeneralSetting;
        $generalSettings = GeneralSetting::first();
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | {{ $generalSettings->app_name ?? 'Edulife' }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/user/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">

    <!-- favicon -->
    @if($generalSettings && $generalSettings->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $generalSettings->favicon) }}">
    @endif
</head>

<style>
    .card{
        background-color: #5353533b;
        box-shadow: 0 4px 12px rgba(0,0,0,.7);
    }
    .form-control{
        background-color: #70737f69;
    }
    .form-control:focus{
        background-color: #2a303861;
        border: 1px solid rgb(18 215 18 / 50%);
    }
    .input-group-text.password-eye{
        background-color: #70737f69;
        border: none;
        cursor: pointer;
    }
    .input-group-text.password-eye i{
        color: #ccc;
        font-size: 18px;
    }
    .input-group-text.password-eye:hover i{
        color: #fff;
    }
    .back-login{
        color: #d19d11;
        font-size: 14px;
        text-decoration: none;
    }
    .back-login:hover{
        text-decoration: underline;
    }
    .text-muted{
        color: #d0d0d0 !important;
    }
</style>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                    <div class="card-body px-5 py-5">

                        <h4 class="mb-3">Reset Password</h4>
                        <p class="text-muted mb-4">
                            Enter the verification code sent to your email and choose a new password.
                        </p>

                        {{-- Success message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('reset.password') }}">
                            @csrf

                            <input type="hidden" name="email"
                                   value="{{ old('email', request('email')) }}" readonly>

                            {{-- Verification Code --}}
                            <div class="form-group">
                                <label>Verification Code *</label>
                                <input type="text"
                                       name="code"
                                       class="form-control text-white p_input"
                                       value="{{ old('code') }}"
                                       required>
                                @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="form-group">
                                <label>New Password *</label>
                                <div class="input-group">
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control text-white p_input"
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text password-eye"
                                              onclick="togglePassword('password', this)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="form-group">
                                <label>Confirm Password *</label>
                                <div class="input-group">
                                    <input type="password"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           class="form-control text-white p_input"
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text password-eye"
                                              onclick="togglePassword('password_confirmation', this)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-success btn-block">
                                    Reset Password
                                </button>
                            </div>
                        </form>

                        <div class="text-right mt-3">
                            <a href="{{ route('login') }}" class="back-login">
                                ← Back to Login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- plugins:js -->
<script src="{{ asset('assets/user/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/user/js/misc.js') }}"></script>

<script>
function togglePassword(inputId, el) {
    const input = document.getElementById(inputId);
    const icon = el.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("mdi-eye-off");
        icon.classList.add("mdi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("mdi-eye");
        icon.classList.add("mdi-eye-off");
    }
}
</script>

</body>
</html>
