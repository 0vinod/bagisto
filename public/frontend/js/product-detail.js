    document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.addEventListener('click', function() {
                const mainImage = this.querySelector('.thumbnail-image').dataset.mainImage;
                document.getElementById('mainProductImage').src = mainImage;

                // Update active state
                document.querySelectorAll('.thumbnail-item').forEach(thumb => {
                    thumb.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Quantity Update
        function updateQuantity(action) {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.dataset.stock);

            if (action === 'plus' && currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            } else if (action === 'minus' && currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }

            // Trigger change event
            quantityInput.dispatchEvent(new Event('change'));
        }

        // Validate quantity input
        document.getElementById('quantity')?.addEventListener('change', function() {
            let value = parseInt(this.value);
            const maxStock = parseInt(this.dataset.stock);

            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > maxStock) {
                this.value = maxStock;
                swal('Info', `Only ${maxStock} units available`, 'info');
            }
        });

        // Add to Cart with AJAX
        document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.getElementById('addToCartBtn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.status) {
                    swal({
                        title: 'Success!',
                        text: data.msg || 'Product added to cart successfully',
                        icon: 'success',
                        button: 'Continue Shopping'
                    }).then(() => {
                        // Update cart count in header
                        updateCartCount();
                    });
                } else {
                    swal('Error', data.msg || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                swal('Error', 'Something went wrong. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Share Product
        function shareProduct(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $product_detail->title }}');
            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'pinterest':
                    shareUrl =
                        `https://pinterest.com/pin/create/button/?url=${url}&media={{ $photos[0] }}&description=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title} ${url}`;
                    break;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        // Add to Compare
        function addToCompare(slug) {
            // Implement compare functionality
            swal('Info', 'Product added to compare list', 'info');
        }

        // Update cart count (implement based on your header structure)
        function updateCartCount() {
            // You can implement this to update cart count in header
            if (window.updateHeaderCartCount) {
                window.updateHeaderCartCount();
            }
        }

        // Smooth scroll to reviews
        document.querySelector('.total-review')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#reviews-tab')?.click();
            document.querySelector('#reviews')?.scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Star rating preview
        document.querySelectorAll('.star-label').forEach(star => {
            star.addEventListener('mouseenter', function() {
                const stars = this.parentElement.querySelectorAll('.star-label');
                const index = Array.from(stars).indexOf(this);

                stars.forEach((s, i) => {
                    if (i >= index) {
                        s.querySelector('i').classList.remove('far');
                        s.querySelector('i').classList.add('fas');
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const stars = this.parentElement.querySelectorAll('.star-label');
                const checked = this.parentElement.querySelector('input:checked');
                const checkedIndex = checked ? Array.from(stars).indexOf(checked.parentElement
                    .querySelector('.star-label')) : -1;

                stars.forEach((s, i) => {
                    if (i <= checkedIndex) {
                        s.querySelector('i').classList.add('fas');
                        s.querySelector('i').classList.remove('far');
                    } else {
                        s.querySelector('i').classList.add('far');
                        s.querySelector('i').classList.remove('fas');
                    }
                });
            });
        });