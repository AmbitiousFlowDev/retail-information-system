# Retail Information System (RSI)

A web-based retail management application built with a custom PHP MVC architecture. This system manages employees, clients, products, orders, and provides audit logging and role-based access control.

## 📋 Features

* **User Authentication & Authorization**: Secure login system with role-based permissions (HR, Commercial, Direction, Purchasing).
* **Dashboard**: Overview of system metrics and activities.
* **Resource Management**: Full CRUD (Create, Read, Update, Delete) capabilities for:
* **Employees**: Manage staff details and roles.
* **Clients**: Manage customer information.
* **Products**: Inventory management (Electronics, Office supplies, etc.).
* **Users**: System user account management.


* **Order Processing**: Create and manage sales orders with multiple line items.
* **Audit Logging**: Automatic tracking of system actions (e.g., logins, order creation) using the Observer pattern.
* **PDF Generation**: Built-in utility for generating reports/documents using FPDF.

## 🛠 Technical Architecture

The project implements a **Model-View-Controller (MVC)** design pattern without relying on external frameworks (Vanilla PHP).

* **Language**: PHP 8+
* **Database**: MySQL 8.0
* **Frontend**: HTML5, CSS3, Bootstrap (Public assets included).
* **Design Patterns Used**: Singleton and Observer
* **MVC**: Separation of logic (`controllers/`), data (`models/`), and presentation (`views/`).
* **Service Locator / IOC**: Custom autoloader implementation in `index.php`.
* **Observer Pattern**: Used for the Audit system (`AuditLogger` observes `Controller` actions).



## 📂 Project Structure

```text
Retail Information System/
├── controllers/       # Application logic (Audit, Auth, Client, Order, etc.)
├── database/          # SQL scripts (Schema and Seed data)
├── diagrams/          # PlantUML ERD diagrams
├── models/            # Database interactions (Active Record pattern)
├── public/            # Static assets (CSS, JS, Fonts)
├── traits/            # Shared behaviors (e.g., AuthTrait)
├── utils/             # Utilities (DB Connection, PDF, Logger, Observers)
├── views/             # UI Templates (organized by entity)
├── wireframes/        # UI Design mockups
├── docker-compose.yml # Docker infrastructure configuration
├── index.php          # Application Entry Point (Router)
└── LICENSE.md         # GNU General Public License v3

```

## 🚀 Installation & Setup

This project uses **Docker** for easy deployment.

### Prerequisites

* Docker
* Docker Compose

### Steps to Run

1. **Clone/Download** the repository.
2. Navigate to the project root.
3. Start the containers:
```bash
docker-compose up -d

```


This will start two services:
* **database** (MySQL 8.0) on port `3306`.
* **phpmyadmin** (Database GUI) on port `5050`.


4. **Import Database**:
* Open your browser and go to `http://localhost:5050`.
* Login with Server: `database`, User: `root`, Password: `753159`.
* Select the database `RSI`.
* Import the file located at `database/RSI.sql` to create tables and seed default data.


5. **Configure Application**:
Ensure your `utils/Connection.php` (or equivalent DB config file) matches the Docker environment credentials:
* Host: `database`
* User: `rsi_user`
* Password: `rsi_password`
* Database: `RSI`



## 🔐 Access & Credentials

### Default Application Login

(Based on Seed Data in `database/RSI.sql`)

| Role | Username | Password |
| --- | --- | --- |
| **Admin** | `admin` | `admin123` |
| **Sales** | `alice` | `sales123` |
| **Sales** | `bob` | `sales456` |
| **Account** | `emma` | `account123` |

### Database Credentials (Docker)

| Service | Username | Password | Port |
| --- | --- | --- | --- |
| **MySQL Root** | `root` | `753159` | 3306 |
| **RSI User** | `rsi_user` | `rsi_password` | - |
| **PhpMyAdmin** | `root` | `753159` | 5050 |

## 📜 License

This project is licensed under the **GNU General Public License v3 (GPLv3)**. You are free to copy, distribute, and modify the software as long as you track changes and release it under the same license.