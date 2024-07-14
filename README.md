## Laravel Application Project

### Overview
This project is a Laravel application, reflecting a sophisticated system designed to manage various business processes effectively. It utilizes the modern features of Laravel (v11.14.0) to deliver a robust and scalable solution with a wide range of functionalities.



## demo
 - **cmcnador.site**
 - email: hamid@gmail.com
 - password: password
  
### Key Features
- **Database Models**: The project includes well-defined database models for managing personal information, addresses, supplier types, vendors, product categories, and more. These models facilitate a comprehensive representation of the business domain.
- **Database**: Utilizes SQLite for its simplicity and efficiency in handling application data.
- **Queue System**: Implements a database queue connection to manage background tasks asynchronously.
- **Authentication**: Uses Laravel Sanctum for secure API authentication.
- **Payment Processing**: Integrates Andreia/filament-stripe-payment-link for streamlined payment functionalities.
- **Admin Panel**: Incorporates Filament for creating complex and customizable admin interfaces.

### Schema and Models
The database schema is meticulously designed to cover a wide range of entities and their relationships, including:
- **PersonalInfo**: Stores personal details like first name, last name, email, and phone number.
- **Address**: Contains address details along with city, state, and country indexes.
- **Supplier and Vendor Management**: Defines `SupplierType`, `Vendor`, and related models with specific relationships.
- **Product Management**: Encompasses `ProductCategory`, `Product`, `ProductDimension`, and `ProductSupplier` models.
- **Employee and Department**: Manages employee records and departmental structures.
- **Customer and Order Management**: Includes models like `Customer`, `CustomerType`, `Order`, and `OrderItem`.
- **Audit and Review Logs**: Tracks changes and reviews with `AuditLog` and `ProductReview`.
- **Financial Transactions**: Handles invoices, payments, accounts, and transactions with models like `SalesInvoice`, `PurchaseInvoice`, `Payment`, `Account`, and `FinancialTransaction`.

### Composer Packages
The project integrates numerous Composer packages to enhance functionality:
- **Core Packages**: `laravel/framework`, `laravel/sanctum`, and `laravel/tinker`.
- **Admin and UI**: `arrilot/laravel-widgets`, `bezhansalleh/filament-shield`, `filament/filament`, and `livewire/livewire`.
- **Payment and Charts**: `andreia/filament-stripe-payment-link`, `leandrocfe/filament-apex-charts`, and `ibrahimbougaoua/filament-rating-star`.
- **Development Tools**: `laravel/sail`, `laravel/pint`, `mockery/mockery`, `pestphp/pest`, and others.

### Running the Project
To run the project, follow these steps:

1. **Install Dependencies**: Use Composer to install all required dependencies.
   ```bash
   composer install
   ```

2. **Environment Setup**: Copy `.env.example` to `.env` and configure your environment variables.
   ```bash
   cp .env.example .env
   ```

3. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

4. **Set Up Database**: Ensure the SQLite database file exists and run migrations.
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Start the Laravel Sail Development Environment**:
   ```bash
   ./vendor/bin/sail up
   ```

6. **Run Filament Shield Configuration**:
   ```bash
   php artisan shield:install
   php artisan shield:filament
   ```

These steps will get your Laravel application up and running with Filament Shield configured for admin panel management.

### Conclusion
This project encapsulates a comprehensive and modular approach to web application development using Laravel. With a well-defined schema and integration with various powerful packages, it ensures a scalable, maintainable, and feature-rich application.
