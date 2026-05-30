<!-- Start Shop Newsletter -->
<section class="modern-newsletter section">
    <div class="container">
        <div class="newsletter-wrapper">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="newsletter-content">
                        <div class="newsletter-icon">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <h4>Subscribe to Our Newsletter</h4>
                        <p>Get <span class="discount-text">10% off</span> your first purchase and receive exclusive offers,新品通知, and style inspiration directly in your inbox!</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <form action="{{ route('subscribe') }}" method="post" class="newsletter-form">
                        @csrf
                        <div class="input-group">
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="Enter your email address" 
                                   required
                                   value="{{ old('email') }}">
                            <button class="btn btn-subscribe" type="submit">
                                <i class="fas fa-paper-plane"></i>
                                Subscribe
                            </button>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-lock"></i> We respect your privacy. Unsubscribe at any time.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->

<style>
    /* Modern Newsletter Section with Orange Gradient */
    .modern-newsletter {
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        position: relative;
        overflow: hidden;
        padding: 60px 0;
    }
    
    .modern-newsletter::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 1%, transparent 1%);
        background-size: 50px 50px;
        animation: shimmer 20s linear infinite;
        pointer-events: none;
    }
    
    @keyframes shimmer {
        0% {
            transform: translate(0, 0);
        }
        100% {
            transform: translate(50px, 50px);
        }
    }
    
    .newsletter-wrapper {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 50px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .newsletter-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }
    
    .newsletter-content {
        color: white;
    }
    
    .newsletter-icon {
        font-size: 48px;
        margin-bottom: 20px;
        animation: float 3s ease-in-out infinite;
        filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .newsletter-content h4 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .newsletter-content p {
        font-size: 16px;
        line-height: 1.6;
        opacity: 0.95;
        margin: 0;
    }
    
    .discount-text {
        background: rgba(255, 255, 255, 0.25);
        padding: 2px 12px;
        border-radius: 20px;
        font-weight: 700;
        color: white;
        display: inline-block;
        backdrop-filter: blur(5px);
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .newsletter-form {
        width: 100%;
    }
    
    .input-group {
        display: flex;
        gap: 12px;
        background: white;
        border-radius: 60px;
        padding: 5px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .newsletter-form .form-control {
        flex: 1;
        border: none;
        padding: 14px 24px;
        font-size: 16px;
        border-radius: 60px;
        background: transparent;
        transition: all 0.3s ease;
    }
    
    .newsletter-form .form-control:focus {
        outline: none;
        box-shadow: none;
        background: transparent;
    }
    
    .newsletter-form .form-control::placeholder {
        color: #999;
    }
    
    .btn-subscribe {
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 148, 29, 0.4);
        background: linear-gradient(135deg, #F76E1C 0%, #F7941D 100%);
    }
    
    .btn-subscribe:active {
        transform: translateY(0);
    }
    
    .btn-subscribe i {
        font-size: 14px;
        transition: transform 0.3s ease;
    }
    
    .btn-subscribe:hover i {
        transform: translateX(3px);
    }
    
    .form-text {
        font-size: 12px;
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.9);
    }
    
    .form-text i {
        font-size: 11px;
    }
    
    /* Success Message Animation */
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .alert-success {
        animation: slideInDown 0.5s ease-out;
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 12px;
        color: white;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .alert-danger {
        animation: slideInDown 0.5s ease-out;
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        border-radius: 12px;
        color: white;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Loading State */
    .btn-subscribe.loading {
        position: relative;
        pointer-events: none;
        opacity: 0.8;
    }
    
    .btn-subscribe.loading::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        top: 50%;
        right: 20px;
        margin-top: -9px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .newsletter-wrapper {
            padding: 40px;
        }
        
        .newsletter-content {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .newsletter-content h4 {
            font-size: 24px;
        }
        
        .input-group {
            flex-direction: column;
            border-radius: 12px;
            background: white;
            padding: 10px;
        }
        
        .newsletter-form .form-control {
            padding: 12px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }
        
        .btn-subscribe {
            width: 100%;
            justify-content: center;
            padding: 12px;
            border-radius: 12px;
        }
        
        .form-text {
            text-align: center;
            justify-content: center;
        }
    }
    
    @media (max-width: 768px) {
        .modern-newsletter {
            padding: 40px 0;
        }
        
        .newsletter-wrapper {
            padding: 30px 20px;
        }
        
        .newsletter-content h4 {
            font-size: 22px;
        }
        
        .newsletter-content p {
            font-size: 14px;
        }
        
        .newsletter-icon {
            font-size: 36px;
        }
    }
    
    /* Optional: Add floating particles */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }
    
    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        animation: float-particle 10s linear infinite;
    }
    
    @keyframes float-particle {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100vh) rotate(360deg);
            opacity: 0;
        }
    }
    
    /* Input Focus Effects */
    .newsletter-form .form-control:focus {
        border-color: #F7941D;
        box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.1);
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.querySelector('.newsletter-form');
        const subscribeBtn = document.querySelector('.btn-subscribe');
        
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                // Add loading state
                if (subscribeBtn) {
                    subscribeBtn.classList.add('loading');
                    subscribeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
                }
                
                // Form will submit normally
                // The loading state will be removed after page reload or via AJAX
            });
        }
        
        // Optional: Add floating particles
        const newsletterSection = document.querySelector('.modern-newsletter');
        if (newsletterSection && !document.querySelector('.particles')) {
            const particlesDiv = document.createElement('div');
            particlesDiv.className = 'particles';
            
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 5 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.animationDuration = Math.random() * 10 + 5 + 's';
                particlesDiv.appendChild(particle);
            }
            
            newsletterSection.style.position = 'relative';
            newsletterSection.appendChild(particlesDiv);
        }
    });
</script>
@endpush

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif