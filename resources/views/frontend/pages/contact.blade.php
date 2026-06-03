@extends('frontend.layouts.master')

@section('title','Moonzio || Contact')

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
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
                               
                                <li>+918604133275</li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-envelope-open"></i>
                            <h4 class="title">Email:</h4>
                            <ul>
                                <li><a href="mailto:support@ecomstore.com">support@moonzio.com</a></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-location-arrow"></i>
                            <h4 class="title">Our Address:</h4>
                            <ul>
                                <li>Dau Kuti, Burlington, Lucknow 2260001</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (exact iframe from original) -->
<div class="map-section mb-3">
    <div id="myMap">
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d10069.921631606192!2d80.93685573800101!3d26.831842627992014!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1780420902391!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

	@include('frontend.layouts.newsletter')
@endsection
