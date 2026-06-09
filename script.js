// Green Waste Management System - JavaScript

// Initialize tooltips and popovers
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// Get user's geolocation
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            console.log('Location: ' + lat + ', ' + lng);
            return { latitude: lat, longitude: lng };
        }, function(error) {
            console.error('Error getting location: ' + error.message);
        });
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}

// Format date
function formatDate(date) {
    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
}

// Format time
function formatTime(time) {
    var options = { hour: '2-digit', minute: '2-digit' };
    return new Date('1970-01-01T' + time).toLocaleTimeString('en-US', options);
}

// Show alert
function showAlert(message, type) {
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show';
    alertDiv.role = 'alert';
    alertDiv.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    
    var container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
    }
}

// Validate email
function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validate phone number
function validatePhone(phone) {
    var re = /^[\d\s\-\+\(\)]+$/;
    return re.test(phone) && phone.replace(/\D/g, '').length >= 10;
}

// Format currency
function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// Debounce function
function debounce(func, wait) {
    var timeout;
    return function executedFunction(...args) {
        var later = function() {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function
function throttle(func, limit) {
    var inThrottle;
    return function() {
        var args = arguments;
        var context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(function() { inThrottle = false; }, limit);
        }
    };
}

// AJAX request helper
function makeRequest(url, method, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            callback(null, JSON.parse(xhr.responseText));
        } else {
            callback(new Error('Request failed with status ' + xhr.status));
        }
    };
    
    xhr.onerror = function() {
        callback(new Error('Network error'));
    };
    
    xhr.send(JSON.stringify(data));
}

// Initialize map
function initializeMap(mapId, latitude, longitude, zoom) {
    if (typeof L === 'undefined') {
        console.error('Leaflet library not loaded');
        return;
    }
    
    var map = L.map(mapId).setView([latitude, longitude], zoom || 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    return map;
}

// Add marker to map
function addMarker(map, latitude, longitude, title, popupText) {
    var marker = L.marker([latitude, longitude])
        .bindPopup('<strong>' + title + '</strong><br>' + popupText)
        .addTo(map);
    return marker;
}

// Clear form
function clearForm(formId) {
    document.getElementById(formId).reset();
}

// Disable form submission button
function disableFormButton(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    }
}

// Enable form submission button
function enableFormButton(buttonId, originalText) {
    var button = document.getElementById(buttonId);
    if (button) {
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

// Export data to CSV
function exportToCSV(data, filename) {
    var csv = 'data:text/csv;charset=utf-8,';
    data.forEach(function(row) {
        csv += row.join(',') + '\n';
    });
    
    var link = document.createElement('a');
    link.setAttribute('href', encodeURI(csv));
    link.setAttribute('download', filename);
    link.click();
}

// Print page
function printPage() {
    window.print();
}

// Smooth scroll
function smoothScroll(target) {
    var element = document.querySelector(target);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}
