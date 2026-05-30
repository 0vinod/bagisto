@extends('frontend.layouts.master')

@section('title', 'E-Shop || Login Page')

@section('main-content')
    <!-- Modern Breadcrumbs -->
    <div class="modern-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Login Section -->
    <section class="modern-login section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="login-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2>Welcome Back!</h2>
                            <p>Please login to your account to continue shopping</p>
                        </div>
                        
                        <div class="login-body">
                            <form class="login-form" method="post" action="{{ route('login.submit') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i>
                                        Email Address
                                        <span class="required">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Enter your email address"
                                           required="required" 
                                           value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">
                                        <i class="fas fa-lock"></i>
                                        Password
                                        <span class="required">*</span>
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" 
                                               name="password" 
                                               id="password"
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Enter your password"
                                               required="required" 
                                               value="{{ old('password') }}">
                                        <button type="button" class="toggle-password" data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-options">
                                    <div class="checkbox">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="remember" id="remember">
                                            <span class="checkmark"></span>
                                            Remember me
                                        </label>
                                    </div>
                                    
                                    @if (Route::has('password.request'))
                                        <a class="forgot-password" href="{{ route('password.request') }}">
                                            <i class="fas fa-key"></i> Forgot Password?
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn-login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login to Your Account
                                    </button>
                                </div>
                                
                                <div class="register-link">
                                    <p>Don't have an account? 
                                        <a href="{{ route('register.form') }}">Create an account</a>
                                    </p>
                                </div>
                                
                                {{-- <div class="social-login">
                                    <div class="divider">
                                        <span>Or continue with</span>
                                    </div>
                                    <div class="social-buttons">
                                        <a href="{{ route('login.redirect', 'facebook') }}" class="social-btn facebook">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>Facebook</span>
                                        </a>
                                        <a href="{{ route('login.redirect', 'google') }}" class="social-btn google">
                                            <i class="fab fa-google"></i>
                                            <span>Google</span>
                                        </a>
                                        <a href="{{ route('login.redirect', 'github') }}" class="social-btn github">
                                            <i class="fab fa-github"></i>
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                    
                  
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Modern Login Styles */
    .modern-breadcrumbs {
        background: #f8f9fa;
        padding: 15px 0;
        margin-bottom: 30px;
    }
    
    .modern-breadcrumb {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        background: transparent;
    }
    
    .modern-breadcrumb .breadcrumb-item {
        color: #6c757d;
    }
    
    .modern-breadcrumb .breadcrumb-item a {
        color: #F7941D;
        text-decoration: none;
    }
    
    .modern-breadcrumb .breadcrumb-item.active {
        color: #333;
    }
    
    .modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding: 0 8px;
        color: #6c757d;
    }
    
    /* Login Card */
    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 50px rgba(0, 0, 0, 0.12);
    }
    
    .login-header {
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        padding: 10px 30px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .login-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
        background-size: 30px 30px;
        animation: shimmer 20s linear infinite;
    }
    
    @keyframes shimmer {
        0% {
            transform: translate(0, 0);
        }
        100% {
            transform: translate(50px, 50px);
        }
    }
    
    .login-icon {
        font-size: 64px;
        margin-bottom: 15px;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .login-header h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }
    
    .login-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }
    
    .login-body {
        padding: 40px 30px;
    }
    
    /* Form Groups */
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }
    
    .form-group label i {
        color: #F7941D;
        margin-right: 8px;
        width: 18px;
    }
    
    .required {
        color: #dc3545;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #F7941D;
        box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.1);
        background: white;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    /* Password Toggle */
    .password-wrapper {
        position: relative;
    }
    
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    
    .toggle-password:hover {
        color: #F7941D;
    }
    
    /* Form Options */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
        padding-left: 30px;
        font-size: 14px;
        color: #666;
        user-select: none;
    }
    
    .checkbox-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .checkmark {
        position: absolute;
        left: 0;
        top: 0;
        height: 20px;
        width: 20px;
        background-color: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .checkbox-label:hover input ~ .checkmark {
        background-color: #fef9f0;
    }
    
    .checkbox-label input:checked ~ .checkmark {
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        border-color: #F7941D;
    }
    
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .checkbox-label input:checked ~ .checkmark:after {
        display: block;
    }
    
    .checkbox-label .checkmark:after {
        left: 7px;
        top: 3px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .forgot-password {
        color: #F7941D;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .forgot-password:hover {
        color: #F76E1C;
        text-decoration: underline;
    }
    
    /* Login Button */
    .form-actions {
        margin-bottom: 20px;
    }
    
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    /* Register Link */
    .register-link {
        text-align: center;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
        margin-top: 10px;
    }
    
    .register-link p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
    
    .register-link a {
        color: #F7941D;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .register-link a:hover {
        color: #F76E1C;
        text-decoration: underline;
    }
    
    /* Social Login */
    .social-login {
        margin-top: 25px;
    }
    
    .divider {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }
    
    .divider:before,
    .divider:after {
        content: "";
        position: absolute;
        top: 50%;
        width: calc(50% - 80px);
        height: 1px;
        background: #e5e7eb;
    }
    
    .divider:before {
        left: 0;
    }
    
    .divider:after {
        right: 0;
    }
    
    .divider span {
        background: white;
        padding: 0 15px;
        font-size: 13px;
        color: #999;
    }
    
    .social-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    
    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #f8f9fa;
        color: #333;
        border: 1px solid #e5e7eb;
    }
    
    .social-btn i {
        font-size: 16px;
    }
    
    .social-btn.facebook {
        background: #1877f2;
        color: white;
        border: none;
    }
    
    .social-btn.facebook:hover {
        background: #0c63e4;
        transform: translateY(-2px);
    }
    
    .social-btn.google {
        background: #ea4335;
        color: white;
        border: none;
    }
    
    .social-btn.google:hover {
        background: #d33426;
        transform: translateY(-2px);
    }
    
    .social-btn.github {
        background: #24292e;
        color: white;
        border: none;
    }
    
    .social-btn.github:hover {
        background: #1a1e22;
        transform: translateY(-2px);
    }
    
    /* Demo Credentials */
    .demo-credentials {
        margin-top: 20px;
        background: #fef9f0;
        border-radius: 12px;
        padding: 15px;
        border-left: 4px solid #F7941D;
    }
    
    .demo-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-weight: 600;
        color: #F7941D;
    }
    
    .demo-header i {
        font-size: 16px;
    }
    
    .demo-content {
        display: flex;
        gap: 20px;
        font-size: 13px;
        color: #666;
    }
    
    .demo-content p {
        margin: 0;
    }
    
    .demo-content strong {
        color: #333;
    }
    
    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .login-card {
        animation: slideInUp 0.5s ease-out;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .login-header {
            padding: 30px 20px;
        }
        
        .login-header h2 {
            font-size: 24px;
        }
        
        .login-icon {
            font-size: 48px;
        }
        
        .login-body {
            padding: 30px 20px;
        }
        
        .social-buttons {
            flex-direction: column;
        }
        
        .social-btn {
            justify-content: center;
        }
        
        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .demo-content {
            flex-direction: column;
            gap: 5px;
        }
    }
    
    /* Loading State */
    .btn-login.loading {
        position: relative;
        pointer-events: none;
        opacity: 0.8;
    }
    
    .btn-login.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        right: 20px;
        margin-top: -10px;
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password Toggle
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Form Submission Loading State
        const loginForm = document.querySelector('.login-form');
        const loginBtn = document.querySelector('.btn-login');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                loginBtn.classList.add('loading');
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
            });
        }
        
        // Auto-fill demo credentials on click
        const demoCredentials = document.querySelector('.demo-credentials');
        if (demoCredentials) {
            demoCredentials.addEventListener('click', function() {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                
                if (emailInput && passwordInput) {
                    emailInput.value = 'demo@example.com';
                    passwordInput.value = 'demo123';
                    
                    // Add highlight effect
                    emailInput.style.transition = 'all 0.3s ease';
                    passwordInput.style.transition = 'all 0.3s ease';
                    emailInput.style.borderColor = '#F7941D';
                    passwordInput.style.borderColor = '#F7941D';
                    
                    setTimeout(() => {
                        emailInput.style.borderColor = '#e5e7eb';
                        passwordInput.style.borderColor = '#e5e7eb';
                    }, 2000);
                }
            });
        }
    });
</script>
@endpush