# Auto-Hide Notifications JavaScript

File JavaScript terpisah untuk menangani auto-hide notifikasi di Web Renangku.

## Lokasi File
```
public/js/notifications.js
```

## Cara Penggunaan

### 1. Include Script di HTML
Tambahkan script di bagian `<head>` setelah Tailwind CSS:

```html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
</head>
```

### 2. Struktur HTML Notifikasi
Pastikan notifikasi memiliki class `notification-message`:

```html
@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 notification-message">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 notification-message">
    {{ session('error') }}
</div>
@endif

@if (session('warning'))
<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 notification-message">
    {{ session('warning') }}
</div>
@endif

@if (session('info'))
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 notification-message">
    {{ session('info') }}
</div>
@endif
```

### 3. Penggunaan Otomatis
Script akan bekerja otomatis setelah halaman dimuat. Tidak perlu kode tambahan.

## Konfigurasi Lanjutan

### Custom Settings
Jika ingin mengubah pengaturan default:

```javascript
// Custom notification manager dengan pengaturan berbeda
const customNotificationManager = new NotificationManager({
    duration: 3000,        // 3 detik (default: 5000)
    fadeOutDuration: 800,  // 0.8 detik fade (default: 500)
    selector: '.my-alert'  // Custom selector (default: '.notification-message')
});
```

### Manual Control
Menggunakan kontrol manual:

```javascript
// Hide semua notifikasi sekarang
window.notificationManager.hideAll();

// Hide notifikasi spesifik
const notification = document.querySelector('.notification-message');
window.notificationManager.hideSpecific(notification);
```

## File yang Sudah Menggunakan
- `resources/views/admin/dashboard.blade.php`
- `resources/views/coach/dashboard.blade.php`
- `resources/views/member/dashboard.blade.php`
- `resources/views/coach/pending-approval.blade.php`

## Fitur
- ✅ Auto-hide setelah 5 detik (configurable)
- ✅ Smooth fade-out dan slide-up animation
- ✅ Multiple notifications support dengan delay
- ✅ Manual control methods
- ✅ No jQuery dependency
- ✅ Responsive dan modern ES6 syntax
- ✅ Error handling
- ✅ Global accessibility

## Browser Support
- Chrome/Edge 60+
- Firefox 55+
- Safari 11+
- IE tidak didukung (menggunakan ES6 classes)
