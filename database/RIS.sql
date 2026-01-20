CREATE TABLE Employee (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE User (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_category VARCHAR(50) NOT NULL,
    employee_id INT NOT NULL UNIQUE,

    CONSTRAINT fk_user_employee
        FOREIGN KEY (employee_id)
        REFERENCES Employee(employee_id)
        ON DELETE CASCADE
);

CREATE TABLE Client (
    client_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    address VARCHAR(255),
    city VARCHAR(100)
);

CREATE TABLE Product (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    name VARCHAR(150) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL CHECK (unit_price >= 0),
    stock_quantity INT NOT NULL CHECK (stock_quantity >= 0)
);

CREATE TABLE `Order` (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    order_date DATE NOT NULL,
    client_id INT NOT NULL,
    employee_id INT NOT NULL,

    CONSTRAINT fk_order_client
        FOREIGN KEY (client_id)
        REFERENCES Client(client_id),

    CONSTRAINT fk_order_employee
        FOREIGN KEY (employee_id)
        REFERENCES Employee(employee_id)
);

CREATE TABLE OrderLine (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(10,2) NOT NULL CHECK (unit_price >= 0),

    PRIMARY KEY (order_id, product_id),

    CONSTRAINT fk_orderline_order
        FOREIGN KEY (order_id)
        REFERENCES `Order`(order_id)
        ON DELETE CASCADE,

    CONSTRAINT fk_orderline_product
        FOREIGN KEY (product_id)
        REFERENCES Product(product_id)
);

CREATE TABLE Audit (
    audit_id INT PRIMARY KEY AUTO_INCREMENT,
    action_type VARCHAR(50) NOT NULL,
    action_date DATETIME NOT NULL,
    description TEXT,
    user_id INT NOT NULL,

    CONSTRAINT fk_audit_user
        FOREIGN KEY (user_id)
        REFERENCES User(user_id)
);

CREATE TABLE Bonus (
    bonus_id INT PRIMARY KEY AUTO_INCREMENT,
    year INT NOT NULL,
    turnover DECIMAL(12,2) NOT NULL CHECK (turnover >= 0),
    bonus_amount DECIMAL(12,2) NOT NULL CHECK (bonus_amount >= 0),
    employee_id INT NOT NULL,

    CONSTRAINT fk_bonus_employee
        FOREIGN KEY (employee_id)
        REFERENCES Employee(employee_id),

    CONSTRAINT uq_bonus_employee_year
        UNIQUE (employee_id, year)
);

CREATE TABLE Discount (
    discount_id INT PRIMARY KEY AUTO_INCREMENT,
    year INT NOT NULL,
    total_purchases DECIMAL(12,2) NOT NULL CHECK (total_purchases >= 0),
    discount_amount DECIMAL(12,2) NOT NULL CHECK (discount_amount >= 0),
    client_id INT NOT NULL,

    CONSTRAINT fk_discount_client
        FOREIGN KEY (client_id)
        REFERENCES Client(client_id),

    CONSTRAINT uq_discount_client_year
        UNIQUE (client_id, year)
);
