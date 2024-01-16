@extends('layouts.main')
@section('title', 'Customer Address')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Customer Address</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Customer Address</li>
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
           <h4 class="mb-5 fw-bold">Customer Address</h4>
           <div class="row g-4">
            <div class="col-lg-12">
                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add a New Address</a>

                <!--Address Form Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('address.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="customer" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mobile_num" class="col-form-label">Mobile Number</label>
                                        <input type="text" class="form-control"
                                            name="mobile_num" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pincode" class="col-form-label">Pin Code</label>
                                        <input type="number" class="form-control" name="pincode"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Address(Area &
                                            Street)</label>
                                        <textarea class="form-control" name="address" required></textarea>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Address</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                 <!--Edit Address Form Modal -->
                 <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                 <div class="modal-dialog">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                             <form action="{{ route('address.update') }}" method="POST">
                                 @csrf
                                 <input type="hidden" name="address_id" id="addressId">
                                 <div class="mb-3">
                                     <label for="customer" class="col-form-label">Name</label>
                                     <input type="text" class="form-control" id="name" name="name"
                                         required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="mobile_num" class="col-form-label">Mobile Number</label>
                                     <input type="text" class="form-control" id="mobile_num"
                                         name="mobile_num" required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="pincode" class="col-form-label">Pin Code</label>
                                     <input type="number" class="form-control" id="pincode" name="pincode"
                                         required>
                                 </div>
                                 <div class="mb-3">
                                     <label for="message-text" class="col-form-label">Address(Area &
                                         Street)</label>
                                     <textarea class="form-control" id="address" name="address" required></textarea>
                                 </div>

                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary"
                                 data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary">Save changes</button>
                         </div>
                         </form>
                     </div>
                 </div>
             </div>

            </div>
            @foreach ($addresses as $address)
                <div class="row g-4">
                    <div class="col-lg-10">
                        <div class="border-bottom rounded">
                            <h6 class=" fw-bold">Name: {{ $address->name }}</h6>
                            <h6 class=" fw-bold">Pincode: {{ $address->pincode }}</h6>
                            <h6 class=" fw-bold">Address: {{ $address->address }}</h6>
                            <h6 class=" fw-bold">Contact Number: {{ $address->mobile_num ?? 'Not Available' }}
                            </h6>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <a href="#" class="fw-semibold mb-0 fs-4" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="false"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="#" class="fw-semibold mb-0 fs-4 delete-address"
                                        data-address-id="{{ $address->id }}">
                                        <i class="fa fa-trash pd-l" aria-hidden="true"></i>Delete
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="fw-semibold mb-0 fs-4 edit-address" data-bs-toggle="modal" data-bs-target="#editAddressModal" data-address-id="{{ $address->id }}">
                                        <i class="fas fa-pencil-alt pd-l"></i> Edit
                                    </a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.delete-address', function(e) {
            e.preventDefault();
            var addressId = $(this).data('address-id');
            $.ajax({
                url: '/customer/address/' + addressId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    <script>
$(document).ready(function () {
    $('.edit-address').click(function (e) {
        e.preventDefault();
        var addressId = $(this).data('address-id');
        $.ajax({
            url: '/customer/edit-address/' + addressId,
            method: 'GET',
            success: function (data) {
                $('#addressId').val(data.id);
                $('#name').val(data.name);
                $('#mobile_num').val(data.mobile_num);
                $('#pincode').val(data.pincode);
                $('#address').val(data.address);
            },
            error: function (error) {
                console.error('Error fetching address data:', error);
            }
        });
    });
});
</script>
@endsection
