import './bootstrap';


// Global helper functions
function renderRatingStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let stars = '';
    
    for (let i = 1; i <= 5; i++) {
        if (i <= fullStars) {
            stars += '<i class="bi bi-star-fill text-warning"></i>';
        } else if (i === fullStars + 1 && hasHalfStar) {
            stars += '<i class="bi bi-star-half text-warning"></i>';
        } else {
            stars += '<i class="bi bi-star text-warning"></i>';
        }
    }
    
    return stars;
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Set default dates for booking forms
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);
    
    const checkInInputs = document.querySelectorAll('input[name="check_in"]');
    const checkOutInputs = document.querySelectorAll('input[name="check_out"]');
    
    checkInInputs.forEach(input => {
        if (!input.value) {
            input.valueAsDate = today;
            input.min = input.value;
        }
    });
    
    checkOutInputs.forEach(input => {
        if (!input.value) {
            input.valueAsDate = tomorrow;
            if (input.previousElementSibling?.name === 'check_in') {
                input.min = input.previousElementSibling.value;
            }
        }
    });
    
    // Update min check-out date when check-in changes
    document.addEventListener('change', function(e) {
        if (e.target.name === 'check_in') {
            const checkOutInput = e.target.closest('form').querySelector('input[name="check_out"]');
            if (checkOutInput) {
                checkOutInput.min = e.target.value;
                if (new Date(checkOutInput.value) < new Date(e.target.value)) {
                    checkOutInput.valueAsDate = new Date(e.target.value);
                    checkOutInput.valueAsDate.setDate(checkOutInput.valueAsDate.getDate() + 1);
                }
            }
        }
    });
});

// Handle CSRF token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

// Handle auth token for API requests
const authToken = localStorage.getItem('authToken');
if (authToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
}