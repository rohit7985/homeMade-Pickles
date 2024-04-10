@extends('layouts.main')
@section('title', 'Login')
@section('main-content')

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('otpExpr'))
                        <div class="alert alert-danger">
                            {{ session('otpExpr') }}
                            <p>Click Here to <a href="{{ route('resend.otp', session('user')->id) }}">resend OTP</a></p>
                        </div>
                    @endif
                    @if ($errors->has('otp'))
                        <div class="alert alert-danger">
                            <p>{{ $errors->first('otp') }}</p>
                        </div>
                    @endif

                    <h1 class="mb-5 display-3 text-primary">100% Organic Pickles</h1>
                    @if (isset($user))
                        <form action="{{ route('otp.verify') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value={{ $user->id }}>
                            <div class="position-relative mx-auto mb">
                                <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    type="email" name="email" placeholder="Enter Email" value={{ $user->email }}>
                            </div>
                            <div class="position-relative mx-auto mb">
                                <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    name="otp" type="text" placeholder="Enter OTP">
                            </div>
                            <div class="position-relative mx-auto mb">
                                <input class="btn border border-secondary text-primary rounded-pill px-4 py-3"
                                    type="submit" value="Verify OTP">
                            </div>
                        </form>
                    @else
                        <h3 id="emailError" style="display: none; color: red;">Please enter a valid email.</h3>
                        <h3 id="passwordError" style="display: none; color: red;">Password must be at least 8 characters.
                        </h3>

                        <form id="" action="{{ route('user.login') }}" method="post">
                            @csrf
                            <div class="position-relative mx-auto mb">
                                <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    type="email" name="email"
                                    placeholder="Enter Email"><!-- 'required' attribute for HTML5 email validation -->
                            </div>
                            <div class="position-relative mx-auto mb">
                                <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    name="password" type="password"
                                    placeholder="Enter Password"><!-- 'required' attribute for password validation -->
                            </div>
                            <div class="position-relative mx-auto mb">
                                <input class="btn border border-secondary text-primary rounded-pill px-4 py-3"
                                    type="submit" value="Login">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Forgot Password?
                                </a>
                            </div>
                        </form>
                    @endif
                    <h4 class=" text-secondary">Don't have an account? <a
                            href="{{ route('view.registration') }}">Registration</a></h4>
                </div>

                <!--Address Form Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Contact Details Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('send.resetPasswordLink') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="mobile_number" class="form-label">Email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Email"
                                                name="email" id="email" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ url('asset/img/hero-img-1.png') }}"
                                    class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ url('asset/img/hero-img-2.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            emailError.style.display = 'none'; // Hide error messages by default
            passwordError.style.display = 'none';

            if (email === '') {
                event.preventDefault();
                emailError.style.display = 'block'; // Show email error message
            } else if (!isValidEmail(email)) {
                event.preventDefault();
                emailError.style.display = 'block'; // Show invalid email format message
            }

            if (password === '') {
                event.preventDefault();
                passwordError.style.display = 'block'; // Show password error message
            } else if (password.length < 8) {
                event.preventDefault();
                passwordError.style.display = 'block'; // Show password length error message
            }
        });

        function isValidEmail(email) {
            // Regular expression for basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>
