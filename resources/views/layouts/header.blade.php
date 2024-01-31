<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home Made Pickles')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('asset/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('asset/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ url('asset/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('asset/css/main.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white">123 Street, New York</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white">Email@Example.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary display-6">Fruitables</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ '/' }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ '/shop' }}" class="nav-item nav-link">Shop</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <button
                            class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fas fa-search text-primary"></i></button>
                        @auth
                        <a href="{{ route('customer.cart') }}" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartItemCount ?? '' }}</span>
                        </a>
                            <a class="my-auto dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.myProfile') }}">My Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                                </li>
                            </ul>
                        @else
                            <a href="{{route('login.view')}}" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('productSearch')}}" method="POST">
                    @csrf
                    <div class="input-group w-75 mx-auto">
                        <input type="search" class="form-control p-3" id="searchInput" name="searchInput" placeholder="keywords" aria-describedby="search-icon-1">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>                    
                </form>
                <div class="input-group w-75 mx-auto autocomplete-results" id="searchResults">
                
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->

<!-- Add jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#searchInput').on('input', function () {
            var query = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route("search.product") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'query': query
                },
                success: function (data) {
                    updateAutocomplete(data);
                }
            });
        });

        // Updated function to handle click event and fill input field
        $(document).on('click', '#searchResults div', function () {
            var selectedValue = $(this).text();
            $('#searchInput').val(selectedValue);
            $('#searchResults').empty(); // Clear suggestions after selecting
        });

        function updateAutocomplete(results) {
            // Clear previous suggestions
            $('#searchResults').empty();

            // Append new suggestions
            for (var i = 0; i < results.length; i++) {
                $('#searchResults').append('<div class="form-control p-3" >' + results[i].product + '</div>');
            }
        }
    });
</script>



