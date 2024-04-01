@extends('layouts.main')
@section('title', 'Customer Wishlist')
@section('main-content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Wishlist</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Customer / Wallet</li>
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
            <h4 class="mb-5 fw-bold">Wallet Details</h4>
            <div class="row g-4">
                <div class="col-lg-12">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add Balence</a>
                    <a href="#" class="position-relative me-4 my-auto ml">BAL: {{ Auth::user()->balence }} INR</a>
                </div>

                {{-- Start filter Data --}}
                <div class="col-lg-8">
                    <div class="row g-4">
                        <form action="{{ route('wallet.filter') }}" method="POST" class="row">
                            @csrf
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label for="amount" class="col-form-label">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="amount" class="col-form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1">Success</option>
                                    <option value="0">Pending</option>
                                    <option value="2">Failed</option>
                                </select>
                            </div>

                            <div class="col-md-3 align-self-end">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('customer.wallet') }}" class="btn btn-primary">Show All</a>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End filter Data --}}

                <div class="col-lg-12">
                    <!--Address Form Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Balence into the Wallet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('wallet.addMoney') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="customer" class="col-form-label">Amount(INR)</label>
                                            <input type="text" class="form-control" name="amount" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message-text" class="col-form-label">Description</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-20">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data)
                                    @php $counter = 0; @endphp
                                    @foreach ($data as $trans)
                                        <tr>
                                            <td>{{ ++$counter }}</td>
                                            <td>{{ $trans->amount }}</td>
                                            <td>
                                                <h6 class=""
                                                    style="
                                            @if ($trans->type == 'credit') color: green;
                                            @elseif($trans->type == 'debit')
                                                color: red;
                                            @else
                                                color: black; @endif
                                        ">
                                                    @if ($trans->type == 'credit')
                                                        Credit
                                                    @elseif($trans->type == 'debit')
                                                        Debit
                                                    @else
                                                        Unknown Status
                                                    @endif
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 class=""
                                                    style="
                                            @if ($trans->status == '0') color: blue; /* Change color for Pending */
                                            @elseif($trans->status == '1')
                                                color: green; /* Change color for Completed */
                                            @elseif($trans->status == '2')
                                                color: red; /* Change color for Canceled */
                                            @else
                                                color: black; /* Default color for unknown status */ @endif
                                        ">
                                                    @if ($trans->status == '0')
                                                        Pending
                                                    @elseif($trans->status == '1')
                                                        Success
                                                    @elseif($trans->status == '2')
                                                        Failed
                                                    @else
                                                        Unknown Status
                                                    @endif
                                                </h6>
                                            </td>
                                            <td>{{ $trans->description }}</td>
                                            <td>{{ $trans->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                <h5 class="text-center">Result Not Found.</h5>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <div class="pagination d-flex justify-content-center mt-5">
                        <!-- Previous Page Link -->
                        @if ($data->onFirstPage())
                            <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                        @else
                            <a href="{{ $data->previousPageUrl() }}" class="rounded">&laquo;</a>
                        @endif

                        <!-- Pagination sElements -->
                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                            <a href="{{ $data->url($i) }}"
                                class="rounded @if ($data->currentPage() === $i) active @endif">{{ $i }}</a>
                        @endfor

                        <!-- Next Page Link -->
                        @if ($data->hasMorePages())
                            <a href="{{ $data->nextPageUrl() }}" class="rounded">&raquo;</a>
                        @else
                            <a href="#" class="rounded disabled" aria-disabled="true">&raquo;</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

@endsection
