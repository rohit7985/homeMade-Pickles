@extends('layouts.main')
@section('title', 'Customer Order Details')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Order Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Customer / Order Details</li>
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
            @include('customer.customerNav')
            @php
                $counter = 0;
            @endphp
            <h4 class="mb-5 fw-bold">Order Details</h4>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Rate & Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    @foreach ($order->orderDetails as $item)
                                        <tr>
                                            <td>
                                                <p class="mb-0 mt-4">{{ ++$counter }}</p>
                                            </td>
                                            <td scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src={{ asset($item['image']) }}
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">{{ $item['product_name'] }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4 price">{{ $item['price'] }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4 price">{{ $item['quantity'] }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4 total-price">
                                                    &#8377;{{ $item['price'] * $item['quantity'] }}
                                                </p>
                                            </td>
                                            <td>
                                                @if($item['rating'] >= 1)
                                                <p>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=$item['rating'])
                                                        <i class="fa fa-star text-secondary"></i>
                                                    @else
                                                        <i class="fa fa-star"></i>
                                                    @endif
                                                @endfor
                                                </p>
                                                <p>{{ $item['review'] }}</p>
                                                @else
                                                <p class="mb-0 mt-4 total-price">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-order-id="{{ $order->id }}"
                                                        data-product-id="{{ $item['product_id'] }}"
                                                        data-bs-target="#exampleModal">
                                                        <i class="fa fa-star text-secondary"></i>Rating & Reviews</a>
                                                </p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <!--Address Form Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rating & Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rating.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="customer" class="col-form-label">Rate this Product</label>
                            <input type="hidden" name="orderId" id="modalOrderId" value="">
                            <input type="hidden" name="productId" id="modalProductId" value="">
                            <input type="hidden" name="rating" id="rating" value="0">
                            <i class="fa fa-star " data-value="1"></i>
                            <i class="fa fa-star " data-value="2"></i>
                            <i class="fa fa-star" data-value="3"></i>
                            <i class="fa fa-star " data-value="4"></i>
                            <i class="fa fa-star" data-value="5"></i>
                            <i id="rating_value"></i>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function(event) {
                var link = $(event.relatedTarget);
                var orderId = link.data('order-id');
                var productId = link.data('product-id');

                // Set the values in the hidden input fields
                $('#modalOrderId').val(orderId);
                $('#modalProductId').val(productId);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.fa-star').on('click', function() {
                var value = $(this).data('value');
                $('#rating').val(value);

                // Reset color of all stars
                $('.fa-star').removeClass('text-warning');

                // Change color of selected stars
                $('.fa-star').each(function() {
                    if ($(this).data('value') <= value) {
                        $(this).addClass('text-warning');
                    }
                });

                // Display corresponding label and value with different colors
                var ratingInfo = getRatingInfo(value);
                $('#rating_label').text(ratingInfo.label).removeClass().addClass(ratingInfo.colorClass);
                $('#rating_value').text(ratingInfo.label).removeClass().addClass(ratingInfo.colorClass);
            });

            function getRatingInfo(value) {
                var ratings = {
                    1: {
                        label: 'Very Bad',
                        colorClass: 'text-danger'
                    },
                    2: {
                        label: 'Bad',
                        colorClass: 'text-warning'
                    },
                    3: {
                        label: 'Good',
                        colorClass: 'text-primary'
                    },
                    4: {
                        label: 'Very Good',
                        colorClass: 'text-success'
                    },
                    5: {
                        label: 'Excellent',
                        colorClass: 'text-info'
                    }
                };

                return ratings[value] || {
                    label: 'No Rating',
                    colorClass: ''
                };
            }
        });
    </script>


@endsection
