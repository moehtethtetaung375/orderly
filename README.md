# Orderly – Order Management System

## Project Description

Orderly is a web-based Order Management System developed using Laravel and MySQL. It helps users manage items and orders through a simple and user-friendly interface.

## Features

### Authentication
- User Registration
- User Login
- User Logout

### Item Management
- View all items
- Add new items
- Edit item information
- Delete items
- Search items by name or description
- Pagination
- Prevent deletion of items that are already used in orders

### Order Management
- View all orders
- Create new orders
- Select items and quantities
- Automatically calculate order totals
- View order details
- Update order information and status
- Delete orders
- Search orders

### Order Status
- Pending
- Processing
- Completed
- Cancelled

## Technologies Used

- **Backend:** PHP, Laravel
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5, Laravel Blade
- **Database:** MySQL
- **Tools:** Visual Studio Code, Git, GitHub

## Installation Guide

Follow these steps to run the project locally.

### 1. Clone the Repository

```bash
git clone https://github.com/moehtethtetaung375/orderly.git
```

### 2. Go to the Project Folder

```bash
cd orderly
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Create the Environment File

For Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate the Application Key

```bash
php artisan key:generate
```

### 6. Configure the Database

Create a MySQL database named `orderly`.

Update the database settings in the `.env` file according to your MySQL configuration.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orderly
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Start the Development Server

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

## Developer

**Moe Htet Htet Aung**

Information Science and Technology Student

University of Technology Yadanarpon Cyber City (UTYCC)

## Repository

https://github.com/moehtethtetaung375/orderly
