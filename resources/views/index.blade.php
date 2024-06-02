<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <head>
        <link rel="icon" href="{{ asset('images/home/favicon.png') }}" type="image/png">
    </head>

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">


    <style>
        /* For webkit-based browsers (Chrome, Safari) */
        ::-webkit-scrollbar {
            width: 5px;
            /* Width of the scrollbar */
        }

        /* Track (the area around the thumb) */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Color of the track */
        }

        /* Thumb (the draggable scrolling handle) */
        ::-webkit-scrollbar-thumb {
            background: #eaeaea;
            /* Color of the thumb */
        }

        /* When hovering over the scrollbar */
        ::-webkit-scrollbar-thumb:hover {
            background: #848484;
            /* Color of the thumb on hover */
        }

        .bi-cart:after {
            content: attr(value);
            font-size: 12px;
            color: #fff;
            background: rgb(255, 53, 53);
            border-radius: 50%;
            padding: 0 5px;
            position: relative;
            left: -8px;
            top: -10px;
            opacity: 0.9;
        }

        /* spinner */

        /* Spinner styles */
    </style>


    @yield('style')

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Spinner element -->
    {{-- <div id="loading-spinner" class="spinner"></div> --}}

    <main class="flex-fill">
        <div id="main-content" class="content">
            @yield('content')
        </div>
    </main>


    @include('components.home.footer')
    @yield('javascript')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
