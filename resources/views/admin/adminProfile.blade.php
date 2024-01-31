@extends('admin.layouts.main')
@section('title', 'Admin - Profile Page')
@section('main-content')
    @php
        $counter = 0;
    @endphp
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        <div class="card-body p-4">
                            <h4>Personal Details</h4>
                            <h6>Name: {{ $user->name }}</h6>
                            <h6>Email: {{ $user->email }}<a href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    Edit
                                </a></h6>
                            <h6>Contact: {{ $user->mobile_number ?? 'Not Available' }}</h6>
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
                                                name="email" id="email" value="{{$user->email}}" aria-describedby="basic-addon1">
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
