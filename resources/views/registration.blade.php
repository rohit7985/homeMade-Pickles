@extends('layouts.main')
@section('title', 'Registration Page')
@section('main-content')

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                    <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                    <h3 id="nameError" style="display: none; color: red;">Please enter your name.</h3>
                    <h3 id="emailErrorReg" style="display: none; color: red;">Please enter a valid email.</h3>
                    <h3 id="passwordErrorReg" style="display: none; color: red;">Password must be at least 8 characters.
                    </h3>
                    <form id="registerForm" action="{{ route('users.create') }}" method="post">
                        @csrf
                        <div class="position-relative mx-auto mb">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="name"
                                name="name" placeholder="Enter Name" >
                        </div>
                        <div class="position-relative mx-auto mb">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="email"
                                name="email" placeholder="Enter Email" >
                        </div>
                        <div class="position-relative mx-auto mb">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                name="password" type="password" placeholder="Enter Password" >
                        </div>
                        <div class="position-relative mx-auto mb">
                            <input class="btn border border-secondary text-primary rounded-pill px-4 py-3" type="submit"
                                value="Register">
                        </div>
                    </form>
                    <h4 class=" text-secondary">Already have an account? <a href="{{ route('login.view') }}">Login</a></h4>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const name = document.querySelector('input[name="name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailErrorReg');
            const passwordError = document.getElementById('passwordErrorReg');

            nameError.style.display = 'none'; // Hide error messages by default
            emailError.style.display = 'none';
            passwordError.style.display = 'none';

            if (name === '') {
                event.preventDefault();
                nameError.style.display = 'block'; // Show name error message
            }

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
