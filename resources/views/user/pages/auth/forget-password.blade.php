<!DOCTYPE html>
<html lang="en">
<head>
    @php
        use App\Models\GeneralSetting;
        $generalSettings = GeneralSetting::first();
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | {{ $generalSettings->app_name ?? 'Edulife' }}</title>

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

                        <h4 class="mb-3">Forgot Password?</h4>
                        <p class="text-muted mb-4">
                            Enter your email address and we’ll send you a password reset link.
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

                        <form method="POST" action="{{ route('forgot.password.sent.email') }}">
                            @csrf

                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email"
                                       name="email"
                                       class="form-control text-white p_input"
                                       value="{{ old('email') }}"
                                       required autofocus>
                            </div>

                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-primary btn-block">
                                    Send Password Reset Link
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
<script src="{{ asset('assets/user/vendors/js/vendor.bundle.base.js') }}"></cript>
<script src="{{ asset('assets/user/js/misc.js') }}"></script>

</body>
</html>
