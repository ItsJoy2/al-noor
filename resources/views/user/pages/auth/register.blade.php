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
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    <!-- End layout styles -->
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

    /* input focus sync */
    .form-control:focus + .input-group-append .password-eye {
        background-color: #2a303861;
    }


</style>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
                <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Register</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control text-white p_input" name="name" value="{{ old('name') }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control text-white p_input" name="email" value="{{ old('email') }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" class="form-control text-white p_input" name="mobile" value="{{ old('mobile') }}">
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password"
                                id="password"
                                class="form-control text-white p_input"
                                name="password">

                            <div class="input-group-append">
                                <span class="input-group-text password-eye"
                                    onclick="togglePassword('password', this)">
                                    <i class="mdi mdi-eye-off"></i>
                                </span>
                            </div>
                        </div>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>


                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input type="password"
                                id="password_confirmation"
                                class="form-control text-white p_input"
                                name="password_confirmation">

                            <div class="input-group-append">
                                <span class="input-group-text password-eye"
                                    onclick="togglePassword('password_confirmation', this)">
                                    <i class="mdi mdi-eye-off"></i>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Referral Code (optional)</label>
                        <input type="text" class="form-control text-white p_input" name="referCode" value="{{ old('referCode') }}">
                        @error('referCode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
                    </div>

                    <p class="sign-up text-center">Already have an Account? <a href="{{ route('login') }}">Login</a></p>
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
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/user/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/user/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/user/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/user/js/misc.js') }}"></script>
    <script src="{{ asset('assets/user/js/settings.js') }}"></script>
    <script src="{{ asset('assets/user/js/todolist.js') }}"></script>

    <!-- ... আপনার আগের HTML ... -->

    <script>
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const referCode = getQueryParam('ref');
        if (referCode) {
        const referInput = document.querySelector('input[name="referCode"]');
        if (referInput) {
            referInput.value = referCode;
        }
        }
    });
    </script>
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


    <!-- endinject -->
  </body>
</html>
