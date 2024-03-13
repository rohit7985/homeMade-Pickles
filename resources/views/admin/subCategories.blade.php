@extends('admin.layouts.main')
@section('title', 'Admin - SubCategories')
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Sub Categories</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-outline-dark m-1" id="openModal">+ Add Sub Categories</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="myModal">
            <div class="modal-content">
                <div class="card mb-0">
                    <div class="card-body">
                        <p class="text-center">Add Sub Categories By Admin</p>
                        <form method="POST" action="{{ route('admin.subcategory.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryId" class="form-label">Select Category:</label>
                                <select class="form-select" id="categoryId" name="categoryId" required>
                                    <option value="" selected disabled>Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subcategory" class="form-label">Sub Category Name:</label>
                                <input type="text" class="form-control" id="subcategory" name="subcategory" required>
                                @error('subcategory')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded"
                                value="Add Sub-Category">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('success-delete'))
            <div class="alert alert-success">
                {{ session('success-delete') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Sub Categories Details:</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">S.No.</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Sub Category</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Category</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($subcategories->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h4>No Subcategories Found!</h4>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($subcategories as $subcategory)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $loop->index + 1 }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#"
                                                        class="fw-semibold mb-0">{{ $subcategory->sub_category }}</a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#"
                                                        class="fw-semibold mb-0">{{ $subcategory->category->category }}</a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0 fs-4"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="false"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="#"
                                                                class="fw-semibold mb-0 fs-4 delete-subcategory"
                                                                data-subcategory-id="{{ $subcategory->id }}">
                                                                <i class="fa fa-trash pd-l" aria-hidden="true"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 edit-subcategory"
                                                                data-target="#myEditModal"
                                                                data-subcategory-id="{{ $subcategory->id }}"
                                                                data-subcategory-name="{{ $subcategory->sub_category }}"
                                                                data-category-id="{{ $subcategory->category->id }}"
                                                                data-category-name="{{ $subcategory->category->category }}">
                                                                <i class="fa fa-edit pd-l" aria-hidden="true"></i> Edit
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <!-- Previous Page Link -->
                                @if ($customers->onFirstPage())
                                    <a href="#" class="rounded disabled" aria-disabled="true">&laquo;</a>
                                @else
                                    <a href="{{ $customers->previousPageUrl() }}" class="rounded">&laquo;</a>
                                @endif

                                <!-- Pagination sElements -->
                                @for ($i = 1; $i <= $customers->lastPage(); $i++)
                                    <a href="{{ $customers->url($i) }}"
                                        class="rounded @if ($customers->currentPage() === $i) active @endif">{{ $i }}</a>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($customers->hasMorePages())
                                    <a href="{{ $customers->nextPageUrl() }}" class="rounded">&raquo;</a>
                                @else
                                    <a href="#" class="rounded disabled" aria-disabled="true">&raquo;</a>
                                @endif
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="myEditModal" >
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-body">
                    <p class="text-center">Edit Subcategory</p>
                    <form method="POST" action="{{ route('admin.subcategory.update') }}" id="subcategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="editSubCategoryName" class="form-label">Subcategory Name:</label>
                            <input type="text" class="form-control" id="editSubCategoryName" name="subcategoryName"
                                required>
                            @error('subcategoryName')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryId" class="form-label">Select Category:</label>
                            <select class="form-select" id="editCategoryId" name="categoryId" required>
                                <option value="" selected disabled>Select a Category</option>
                                {{-- Populate the dropdown with categories --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('categoryId')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" id="editSubCategoryId" name="subcategoryId">
                        <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded"
                            value="Update Subcategory">
                        <input type="button" class="btn btn-primary closeModel w-100 py-8 fs-4 mb-4 rounded"
                            value="Close">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.getElementById('openModal').addEventListener('click', function(e) {
            e.preventDefault();
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.closeModel').on('click', function() {
                    location.reload();
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Assuming you have a click event for the edit-subcategory link
            $('.edit-subcategory').on('click', function() {
                // Extract data attributes from the link
                var subcategoryId = $(this).data('subcategory-id');
                var subcategoryName = $(this).data('subcategory-name');
                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');

                // Populate the modal form fields with the extracted data
                $('#editSubCategoryId').val(subcategoryId);
                $('#editSubCategoryName').val(subcategoryName);
                $('#editCategoryId').val(categoryId);

                // Optional: Update the text of the modal for clarity
                $('#myEditModal .text-center').text('Edit Subcategory');

                // Trigger the modal
                $('#myEditModal').modal('show');

            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.delete-subcategory').on('click', function(e) {
                e.preventDefault();
                var subCategoryId = $(this).data('subcategory-id');
                $.ajax({
                    url: '/admin/delete-subcategory/' + subCategoryId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>


@endsection
