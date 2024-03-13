@extends('merchant.layouts.main')
@section('title', 'Merchant - Products')
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Products</h5>
                            </div>
                            <div>
                                <a href="{{ route('merchant.addProduct') }}" class="btn btn-outline-dark m-1">+ Add Product</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="GET" action="{{ route('filter.products') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Visibility</label>
                                <select id="visibility" name="visibility" class="form-control">
                                    <option value="" {{ request('visibility') === null ? 'selected' : '' }}>Select
                                    </option>
                                    <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>Show
                                    </option>
                                    <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>Hidden
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Product</label>
                                <input type="text" class="form-control" id="product" name="product"
                                    value="{{ request('product') }}">
                                <div id="searchProductResults"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="minPrice" class="form-label">Price Range</label>
                                <div class="input-group">
                                    <input type="range" class="form-range" id="priceRange" name="priceRange" min="0" max="1000" step="10" value="{{ request('priceRange') ?? 0 }}" oninput="amount.value=priceRange.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500"
                                            for="priceRange">{{ request('priceRange') ?? 0 }}</output>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3" style="margin-top: 46px">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('merchant.products') }}" class="btn btn-primary">Show All</a>
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
                        <h5 class="card-title fw-semibold mb-4">Product Details:</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Id</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Product</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Merchant</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Price</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Weight (kg)</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Ribbon</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Quantity</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Rating</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Desciption</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Visibility</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($products->isEmpty())
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <h4>Result Not Found!</h4>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">
                                                        {{ $loop->index + $products->firstItem() }}
                                                    </h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1">{{ $product->product }}</h6>
                                                    @if ($product->image)
                                                        <img src="{{ asset($product->image) }}" alt="Product Image"
                                                            style="max-width: 100px;" class="">
                                                    @else
                                                        No Image Available
                                                    @endif
                                                    <p class="mb-0 fw-normal">Category: {{ $product->category->category }}
                                                    </p>
                                                    <!-- Display Subcategory Name -->
                                                    <p class="mb-0 fw-normal">Subcategory:
                                                        {{ $product->subcategory->sub_category }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">{{ $product->merchant->name }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">&#8377;{{ $product->price }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-semibold">{{ $product->weight }}</span>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="badge bg-primary rounded-3 fw-semibold mb-0 fs-4">
                                                        {{ $product->ribbon }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn btn-sm btn-secondary me-2"
                                                            onclick="decreaseQuantity({{ $product->id }})">-</button>
                                                        <input type="text" id="quantityInput_{{ $product->id }}"
                                                            value="{{ $product->quantity }}" class="form-control w-min">
                                                        <button class="btn btn-sm btn-secondary ms-2"
                                                            onclick="increaseQuantity({{ $product->id }})">+</button>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    @if ($product->ratingReviews->isNotEmpty())
                                                        <p class="mb-0 fw-normal">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $product->ratingReviews->avg('rating'))
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
                                                    <h6 class="fw-semibold mb-0 fs-4">
                                                        {{ strlen($product->description) > 30 ? substr($product->description, 0, 30) . '...' : $product->description }}
                                                    </h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0 fs-4 toggle-hidden"
                                                        data-product-id="{{ $product->id }}">
                                                        @if ($product->hidden)
                                                            <i class="fa fa-eye-slash" aria-hidden="false"></i>
                                                        @else
                                                            <i class="fa fa-eye" aria-hidden="false"></i>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0 fs-4"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-ellipsis-v" aria-hidden="false"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 delete-product"
                                                                data-product-id="{{ $product->id }}">
                                                                <i class="fa fa-trash pd-l" aria-hidden="true"></i>Delete
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('products.edit', $product->id) }}"
                                                                class="fw-semibold mb-0 fs-4">
                                                                <i class="fas fa-pencil-alt pd-l"></i> Edit
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
                                @if ($products->onFirstPage())
                                    <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="rounded">&laquo;</a>
                                @endif

                                <!-- Pagination sElements -->
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <a href="{{ $products->url($i) }}"
                                        class="rounded @if ($products->currentPage() === $i) active @endif">{{ $i }}</a>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="rounded">&raquo;</a>
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
        $(document).ready(function () {
            $('#priceRange').on('input', function () {
                $('output[for=priceRange]').val($(this).val());
            });
        });
    </script>
    
    <script>
        $(document).on('click', '.delete-product', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            $.ajax({
                url: '/merchant/products/' + productId,
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
        $(document).ready(function() {
            $('.toggle-hidden').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).data('product-id');
                var isHidden = $(this).data('hidden');

                // Toggle the hidden status (true/false)
                isHidden = !isHidden;

                $.ajax({
                    url: '/merchant/products/toggle-hidden/' + productId,
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
                    from: 'Merchant',
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
            $(document).on('click', '#searchProductResults h5', function() {
                var selectedValue = $(this).text();
                $('#product').val(selectedValue);
                $('#searchProductResults').empty(); // Clear suggestions after selecting
            });

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



@endsection