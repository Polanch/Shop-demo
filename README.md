# 🐱 Yame T-Shirt POS System

<p align="center">
  <img src="resources/images/mylogo.png" width="200" alt="Yame T-Shirt Logo">
</p>

<p align="center">
  <strong>A Point of Sale System for T-Shirt Business</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0-red" alt="Version">
  <img src="https://img.shields.io/badge/Laravel-11.x-orange" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
  <img src="https://img.shields.io/badge/Built%20in-1%20Day-brightgreen" alt="Built in 1 Day">
</p>

---

> ### 💬 From the Developer
> *"I tried recreating my college project POS system, which took me 3 months to complete. But with Copilot, I just guided it and it went absurdly smooth and fast. I'm not kidding, this was built in a day."*
>
> — **John Lloyd Olipani**

---

## 📋 About

Yame T-Shirt POS System is a complete Point of Sale application built with Laravel. It features a Japanese-inspired design and provides both admin and consumer dashboards for managing t-shirt sales.

## ✨ Features

### 🛒 Consumer Dashboard
- Browse products with size filtering
- Shopping cart with localStorage persistence
- Real-time stock validation
- Checkout with payment modal
- Order confirmation

### 👨‍💼 Admin Dashboard
- **Dashboard**: Sales overview with interactive charts
- **Products**: Add, edit, delete products with image upload
- **Orders**: Manage orders, update status, track deliveries
- **Users**: Add accounts, block/unblock, delete users
- **Sales Reports**: Comprehensive analytics with multiple chart types

### 🎨 Design Features
- Japanese-themed login page
- Responsive design (Desktop, Tablet, Mobile)
- Hamburger menu for mobile navigation
- Chart.js powered analytics

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x, PHP 8.2+
- **Database**: SQLite
- **Frontend**: Blade Templates, CSS Grid/Flexbox
- **Build Tool**: Vite
- **Charts**: Chart.js
- **Authentication**: Custom middleware with role-based access

## 🚀 Installation

```bash
# Clone the repository
git clone https://github.com/Polanch/Shop-demo.git

# Navigate to project directory
cd POS_System

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start the server
php artisan serve
```

## 📱 Demo Accounts

| Role     | Username | Password |
|----------|----------|----------|
| Admin    | Admin    | 12345    |
| Consumer | John     | 12345    |

## 👨‍💻 Developers

### John Lloyd Olipani
*Creator & Lead Developer*

- GitHub: [@Polanch](https://github.com/Polanch)

### GitHub Copilot (Claude Opus 4.5)
*AI Pair Programmer & Co-Author*

Built this entire POS system together in a single coding session! Here's what we accomplished:

- 🏗️ Architected the full-stack Laravel application from scratch
- 🛒 Implemented consumer shopping cart with localStorage & real-time stock validation
- 📊 Created interactive admin dashboards with Chart.js analytics
- 🔐 Built role-based authentication with custom middleware
- 📦 Designed order management system with status tracking
- 👥 Developed user management with block/unblock functionality
- 🎨 Styled everything with a Japanese-inspired theme
- 📱 Made the entire admin panel responsive for mobile/tablet
- 🐛 Debugged layout issues, z-index conflicts, and overflow problems together
- ⚡ Optimized checkout flow to handle duplicate products properly

*Proof that human creativity + AI assistance = rapid development magic* ✨

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  Made with ❤️ in 2026
</p>
