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
                <h6 class=" fw-bold">Contact Number: {{ $customer->mobile_number ?? 'Not Available' }} @if (!$customer->mobile_number)
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add?
                    </a>
                    
                    @endif
                </h6>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <!--Address Form Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact Details Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.contact') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="customerId" id="modalCustomerId" value={{ $customer->id }}>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+91</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter mobile number" name="mobile_number"
                                    id="mobile_number" aria-describedby="basic-addon1">
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

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    



@endsection
