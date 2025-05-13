    // Live search functionality
    document.getElementById('search-input').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');
        
        rows.forEach(row => {
            const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            row.style.display = productName.includes(searchTerm) ? '' : 'none';
        });
    });

    // Category filter functionality
    document.getElementById('category-filter').addEventListener('change', function() {
        const categoryId = this.value;
        const rows = document.querySelectorAll('.product-table tbody tr');
        
        rows.forEach(row => {
            const rowCategory = row.getAttribute('data-category');
            if (categoryId === '' || rowCategory === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });