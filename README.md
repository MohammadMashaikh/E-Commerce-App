🛒 E-Commerce Application

This is a full-featured E-Commerce Application built with Laravel, including a website (frontend), an admin panel, and a REST API. It follows modern best practices with clean architecture and scalable design patterns.

🚀 Features
🔑 Authentication & Authorization

Laravel Breeze for user authentication (registration, login, password reset).

Laravel Passport for API authentication (JWT tokens).

Two authentication guards:

web → for customers/users.

admin → for administrators.

Gate-based Authorization for role & permission handling.

Custom middleware: redirects admins to /admin/dashboard after login.

🏗 Architecture & Design

Repository Design Pattern implemented with interfaces & repositories for clean separation of concerns.

Service layer for handling business logic.

Queue System (via Laravel Queues) for sending emails asynchronously.

📦 Admin Panel

Manage products, roles and permissions, orders, and users.

Role-based access control via Gates.

Livewire + Alpine.js used for interactive & reactive UI.

Dashboard for statistics and quick actions.

🌐 Website (Frontend)

Browse and search products.

Shopping cart & checkout system.

User account management (profile, orders, etc.).

📡 API (with Passport)

Secure API endpoints for mobile or third-party integrations.

Token-based authentication using Passport.

Supports CRUD operations on products, orders, and users (authorized access only).

⚙️ Tech Stack

Framework: Laravel 12

Auth: Breeze + Passport

Authorization: Laravel Gates

Frontend: Livewire, Alpine.js, Tailwind CSS

Database: MySQL (or any SQL DB)

Queues: Database driver (can be swapped with Redis/Beanstalkd)

Pattern: Repository Pattern (Interfaces + Repositories)

Deployment: Works with IIS / Apache / Nginx
