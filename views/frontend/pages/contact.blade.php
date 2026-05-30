@extends('frontend.layouts.master')

  <style>
        /* Reset & base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            line-height: 1.5;
        }
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        @media (max-width: 640px) {
            .container { padding: 0 20px; }
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -12px;
        }
        .col-lg-8, .col-lg-6, .col-12, .col-lg-4 {
            padding: 0 12px;
            width: 100%;
        }
        .col-lg-8 { flex: 0 0 66.6666%; max-width: 66.6666%; }
        .col-lg-4 { flex: 0 0 33.3333%; max-width: 33.3333%; }
        .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
        @media (max-width: 992px) {
            .col-lg-8, .col-lg-4, .col-lg-6 { flex: 0 0 100%; max-width: 100%; }
        }
        .col-12 { flex: 0 0 100%; max-width: 100%; }
        
        /* Breadcrumbs */
        .breadcrumbs {
            background: #f8fafc;
            padding: 20px 0;
            border-bottom: 1px solid #e9edf2;
        }
        .bread-inner .bread-list {
            list-style: none;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
        }
        .bread-list li {
            font-size: 14px;
        }
        .bread-list li a {
            text-decoration: none;
            color: #475569;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .bread-list li a:hover {
            color: #2563eb;
        }
        .bread-list li.active a {
            color: #0f172a;
            font-weight: 600;
            cursor: default;
        }
        .bread-list li a i {
            font-style: normal;
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
        }
        .bread-list li a i:before {
            content: "\f054";
        }
        
        /* Contact Section */
        .contact-us {
            padding: 70px 0 80px;
        }
        .form-main {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
            padding: 2rem 2rem 2.2rem;
            border: 1px solid #eef2f8;
        }
        .title h4 {
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #3b82f6;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .title h3 {
            font-size: 1.85rem;
            font-weight: 700;
            margin-bottom: 28px;
            color: #0f172a;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }
        .title h3 .text-danger {
            font-size: 0.75rem;
            background: #fee2e2;
            padding: 4px 14px;
            border-radius: 30px;
            font-weight: 500;
            color: #b91c1c;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 0.9rem;
            color: #1e293b;
        }
        .form-group label span {
            color: #ef4444;
            margin-left: 2px;
        }
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 12px 18px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background-color: #fefefe;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            font-family: inherit;
            color: #0f172a;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.08);
            background-color: #ffffff;
        }
        .btn {
            background: #0f172a;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn:hover {
            background: #c8cbd1;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -12px rgba(0,0,0,0.2);
        }
        .btn:active { transform: translateY(1px); }
        
        /* Right side info cards */
        .single-head {
            background: #ffffff;
            border-radius: 28px;
            padding: 2rem 1.8rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.04);
            border: 1px solid #eef2f8;
        }
        .single-info {
            margin-bottom: 34px;
        }
        .single-info i {
            font-size: 1.8rem;
            color: #2563eb;
            background: #eef2ff;
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 28px;
            margin-bottom: 16px;
        }
        .single-info .title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #0f172a;
        }
        .single-info ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        .single-info ul li {
            margin-bottom: 8px;
            color: #334155;
            word-break: break-word;
        }
        .single-info ul li a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .single-info ul li a:hover {
            text-decoration: underline;
        }
        
        /* Map Section */
        .map-section {
            width: 100%;
            height: 380px;
            background: #eef2ff;
        }
        #myMap {
            width: 100%;
            height: 100%;
        }
        #myMap iframe {
            width: 100%;
            height: 100%;
            display: block;
            border: 0;
        }
        
        /* Newsletter section (simulated include) */
        .newsletter-area {
            background: #f1f5f9;
            padding: 60px 0;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .newsletter-inner h4 {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .newsletter-inner p {
            color: #475569;
            margin-bottom: 24px;
        }
        
        /* Modal styling (exactly per original but modernized) */
        .modal-dialog .modal-content {
            border-radius: 28px;
            border: none;
            box-shadow: 0 25px 45px -12px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .modal-dialog .modal-content .modal-header {
            position: initial;
            padding: 18px 24px;
            border-bottom: 1px solid #f0f2f5;
            background: #ffffff;
        }
        .modal-dialog .modal-content .modal-body {
            padding: 20px 24px;
            height: auto;
            min-height: 100px;
        }
        .modal-dialog .modal-content {
            width: 90%;
            max-width: 460px;
            border-radius: 28px;
            margin: 1.75rem auto;
        }
        @media (min-width: 576px) {
            .modal-dialog .modal-content { width: 100%; }
        }
        .text-success { color: #10b981 !important; }
        .text-warning { color: #f59e0b !important; }
        .btn-close-custom {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
            padding: 0;
        }
        .close span {
            font-size: 1.8rem;
            color: #64748b;
        }
        
        /* validation error styles */
        .error-message, label.error {
            font-size: 0.7rem;
            color: #ef4444;
            margin-top: 5px;
            display: inline-block;
            font-weight: normal;
        }
        input.error, textarea.error {
            border-color: #f97316;
            background-color: #fffaf5;
        }
        .is-invalid {
            border-color: #f97316 !important;
        }
    </style>
</head>
<body>

<!-- Main content wrapper simulating the blade section -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="#">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Contact -->
<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="contact-head">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="form-main">
                        <div class="title">
                            <!-- Static simulation of settings data (since no DB, inline demo values) -->
                            <h4>Get in touch</h4>
                            <h3>Write us a message <span style="font-size:12px;" class="text-danger">[You need to login first]</span></h3>
                        </div>
                        <form class="form-contact contact_form" method="post" action="#" id="contactForm" novalidate="novalidate">
                            <!-- Simulated CSRF field for consistency -->
                            <input type="hidden" name="_token" value="simulated_token">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Name<span>*</span></label>
                                        <input name="name" id="name" type="text" placeholder="Enter your name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Subjects<span>*</span></label>
                                        <input name="subject" type="text" id="subject" placeholder="Enter Subject">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input name="email" type="email" id="email" placeholder="Enter email address">
                                    </div>	
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Your Phone<span>*</span></label>
                                        <input id="phone" name="phone" type="text" placeholder="Enter your phone">
                                    </div>	
                                </div>
                                <div class="col-12">
                                    <div class="form-group message">
                                        <label>your message<span>*</span></label>
                                        <textarea name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group button">
                                        <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-head">
                        <div class="single-info">
                            <i class="fa fa-phone"></i>
                            <h4 class="title">Call us Now:</h4>
                            <ul>
                                <li>+1 (800) 456-7890</li>
                                <li>+44 20 7946 0138</li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-envelope-open"></i>
                            <h4 class="title">Email:</h4>
                            <ul>
                                <li><a href="mailto:hello@ecomstore.com">hello@ecomstore.com</a></li>
                                <li><a href="mailto:support@ecomstore.com">support@ecomstore.com</a></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-location-arrow"></i>
                            <h4 class="title">Our Address:</h4>
                            <ul>
                                <li>4517 Washington Ave, Manchester, Kentucky 39495, USA</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (exact iframe from original) -->
<div class="map-section">
    <div id="myMap">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14130.857353934944!2d85.36529494999999!3d27.6952226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sne!2snp!4v1595323330171!5m2!1sne!2snp" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
</div>

<!-- Start Shop Newsletter (simulated include) -->
<div class="newsletter-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="newsletter-inner">
                    <h4>Join Our Newsletter</h4>
                    <p>Get the latest updates and exclusive offers straight to your inbox.</p>
                    <div style="max-width: 480px; margin: 20px auto 0;">
                        <div class="input-group" style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;">
                            <input type="email" placeholder="Your email address" style="flex:1; min-width: 200px; padding: 12px 20px; border-radius: 60px; border: 1px solid #cbd5e1;">
                            <button class="btn" style="background:#2563eb;">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Success (exact original style + modern structure) -->
<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-success"><i class="fas fa-check-circle me-2"></i> Thank you!</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-success">Your message is successfully sent...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i> Sorry!</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-warning">Something went wrong.</p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts: jQuery Validate, jQuery Form, Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<script>
    (function($) {
        $(document).ready(function() {
            // Override phone input to accept only digits (type=number can cause issues with non-numeric, better to use text but restrict)
            $('#phone').on('keypress', function(e) {
                var charCode = e.which ? e.which : e.keyCode;
                if (charCode < 48 || charCode > 57) {
                    e.preventDefault();
                }
            });
            
            // Initialize validation with robust rules
            $("#contactForm").validate({
                rules: {
                    name: { required: true, minlength: 2, maxlength: 70 },
                    subject: { required: true, minlength: 3, maxlength: 120 },
                    email: { required: true, email: true },
                    phone: { required: true, digits: true, minlength: 7, maxlength: 15 },
                    message: { required: true, minlength: 10, maxlength: 2000 }
                },
                messages: {
                    name: { required: "Please enter your name", minlength: "At least 2 characters" },
                    subject: { required: "Subject is required", minlength: "Minimum 3 characters" },
                    email: { required: "Email address is required", email: "Valid email required" },
                    phone: { required: "Phone number is required", digits: "Only numbers allowed", minlength: "Enter a valid phone number" },
                    message: { required: "Message cannot be empty", minlength: "Message must be at least 10 characters" }
                },
                errorClass: "error-message",
                errorElement: "label",
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback d-block');
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    var $btn = $(form).find('button[type="submit"]');
                    var originalHtml = $btn.html();
                    $btn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
                    
                    // Gather form data for simulation
                    var formData = {
                        name: $('#name').val(),
                        subject: $('#subject').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        message: $('#message').val(),
                        _token: 'dummy'
                    };
                    
                    // Simulate network request (mimic AJAX post)
                    setTimeout(function() {
                        // For demo, always succeed (show success modal)
                        // You can optionally toggle random error by uncommenting line, but original behavior expects success/failure
                        var isSuccess = true; // Always success for clean demo
                        if (isSuccess) {
                            var successModal = new bootstrap.Modal(document.getElementById('success'));
                            successModal.show();
                            form.reset();
                            // Remove validation highlight classes
                            $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                            $btn.html(originalHtml).prop('disabled', false);
                            setTimeout(function() { successModal.hide(); }, 3200);
                        } else {
                            var errorModal = new bootstrap.Modal(document.getElementById('error'));
                            errorModal.show();
                            $btn.html(originalHtml).prop('disabled', false);
                            setTimeout(function() { errorModal.hide(); }, 2800);
                        }
                    }, 900);
                    
                    return false; // prevent actual form POST
                }
            });
        });
    })(jQuery);
</script>

<!-- additional style to keep exactly same modal css as push style -->
<style>
    .modal-dialog .modal-content .modal-header {
        position: initial;
        padding: 10px 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .modal-dialog .modal-content .modal-body {
        height: auto;
        min-height: 100px;
        padding: 10px 20px;
    }
    .modal-dialog .modal-content {
        width: 50%;
        border-radius: 0;
        margin: auto;
    }
    @media (max-width: 768px) {
        .modal-dialog .modal-content {
            width: 90%;
        }
    }
    .close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    .close:hover {
        opacity: 1;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
</style>
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush