@extends('layouts.main')
@section('title', 'My Profile')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">My Profile</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">My Profile</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><a href="">My Profile</a></th>
                            <th scope="col"><a href="">My Order</a></th>
                            <th scope="col"><a href="">Payment</a></th>
                            <th scope="col"><a href="">Reviews & Ratings</a></th>
                          </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
