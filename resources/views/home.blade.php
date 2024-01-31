@extends('layouts.main')
@section('title', 'Home Page')
@section('main-content')

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                @if (isset($products))
                <div class="col-lg-12">
                    <div class="row g-4 justify-content-center">
                        @foreach ($products as $product)
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <a href={{ route('product.details', $product->id) }}>
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="{{ asset($product->image) }}"
                                                class="img-fluid w-100 rounded-top" alt="">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                            style="top: 10px; left: 10px;">{{ $product->ribbon }}</div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4>{{ $product->product }}</h4>
                                            <p>{{ strlen($product->description) > 70 ? substr($product->description, 0, 70) . '...' : $product->description }}
                                            </p>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">&#8377;{{ $product->price }} / kg
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
                                    </div>
                                </a>
                            </div>
                        @endforeach
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
                @endif
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                    <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                    <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number"
                            placeholder="Search">
                        <button type="submit"
                            class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                            style="top: 0; right: 25%;">Submit Now</button>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ url('asset/img/hero-img-1.png') }}"
                                    class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ url('asset/img/hero-img-2.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

@endsection
