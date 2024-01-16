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
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif
            @include('customer.customerNav')
            <h4 class="mb-5 fw-bold">Personal Details:</h4>
            <div class="row g-4">
                    <h6 class=" fw-bold">Name: {{ $customer->name }}</h6>
                    <h6 class=" fw-bold">Email: {{ $customer->email }}</h6>
                    <h6 class=" fw-bold">Contact Number: {{ $customer->mobile_number ?? 'Not Available' }}</h6>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

 

@endsection
