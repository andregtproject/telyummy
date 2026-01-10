import './bootstrap';

import Alpine from 'alpinejs';

// Import order management modules
import './cart-manager';
import './checkout-manager';

// Import menu item management modules
import './category-autocomplete';

window.Alpine = Alpine;

Alpine.start();
