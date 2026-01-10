/**
 * Cart Manager - Alpine.js component for managing cart state
 * Used in orders/menu.blade.php
 * 
 * @param {Object} config
 * @param {number} config.canteenId - The canteen ID for localStorage key
 * @returns {Object} Alpine.js component
 */
export function createCartManager(config) {
    return {
        items: [],
        activeCategory: null,
        canteenId: config.canteenId,

        init() {
            // Load cart from localStorage
            const savedCart = localStorage.getItem(`cart_${this.canteenId}`);
            if (savedCart) {
                try {
                    this.items = JSON.parse(savedCart);
                } catch (e) {
                    this.items = [];
                }
            }

            // Watch for changes and save to localStorage
            this.$watch('items', (value) => {
                localStorage.setItem(`cart_${this.canteenId}`, JSON.stringify(value));
            });
        },

        addItem(item) {
            const existing = this.items.find(i => i.id === item.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.items.push({ ...item, quantity: 1 });
            }
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

        getItemQuantity(id) {
            const item = this.items.find(i => i.id === id);
            return item ? item.quantity : 0;
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

        getCheckoutUrl(baseUrl) {
            return `${baseUrl}?cart=${encodeURIComponent(JSON.stringify(this.items))}`;
        }
    };
}

// Make it available globally for inline Alpine usage
window.createCartManager = createCartManager;
