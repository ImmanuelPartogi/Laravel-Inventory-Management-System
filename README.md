# Laravel Inventory Management System

A simple online store inventory management system that allows store owners to track product stock, view sales statistics, and manage orders efficiently.

## Technologies Used

- **Laravel**: PHP Framework
- **MySQL**: Database
- **Bootstrap**: Frontend Framework
- **jQuery**: JavaScript Library
- **Chart.js**: For sales statistics visualization

## Features

- **Admin Dashboard with Real-Time Statistics**
  - Quick overview of sales, inventory, and order metrics
  - 7-day sales chart
  - Low stock product alerts

- **Product & Category Management**
  - Create, read, update, and delete products and categories
  - Product image upload and management
  - Inventory tracking

- **Stock Tracking & Notifications**
  - Automatic low stock detection
  - Email notifications when stock falls below threshold
  - Visual indicators for product stock status

- **Sales Reports**
  - Weekly/monthly sales reports
  - Filter reports by date range
  - Export options (PDF/Excel)

## Project Structure

```
inventory-system/
│
├── app/                                # Core application code
│   ├── Http/
│   │   ├── Controllers/                # Request handlers
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
│   └── seeders/                        # Database seeders
│
├── public/                             # Public files
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/
│   ├── views/                          # Blade view files
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

## Database Schema

The system uses the following database tables:

- **users**: Admin user data
- **categories**: Product categories
- **products**: Product data with stock information
- **orders**: Order data including customer information
- **order_items**: Items within orders

## Installation & Setup

### Prerequisites

- PHP >= 7.4
- Composer
- MySQL
- Node.js & NPM

### Installation Steps

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/Laravel-Inventory-Management-System.git
   cd Laravel-Inventory-Management-System
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JavaScript dependencies
   ```bash
   npm install && npm run dev
   ```

4. Set up environment file
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

8. Start the application
   ```bash
   php artisan serve
   ```

9. Access the application at http://localhost:8000

10. Login with default credentials
    - Email: admin@example.com
    - Password: password

## Testing

The system's main features can be tested as follows:

1. **Admin Dashboard**: Verify all statistics and charts display correctly
2. **Product Management**: Test CRUD operations for products and categories
3. **Stock Tracking**: Test low stock notifications by adjusting product quantities
4. **Sales Reports**: Generate and filter sales reports by date range

## Future Enhancements

- E-commerce platform integration
- Supplier management
- Advanced analytics
