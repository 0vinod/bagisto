 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title', 'Moonzio')</title>
     <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
     <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>


     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

     
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
