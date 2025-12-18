<!DOCTYPE html>
<html lang="en">
<head>
    @php
        use App\Models\GeneralSetting;
        $generalSettings = GeneralSetting::first();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $generalSettings->app_name ?? 'Edulife ' }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/user/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/vendors/css/vendor.bundle.base.css') }}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    <!-- favicon -->
    @if($generalSettings && $generalSettings->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $generalSettings->favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $generalSettings->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('default-favicon.png') }}">
    @endif
</head>

<style>
    .card{
        background-color: #5353533b;
        box-shadow: 0 4px 12px rgba(0, 0, 0);
    }
    .form-control {
        background-color: #70737f69;
    }
    .form-control:focus{
        background-color: #2a303861;
        border: 1px solid rgb(18 215 18 / 50%);
    }
    .form-check .form-check-label {
        color: #cdcdcd;
    }
    .auth .sign-up a {
        color: #d19d11;
    }
    .input-group-text.password-eye {
        background-color: #70737f69;
        border: none;
        cursor: pointer;
    }

    .input-group-text.password-eye i {
        color: #ccc;
        font-size: 18px;
    }

    .input-group-text.password-eye:hover i {
        color: #fff;
    }

    /* focus time input + icon sync */
    .form-control:focus + .input-group-append .password-eye {
        background-color: #2a303861;
    }
    .forgot-pass {
    font-size: 13px;
    color: #d19d11;
    text-decoration: none;
}

.forgot-pass:hover {
    text-decoration: underline;
    color: #ffd45a;
}


</style>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">User Login</h3>

                            {{-- Show Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Show Flash Messages --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" id="email"
                                           class="form-control text-white p_input"
                                           value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password *</label>

                                    <div class="input-group">
                                        <input type="password"
                                            name="password"
                                            id="password"
                                            class="form-control text-white p_input"
                                            required>

                                        <div class="input-group-append">
                                            <span class="input-group-text password-eye"
                                                onclick="togglePassword('password', this)">
                                                <i class="mdi mdi-eye-off"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right mt-1">
                                        <a href="{{ route('forgot.password') }}"
                                        class="forgot-pass">
                                            Forgot password?
                                        </a>
                                    </div>
                                </div>



                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            Remember me
                                        </label>
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>

                                {{-- Optional Social login --}}
                                {{-- <div class="d-flex mt-3">
                                    <button class="btn btn-facebook mr-2 col">
                                        <i class="mdi mdi-facebook"></i> Facebook
                                    </button>
                                    <button class="btn btn-google col">
                                        <i class="mdi mdi-google-plus"></i> Google plus
                                    </button>
                                </div> --}}

                                <p class="sign-up mt-3">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- plugins:js -->
    <script src="{{ asset('assets/user/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/user/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/user/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/user/js/misc.js') }}"></script>
    <script src="{{ asset('assets/user/js/settings.js') }}"></script>
    <script src="{{ asset('assets/user/js/todolist.js') }}"></script>
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
