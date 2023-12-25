@extends('admin.layouts.main')
@section('title', 'Admin - Customers')
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Customers</h5>
                            </div>
                            <div>
                                <a href="" class="btn btn-outline-dark m-1" id="openModal">+ Add Customer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModal">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-body">
                        <p class="text-center">Add Customer By Admin</p>
                        <form method="POST" action={{ route('admin.user.create') }}>
                            @csrf
                            <input type="hidden" name="createdBy" value="Admin">
                            <div class="mb-3">
                                <label for="username" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="username"
                                    aria-describedby="emailHelp" name="name" required>
                                @error('name')
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
                            <div class="mb-4">
                                <label for="exampleInputPassword1" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="exampleInputPassword1"
                                    name="password" required>
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded"
                                value="Add">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('success-delete'))
            <div class="alert alert-success">
                {{ session('success-delete') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Customer Details:</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Id</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Name</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Email</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Mobile Number</h6>
                                        </th>
                                        
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Edit</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Delete</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $customer->name }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $customer->email }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $customer->mobile_number }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                {{-- <a href={{ route('products.edit', $customer->id) }}
                                                    class="fw-semibold mb-0 fs-4">Edit</a> --}}

                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="#" class="fw-semibold mb-0 fs-4 delete-customer"
                                                    data-customer-id="{{ $customer->id }}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <!-- Previous Page Link -->
                                @if ($customers->onFirstPage())
                                    <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                                @else
                                    <a href="{{ $customers->previousPageUrl() }}" class="rounded">&laquo;</a>
                                @endif

                                <!-- Pagination sElements -->
                                @for ($i = 1; $i <= $customers->lastPage(); $i++)
                                    <a href="{{ $customers->url($i) }}"
                                        class="rounded @if ($customers->currentPage() === $i) active @endif">{{ $i }}</a>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($customers->hasMorePages())
                                    <a href="{{ $customers->nextPageUrl() }}" class="rounded">&raquo;</a>
                                @else
                                    <a href="#" class="rounded disabled" aria-disabled="true">&raquo;</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('openModal').addEventListener('click', function(e) {
            e.preventDefault(); 
            var modal = document.getElementById('myModal');
            modal.style.display = 'block'; 
        });
            window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
     <script>
        $(document).on('click', '.delete-customer', function(e) {
            e.preventDefault();
            var customerId = $(this).data('customer-id');
            $.ajax({
                url: '/admin/customer/' + customerId,
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

     {{-- <script>
        $(document).ready(function() {
            $('.toggle-hidden').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).data('product-id');
                var isHidden = $(this).data('hidden');

                // Toggle the hidden status (true/false)
                isHidden = !isHidden;

                $.ajax({
                    url: '/admin/products/toggle-hidden/' + productId,
                    method: 'POST',
                    data: {
                        hidden: isHidden,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var productId = response
                            .productId; // Assuming you have productId in the response
                        var isHidden = response
                            .isHidden; // Assuming you receive the hidden status in the response

                        var iconClass = isHidden ? 'fa fa-eye' : 'fa fa-eye-slash';

                        $('.toggle-hidden[data-product-id="' + productId + '"]')
                            .data('hidden', isHidden)
                            .html('<i class="' + iconClass + '" aria-hidden="false"></i>');

                        location.reload();
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script> --}}

@endsection
