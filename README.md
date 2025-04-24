# Stock Management System

A comprehensive stock management system built with Laravel and Vue.js, featuring voice control capabilities.

## Features

- Product Management
  - Add, edit, and delete products
  - Track product details (name, SKU, price, quantity)
  - Categorize products
  - Associate products with vendors
  - Product image upload

- Stock Movement Tracking
  - Record stock in/out movements
  - Track movement history
  - Add notes to movements
  - View current stock levels

- Voice Control
  - Voice commands for navigation
  - Speech-to-text for input
  - Text-to-speech for system responses
  - Supported commands:
    - "Add product"
    - "List products"
    - "Add stock"
    - "View stock"
    - "Search for [term]"

- User Management
  - Role-based access control
  - User authentication
  - Profile management

## Requirements

- PHP >= 8.1
- Node.js >= 16
- MySQL >= 5.7
- Composer
- NPM

## Installation

1. Clone the repository:
```bash
git clone https://github.com/divyanshcbl24/stock-management.git
cd stock-management
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure database in .env file

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## Voice Control Usage

1. Click the microphone button in the navigation bar
2. When you see "Listening..." and hear the confirmation sound, speak your command
3. The system will execute the command and provide voice feedback
4. The microphone will automatically stop listening after the command is processed

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License.
