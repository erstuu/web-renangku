/**
 * Admin Modal Manager
 * Handles common modal functionality across admin pages
 */
class AdminModalManager {
    /**
     * Initialize modal manager
     */
    static init() {
        // Initialize notification manager if available
        try {
            if (typeof NotificationManager !== 'undefined') {
                window.notificationManager = new NotificationManager();
            }
        } catch (e) {
            console.log('NotificationManager not available');
        }

        // Auto-hide notification messages after 5 seconds
        this.initAutoHideNotifications();
    }

    /**
     * Auto-hide notification messages
     */
    static initAutoHideNotifications() {
        const notifications = document.querySelectorAll('.notification-message');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }, 5000);
        });
    }

    /**
     * Open modal by ID
     * @param {string} modalId - The ID of the modal to open
     */
    static openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            // Focus on first input if exists
            const firstInput = modal.querySelector('input, textarea, select');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        }
    }

    /**
     * Close modal by ID
     * @param {string} modalId - The ID of the modal to close
     */
    static closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            // Clear form inputs
            const form = modal.querySelector('form');
            if (form) {
                this.clearForm(form);
            }
        }
    }

    /**
     * Clear form inputs
     * @param {HTMLFormElement} form - The form to clear
     */
    static clearForm(form) {
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
        inputs.forEach(input => {
            input.value = '';
        });

        const selects = form.querySelectorAll('select');
        selects.forEach(select => {
            select.selectedIndex = 0;
        });
    }

    /**
     * Setup click outside to close modal
     * @param {string} modalId - The ID of the modal
     */
    static setupClickOutsideClose(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    AdminModalManager.closeModal(modalId);
                }
            });
        }
    }

    /**
     * Setup reject modal functionality
     * @param {string} formAction - The form action URL (optional)
     */
    static setupRejectModal(formAction = null) {
        // Setup click outside to close
        this.setupClickOutsideClose('rejectModal');

        // If form action is provided, update it
        if (formAction) {
            const form = document.getElementById('rejectForm');
            if (form) {
                form.action = formAction;
            }
        }
    }
}

/**
 * Reject Modal Functions (for backward compatibility)
 */
function openRejectModal(requestId = null) {
    if (requestId) {
        // Update form action if request ID is provided
        const form = document.getElementById('rejectForm');
        if (form) {
            // Extract base URL and construct new action
            const currentPath = window.location.pathname;
            const basePath = currentPath.includes('/admin/data-change-requests')
                ? '/admin/data-change-requests'
                : currentPath.split('/').slice(0, -1).join('/');
            form.action = `${basePath}/${requestId}/reject`;
        }
    }
    AdminModalManager.openModal('rejectModal');
}

function closeRejectModal() {
    AdminModalManager.closeModal('rejectModal');
}

/**
 * Generic modal functions
 */
function openModal(modalId) {
    AdminModalManager.openModal(modalId);
}

function closeModal(modalId) {
    AdminModalManager.closeModal(modalId);
}

/**
 * Confirmation dialog helper
 * @param {string} message - Confirmation message
 * @returns {boolean} - User confirmation result
 */
function confirmAction(message = 'Apakah Anda yakin?') {
    return confirm(message);
}

/**
 * Initialize when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function () {
    AdminModalManager.init();

    // Setup reject modal if it exists
    if (document.getElementById('rejectModal')) {
        AdminModalManager.setupRejectModal();
    }
});

// Export for module use if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { AdminModalManager };
}
