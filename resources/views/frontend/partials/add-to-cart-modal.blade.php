@push('scripts')
<script>
    $(document).ready(function() {
        // Load More Products
        $("#load-more").click(function() {
            var page = $(this).data("page");

            $.ajax({
                url: "{{ route('products.loadmore') }}",
                type: "GET",
                data: {
                    page: page
                },
                success: function(data) {
                    if (data.trim() == "") {
                        $("#load-more").hide();
                    } else {
                        $("#product-data").append(data);
                        $("#load-more").data("page", page + 1);
                        // Re-initialize cart buttons for new products
                        initializeCartButtons();
                    }
                },
                error: function() {
                    console.log("Error loading products");
                }
            });
        });

        // Initialize cart buttons for existing products
        initializeCartButtons();

        function initializeCartButtons() {
            // Add to Cart
            var isLoggedIn = "{{ session('user') ? '1' : '0' }}";

            $(".btn-add-cart").off('click').on('click', function() {

                if (isLoggedIn != "1") {
                    window.location.href = "{{ route('login.form') }}";
                    return;
                }

                var productSlug = $(this).data("slug");
                var button = $(this);
                var originalText = button.html();

                // Add loading state
                button.addClass('loading');
                button.html('<i class="fas fa-spinner fa-spin"></i> Adding...');

                $.ajax({
                    url: "{{ route('add-to-cart', '') }}/" + productSlug,
                    type: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",
                        slug: productSlug,
                        quantity: 1
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            // Update cart count badge
                            $(".total-count").text(response.cartCount);
                            $(".total-count").addClass('update');
                            setTimeout(function() {
                                $(".total-count").removeClass('update');
                            }, 500);

                            // Update cart dropdown
                            updateCartDropdown(response.cartItems, response.cartTotal);

                            // Replace button with quantity controls for this product
                            var productCard = button.closest('.single-product');
                            var productId = productCard.data('product-id');

                            button.replaceWith(`
                                <div class="cart-quantity-controls">
                                    <button class="qty-decrease" data-product-id="${productId}">
                                    
                                    </button>
                                    <span class="cart-qty">1</span>
                                    <button class="qty-increase" data-product-id="${productId}">
                                      
                                    </button>
                                </div>
                            `);

                            // Re-initialize quantity controls for new buttons
                            initializeQuantityControls();

                            // Show success message
                            swal({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                button: "Continue Shopping",
                                timer: 2000
                            });
                        } else {
                            swal({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                button: "OK"
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        swal({
                            title: "Error!",
                            text: errorMessage,
                            icon: "error",
                            button: "OK"
                        });
                    },
                    complete: function() {
                        // Remove loading state
                        button.removeClass('loading');
                        button.html(originalText);
                    }
                });
            });
        }

        // Initialize quantity controls
        function initializeQuantityControls() {
            // Increase quantity
            $(".qty-increase").off('click').on('click', function() {
                var productId = $(this).data("product-id");
                var productCard = $(this).closest('.single-product');
                var quantitySpan = ($(this).siblings('.cart-qty'));
                var currentQty = parseInt(quantitySpan.text()) || parseInt(quantitySpan.val());
                var newQty = currentQty + 1;

                updateCartQuantity(productId, newQty, productCard, quantitySpan);
            });

            // Decrease quantity
            $(".qty-decrease").off('click').on('click', function() {
                var productId = $(this).data("product-id");
                var productCard = $(this).closest('.single-product');
                var quantitySpan = $(this).siblings('.cart-qty');
                var currentQty = parseInt(quantitySpan.text()) || parseInt(quantitySpan.val());
                var newQty = currentQty - 1;

                if (newQty < 1) {
                    // Remove from cart if quantity becomes 0
                    removeFromCart(productId, productCard);
                } else {
                    updateCartQuantity(productId, newQty, productCard, quantitySpan);
                }
            });
        }

        // Update cart quantity
        function updateCartQuantity(productId, newQty, productCard, quantitySpan) {
            $.ajax({
                url: "{{ route('cart.update-quantity') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    quantity: newQty
                },
                beforeSend: function() {
                    quantitySpan.html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.status == 'success') {
                        // Update quantity display


                        quantitySpan.text(newQty);
                        quantitySpan.val(newQty);

                        // Update cart count badge
                        $(".total-count").text(response.cartCount);
                        $(".total-count").addClass('update');
                        setTimeout(function() {
                            $(".total-count").removeClass('update');
                        }, 500);

                        // Update cart dropdown
                        updateCartDropdown(response.cartItems, response.cartTotal);
                    } else {
                        swal("Error!", response.message, "error");
                        // Revert quantity
                        var oldQty = newQty > response.cartItem.quantity ? newQty - 1 : newQty + 1;
                        quantitySpan.text(oldQty);
                    }
                },
                error: function() {
                    swal("Error!", "Failed to update cart", "error");
                }
            });
        }

        // Remove from cart
        function removeFromCart(productId, productCard) {
            $.ajax({
                url: "{{ route('cart.remove-product') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    if (response.status == 'success') {
                        // Replace quantity controls with add to cart button
                        var productSlug = productCard.data('product-slug');
                        productCard.find('.cart-quantity-controls').replaceWith(`
                            <button class="btn-add-cart" data-slug="${productSlug}" data-id="${productId}">
                                <i class="ti-shopping-cart"></i> Add to Cart
                            </button>
                        `);

                        // Re-initialize add to cart button
                        initializeCartButtons();

                        // Update cart count badge
                        $(".total-count").text(response.cartCount);
                        $(".total-count").addClass('update');
                        setTimeout(function() {
                            $(".total-count").removeClass('update');
                        }, 500);

                        // Update cart dropdown
                        updateCartDropdown(response.cartItems, response.cartTotal);

                        swal("Removed!", response.message, "success");

                        if (location.pathname == '/cart') {
                            location.reload()
                        }

                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function() {
                    swal("Error!", "Failed to remove item", "error");
                }
            });
        }

        // Function to update cart dropdown
        function updateCartDropdown(cartItems, cartTotal) {
            var cartList = $(".shopping-list");
            var cartFooter = $(".cart-footer");

            // Update items count in header
            $(".dropdown-cart-header span").html(
                `<i class="fas fa-shopping-bag"></i> ${cartItems.length} Item(s)`);

            if (cartItems && cartItems.length > 0) {
                // Build cart items HTML
                var itemsHtml = '';

                $.each(cartItems, function(index, item) {
                    // Get product image
                    var productImage = '';
                    if (item.product && item.product.photo) {
                        var photos = item.product.photo.split(',');
                        productImage = photos[0];
                    } else {
                        productImage = "{{ asset('frontend/img/default.jpg') }}";
                    }

                    // Truncate product title
                    var productTitle = item.product.title;
                    if (productTitle.length > 30) {
                        productTitle = productTitle.substring(0, 30) + '...';
                    }

                    itemsHtml += `
                        <li class="cart-item" data-cart-id="${item.id}" data-product-id="${item.product_id}">
                            <a href="{{ url('/cart-delete') }}/${item.id}" class="remove-item" title="Remove Item">
                                <i class="fa fa-times-circle"></i>
                            </a>
                            <a class="cart-img" href="{{ url('/product-detail') }}/${item.product.slug}">
                                <img src="${productImage}" alt="${item.product.title}">
                            </a>
                            <div class="cart-item-info">
                                <h4>
                                    <a href="{{ url('/product-detail') }}/${item.product.slug}">
                                        ${productTitle}
                                    </a>
                                </h4>
                                <p class="quantity">
                                    <span class="qty-label">Qty:</span>
                                    <span class="qty-value">${item.quantity}</span>
                                    <span class="price-separator">x</span>
                                    <span class="amount">Rs. ${formatPrice(item.price)}</span>
                                </p>
                                <p class="item-total">
                                    <span class="total-label">Total:</span>
                                    <span class="total-value">Rs. ${formatPrice(item.amount)}</span>
                                </p>
                            </div>
                        </li>
                    `;
                });

                cartList.html(itemsHtml);

                // Update footer totals
                var footerHtml = `
                    <div class="cart-subtotal">
                        <span class="subtotal-label">Subtotal</span>
                        <span class="subtotal-amount">
                            Rs. ${formatPrice(cartTotal)}
                        </span>
                    </div>
                `;

                @if (session()->has('coupon'))
                    var discount = {{ session('coupon')['value'] }};
                    var finalTotal = cartTotal - discount;
                    footerHtml += `
                        <div class="cart-discount">
                            <span class="discount-label">
                                <i class="fas fa-ticket-alt"></i> Discount
                            </span>
                            <span class="discount-amount">
                                -Rs. ${formatPrice(discount)}
                            </span>
                        </div>
                        <div class="cart-total">
                            <span class="total-label">Total</span>
                            <span class="total-amount">Rs. ${formatPrice(finalTotal)}</span>
                        </div>
                    `;
                @else
                    footerHtml += `
                        <div class="cart-total">
                            <span class="total-label">Total</span>
                            <span class="total-amount">Rs. ${formatPrice(cartTotal)}</span>
                        </div>
                    `;
                @endif

                footerHtml += `
                    <div class="cart-actions">
                   
                        <a href="{{ route('cart') }}" class="btn-view-cart">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                    </div>
                `;

                cartFooter.html(footerHtml);
                cartFooter.show();

            } else {
                // Empty cart
                cartList.html(`
                    <li class="empty-cart">
                        <i class="fas fa-shopping-bag"></i>
                        <p>Your cart is empty</p>
                        <a href="{{ route('product-grids') }}" class="btn-shop-now">Shop Now</a>
                    </li>
                `);
                cartFooter.hide();
            }

            // Re-initialize remove cart items
            initializeRemoveCartItems();
        }

        // Helper function to format price
        function formatPrice(price) {
            return parseFloat(price).toFixed(2);
        }

        // Initialize remove cart items
        function initializeRemoveCartItems() {
            // Remove from Cart with AJAX
            $(document).off('click', '.remove-item').on('click', '.remove-item', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var cartItem = $(this).closest('.cart-item');
                var productId = cartItem.data('product-id');
                var productCard = $(`.single-product[data-product-id="${productId}"]`);

                swal({
                    title: "Remove Item?",
                    text: "Are you sure you want to remove this item from your cart?",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, Remove"],
                    dangerMode: true,
                }).then((willRemove) => {
                    if (willRemove) {
                        // Add fade out animation
                        cartItem.css({
                            'transition': 'all 0.3s ease',
                            'opacity': '0',
                            'transform': 'translateX(20px)'
                        });

                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function(response) {
                                if (response.status == 'success') {
                                    // Update cart count badge
                                    $(".total-count").text(response.cartCount);
                                    $(".total-count").addClass('update');
                                    setTimeout(function() {
                                        $(".total-count").removeClass(
                                            'update');
                                    }, 500);

                                    // Update cart dropdown
                                    updateCartDropdown(response.cartItems, response
                                        .cartTotal);

                                    // Update product card button if exists
                                    if (productCard.length) {
                                        var productSlug = productCard.data(
                                            'product-slug');
                                        productCard.find('.cart-quantity-controls')
                                            .replaceWith(`
                                            <button class="btn-add-cart" data-slug="${productSlug}" data-id="${productId}">
                                                <i class="ti-shopping-cart"></i> Add to Cart
                                            </button>
                                        `);
                                        initializeCartButtons();
                                    }

                                    swal("Removed!", response.message, "success");
                                } else {
                                    swal("Error!", response.message, "error");
                                }
                            },
                            error: function() {
                                swal("Error!", "Failed to remove item", "error");
                                // Revert animation
                                cartItem.css({
                                    'opacity': '1',
                                    'transform': 'translateX(0)'
                                });
                            }
                        });
                    }
                });
            });
        }

        // Initialize all functions
        initializeQuantityControls();
        initializeRemoveCartItems();
    });


    $(document).ready(function() {
        $('#state-dropdown').on('change', function() {
            var stateId = this.value;
            $("#city-dropdown").html('<option value="">Loading...</option>');

            if (stateId) {
                $.ajax({
                    url: "{{ route('getCityByStateId', '') }}" + '/' + stateId,
                    type: "GET",
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">Select City</option>');
                        $.each(res, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.city_name + '</option>');
                        });
                    }
                });
            } else {
                $("#city-dropdown").html('<option value="">Select State First</option>');
            }
        });
    });
</script>

@endpush
