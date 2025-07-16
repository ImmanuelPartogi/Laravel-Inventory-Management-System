# Online Store Inventory Management System

## Technologies
Laravel, PHP, MySQL, Bootstrap, jQuery

## Description
Simple inventory management system for online stores that allows store owners to track product stock, view sales statistics, and manage orders.

## Main Features
- Dashboard admin with real-time statistics
- Product and category management
- Stock tracking and low stock notifications
- Weekly/monthly sales reports

## Directory Structure

```
inventory-system/
│
├── app/                                # Main application code
│   ├── Http/
│   │   ├── Controllers/                # Controllers to handle requests
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── OrderController.php
│   │   │   ├── DashboardController.php
│   │   │   └── ReportController.php
│   │   │
│   │   ├── Middleware/                 # Application middleware
│   │   └── Requests/                   # Form request validation
│   │
│   ├── Models/                         # Database models
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   │
│   └── Notifications/                  # System notifications
│       └── LowStockNotification.php
│
├── config/                             # Configuration files
├── database/
│   ├── migrations/                     # Database migrations
│   └── seeders/                        # Initial database data
│
├── public/                             # Public files
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/
│   ├── views/                          # View files (blade)
│   │   ├── dashboard/
│   │   ├── products/
│   │   ├── categories/
│   │   ├── orders/
│   │   ├── reports/
│   │   ├── layouts/
│   │   └── components/
│   │
│   ├── js/                             # JavaScript files
│   └── css/                            # CSS files
│
├── routes/                             # Route definitions
│   └── web.php
│
└── vendor/                             # Dependencies (managed by Composer)
```

## Database Design

### Tables and Relations

- **users** - Stores admin user data
  - id (primary key)
  - name
  - email
  - password
  - remember_token
  - timestamps

- **categories** - Product categories
  - id (primary key)
  - name
  - description
  - timestamps

- **products** - Product data
  - id (primary key)
  - category_id (foreign key to categories)
  - name
  - description
  - price
  - stock_quantity
  - min_stock_threshold (for low stock notifications)
  - image_path
  - timestamps

- **orders** - Order data
  - id (primary key)
  - order_number
  - customer_name
  - customer_email
  - customer_phone
  - status (pending, processing, completed, cancelled)
  - total_amount
  - timestamps

- **order_items** - Items in orders
  - id (primary key)
  - order_id (foreign key to orders)
  - product_id (foreign key to products)
  - quantity
  - price (price at purchase time)
  - timestamps

## Installation and Setup

### Prerequisites
- PHP >= 7.4
- Composer
- MySQL
- Node.js & NPM

### Installation Steps
1. Clone or download project
2. Install PHP dependencies
   ```bash
   composer install
   ```
3. Install JavaScript dependencies
   ```bash
   npm install && npm run dev
   ```
4. Setup .env file
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Configure database in .env file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```
6. Run migrations and seeders
   ```bash
   php artisan migrate --seed
   ```
7. Create storage symbolic link
   ```bash
   php artisan storage:link
   ```
8. Run the application
   ```bash
   php artisan serve
   ```
9. Access application in browser
   - http://localhost:8000
10. Login with default account
    - Email: admin@example.com
    - Password: password

## Testing Main Features

### 1. Admin Dashboard
- What to test: Real-time statistics display and charts
- Testing method:
  - Login to system
  - Check if all statistics and charts display correctly
  - Create new order and see if statistics update

### 2. Product and Category Management
- What to test: CRUD operations for products and categories
- Testing method:
  - Create new category
  - Add new product in that category
  - Edit product and category
  - Delete product and category
  - Verify all changes are reflected in database and display

### 3. Stock Tracking and Notifications
- What to test: Stock tracking and low stock notification features
- Testing method:
  - Edit product stock to below minimum threshold
  - Check if product appears in "Low Stock" list on dashboard
  - Check if email notification is sent (check email log in storage/logs)
  - Add stock and verify status changes to "Sufficient Stock"

### 4. Sales Reports
- What to test: Weekly/monthly sales reports
- Testing method:
  - Create several new orders
  - Access sales report page
  - Filter report by date
  - Export report in PDF or Excel format (if feature is available)
  - Verify report data is accurate and matches filters

## Conclusion
This Online Store Inventory Management System built with Laravel, PHP, MySQL, Bootstrap, and jQuery includes all the main features requested:
- Admin dashboard with real-time statistics
- Product and category management
- Stock tracking and low stock notifications
- Weekly/monthly sales reports

This system is simple but functional, suitable for small to medium online stores. With some further development, the system can be enhanced by adding features such as e-commerce platform integration, supplier management, or barcode/QR code features.
