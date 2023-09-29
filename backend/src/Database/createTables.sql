-- User Table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Product Types Table
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Products Table
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT REFERENCES categories(id)
);

-- Taxes Table
CREATE TABLE taxes (
    id SERIAL PRIMARY KEY,
    category_id INT REFERENCES categories(id),
    percentage DECIMAL(5, 2) NOT NULL
);

-- Sales Table
CREATE TABLE sales (
    id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    total_purchase DECIMAL(10, 2) NOT NULL,
    total_taxes DECIMAL(10, 2) NOT NULL
);

-- Sales Items Table
CREATE TABLE sales_items (
    id SERIAL PRIMARY KEY,
    sale_id INT REFERENCES sales(id),
    product_id INT REFERENCES products(id),
    quantity INT NOT NULL,
    item_value DECIMAL(10, 2) NOT NULL,
    tax_value DECIMAL(10, 2) NOT NULL
);