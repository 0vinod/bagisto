{{-- Quick View Modal --}}
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    async function quickView(slug) {
        const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
        const content = document.getElementById('quickViewContent');
        
        content.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        modal.show();
        
        try {
            const response = await fetch(`/product/quick-view/${slug}`);
            const data = await response.text();
            content.innerHTML = data;
        } catch (error) {
            content.innerHTML = `
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <p>Failed to load product details. Please try again.</p>
                </div>
            `;
        }
    }
    
    async function addToCart(slug, quantity) {
        try {
            const response = await fetch('/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ slug, quantity })
            });
            
            const data = await response.json();
            
            if (data.status) {
                swal('Success!', data.msg, 'success');
                updateCartCount();
            } else {
                swal('Error', data.msg, 'error');
            }
        } catch (error) {
            swal('Error', 'Something went wrong', 'error');
        }
    }
    
    async function addToWishlist(slug) {
        try {
            const response = await fetch(`/add-to-wishlist/${slug}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.status) {
                swal('Success!', 'Added to wishlist', 'success');
            } else {
                swal('Info', 'Already in wishlist', 'info');
            }
        } catch (error) {
            swal('Error', 'Please login to add to wishlist', 'error');
        }
    }
</script>
@endpush