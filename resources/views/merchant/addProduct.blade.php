@extends('merchant.layouts.main')
@section('title', 'Merchant - Add Product')
@section('main-content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if (isset($editProduct))
                    <form method="POST" action={{ route('products.update', $editProduct->id) }}
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Add Category and Subcategory Fields -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" name="category" class="form-control" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $editProduct->category_id ? 'selected' : '' }}>
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subcategory" class="form-label">Subcategory</label>
                            <select id="subcategory" name="subcategory" class="form-control" required>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ $subcategory->id == $editProduct->subcategory_id ? 'selected' : '' }}>
                                        {{ $subcategory->sub_category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- End of Category and Subcategory Fields -->
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
                                value="{{ $editProduct->image }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="ribbon" class="form-label">Ribbon</label>
                            <input type="text" class="form-control" id="ribbon" name="ribbon"
                                value="{{ $editProduct->ribbon }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="150" rows="10">{{ $editProduct->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                @else
                    <form method="POST" action={{ route('products.store') }} enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="product" class="form-label">Category</label>
                            <select id="category" name="category" class="form-control">
                                <option>Select Category</option>
                                $@foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="subcategoryDiv" class="mb-3" style="display: none;">
                            <label for="product" class="form-label">Sub Category</label>
                            <select id="subcategory" name="subcategory" class="form-control">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product" name="product" required>
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
                            <input type="file" class="form-control" id="image" name="image[]" multiple
                                accept="image/*" required>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        type: 'GET',
                        url: '/merchant/get-subcategories/' + categoryId,
                        success: function(data) {
                            if (data && data.length > 0) {
                                $('#subcategory').empty().prop('disabled', false);
                                $.each(data, function(key, value) {
                                    $('#subcategory').append('<option value="' + value
                                        .id +
                                        '">' + value.sub_category + '</option>');
                                });
                                $('#subcategoryDiv').show(); // Show the subcategory div
                            } else {
                                $('#subcategory').empty().prop('disabled', true);
                                $('#subcategoryDiv').hide(); // Hide the subcategory div
                            }
                        },
                        error: function() {
                            console.log('Error fetching subcategories');
                        }
                    });
                } else {
                    $('#subcategory').empty().prop('disabled', true);
                    $('#subcategoryDiv').hide(); // Hide the subcategory div if no category is selected
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                var query = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('search.user') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'query': query,
                        'user_type': 'M',
                    },
                    success: function(data) {
                        updateAutocomplete(data);
                    }
                });
            });

            // Updated function to handle click event and fill input field
            $(document).on('click', '#searchResults h5', function() {
                var selectedValue = $(this).text();
                $('#name').val(selectedValue);
                $('#searchResults').empty(); // Clear suggestions after selecting
            });

            function updateAutocomplete(results) {
                // Clear previous suggestions
                $('#searchResults').empty();

                // Append new suggestions
                for (var i = 0; i < results.length; i++) {
                    $('#searchResults').append('<h5>' + results[i].name + '</h5>');
                }
            }
        });
    </script>


@endsection
