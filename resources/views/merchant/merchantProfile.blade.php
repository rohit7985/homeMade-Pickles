@extends('merchant.layouts.main')
@section('title', 'Merchant - Profile Page')
@section('main-content')
    @php
        $counter = 0;
    @endphp
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="">
                        <div class="card-body p-4">
                            <h4>Personal Details</h4>
                            <h6>Name: {{ $user->merchant->name ?? '' }}</h6><a href="#" data-bs-toggle="modal"
                                data-bs-target="#nameEditModal">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                Edit
                            </a>
                            <h6>Date of birth : {{ $user->merchant->dob ?? '' }}</h6>
                            <h6>Email: {{ $user->email ?? '' }}<a href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    Edit
                                </a></h6>
                            <h6>Contact: {{ $user->mobile_number ?? 'Not Available' }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="">
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
                        <div class="card-body p-4">
                            <h4>Bank Details</h4>
                            @if ($user->merchant)
                                <h6>Bank Name: {{ $user->merchant->bankName ?? '' }}</h6>
                                <h6>IFSC Code: {{ $user->merchant->ifsc_code ?? '' }}</h6>
                                <h6>Account No: {{ $user->merchant->accountNo ?? '' }}<a href="#"
                                        data-bs-toggle="modal" data-bs-target="#editBankDetails">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit
                                    </a></h6>
                                <h6>Contact: {{ $user->merchant->mobile_number ?? 'Not Available' }}</h6>

                                <!-- Display Bank Branches -->
                                @if ($user->merchant->bank)
                                    <h4>Branches</h4>
                                    @foreach ($user->merchant->bank->branches as $branch)
                                        <h6>{{ $branch->name }}</h6>
                                        <!-- Add other branch details as needed -->
                                    @endforeach
                                @endif
                            @else
                                <p>No bank details found</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!--Address Form Modal -->
            <div class="modal fade" id="editBankDetails" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content mt">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Bank Details:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('change.bankDetails') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="merchantId" id="modalCustomerId" value={{ $user->id }}>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Bank Name:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="bankName" id="bankName"
                                            value="{{ $user->merchant->bankName ?? '' }}" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">IFSC Code:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="ifsc_code" id="ifsc_code"
                                            value="{{ $user->merchant->ifsc_code ?? '' }}" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Account Number:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="accNumber" id="accNumber"
                                            value="{{ $user->merchant->accountNo ?? '' }}" aria-describedby="basic-addon1">
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

            <!--Address Form Modal -->
            <div class="modal fade" id="nameEditModal" tabindex="-1" aria-labelledby="nameEditModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content mt">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Personal Data:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('change.personalData') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="customerId" id="modalCustomerId"
                                        value={{ $user->id }}>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Name"
                                            name="name" id="name" value="{{ $user->name ?? '' }}"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Contact Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Mobile Number"
                                            name="mobile_number" id="mobile_number" value="{{ $user->mobile_number ?? '' }}"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Date of Birth</label>
                                    <div class="input-group">
                                        <input type="date" id="dob" name="dob" class="form-control" placeholder="Enter Date of Birth"
                                        name="name" id="name" value="{{ $user->dob ?? '' }}"
                                        aria-describedby="basic-addon1">
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
            <!--Address Form Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content mt">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Email:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('change.email') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="customerId" id="modalCustomerId"
                                        value={{ $user->id }}>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Email"
                                            name="email" id="email" value="{{ $user->email }}"
                                            aria-describedby="basic-addon1">
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
            <div class="col-md-8">
                <div class="">
                    <div class="card-body p-4">
                        {{-- <h4>Address Details</h4>
                            <div class="row">
                                @foreach ($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="card-body p-4">
                                            <h6>{{ $address->address }}- {{ $address->pincode }} </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body p-4">

        </div>
    </div>
    </div>


@endsection
