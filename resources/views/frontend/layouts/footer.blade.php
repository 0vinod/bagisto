<footer class="footer">
    <!-- Footer Top -->
    @php
								$settings=DB::table('settings')->first();
							@endphp
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <!-- About Widget -->
                    <div class="single-footer about">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('backend/img/logo2.png') }}" alt="{{ config('app.name') }}">
                            </a>
                        </div>  
                        <p class="text">{!! isset($settings) ? $settings->short_des : 'Your one-stop destination for trendy fashion, electrnics, and lifestyle products. Quality guaranteed.' !!}</p>
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
                
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="single-footer links">
                        <h4>Information</h4>
                        <ul>
                            <li><a href="{{ route('about-us') }}">About Us</a></li>
                            {{-- <li><a href="{{ route('faq') }}">Faq</a></li> --}}
                            {{-- <li><a href="{{ route('terms') }}">Terms & Conditions</a></li> --}}
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            {{-- <li><a href="{{ route('help') }}">Help</a></li> --}}
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="single-footer links">
                        <h4>Customer Service</h4>
                        <ul>
                            {{-- <li><a href="">Payment Methods</a></li> --}}
                            <li><a href=" ">Returns</a></li>
                            <li><a href=" ">Shipping</a></li>
                            <li><a href=" ">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-footer social">
                        <h4>Get In Touch</h4>
                        <div class="contact">
                            <ul>
                                <li>{{ isset($settings) ? $settings->address : '123 Market St, San Francisco, CA' }}</li>
                                <li>{{ isset($settings) ? $settings->email : 'support@Moonzio.com' }}</li>
                                <li>{{ isset($settings) ? $settings->phone : '+1 800 123 4567' }}</li>
                            </ul>
                        </div>
                        <div class="social-icons mt-3">
                            <a href="#" class="mr-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="mr-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="mr-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="mr-2"><i class="fab fa-youtube"></i></a>
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
                            <p>Copyright © {{ date('Y') }} 
                                <a href="{{ route('home') }}" target="_blank">{{ config('app.name') }}</a> 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
  .whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;

    width: 65px;
    height: 65px;
    border-radius: 50%;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    transition: all 0.25s ease;
    text-decoration: none;

    animation: pulse 1.5s infinite;
    background: white;
  }

  /* Image */
  .whatsapp-float img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .whatsapp-float:hover {
    transform: scale(1.08);
  }

  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5);
    }
    70% {
      box-shadow: 0 0 0 12px rgba(37, 211, 102, 0);
    }
    100% {
      box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
    }
  }

  .tooltip-text {
    position: absolute;
    right: 75px;
    background: #1f2a3e;
    color: white;
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 13px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: 0.2s;
  }

  .whatsapp-float:hover .tooltip-text {
    opacity: 1;
    visibility: visible;
  }

  @media (max-width: 480px) {
    .whatsapp-float {
      width: 55px;
      height: 55px;
      bottom: 20px;
      right: 20px;
    }

    .tooltip-text{
      display:none;
    }
  }
</style>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/918604133275?text=Hello%20Vedika%20Home%20Decor,%20I%20want%20to%20know%20more%20about%20your%20products."
   class="whatsapp-float"
   target="_blank">

    <!-- YOUR DP IMAGE -->
    <img src="{{ asset('images/whatsapp-icon.png') }}" alt="WhatsApp">

    <span class="tooltip-text">Chat on WhatsApp</span>
</a>
<style>
.footer {
    background: #1e272e;
    color: #dcdde1;
}

.footer-top.section {
    padding: 55px 0 40px;
}

.single-footer.about .logo img {
    max-width: 140px;
    margin-bottom: 15px;
}

.single-footer p, 
.single-footer ul li a {
    color: #bdc3c7;
    font-size: 14px;
    line-height: 1.7;
}

.single-footer ul {
    list-style: none;
    padding-left: 0;
}

.single-footer ul li {
    margin-bottom: 10px;
}

.single-footer ul li a:hover {
    color: #F7941D;
}

.single-footer h4 {
    color: #fff;
    font-size: 18px;
    margin-bottom: 20px;
    font-weight: 600;
}

.copyright {
    background: #141a1f;
    padding: 20px 0;
    text-align: center;
}

.copyright p {
    margin: 0;
    font-size: 13px;
}

.social-icons a {
    color: #bdc3c7;
    font-size: 18px;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    color: #F7941D;
}

@media (max-width: 768px) {
    .footer-top.section {
        padding: 40px 0 20px;
    }
    
    .single-footer {
        margin-bottom: 30px;
        text-align: center;
    }
    
    .single-footer .logo {
        text-align: center;
    }
}
</style>