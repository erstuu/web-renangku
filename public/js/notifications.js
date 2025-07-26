class NotificationManager {
    constructor(options = {}) {
        this.duration = options.duration || 5000;
        this.fadeOutDuration = options.fadeOutDuration || 500;
        this.selector = options.selector || '.notification-message';
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.hideNotifications();
        });
    }

    hideNotifications() {
        const notifications = document.querySelectorAll(this.selector);

        notifications.forEach((notification, index) => {
            // Add slight delay between multiple notifications for better UX
            const delay = this.duration + (index * 100);

            setTimeout(() => {
                this.hideNotification(notification);
            }, delay);
        });
    }

    hideNotification(notification) {
        if (!notification) return;

        // Add transition styles
        notification.style.transition = `opacity ${this.fadeOutDuration}ms ease-out, transform ${this.fadeOutDuration}ms ease-out`;
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-10px)';

        // Remove element after animation completes
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, this.fadeOutDuration);
    }

    // Method to manually hide specific notification
    hideSpecific(notificationElement) {
        this.hideNotification(notificationElement);
    }

    // Method to hide all notifications immediately
    hideAll() {
        const notifications = document.querySelectorAll(this.selector);
        notifications.forEach(notification => {
            this.hideNotification(notification);
        });
    }
}

// Initialize with default settings
const notificationManager = new NotificationManager();

// Make it globally available for manual control if needed
window.NotificationManager = NotificationManager;
window.notificationManager = notificationManager;
