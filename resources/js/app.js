import './bootstrap';

    // Show loading spinner on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        var loadingElement = document.getElementById('loading');
        if (loadingElement) {
            loadingElement.style.display = 'block'; // or 'inline' or your desired display property
        }
    });

    // Hide loading spinner when the page is fully loaded
    window.addEventListener('load', function() {
        var loadingElement = document.getElementById('loading');
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
    });
