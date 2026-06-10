 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title', 'Moonzio')</title>
     <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
     <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('frontend/css/themify.min.css') }}">
     <script src="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/ie7/ie7.min.js"></script>
     <link
         href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
         rel="stylesheet">

     <!-- Custom CSS -->
     <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <link rel="stylesheet" href="{{ ('frontend/css/toastr.css') }}"   />
     @stack('styles')

 </head>

 <body>
@include('frontend.layouts.notification')
@include('frontend.layouts.header')
@yield('main-content')
@include('frontend.layouts.footer')
@include('frontend.partials.add-to-cart-modal')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script>
         $(document).ready(function() {
             // Auto-hide alerts after 5 seconds
             setTimeout(function() {
                 $('.alert').fadeOut('slow');
             }, 5000);
         });
     </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("searchToggle");
    const form = document.getElementById("searchForm");

    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        form.classList.toggle("active");
    });
});
</script>
<script>
    // Optional: Add AJAX cart removal with animation
    document.addEventListener('DOMContentLoaded', function() {
        // Add remove item functionality with animation
        const removeButtons = document.querySelectorAll('.remove-item');

        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const cartItem = this.closest('.cart-item');

                // Add fade out animation
                cartItem.style.transition = 'all 0.3s ease';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(20px)';

                setTimeout(() => {
                    window.location.href = url;
                }, 300);
            });
        });

        // Update cart count animation
        const cartCount = document.querySelector('.total-count');
        if (cartCount) {
            const currentCount = parseInt(cartCount.textContent);
            if (currentCount > 0) {
                cartCount.style.animation = 'none';
                setTimeout(() => {
                    cartCount.style.animation = 'pulse 0.5s ease-in-out';
                }, 10);
            }
        }
    });
</script>

     @stack('scripts')
 </body>

 </html>
