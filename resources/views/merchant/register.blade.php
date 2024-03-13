<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('admin/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('admin/assets/css/styles.min.css') }}" />
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
                                <p class="text-center">Merchant Registration Panel</p>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('merchant.register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Shop Name:</label>
                                        <input type="text" class="form-control" id="shopName"
                                            aria-describedby="shopName" name="shopName" required>
                                        @error('shopName')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email:</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" name="email" required>
                                        @error('email')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded"
                                        value="Sign In">

                                    <div class="text-center"> OR
                                    </div>
                                    <!-- Google Sign-In button -->
                                    <div class="mb-3">
                                        <a href="{{route('merchantLogin.via.google')}}" class="btn btn-danger w-100 py-2 fs-4 mb-4 rounded">Sign In with Google</a>
                                    </div>
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
    <!-- Include Google Sign-In JavaScript SDK -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

    <script>
        function signInWithGoogle() {
            // Initialize Google Sign-In with your client ID
            gapi.load('auth2', function() {
                var auth2 = gapi.auth2.init({
                    client_id: 508521453672-ik31hp01r7ie5pdo0ndi67ep8e3490s2.apps.googleusercontent.com
                });

                // Start the sign-in process
                auth2.signIn().then(function(googleUser) {
                    var profile = googleUser.getBasicProfile();
                    var id_token = googleUser.getAuthResponse().id_token;

                    var shopName = document.getElementById("shopName").value;
                    var email = profile.getEmail();

                    // Send the user's information (shopName, email, and id_token) to your server for registration
                    var formData = new FormData();
                    formData.append('shopName', shopName);
                    formData.append('email', email);
                    formData.append('id_token', id_token);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{route('merchant.register.viaGoogle')}}, true);
                    xhr.onload = function() {
                        // Handle response from your server
                        if (xhr.status === 200) {
                            // Registration successful, redirect or show a success message
                            window.location.href = "{{ route('merchant.dashboard') }}";
                        } else {
                            // Registration failed, handle error
                            console.error('Registration failed:', xhr.responseText);
                        }
                    };
                    xhr.send(formData);
                }).catch(function(error) {
                    // Handle sign-in errors
                    console.error('Sign-in error:', error);
                });
            });
        }
    </script>

</body>

</html>
