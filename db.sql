CREATE DATABASE IF NOT EXISTS pawfect_treats;
USE pawfect_treats;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    role ENUM('user', 'admin', 'vet', 'fosterer') NOT NULL DEFAULT 'user',
    images VARCHAR(255) DEFAULT 'IMAGES/default-profile.png'
);

-- Fosterers Table
CREATE TABLE IF NOT EXISTS fosterers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    email VARCHAR(100) NOT NULL,
    description TEXT,
    number_of_listings INT DEFAULT 0,
    images VARCHAR(255) DEFAULT 'IMAGES/default-profile.png',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    description TEXT,
    sales DECIMAL(10,2) DEFAULT 0.00,
    merchandise_listings INT DEFAULT 0,
    images VARCHAR(255) DEFAULT 'IMAGES/default-profile.png',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Vets Table
CREATE TABLE IF NOT EXISTS vets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    guide_listings INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Cats Table
CREATE TABLE IF NOT EXISTS cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    breed ENUM(
        'Abyssinian', 'American Bobtail', 'American Curl', 'American Shorthair', 'American Wirehair', 'Balinese',
        'Bengal', 'Birman', 'Bombay', 'British Shorthair', 'Burmese', 'Burmilla', 'Chartreux', 'Chausie',
        'Cornish Rex', 'Devon Rex', 'Egyptian Mau', 'Exotic Shorthair', 'Havana Brown', 'Himalayan', 'Japanese Bobtail',
        'Korat', 'LaPerm', 'Maine Coon', 'Manx', 'Munchkin', 'Norwegian Forest Cat', 'Ocicat', 'Oriental Shorthair',
        'Persian', 'Ragdoll', 'Russian Blue', 'Savannah', 'Scottish Fold', 'Selkirk Rex', 'Siamese', 'Siberian',
        'Singapura', 'Snowshoe', 'Somali', 'Sphynx', 'Tonkinese', 'Toyger', 'Turkish Angora', 'Turkish Van'
    ) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    age INT NOT NULL,
    neutered BOOLEAN DEFAULT FALSE,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    fosterer_id INT,
    FOREIGN KEY (fosterer_id) REFERENCES fosterers(id) ON DELETE SET NULL
);

-- Merchandises Table
CREATE TABLE IF NOT EXISTS merchandises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    stock INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    images VARCHAR(255) NOT NULL,
    admin_name VARCHAR(100) NOT NULL
);

-- Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    review TEXT NOT NULL,
    review_point INT CHECK (review_point BETWEEN 1 AND 5),
    average_review DECIMAL(3,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Adoptions Table
CREATE TABLE IF NOT EXISTS adoptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    breed VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    fosterer_name VARCHAR(100) NOT NULL,
    adoption_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES cats(id) ON DELETE CASCADE
);

-- Favorites Table
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT DEFAULT NULL,
    merch_id INT DEFAULT NULL,
    cat_name VARCHAR(100),
    merch_name VARCHAR(100),
    cat_gender ENUM('Male', 'Female'),
    item_price DECIMAL(10,2),
    admin_name VARCHAR(100),
    amount INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES cats(id) ON DELETE CASCADE,
    FOREIGN KEY (merch_id) REFERENCES merchandises(id) ON DELETE CASCADE
);

-- Purchases Table
CREATE TABLE IF NOT EXISTS purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    merch_id INT NOT NULL,
    merch_name VARCHAR(100) NOT NULL,
    admin_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    amount INT DEFAULT 1,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (merch_id) REFERENCES merchandises(id) ON DELETE CASCADE
);
