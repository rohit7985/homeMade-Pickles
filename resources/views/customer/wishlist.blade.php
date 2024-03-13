@extends('layouts.main')
@section('title', 'Customer Wishlist')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Wishlist</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Customer / Wishlist</li>
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
            <h4 class="mb-5 fw-bold">Wishlist Details</h4>
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 0; @endphp
                                @foreach ($wishlistItems as $item)
                                    <tr>
                                        <td>{{ ++$counter }}</td>
                                        <td><img src="{{ asset($item->product->image) }}" class="img-fluid rounded"
                                                style="width: 80px; height: 80px;" alt=""></td>
                                        <td>{{ $item->product->product }}</td>
                                        <td>{{ $item->product->price }}</td>
                                        <td>
                                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product from your wishlist?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link"><i class="fa fa-trash text-danger"></i></button>
                                            </form>
                                        </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

@endsection
