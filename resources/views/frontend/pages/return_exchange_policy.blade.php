@extends('frontend.layouts.master')

@section('title', 'Moonzio || Return, Refund & Exchange Policy')

@section('main-content')
  
    <style>
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
            .container {
                padding: 0 20px;
            }
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -12px;
        }

        .col-12 {
            width: 100%;
            padding: 0 12px;
        }

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
            color: #b87333;
            /* warm accent matching saree theme */
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

        /* Return & Exchange Policy Section */
        .return-us {
            padding: 70px 0 90px;
        }

        .return-us .row {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
            padding: 2rem 2rem 2.5rem;
            border: 1px solid #f0f2f8;
            transition: all 0.2s;
        }

        .return-us h4 {
            font-size: 1.9rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
            letter-spacing: -0.3px;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .return-us h4:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 70px;
            height: 3px;
            background: #b87333;
            border-radius: 4px;
        }

        /* policy text styling */
        .policy-content {
            margin-top: 8px;
        }

        .policy-content p {
            margin-bottom: 1.2rem;
            font-size: 1rem;
            color: #2d3a4a;
        }

        .policy-section-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 1.8rem;
            margin-bottom: 0.75rem;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #b87333;
            padding-left: 16px;
        }

        .policy-section-title i {
            color: #b87333;
            font-size: 1.3rem;
        }

        .policy-list {
            margin: 0.8rem 0 1rem 1.8rem;
            list-style-type: disc;
        }

        .policy-list li {
            margin-bottom: 0.5rem;
            line-height: 1.55;
        }

        .contact-highlight {
            background: #fef7e8;
            padding: 1.2rem 1.5rem;
            border-radius: 20px;
            margin: 1.5rem 0 0.8rem;
            border-left: 5px solid #b87333;
        }

        .contact-highlight strong {
            color: #b87333;
        }

        .badge-policy {
            background: #f1f5f9;
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #1e293b;
            display: inline-block;
            margin-right: 8px;
        }

        hr {
            margin: 1.5rem 0;
            border: none;
            border-top: 1px solid #e9edf2;
        }

        @media (max-width: 768px) {
            .return-us {
                padding: 45px 0;
            }

            .return-us .row {
                padding: 1.5rem;
            }

            .return-us h4 {
                font-size: 1.6rem;
            }

            .policy-section-title {
                font-size: 1.1rem;
            }
        }
    </style>
    </head>

    <body>

        <!-- Breadcrumbs (exactly as provided, with home link) -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bread-inner">
                            <ul class="bread-list">
                                <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                                <li class="active"><a href="blog-single.html">Return & Exchange Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- Return & Exchange Policy Section (enhanced layout with clear hierarchy) -->
        <section class="return-us section">
            <div class="container">
                <div class="row">
                    <h4>Return, Refund & Exchange Policy</h4>

                    <p>At Moonzio, customer satisfaction is our priority. We strive to provide high-quality products and a
                        smooth shopping experience. Please read our Return, Refund, Exchange, and Cancellation Policy
                        carefully before placing an order.</p>

                    <!-- Returns Section -->
                    <div class="policy-section-title">
                        <i class="fas fa-undo-alt"></i>
                        <span>Returns</span>
                    </div>
                    <ul class="policy-list">
                        <li>If you are not completely satisfied with your purchase, you may request a return within 3 days
                            of receiving the product.</li>
                        <li>Once the returned product is received and successfully passes our quality inspection, 100% of
                            the product value will be credited to your Moonzio Wallet.</li>
                        <li>Moonzio Wallet credits can be used for future purchases on our website.</li>
                        <li>For damaged, defective, missing, or incorrect products, an unboxing/opening video recorded from
                            the moment the package is opened is required for verification.</li>
                        <li>Claims submitted without a valid opening video may not be eligible for return or exchange
                            approval.</li>
                    </ul>

                    <!-- Refund Policy -->
                    <div class="policy-section-title">
                        <i class="fas fa-wallet"></i>
                        <span>Refund Policy</span>
                    </div>
                    <ul class="policy-list">
                        <li>Refunds are provided in the form of Moonzio Wallet Credit only.</li>
                        <li>After successful quality verification, the eligible refund amount will be credited to your
                            Moonzio Wallet.</li>
                        <li>Wallet credits can be used for future purchases on Moonzio.</li>
                        <li>Wallet credits are non-transferable and cannot be converted into cash or transferred to a bank
                            account unless required by applicable law.</li>
                    </ul>

                    <!-- Exchanges Section -->
                    <div class="policy-section-title">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Exchanges</span>
                    </div>
                    <ul class="policy-list">
                        <li>If you receive a damaged, defective, or incorrect product, you may request an exchange within
                            <strong>3 days</strong> of receiving the item.</li>
                        <li>To initiate an exchange, please contact our customer support team via <strong>WhatsApp: +91
                                8604133275</strong> or email us at <strong>support@moonzio.com</strong>.</li>
                    </ul>

                    <!-- Conditions for Exchanges -->
                    <div class="policy-section-title">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Conditions for Exchanges</span>
                    </div>
                    <ul class="policy-list">
                        <li>The item must be unused and in its original packaging.</li>
                        <li>The issue must be reported within 3 days of delivery.</li>
                        <li>Proof of purchase, such as the order number or receipt, must be provided.</li>
                        <li>Clear photos or videos may be requested for verification.</li>
                        <li>An unboxing/opening video is required for damaged, defective, missing, or incorrect item claims.
                        </li>
                    </ul>

                    <!-- Exchange Process -->
                    <div class="policy-section-title">
                        <i class="fas fa-truck"></i>
                        <span>Exchange Process</span>
                    </div>
                    <ul class="policy-list">
                        <li>Contact our customer support team via WhatsApp or email.</li>
                        <li>Provide your order number and details of the issue.</li>
                        <li>Our team will review your request and provide further instructions.</li>
                        <li>If required, return the product to the address provided by our support team.</li>
                        <li>After inspection and approval, a replacement product will be shipped.</li>
                        <li>If the same product is unavailable, Moonzio may offer a similar replacement product or store
                            credit.</li>
                    </ul>

                    <!-- Non-Defective Items -->
                    <div class="policy-section-title">
                        <i class="fas fa-box-open"></i>
                        <span>Non-Returnable & Non-Exchangeable Items</span>
                    </div>
                    <ul class="policy-list">
                        <li>Products damaged due to misuse, negligence, or improper handling.</li>
                        <li>Products returned without original packaging.</li>
                        <li>Requests submitted after the allowed return or exchange period.</li>
                        <li>Products showing signs of use or alteration by the customer.</li>
                        <li>Change-of-mind requests for products that are delivered correctly and without defects.</li>
                    </ul>

                    <!-- Shipping Information -->
                    <div class="policy-section-title">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Shipping Information</span>
                    </div>
                    <ul class="policy-list">
                        <li>Orders are generally processed within 24–48 hours after confirmation.</li>
                        <li>Delivery typically takes 3–7 business days depending on your location and courier availability.
                        </li>
                        <li>Tracking details will be shared via email or WhatsApp after dispatch.</li>
                        <li>Delivery delays caused by weather conditions, public holidays, courier issues, or unforeseen
                            circumstances may occur.</li>
                    </ul>

                    <!-- Cancellations -->
                    <div class="policy-section-title">
                        <i class="fas fa-ban"></i>
                        <span>Order Cancellation</span>
                    </div>
                    <ul class="policy-list">
                        <li>Orders may be cancelled before they are shipped.</li>
                        <li>Once an order has been shipped, cancellation requests cannot be guaranteed.</li>
                        <li>If you wish to cancel an order, please contact our customer support team as soon as possible.
                        </li>
                    </ul>

                    <!-- Contact Information -->
                    <div class="contact-highlight">
                        <i class="fas fa-headset" style="margin-right: 8px; color:#b87333;"></i>
                        <strong>Contact Information:</strong><br>
                        Business Name: Moonzio<br>
                        WhatsApp: <strong>+91 8604133275</strong><br>
                        Email: <strong>support@moonzio.com</strong>
                    </div>

                    <p style="margin-top: 1.5rem; font-style: italic; color: #4b5563;">
                        Thank you for choosing Moonzio. We appreciate your trust and look forward to serving you.
                    </p>
                </div>
            </div>
        </section>
        <!-- End Return & Exchange Policy Section -->



        @include('frontend.layouts.newsletter')
    @endsection
