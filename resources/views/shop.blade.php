@extends('layouts.main')
@section('title', 'Shop')
@section('main-content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Fresh fruits shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        {{-- <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div> --}}
                        <div class="col-6"></div>
                        {{-- <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="fruits">Default Sorting:</label>
                                <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3"
                                    form="fruitform">
                                    <option value="volvo">Nothing</option>
                                    <option value="saab">Popularity</option>
                                    <option value="opel">Organic</option>
                                    <option value="audi">Fantastic</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="{{ route('filter.category', ['category' => $category]) }}">
                                                            <i class="fas fa-apple-alt me-2"></i>{{ $category->category }}
                                                        </a>
                                                        <span>({{ $category->products_count }})</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <form action="{{ route('filter.by.price') }}" method="POST">
                                    @csrf
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput"
                                                value="{{ request('rangeInput') ?? 0 }}" min="0" max="500"
                                                value="0" oninput="amount.value=rangeInput.value">
                                            <output id="amount" name="amount" min-velue="0" max-value="500"
                                                for="rangeInput">{{ request('rangeInput') ?? 0 }}</output>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <button type="submit"
                                                class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                    class="fa fa-shopping-bag me-2 text-primary"></i>Apply
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @if (count($products) > 0)
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <a href={{ route('product.details', $product->id) }}>
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="{{ asset($product->image) }}"
                                                            class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 10px;">{{ $product->category->category }}
                                                    </div>
                                                    <div class=" px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 220px;">
                                                        <a href="#" class="wishlistIcon" data-product-id="{{ $product->id }}">
                                                            @if($product->isInWishlist())
                                                                <img width="42" height="42" src="https://img.icons8.com/external-anggara-outline-color-anggara-putra/42/external-wishlist-ecommerce-interface-anggara-outline-color-anggara-putra.png" alt="Wishlist Added" />
                                                            @else
                                                                <img width="42" height="42" src="https://img.icons8.com/external-anggara-flat-anggara-putra/32/000000/external-wishlist-ecommerce-interaface-anggara-flat-anggara-putra.png" alt="external-wishlist-ecommerce-interaface-anggara-flat-anggara-putra" />
                                                            @endif
                                                        </a>
                                                        
                                                    </div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>{{ $product->product }}</h4>
                                                        <p>{{ strlen($product->description) > 70 ? substr($product->description, 0, 70) . '...' : $product->description }}
                                                        </p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">
                                                                &#8377;{{ $product->price }}
                                                                / kg
                                                            </p>
                                                            @auth
                                                                <form method="POST" action="{{ route('cart.add') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">
                                                                    <input type="hidden" name="product_name"
                                                                        value="{{ $product->product }}">
                                                                    <input type="hidden" name="product_price"
                                                                        value="{{ $product->price }}">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button type="submit"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>Add
                                                                        to
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
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center">
                                        <p class="text-muted">Sorry, no products found.</p>
                                    </div>
                                @endif
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
        </div>
    </div>
    <!-- Fruits Shop End-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Find all wishlist icons
            var wishlistIcons = document.querySelectorAll('.wishlistIcon');
    
            // Add click event listener to each wishlist icon
            wishlistIcons.forEach(function (icon) {
                icon.addEventListener('click', function (event) {
                    event.preventDefault();
    
                    // Get the product ID from the data attribute
                    var productId = icon.dataset.productId;
    
                    // Send an AJAX request to add the item to the wishlist
                    addToWishlist(productId);
                });
            });
    
            function addToWishlist(productId) {
                // Get the CSRF token value from the meta tag
                var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
                // Construct the headers object with the CSRF token
                var headers = new Headers();
                headers.append('Content-Type', 'application/json');
                headers.append('X-CSRF-TOKEN', csrfToken);
    
                // Construct the request object
                var request = new Request('{{ route('wishlist.add') }}', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ productId: productId }),
                });
    
                // Send the AJAX request
                fetch(request)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to add item to wishlist');
                    }
                    // Item added successfully
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>
    


@endsection
