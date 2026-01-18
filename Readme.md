# SmartWallet

SmartWallet is a personal finance management web application designed to help users track their incomes and expenses, visualize their financial health, and manage their budget effectively.

## Features

- **Dashboard**: Get a quick overview of your total balance, income, and expenses with interactive charts.
- **Income Management**: Add, edit, and delete income records.
- **Expense Management**: Track expenses with categories, amounts, and dates.
- **Category System**: Categorize expenses for better analysis (e.g., Food, Transport, Utilities).
- **Data Visualization**: Visual representations of financial data using Charts.js.
- **Responsive Design**: distinct mobile and desktop views using Tailwind CSS.

## Technology Stack

- **Backend**: PHP 8+ (Native, MVC structure)
- **Database**: PostgreSQL
- **Frontend**: HTML5, Tailwind CSS, Alpine.js, Chart.js
- **Routing**: Custom PHP Router

## Prerequisites

- PHP 8.0 or higher
- Composer
- PostgreSQL
- PDO PostgreSQL extension for PHP

## Installation

1.  **Clone the repository:**

    ```bash
    git clone <repository-url>
    cd Smart_Wallet
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Environment Configuration:**
    - Copy `.env.example` to `.env` (if valid) or create a `.env` file.
    - Update the database credentials in `.env`:
      ```env
      DB_CONNECTION=pgsql
      DB_HOST=127.0.0.1
      DB_PORT=5432
      DB_DATABASE=smart_wallet
      DB_USERNAME=your_username
      DB_PASSWORD=your_password
      ```

4.  **Database Setup:**
    - Create a PostgreSQL database named `smart_wallet`.
    - Import the schema from `database/smart_wallet.sql`.
    - (Optional) Run the seeding script if available to populate categories.

5.  **Run the Application:**
    Start the internal PHP server:

    ```bash
    php -S localhost:8000 -t public
    ```

6.  **Access:**
    Open your browser and navigate to `http://localhost:8000`.

## Project Structure

- `App/`: Core application logic (Controllers, Models, Repositories, Services, Views).
- `public/`: Public entry point (`index.php`) and assets.
- `database/`: SQL scripts for database schema.
- `vendor/`: Composer dependencies.

## Contributors

- Safiy (Developer)

## License

This project is open-source and available under the MIT License.
