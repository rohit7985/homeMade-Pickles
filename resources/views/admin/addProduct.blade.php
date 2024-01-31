@extends('admin.layouts.main')
@section('title', 'Admin - Add Product')
@section('main-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if (isset($editProduct))
                    <form method="POST" action={{ route('products.update', $editProduct->id) }} enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="product" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product" name="product"
                                value="{{ $editProduct->product }}" required>
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                value="{{ $editProduct->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                                value="{{ $editProduct->weight }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                value="{{ $editProduct->quantity }}" required>
                        </div>
                        <div class="mb-3">
                            @if ($editProduct->image)
                                <img src="{{ asset($editProduct->image) }}" alt="Product Image" style="max-width: 100px;"
                                    class="">
                            @else
                                No Image Available
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" step="0.01" class="form-control" id="image" name="image"
                              value="{{ $editProduct->image }}"  required>
                        </div>
                        <div class="mb-3">
                            <label for="ribbon" class="form-label">Ribbon</label>
                            <input type="text" class="form-control" id="ribbon" name="ribbon"
                                value="{{ $editProduct->ribbon }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="150" rows="10"
                                >{{ $editProduct->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                @else
                    <form method="POST" action={{ route('products.store') }} enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="product" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product" name="product" required>
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image[]"  multiple accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="ribbon" class="form-label">Ribbon</label>
                            <input type="text" class="form-control" id="ribbon" name="ribbon" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="150" rows="10"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                @endif
            </div>
        </div>
    </div>


@endsection
