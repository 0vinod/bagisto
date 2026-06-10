 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title', 'Moonzio')</title>
     <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
     <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <link rel="stylesheet" href="{{ asset('frontend/css/themify.min.css') }}">
     <script src="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/ie7/ie7.min.js"></script>
     <link
         href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
         rel="stylesheet">

     <!-- Custom CSS -->
     <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">


     @stack('styles')

 </head>

 <body>
     @include('frontend.layouts.notification')
     @include('frontend.layouts.header')

     <main>
         @yield('main-content')
     </main>

     @include('frontend.layouts.footer')
     @include('frontend.partials.add-to-cart-modal')

     <!-- Scripts -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js">
     </script>
     </script>
     <!-- Global JavaScript -->
     <script>
         $(document).ready(function() {
             // Auto-hide alerts after 5 seconds
             setTimeout(function() {
                 $('.alert').fadeOut('slow');
             }, 5000);
         });
     </script>

     @stack('scripts')
 </body>

 </html>
