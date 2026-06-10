 <!-- Start Shop Services Area  -->
 <section class="shop-services section">
     <div class="container">
         <div class="row">
             <div class="col-lg-3 col-md-6 col-6">
                 <div class="single-service">
                     <i class="ti-rocket"></i>
                     <h4>Free Shipping</h4>
                     <p>Cash on delivery</p>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-6">
                 <!-- Start Single Service -->
                 <div class="single-service">
                     <i class="ti-reload"></i>
                     <h4>Free Return</h4>
                     <p>Within 3 days of purchase</p>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-6">
                 <div class="single-service">
                     <i class="ti-lock"></i>
                     <h4>Secure Payment</h4>
                     <p>100% secure payment</p>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-6">
                 <!-- Start Single Service -->
                 <div class="single-service">
                     <i class="ti-tag"></i>
                     <h4>Best Price</h4>
                     <p>Guaranteed price</p>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- End Shop Newsletter -->


 <footer class="footer">
     <!-- Footer Top -->
     @php
         $settings = DB::table('settings')->first();
     @endphp
     <div class="footer-top section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-4 col-12 ">
                     <!-- About Widget -->
                     <div class="single-footer about">
                         <div class="logo">
                             <a href="{{ route('home') }}">
                                 <img src="{{ asset('backend/img/logo2.png') }}" alt="Moonzio">
                             </a>
                         </div>
                         <p class="text">{!! isset($settings)
                             ? $settings->short_des
                             : 'Your one-stop destination for trendy fashion, electrnics, and lifestyle products. Quality guaranteed.' !!}</p>
                         <p class="call">
                             Got Question? Call us 24/7
                             <span>
                                 <a href="tel:{{ isset($settings) ? $settings->phone : '+1 800 123 4567' }}">
                                     {{ isset($settings) ? $settings->phone : '+1 800 123 4567' }}
                                 </a>
                             </span>
                         </p>
                     </div>
                 </div>

                 <div class="col-lg-2 col-6 ">
                     <div class="single-footer links">
                         <h4>Information</h4>
                         <ul>
                             <li><a href="{{ route('about-us') }}">About Us</a></li>
                             {{-- <li><a href="{{ route('faq') }}">Faq</a></li> --}}
                             {{-- <li><a href="{{ route('terms') }}">Terms & Conditions</a></li> --}}
                             <li><a href="{{ route('contact') }}">Contact Us</a></li>
                             {{-- <li><a href="{{ route('help') }}">Help</a></li> --}}
                             <li><a href="{{ route('return.exchange.policy') }}">Returns & Exchanges</a></li>
                             <li><a href="{{ route('shipping.policy') }}">Shipping</a></li>
                             <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                         </ul>
                     </div>
                 </div>

                 <div class="col-lg-2 col-6 ">
                     <div class="single-footer links">
                         <h4>Customer Service</h4>
                         <ul>
                             {{-- <li><a href="">Payment Methods</a></li> --}}
                             <li>Cash on Delivery</li>
                             <li>Free Shipping</li>
                             <li>7 Day Replacement</li>
                             <li>WhatsApp/Call Support</li>
                         </ul>
                     </div>
                 </div>

                 <div class="col-lg-4 col-12">
                     <div class="single-footer social">
                         <h4>Get In Touch</h4>
                         <div class="contact">
                             <ul>
                                 <li>{{ isset($settings) ? $settings->address : 'Dau kuti, Lucknow 226001' }}</li>
                                 <li>{{ isset($settings) ? $settings->email : 'support@Moonzio.com' }}</li>
                                 <li>{{ isset($settings) ? $settings->phone : '+91 8604133275' }}</li>
                             </ul>
                         </div>
                         <div class="social-icons mt-3">
                             <a href="https://www.facebook.com/share/18xUss5han/" class="mr-2"><i
                                     class="fab fa-facebook-f"></i></a>
                             {{-- <a href="#" class="mr-2"><i class="fab fa-twitter"></i></a> --}}
                             <a href="https://www.instagram.com/reel/DY5L0Wty7kk/?igsh=N3Y1cG93aWJxc290"
                                 class="mr-2"><i class="fab fa-instagram"></i></a>
                             {{-- <a href="#" class="mr-2"><i class="fab fa-youtube"></i></a> --}}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- Copyright -->
     <div class="copyright">
         <div class="container">
             <div class="inner">
                 <div class="row">
                     <div class="col-lg-6 col-12">
                         <div class="left"> 
                             <p>Copyright © 2026
                                 <a href="{{ route('home') }}" target="_blank">Moonzio</a>
                               - All Rights Reserved.
                             </p>
                         </div>
                     </div>
                     <div class="col-lg-6 col-12">
                         <div class="right">
                             <img src="{{ asset('backend/img/payments.png') }}" alt="Payment Methods">
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>



 <!-- Floating WhatsApp Button -->
 <a href="https://wa.me/918604133275?text=Hello%20Moonzio%20Team,%20I%20want%20to%20know%20more%20about%20your%20products."
     class="whatsapp-float" target="_blank">

<i class="fa-brands fa-rocketchat"></i>

     <span class="tooltip-text">Chat on WhatsApp</span>
 </a>
