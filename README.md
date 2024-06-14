# File Uploading System

This project is a user dashboard application that lets authenticated users easily upload and view their Excel files.

## Features

-   **User Login**: Secure login for accessing the dashboard.
-   **Upload Excel Files**: Simple interface for uploading Excel files.
-   **View Files**: List of uploaded files that can be opened anytime.
-   **Profile Settings**: Users can update their profile information and settings.
-   **Sidebar Navigation**: Sidebar menu with links to home, file upload, and settings. Includes a hamburger menu for smaller screens.
-   **Responsive Design**: Works well on computers, tablets, and phones.
-   **Upload Statistics**: Visual representation of upload statistics using Chart.js.

## Getting Started

### Prerequisites

-   Node.js
-   npm
-   PHP
-   PostgreSQL
-   Laravel

### Installation

-   Clone the repository:
    ```sh
    git clone https://github.com/biptu123/nic-userdashboard.git
    ```
-   Navigate to the project directory:
    ```sh
    cd nic-userdashboard
    ```
-   Install dependencies:
    ```sh
    npm install
    composer install
    ```
-   Create a copy of the `.env` file:
    ```sh
    cp .env.example .env
    ```
-   Generate an application key, This key is used for encryption and ensuring the security of your application:
    ```sh
    php artisan key:generate
    ```
-   Configure your database in the `.env` file:
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```
-   Configure your smtp details the `.env` file:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```
-   Run the migrations:

    ```sh
    php artisan migrate
    ```

-   Start the development server:
    ```sh
    php artisan serve
    npm run dev
    ```

## Usage

-   Register or log in to access the dashboard.
-   Use the sidebar menu to navigate between home, file upload, and settings.
-   Upload your Excel files and view them anytime.

## Acknowledgements

-   [Laravel](https://laravel.com/)
-   [Node.js](https://nodejs.org/)
-   [npm](https://www.npmjs.com/)
-   [Tailwind CSS](https://tailwindcss.com/)
-   [Chart.js](https://www.chartjs.org/)
-   [XLSX](https://github.com/SheetJS/sheetjs)
