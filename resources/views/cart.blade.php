@extends('layouts.main')
@section('title', 'Product Details')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
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
            <div class="row g-4">
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Products</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center">
                                                <img src={{ asset($item->product->image) }}
                                                    class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                    alt="">
                                            </div>
                                        </th>
                                        <td>
                                            <p class="mb-0 mt-4">{{ $item->product->product }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4 price">{{ $item->product->price }}</p>
                                        </td>
                                        <td>
                                            <div class="input-group quantity mt-4" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                        onclick="decreaseQuantity({{ $item->id }})" id="decreaseButton_{{ $item->id }}" {{ $item->quantity == 1 ? 'disabled' : '' }}>
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text"
                                                    class="form-control quantity form-control-sm text-center border-0"
                                                    value="{{ $item->quantity }}" name="buy_quantity"
                                                    id="quantityInput_{{ $item->id }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                        onclick="increaseQuantity({{ $item->id }})">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4 total-price">&#8377;{{ $item->product->price * $item->quantity }}
                                                </p>
                                        </td>
                                        <td>
                                            <form action="{{ route('cartItem.delete', ['item' => $item]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-md rounded-circle bg-light border mt-4">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4"
                            placeholder="Coupon Code">
                        <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply
                            Coupon</button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <form action="{{ route('complete.customerOrder') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="userId" value="{{ $user->id }}">
                                    <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                                    <input type="hidden" name="items" value="{{ $cartItems }}">
                                    <div class="p-4">
                                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="mb-0 me-4">Subtotal:</h5>
                                            <p class="mb-0">&#8377;{{ $totalPrice }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-0 me-4">Shipping</h5>
                                            <div class="">
                                                <p class="mb-0">Flat rate: &#8377;60</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                                        <p class="mb-0 pe-4">&#8377;{{ $totalPrice + 60 }}<i class="fa fa-inr"
                                                aria-hidden="true"></i></p>
                                    </div>
                                    <button
                                        class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                                        type="submit">Proceed Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Related products</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($products as $product)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <a href={{ route('product.details', $product->id) }}>
                                <div class="vesitable-img">
                                    <img src="{{ asset($product->image) }}" class="img-fluid w-100 rounded-top"
                                        alt="">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; right: 10px;">Veg Pickles</div>
                                <div class="p-4 pb-0 rounded-bottom">
                                    <h4>{{ $product->product }}</h4>
                                    <p>{{ strlen($product->description) > 70 ? substr($product->description, 0, 70) . '...' : $product->description }}
                                    </p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold">&#8377;{{ $product->price }}</p>
                                        @auth
                                            <form method="POST" action="{{ route('cart.add') }}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="product_name" value="{{ $product->product }}">
                                                <input type="hidden" name="product_price" value="{{ $product->price }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                        class="fa fa-shopping-bag me-2 text-primary"></i>Add to
                                                    cart
                                                </button>
                                            </form>
                                        @else
                                            <a href={{ route('login.view') }}
                                                class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                    class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                cart</a>
                                        @endauth
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    </script>
    <script>
        function increaseQuantity(productId) {
            var currentQuantity = parseInt($('#quantityInput_' + productId).val());
            var newQuantity = currentQuantity + 1;
            updateQuantity(productId, newQuantity);
        }

        function decreaseQuantity(productId) {
            var currentQuantity = parseInt($('#quantityInput_' + productId).val());
            // if(currentQuantity == 2){
            //     $('#decreaseButton_' + productId).prop('disabled', true);
            // }
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
                    from: 'cart',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                }
            });
        }
    </script>



@endsection
