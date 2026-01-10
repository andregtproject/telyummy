/**
 * Category Autocomplete Alpine.js Component
 * Digunakan di menu-items/create dan menu-items/edit
 */

export function createCategoryAutocomplete(categories, initialValue = '') {
    return {
        categories: categories,
        filteredCategories: categories,
        query: initialValue,
        showDropdown: false,
        highlightedIndex: -1,

        get exactMatch() {
            return this.categories.some(
                cat => cat.toLowerCase() === this.query.toLowerCase()
            );
        },

        filterCategories() {
            this.showDropdown = true;
            this.highlightedIndex = -1;
            if (this.query.length === 0) {
                this.filteredCategories = this.categories;
            } else {
                this.filteredCategories = this.categories.filter(cat =>
                    cat.toLowerCase().includes(this.query.toLowerCase())
                );
            }
        },

        selectCategory(cat) {
            this.query = cat;
            this.showDropdown = false;
            this.highlightedIndex = -1;
        },

        addNewCategory() {
            // Capitalize first letter
            const newCat = this.query.charAt(0).toUpperCase() + this.query.slice(1);
            this.query = newCat;
            this.showDropdown = false;
            this.highlightedIndex = -1;
        },

        selectFirstOrCreate() {
            if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredCategories.length) {
                this.selectCategory(this.filteredCategories[this.highlightedIndex]);
            } else if (this.highlightedIndex === this.filteredCategories.length && !this.exactMatch) {
                this.addNewCategory();
            } else if (this.filteredCategories.length > 0) {
                this.selectCategory(this.filteredCategories[0]);
            } else if (this.query.length > 0) {
                this.addNewCategory();
            }
        },

        highlightNext() {
            const maxIndex = this.exactMatch ? this.filteredCategories.length - 1 : this.filteredCategories.length;
            if (this.highlightedIndex < maxIndex) {
                this.highlightedIndex++;
            }
        },

        highlightPrev() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
            }
        }
    };
}

// Make it available globally for Alpine.js
window.createCategoryAutocomplete = createCategoryAutocomplete;
