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
                                <h5 class="card-title fw-semibold">Merchants</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-outline-dark m-1" id="openModal">+ Add Merchants</a>
                            </div>
                        </div>

                        <form class="row g-3" method="GET" action="{{ route('filter.customer') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Approval Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="" {{ request('status') === null ? 'selected' : '' }}>Select
                                    </option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Disapproved
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ request('name') }}">
                                <div id="searchResults"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email ID</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ request('email') }}">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.orders') }}" class="btn btn-primary ml">Show All</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="myModal">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-body">
                        <p class="text-center">Add Merchant By Admin</p>
                        <form method="POST" action={{ route('admin.user.create') }}>
                            @csrf
                            <input type="hidden" name="createdBy" value="Admin">
                            <div class="mb-3">
                                <label for="username" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="username" aria-describedby="emailHelp"
                                    name="name" required>
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
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                                    required>
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded" value="Add">
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
                        <h5 class="card-title fw-semibold mb-4">Merchants Detail:</h5>
                        <a href="#" class="fw-semibold mb-0 fs-4" data-bs-toggle="dropdown" aria-expanded="false"><i
                                class="fa fa-ellipsis-v" aria-hidden="false"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="#" class="fw-semibold mb-0 fs-4 approve_all_pending">
                                    Approve Pending Status
                                </a>
                            </li>
                        </ul>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Select</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">S.No.</h6>
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
                                            <h6 class="fw-semibold mb-0">Approval Status</h6>
                                        </th>

                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Result Not Found!</h4>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <input type="checkbox" class="approve-checkbox"
                                                        data-customer-id="{{ $customer->id }}">
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">
                                                        {{ $loop->index + $customers->firstItem() }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="{{ route('customer.details', $customer->id) }}"
                                                        class="fw-semibold mb-0">{{ $customer->name }}</a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $customer->email }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $customer->mobile_number }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0"
                                                        style="
                                                    @if ($customer->status == '0') color: blue; /* Change color for Pending */
                                                    @elseif($customer->status == '1')
                                                        color: green; /* Change color for Approved */
                                                    @elseif($customer->status == '2')
                                                        color: red; /* Change color for Disapproved */
                                                    @else
                                                        color: black; /* Default color for unknown status */ @endif
                                                ">
                                                        @if ($customer->status == '0')
                                                            Pending
                                                        @elseif($customer->status == '1')
                                                            Approved
                                                        @elseif($customer->status == '2')
                                                            Disapproved
                                                        @else
                                                            Unknown Status
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0 fs-4"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-ellipsis-v" aria-hidden="false"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 delete-product"
                                                                data-product-id="{{ $customer->id }}">
                                                                <i class="fa fa-trash pd-l" aria-hidden="true"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 change-status"
                                                                data-product-id="{{ $customer->id }}">
                                                                <i class="fa fa-check-square pd-l"
                                                                    aria-hidden="true"></i>Change Status
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 approveAll">
                                                                <i class="fa fa-check-square pd-l"
                                                                    aria-hidden="true"></i>Approve Selected
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
        $(document).on('click', '.approve_all_pending', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/admin/customer/approve-all-pending',
                type: 'GET',
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

    <script>
        $(document).on('click', '.change-status', function(e) {
            e.preventDefault();
            var customerId = $(this).data('product-id');
            $.ajax({
                url: '/admin/customer/update/' + customerId,
                type: 'PATCH',
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
        $(document).ready(function() {
            $('#name').on('input', function() {
                var query = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('search.user') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'query': query
                    },
                    success: function(data) {
                        updateAutocomplete(data);
                    }
                });
            });

            // Updated function to handle click event and fill input field
            $(document).on('click', '#searchResults h5', function() {
                var selectedValue = $(this).text();
                $('#name').val(selectedValue);
                $('#searchResults').empty(); // Clear suggestions after selecting
            });

            function updateAutocomplete(results) {
                // Clear previous suggestions
                $('#searchResults').empty();

                // Append new suggestions
                for (var i = 0; i < results.length; i++) {
                    $('#searchResults').append('<h5>' + results[i].name + '</h5>');
                }
            }
        });
    </script>

    <script>
        $(document).on('click', '.approveAll', function(e) {
            e.preventDefault();

            var selectedCustomers = $('.approve-checkbox:checked').map(function() {
                return $(this).data('customer-id');
            }).get();
            // console.log(selectedCustomers);
            if (selectedCustomers.length > 0) {
                approveSelectedCustomers(selectedCustomers);
            } else {
                alert('Please select at least one customer for approval.');
            }
        });
        // Function to approve selected customers using AJAX
        function approveSelectedCustomers(customerIds) {
            $.ajax({
                url: '/admin/customer/approve',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'customer_ids': customerIds
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>

@endsection
