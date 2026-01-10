/**
 * Checkout Manager - Alpine.js component for checkout page
 * Used in orders/checkout.blade.php
 * 
 * @param {Object} config
 * @param {number} config.canteenId - The canteen ID for localStorage key
 * @param {string} config.storeUrl - The URL to submit the order
 * @param {string} config.csrfToken - CSRF token for form submission
 * @param {string} config.redirectUrl - Default redirect URL after successful order
 * @returns {Object} Alpine.js component
 */
export function createCheckoutManager(config) {
    return {
        items: [],
        orderNotes: '',
        isSubmitting: false,
        errorMessage: '',
        canteenId: config.canteenId,
        storeUrl: config.storeUrl,
        csrfToken: config.csrfToken,
        redirectUrl: config.redirectUrl,

        init() {
            // Load cart from URL params first
            const urlParams = new URLSearchParams(window.location.search);
            const cartParam = urlParams.get('cart');

            if (cartParam) {
                try {
                    this.items = JSON.parse(decodeURIComponent(cartParam));
                    // Save to localStorage
                    localStorage.setItem(`cart_${this.canteenId}`, JSON.stringify(this.items));
                } catch (e) {
                    console.error('Failed to parse cart from URL:', e);
                }
            }

            // Fallback to localStorage
            if (this.items.length === 0) {
                const savedCart = localStorage.getItem(`cart_${this.canteenId}`);
                if (savedCart) {
                    try {
                        this.items = JSON.parse(savedCart);
                    } catch (e) {
                        this.items = [];
                    }
                }
            }

            // Ensure items have notes field
            this.items = this.items.map(item => ({
                ...item,
                notes: item.notes || ''
            }));

            // Watch for changes
            this.$watch('items', (value) => {
                localStorage.setItem(`cart_${this.canteenId}`, JSON.stringify(value));
            });
        },

        incrementItem(id) {
            const item = this.items.find(i => i.id === id);
            if (item) {
                item.quantity++;
            }
        },

        decrementItem(id) {
            const index = this.items.findIndex(i => i.id === id);
            if (index > -1) {
                if (this.items[index].quantity > 1) {
                    this.items[index].quantity--;
                } else {
                    this.items.splice(index, 1);
                }
            }
        },

        get totalItems() {
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        },

        get totalPrice() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        formatPrice(price) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        },

        async submitOrder() {
            if (this.isSubmitting) return;

            this.isSubmitting = true;
            this.errorMessage = '';

            try {
                const response = await fetch(this.storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        canteen_id: this.canteenId,
                        items: this.items.map(item => ({
                            menu_item_id: item.id,
                            quantity: item.quantity,
                            notes: item.notes || ''
                        })),
                        notes: this.orderNotes
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Clear cart
                    localStorage.removeItem(`cart_${this.canteenId}`);
                    // Redirect to order detail
                    window.location.href = data.redirect || this.redirectUrl;
                } else {
                    this.errorMessage = data.message || 'Gagal membuat pesanan. Silakan coba lagi.';
                }
            } catch (error) {
                console.error('Order submission error:', error);
                this.errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
            } finally {
                this.isSubmitting = false;
            }
        }
    };
}

// Make it available globally for inline Alpine usage
window.createCheckoutManager = createCheckoutManager;
