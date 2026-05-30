@extends('frontend.layouts.master')

@section('title', 'E-SHOP || Return & Exchange Policy')

@section('main-content')
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
      color: #b87333; /* warm accent matching saree theme */
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
      <div class="col-12 policy-content">
        <h4>Return and Exchange Policy</h4>

        <p>At Vedika Home Decore, we are committed to providing you with the highest quality products. We understand that sometimes issues may arise, and we want to ensure your satisfaction. Please review our return and exchange policy below.</p>

        <!-- Returns Section -->
        <div class="policy-section-title">
          <i class="fas fa-undo-alt"></i> 
          <span>Returns</span>
        </div>
        <ul class="policy-list">
          <li>Vedika Home Decore does not accept returns. In case of defect, we only provide exchange.</li>
          <li><strong>Opening Video is compulsory for exchange</strong> – we won't accept any request without opening video.</li>
        </ul>

        <!-- Exchanges Section -->
        <div class="policy-section-title">
          <i class="fas fa-exchange-alt"></i>
          <span>Exchanges</span>
        </div>
        <ul class="policy-list">
          <li>If you receive a defective or damaged product, you may request an exchange within <strong>3 days</strong> of receiving the item.</li>
          <li>To initiate an exchange, please contact our customer service team at <strong>Whatsapp: +91 8604133275</strong> or email us at <strong>vinod190596@gmail.com</strong> with your order number and details about the defect.</li>
        </ul>

        <!-- Conditions for Exchanges -->
        <div class="policy-section-title">
          <i class="fas fa-clipboard-list"></i>
          <span>Conditions for Exchanges</span>
        </div>
        <ul class="policy-list">
          <li>The item must be unused, unworn, and in its original packaging.</li>
          <li>The defect or damage must be clearly visible and reported to Vedika Home Decore within 3 days of receiving the product.</li>
          <li>Proof of purchase, such as the order number or receipt, must be provided.</li>
        </ul>

        <!-- Exchange Process -->
        <div class="policy-section-title">
          <i class="fas fa-truck"></i>
          <span>Exchange Process</span>
        </div>
        <ul class="policy-list">
          <li>Contact our customer service team to report the defect and request an exchange (Whatsapp or Email).</li>
          <li>Our team will guide you through the necessary steps and provide you with a return shipping address if applicable.</li>
          <li>Once we receive the defective item and inspect it, we will process the exchange.</li>
          <li>If the item is no longer in stock, we will offer a similar item or issue a store credit.</li>
          <li><strong>Opening Video is compulsory for exchange – we won't accept without opening video.</strong></li>
        </ul>

        <!-- Shipping Costs for Exchanges -->
        <div class="policy-section-title">
          <i class="fas fa-shipping-fast"></i>
          <span>Shipping Costs for Exchanges</span>
        </div>
        <ul class="policy-list">
          <li>Vedika Home Decore will cover the shipping costs for the return and exchange of defective items.</li>
          <li>Customer itself has to courier the product via <strong>India Post only</strong>.</li>
          <li>Vedika Home Decore will transfer the India Post shipping charges once we receive the product in our hand.</li>
        </ul>

        <!-- Non-Defective Items -->
        <div class="policy-section-title">
          <i class="fas fa-box-open"></i>
          <span>Non-Defective Items</span>
        </div>
        <ul class="policy-list">
          <li>We do not accept exchanges for reasons other than product defects.</li>
          <li>Please carefully review your order before completing your purchase.</li>
        </ul>

        <!-- Cancellations -->
        <div class="policy-section-title">
          <i class="fas fa-ban"></i>
          <span>Cancellations</span>
        </div>
        <ul class="policy-list">
          <li>Orders cannot be canceled once they have been shipped. If you wish to cancel an order, please contact us as soon as possible, and we will do our best to assist you.</li>
        </ul>

        <!-- Contact Information - Highlighted -->
        <div class="contact-highlight">
          <i class="fas fa-headset" style="margin-right: 8px; color:#b87333;"></i>
          <strong>Contact Information:</strong><br>
          If you have any questions or concerns about our return and exchange policy, please contact our customer service team at <strong>Whatsapp : +91 8604133275</strong> or Mail us : <strong>vinod190596@gmail.com</strong>
        </div>

        <p style="margin-top: 1.5rem; font-style: italic; color: #4b5563;">Thank you for choosing Vedika Home Decore. We appreciate your understanding and cooperation in ensuring the quality and satisfaction of your shopping experience.</p>
      </div>
    </div>
  </div>
</section>
<!-- End Return & Exchange Policy Section -->



    @include('frontend.layouts.newsletter')
@endsection
