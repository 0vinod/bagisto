@extends('frontend.layouts.master')

@section('main-content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">We Value Your Feedback!</h4>
                        <small>Share your experience with us</small>
                    </div>
                    <div class="card-body">
                        <form id="feedbackForm" action="{{ route('feedback.submit') }}" method="POST">
                            @csrf

                            <!-- Full Name -->
                            <div class="form-group mb-3">
                                <label for="customer_name" class="fw-bold">Full Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name" placeholder="Enter your full name"
                                    value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group mb-3">
                                <label for="mobile" class="fw-bold">Mobile Number *</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                    id="mobile" name="mobile" placeholder="Enter 10-digit mobile number"
                                    value="{{ old('mobile') }}" maxlength="10" required>
                                @error('mobile')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rating Stars -->
                            <div class="form-group mb-3">
                                <label class="fw-bold d-block">How would you rate your experience?</label>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star" data-rating="{{ $i }}"
                                            style="cursor: pointer; font-size: 2rem;">
                                            <i class="fas fa-star text-muted"></i>
                                        </span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
                                <small id="ratingLabel" class="text-muted">Select a rating</small>
                            </div>

                            <!-- Feedback Suggestions Carousel -->
                            <div id="suggestionsCarousel" class="mb-3" style="display: none;">
                                <label class="fw-bold d-block">Choose what best describes your experience</label>
                                <small class="text-muted d-block mb-2">Select one option from below</small>
                                <div class="suggestions-wrapper"
                                    style="overflow-x: auto; white-space: nowrap; padding: 10px 0;">
                                    <div id="suggestionsContainer" class="d-flex gap-3" style="display: inline-flex;">
                                        <!-- Cards will be dynamically inserted here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback Textarea -->
                            <div class="form-group mb-3">
                                <label for="notes" class="fw-bold">Your Feedback</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="5"
                                    placeholder="How can we help you?" required>{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small id="charCount" class="text-muted">0 characters</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                Submit Feedback
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thank You!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <h4 class="mb-3">We Value Your Feedback!</h4>
                    <p class="text-muted">Thank you for sharing your experience with us. Your feedback helps us improve our
                        services.</p>
                    <div class="mt-3">
                        <span class="badge bg-success p-2">Feedback Submitted Successfully</span>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="doneButton" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>Done
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .star {
            transition: all 0.3s ease;
            padding: 5px;
            display: inline-block;
        }

        .star:hover {
            transform: scale(1.2);
        }

        .star.selected .fas {
            color: #ffc107 !important;
        }

        .star .fas {
            transition: color 0.3s ease;
        }

        .suggestion-card {
            display: inline-block;
            min-width: 200px;
            max-width: 250px;
            padding: 15px;
            margin: 0 10px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            text-align: center;
            white-space: normal;
            word-wrap: break-word;
            vertical-align: top;
        }

        .suggestion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .suggestion-card.selected {
            border-color: #0d6efd;
            background: #f0f7ff;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
        }

        .suggestion-card .card-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .suggestion-card .card-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .suggestion-card .card-text {
            font-size: 0.85rem;
            color: #666;
        }

        .suggestions-wrapper {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .suggestions-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .suggestions-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .suggestions-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .suggestions-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #charCount {
            display: block;
            text-align: right;
            margin-top: 5px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            'use strict';

            document.addEventListener('DOMContentLoaded', function() {
                // Rating suggestion data based on rating
                const suggestionsByRating = {
                    1: [{
                            icon: '😞',
                            title: 'Very Dissatisfied',
                            text: 'The service was very poor. I am disappointed with the overall experience and would like to see significant improvements.'
                        },
                        {
                            icon: '😤',
                            title: 'Poor Service',
                            text: 'The service did not meet my expectations. There were multiple issues that need immediate attention.'
                        },
                        {
                            icon: '🤔',
                            title: 'Disappointed',
                            text: 'I had a disappointing experience due to the lack of professionalism and support provided.'
                        }
                    ],
                    2: [{
                            icon: '😕',
                            title: 'Below Average',
                            text: 'The experience was below average. Some aspects were okay but many areas need improvement.'
                        },
                        {
                            icon: '🤨',
                            title: 'Not Satisfied',
                            text: 'I am not satisfied with the service. There were issues with quality and timely delivery.'
                        },
                        {
                            icon: '😐',
                            title: 'Room for Improvement',
                            text: 'There is significant room for improvement in the service quality and customer support.'
                        }
                    ],
                    3: [{
                            icon: '😐',
                            title: 'Average Experience',
                            text: 'The experience was average. Nothing exceptional but the service was generally acceptable.'
                        },
                        {
                            icon: '🤷',
                            title: 'Okay Service',
                            text: 'The service was okay. It met basic expectations but could definitely be better.'
                        },
                        {
                            icon: '👍',
                            title: 'Decent Service',
                            text: 'Overall decent service. Some aspects were good while others need refinement.'
                        }
                    ],
                    4: [{
                            icon: '😊',
                            title: 'Good Experience',
                            text: 'I had a good experience with the service. The team was helpful and professional throughout.'
                        },
                        {
                            icon: '⭐',
                            title: 'Very Satisfied',
                            text: 'Very satisfied with the service quality. The team went above and beyond to help.'
                        },
                        {
                            icon: '🙌',
                            title: 'Impressive Service',
                            text: 'Impressive service. The team was knowledgeable and provided excellent support.'
                        }
                    ],
                    5: [{
                            icon: '🌟',
                            title: 'Excellent Service',
                            text: 'Excellent service! The team was professional, helpful and made the whole experience smooth and easy.'
                        },
                        {
                            icon: '🏆',
                            title: 'Outstanding Experience',
                            text: 'Outstanding experience! Everything was perfect and exceeded my expectations.'
                        },
                        {
                            icon: '🎉',
                            title: 'Highly Recommended',
                            text: 'Highly recommended! The service was exceptional and I would definitely use it again.'
                        }
                    ]
                };

                const ratingLabels = {
                    1: 'Poor',
                    2: 'Fair',
                    3: 'Good',
                    4: 'Very Good',
                    5: 'Excellent'
                };

                let selectedRating = 0;
                let selectedSuggestion = null;

                // Get elements
                const elements = {
                    notes: document.getElementById('notes'),
                    charCount: document.getElementById('charCount'),
                    rating: document.getElementById('rating'),
                    ratingLabel: document.getElementById('ratingLabel'),
                    suggestionsCarousel: document.getElementById('suggestionsCarousel'),
                    suggestionsContainer: document.getElementById('suggestionsContainer'),
                    feedbackForm: document.getElementById('feedbackForm'),
                    submitBtn: document.getElementById('submitBtn'),
                    stars: document.querySelectorAll('.star'),
                    ratingStars: document.querySelector('.rating-stars'),
                    mobile: document.getElementById('mobile')
                };

                // Check if essential elements exist
                if (!elements.notes || !elements.charCount) {
                    console.warn('Essential elements not found');
                    return;
                }

                // Character counter
                function updateCharCount() {
                    try {
                        const length = elements.notes.value.length;
                        elements.charCount.textContent = length + ' characters';
                    } catch (e) {
                        console.warn('Error updating char count:', e);
                    }
                }

                // Highlight stars
                function highlightStars(rating) {
                    try {
                        elements.stars.forEach(star => {
                            const starRating = parseInt(star.dataset.rating);
                            const icon = star.querySelector('.fas');
                            if (icon) {
                                if (starRating <= rating && rating > 0) {
                                    icon.classList.remove('text-muted');
                                    icon.classList.add('text-warning');
                                    star.classList.add('selected');
                                } else {
                                    icon.classList.remove('text-warning');
                                    icon.classList.add('text-muted');
                                    star.classList.remove('selected');
                                }
                            }
                        });
                    } catch (e) {
                        console.error('Error in highlightStars:', e);
                    }
                }

                // Select rating
                function selectRating(rating) {
                    try {
                        selectedRating = rating;
                        elements.rating.value = rating;
                        highlightStars(rating);
                        elements.ratingLabel.textContent = ratingLabels[rating] + ' (' + rating + '/5)';
                        showSuggestions(rating);
                    } catch (e) {
                        console.error('Error in selectRating:', e);
                    }
                }

                // Show suggestions
                function showSuggestions(rating) {
                    try {
                        const suggestions = suggestionsByRating[rating] || [];

                        if (!elements.suggestionsCarousel || !elements.suggestionsContainer) {
                            return;
                        }

                        if (suggestions.length === 0) {
                            elements.suggestionsCarousel.style.display = 'none';
                            return;
                        }

                        elements.suggestionsContainer.innerHTML = '';
                        suggestions.forEach((suggestion, index) => {
                            const card = document.createElement('div');
                            card.className = 'suggestion-card';
                            card.dataset.index = index;
                            card.innerHTML = `
                        <div class="card-icon">${suggestion.icon}</div>
                        <div class="card-title">${suggestion.title}</div>
                        <div class="card-text">${suggestion.text.substring(0, 60)}...</div>
                    `;
                            card.addEventListener('click', function() {
                                selectSuggestion(index, suggestions);
                            });
                            elements.suggestionsContainer.appendChild(card);
                        });

                        elements.suggestionsCarousel.style.display = 'block';
                        clearSuggestionSelection();
                        selectedSuggestion = null;
                    } catch (e) {
                        console.error('Error in showSuggestions:', e);
                    }
                }

                // Select suggestion
                function selectSuggestion(index, suggestions) {
                    try {
                        clearSuggestionSelection();
                        const cards = document.querySelectorAll('.suggestion-card');
                        if (cards[index]) {
                            cards[index].classList.add('selected');
                        }
                        selectedSuggestion = index;
                        const suggestion = suggestions[index];
                        if (suggestion && suggestion.text) {
                            elements.notes.value = suggestion.text;
                            updateCharCount();
                            elements.notes.focus();
                        }
                    } catch (e) {
                        console.error('Error in selectSuggestion:', e);
                    }
                }

                // Clear suggestion selection
                function clearSuggestionSelection() {
                    try {
                        document.querySelectorAll('.suggestion-card').forEach(card => {
                            card.classList.remove('selected');
                        });
                    } catch (e) {
                        console.error('Error in clearSuggestionSelection:', e);
                    }
                }

                // Event listeners for stars
                elements.stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = parseInt(this.dataset.rating);
                        if (!isNaN(rating) && rating >= 1 && rating <= 5) {
                            selectRating(rating);
                        }
                    });

                    star.addEventListener('mouseenter', function() {
                        const rating = parseInt(this.dataset.rating);
                        if (!isNaN(rating)) {
                            highlightStars(rating);
                        }
                    });
                });

                if (elements.ratingStars) {
                    elements.ratingStars.addEventListener('mouseleave', function() {
                        highlightStars(selectedRating);
                    });
                }

                // Textarea input
                elements.notes.addEventListener('input', updateCharCount);

                // Mobile input
                if (elements.mobile) {
                    elements.mobile.addEventListener('input', function() {
                        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                    });
                }

                // Form submission
                if (elements.feedbackForm) {
                    elements.feedbackForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const originalText = elements.submitBtn.innerHTML;

                        elements.submitBtn.innerHTML =
                            '<span class="loading-spinner"></span> Submitting...';
                        elements.submitBtn.disabled = true;

                        fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            // Inside your fetch success handler
                            .then(data => {
                                if (data.success) {
                                    // Get the modal element
                                    const modalElement = document.getElementById('successModal');

                                    // Create Bootstrap modal instance
                                    const successModal = new bootstrap.Modal(modalElement, {
                                        backdrop: 'static',
                                        keyboard: false
                                    });

                                    // Show the modal
                                    successModal.show();

                                    // Auto-hide after 3 seconds
                                    setTimeout(function() {
                                        successModal.hide();

                                        // Reset form after modal hides
                                        document.getElementById('feedbackForm').reset();
                                        elements.rating.value = 0;
                                        selectedRating = 0;
                                        selectedSuggestion = null;
                                        highlightStars(0);
                                        elements.ratingLabel.textContent =
                                        'Select a rating';
                                        if (elements.suggestionsCarousel) {
                                            elements.suggestionsCarousel.style.display =
                                                'none';
                                        }
                                        updateCharCount();
                                    }, 3000);

                                } else {
                                    alert(data.message ||
                                    'Something went wrong. Please try again.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Something went wrong. Please try again later.');
                            })
                            .finally(() => {
                                elements.submitBtn.innerHTML = originalText;
                                elements.submitBtn.disabled = false;
                            });
                    });
                }

                // Initialize
                updateCharCount();
            });

            // Add this inside your DOMContentLoaded function
            // Handle Done button click
            const doneButton = document.getElementById('doneButton');
            if (doneButton) {
                doneButton.addEventListener('click', function() {
                    // Option 1: Redirect to home page
                    window.location.href = '/';

                    // Option 2: Redirect to a specific page
                    // window.location.href = '{{ route('home') }}';

                    // Option 3: Reload the page (to reset everything)
                    // window.location.reload();

                    // Option 4: Just close the modal (default behavior)
                    // The data-bs-dismiss="modal" already handles this
                    console.log('Feedback submitted successfully!');
                });
            }
        })();
    </script>
@endpush
