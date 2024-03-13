@extends('admin.layouts.main')
@section('title', 'Admin - Categories')
@section('main-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Categories</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-outline-dark m-1" id="openModal">+ Add Categories</a>
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
                        <p class="text-center">Add Categories By Admin</p>
                        <form method="POST" action="{{ route('admin.category.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                                @error('categoryName')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded" value="Add Category">
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
                        <h5 class="card-title fw-semibold mb-4">Customer Details:</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">S.No.</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Name</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h4>No Categories Found!</h4>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $loop->index + 1 }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0">{{ $category->category }}</a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="#" class="fw-semibold mb-0 fs-4"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-ellipsis-v" aria-hidden="false"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 delete-category"
                                                                data-product-id="{{ $category->id }}">
                                                                <i class="fa fa-trash pd-l" aria-hidden="true"></i>Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="fw-semibold mb-0 fs-4 edit-category" 
                                                               data-target="#myEditModal"
                                                               data-category-id="{{ $category->id }}"
                                                               data-category-name="{{ $category->name }}">
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

    <div class="modal closeModel" id="myEditModal">
        <div class="modal-content">
            <div class="card mb-0">
                <div class="card-body">
                    <p class="text-center">Edit Category</p>
                    <form method="POST" action="{{ route('admin.category.update') }}" id="categoryForm">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryName" required>
                            @error('categoryName')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" id="editCategoryId" name="categoryId">
                        <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded" value="Update Category">
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
        $(document).ready(function () {
           $('.edit-category').on('click', function (e) {
              e.preventDefault();
              
              // Get category details from data attributes
              var categoryId = $(this).data('category-id');
              var categoryName = $(this).data('category-name');
              
              // Set form values using plain JavaScript
              document.getElementById('editCategoryId').value = categoryId;
              document.getElementById('editCategoryName').value = categoryName;
     
              // Open the modal using Bootstrap's modal method
              $('#myEditModal').modal('show');
           });
     
           // Additional script for closing the modal
           $('#myModal').on('hidden.bs.modal', function () {
              // Reset or clear the form when the modal is closed
              // Optionally, you can reload the page or update the UI
           });
        });
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
            $('.delete-category').on('click', function(e) {
                e.preventDefault();
                var categoryId = $(this).data('product-id');
                $.ajax({
                    url: '/admin/delete-category/' + categoryId,
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
