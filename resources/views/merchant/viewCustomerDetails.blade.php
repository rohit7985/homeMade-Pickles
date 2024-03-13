@extends('admin.layouts.main')
@section('title', 'Admin - View Customer Details')
@section('main-content')
    @php
        $counter = 0;
    @endphp
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        <div class="card-body p-4">
                            <h4>Personal Details</h4>
                            <h6>Name: {{ $user->name }}</h6>
                            <h6>Email: {{ $user->email }}</h6>
                            <h6>Contact: {{ $user->mobile_number ?? 'Not Available' }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="">
                        <div class="card-body p-4">
                            <h4>Address Details</h4>
                            <div class="row">
                                @foreach ($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="card-body p-4">
                                            <h6>{{ $address->address }}- {{ $address->pincode }} </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                            <p class="mb-0 fw-normal">&#8377;{{ $detail['price'] * $detail['quantity'] }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $detail['quantity'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=$detail['rating'])
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </p>
                                            <p class="mb-0 fw-normal">{{ $detail['review'] }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    
                </div>
            </div>
        </div>
    </div>


@endsection
