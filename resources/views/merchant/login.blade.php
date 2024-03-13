<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Merchant Login Panel')</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('admin/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('admin/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ url('admin/assets/css/main.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                                </a>
                                <p class="text-center">Merchant Login Panel</p>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-success">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @error('email')
                                    <span>{{ $message }}</span>
                                @enderror
                                <form method="POST" action="{{ route('merchant.login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                                            <span class="input-group-text" id="togglePassword">
                                                <i class="fa fa-eye" aria-hidden="false" id="eyeIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded" value="Sign In">
                                    <div class="text-center"> OR
                                    </div>
                                    <!-- Google Sign-In button -->
                                    <div class="mb-3 mt22">
                                        <a href="{{route('merchantLogin.via.google')}}" class="btn btn-danger w-100 py-2 fs-4 mb-4 rounded">Sign In with Google</a>
                                    </div>
                                    <a class="text-primary fw-bold" href="{{route('merchant.registration')}}">Don't have an account? Register</a>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        const passwordInput = document.getElementById('exampleInputPassword1');
        const eyeIcon = document.getElementById('eyeIcon');
    
        eyeIcon.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
    
            // Toggle eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>
