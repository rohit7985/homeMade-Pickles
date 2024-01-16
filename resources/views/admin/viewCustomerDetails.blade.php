@extends('admin.layouts.main')
@section('title', 'Admin - View Customer Details')
@section('main-content')
    @php
        $counter = 0;
    @endphp
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-4">
                <h4>Personal Details</h4>
                <h6>Name:{{ $user->name }}</h6>
                <h6>Email:{{ $user->email }}</h6>
                <h6>Contact:{{ $user->mobile_number ?? 'Not Available' }}</h6>
            </div>
        </div>
        <div class="card">
            <h4>Address Details</h4>
            @foreach ($addresses as $address)
                <div class="card-body p-4">
                    <h4>Details</h4>
                    <h6>Name:{{ $address->name }}</h6>
                    <h6>Pincode:{{ $address->pincode }}</h6>
                    <h6>Address:{{ $address->address }}</h6>
                    <h6>Contact:{{ $address->mobile_num ?? 'Not Available' }}</h6>
                </div>
            @endforeach
        </div>
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Product Details:</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">S.No</h6>
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
                                    <h6 class="fw-semibold mb-0">Rating & Review</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ ++$counter }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $detail['product_name'] }}</h6>
                                            @if ($detail['image'])
                                                <img src="{{ asset($detail['image']) }}" alt="Product Image"
                                                    style="max-width: 100px;" class="rounded-bottom rounded-top">
                                            @else
                                                No Image Available
                                            @endif
                                            {{-- <span class="fw-normal"></span> --}}
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">&#8377;{{ $detail['price'] * $detail['quantity'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $detail['quantity'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $detail['rating'] }}</p>
                                            <p class="mb-0 fw-normal">{{ $detail['review'] }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    {{-- <div class="pagination d-flex justify-content-center mt-5">
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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


@endsection
