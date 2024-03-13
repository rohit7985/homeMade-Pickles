@extends('merchant.layouts.main')
@section('title', 'Merchant - Orders')
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Orders</h5>
                            </div>
                        </div>

                        <form class="row g-3" method="POST" action="{{ route('filter.order') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="" {{ request('status') === null ? 'selected' : '' }}>Select
                                    </option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Canceled
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ request('name') }}">
                                <div id="searchResults"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Product</label>
                                <input type="text" class="form-control" id="product" name="product"
                                    value="{{ request('product') }}">
                                <div id="searchProductResults"></div>
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
                        <h5 class="card-title fw-semibold mb-4">Order Details:</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">S.No</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Customer</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Product</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Price</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Quantity</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Total Price</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Rating</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">status</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                @php
                                    $totalIndex = ($orders->currentPage() - 1) * $orders->perPage();
                                @endphp
                                <tbody>
                                    @if ($orders->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <h4>Result Not Found!</h4>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($orders as $order)
                                            @foreach ($order->orderDetails as $item)
                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0"> {{ $totalIndex + $loop->index + 1 }}
                                                        </h6>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                            <h6 class="fw-semibold mb-0"> {{ $order->customer->name }}
                                                            </h6>
                                                            <h6 class="fw-semibold mb-0"> ({{ $order->customer->email }})
                                                            </h6>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-1">{{ $item['product_name'] }}</h6>
                                                        @if ($item['image'])
                                                            <img src="{{ asset($item['image']) }}" alt="Product Image"
                                                                style="max-width: 100px;" class="">
                                                        @else
                                                            No Image Available
                                                        @endif
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal">&#8377;{{ $item['price'] }}</p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-semibold">{{ $item['quantity'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span
                                                                class="fw-semibold">&#8377;{{ $item['price'] * $item['quantity'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        @if ($item['rating'] > 0)
                                                            <p class="mb-0 fw-normal">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $item['rating'])
                                                                        <i class="fas fa-star"></i>
                                                                    @else
                                                                        <i class="far fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </p>
                                                        @else
                                                            <p class="mb-0 fw-normal">No reviews yet</p>
                                                        @endif
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0"
                                                            style="
                                                        @if ($order->status == '0') color: blue; /* Change color for Pending */
                                                        @elseif($order->status == '1')
                                                            color: green; /* Change color for Completed */
                                                        @elseif($order->status == '2')
                                                            color: red; /* Change color for Canceled */
                                                        @else
                                                            color: black; /* Default color for unknown status */ @endif
                                                    ">
                                                            @if ($order->status == '0')
                                                                Pending
                                                            @elseif($order->status == '1')
                                                                Completed
                                                            @elseif($order->status == '2')
                                                                Canceled
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
                                                                <a href="#"
                                                                    class="fw-semibold mb-0 fs-4 cancel-Order"
                                                                    data-product-id="{{ $order->id }}">
                                                                    <i class="fa fa-trash pd-l"
                                                                        aria-hidden="true"></i>Cancel Order
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" class="fw-semibold mb-0 fs-4 change-orderStatus" data-order-id="{{ $order->id }}">
                                                                    <i class="fa fa-check pd-l" aria-hidden="true"></i> Order Completed
                                                                </a>
                                                                
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalIndex++;
                                                @endphp
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <!-- Previous Page Link -->
                                @if ($orders->onFirstPage())
                                    <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                                @else
                                    <a href="{{ $orders->previousPageUrl() }}" class="rounded">&laquo;</a>
                                @endif

                                <!-- Pagination sElements -->
                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    <a href="{{ $orders->url($i) }}"
                                        class="rounded @if ($orders->currentPage() === $i) active @endif">{{ $i }}</a>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($orders->hasMorePages())
                                    <a href="{{ $orders->nextPageUrl() }}" class="rounded">&raquo;</a>
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
        $(document).on('click', '.cancel-Order', function(e) {
            e.preventDefault();
            var orderId = $(this).data('product-id');
            $.ajax({
                url: '/merchant/orders/' + orderId,
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
    </script>

    <script>
        function increaseQuantity(productId) {
            var currentQuantity = parseInt($('#quantityInput_' + productId).val());
            var newQuantity = currentQuantity + 1;
            updateQuantity(productId, newQuantity);
        }

        function decreaseQuantity(productId) {
            var currentQuantity = parseInt($('#quantityInput_' + productId).val());
            if (currentQuantity > 1) {
                var newQuantity = currentQuantity - 1;
                updateQuantity(productId, newQuantity);
            }
        }

        function updateQuantity(productId, newQuantity) {
            $.ajax({
                url: "{{ route('update.quantity') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    new_quantity: newQuantity,
                    from: 'Admin',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#quantityInput_' + productId).val(response.updatedQuantity);
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                }
            });
        }
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
            $('#product').on('input', function() {
                var query = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('search.products') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'query': query
                    },
                    success: function(data) {
                        updateAutocompleteProduct(data);
                    }
                });
            });

            // Updated function to handle click event and fill input field
            $(document).on('click', '#searchResults h5', function() {
                var selectedValue = $(this).text();
                $('#name').val(selectedValue);
                $('#searchResults').empty(); // Clear suggestions after selecting
            });

            $(document).on('click', '#searchProductResults h5', function() {
                var selectedValue = $(this).text();
                $('#product').val(selectedValue);
                $('#searchProductResults').empty(); // Clear suggestions after selecting
            });

            function updateAutocomplete(results) {
                // Clear previous suggestions
                $('#searchResults').empty();

                // Append new suggestions
                for (var i = 0; i < results.length; i++) {
                    $('#searchResults').append('<h5>' + results[i].name + '</h5>');
                }
            }

            function updateAutocompleteProduct(results) {
                // Clear previous suggestions
                $('#searchProductResults').empty();
                // Append new suggestions
                for (var i = 0; i < results.length; i++) {
                    $('#searchProductResults').append('<h5>' + results[i].product + '</h5>');
                }
            }
        });
    </script>

    <script>
        $(document).on('click', '.change-orderStatus', function(e) {
            e.preventDefault();
            var orderId = $(this).data('order-id');
            $.ajax({
                url: '/merchant/order/mark-completed/' + orderId,
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

@endsection
