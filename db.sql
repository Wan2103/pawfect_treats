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
    images VARCHAR(255) DEFAULT 'images/default-profile.jpeg'
);

-- Fosterers Table
CREATE TABLE IF NOT EXISTS fosterers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    email VARCHAR(100) NOT NULL,
    description TEXT,
    number_of_listings INT DEFAULT 0,
    images VARCHAR(255) DEFAULT 'images/default-profile.jpeg',
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
    images VARCHAR(255) DEFAULT 'images/default-profile.jpeg',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,  -- To store the vet's image filename
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
    breed ENUM(
        'Abyssinian', 'American Bobtail', 'American Curl', 'American Shorthair', 'American Wirehair', 'Balinese',
        'Bengal', 'Birman', 'Bombay', 'British Shorthair', 'Burmese', 'Burmilla', 'Chartreux', 'Chausie',
        'Cornish Rex', 'Devon Rex', 'Egyptian Mau', 'Exotic Shorthair', 'Havana Brown', 'Himalayan', 'Japanese Bobtail',
        'Korat', 'LaPerm', 'Maine Coon', 'Manx', 'Munchkin', 'Norwegian Forest Cat', 'Ocicat', 'Oriental Shorthair',
        'Persian', 'Ragdoll', 'Russian Blue', 'Savannah', 'Scottish Fold', 'Selkirk Rex', 'Siamese', 'Siberian',
        'Singapura', 'Snowshoe', 'Somali', 'Sphynx', 'Tonkinese', 'Toyger', 'Turkish Angora', 'Turkish Van'
    ) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    fosterer_name VARCHAR(100) NOT NULL,
    adoption_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES cats(id) ON DELETE CASCADE
);

-- Favorite Cats Table
CREATE TABLE IF NOT EXISTS favorite_cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES cats(id) ON DELETE CASCADE
);

-- Favorite Merchandise Table
CREATE TABLE IF NOT EXISTS favorite_merchandise (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    merch_id INT NOT NULL,
    amount INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
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

-- Create the care_guides table
CREATE TABLE IF NOT EXISTS care_guides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category ENUM('injury', 'nutrition', 'behavior', 'general') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ALTER TABLE care_guides ADD COLUMN vet_id INT DEFAULT NULL,
ALTER TABLE care_guides ADD CONSTRAINT fk_vet FOREIGN KEY (vet_id) REFERENCES vets(id) ON DELETE SET NULL;

);

-- Insert Sample Guides (For Testing)
INSERT INTO care_guides (title, content, category) VALUES 
("How to Treat a Cat’s Wound", "Clean the wound with saline solution and apply antiseptic.", "injury"),
("First Aid for Broken Bones", "Keep the cat still and bring it to a vet immediately.", "injury"),
("Dealing with Burns", "Cool the affected area with cold water for 10 minutes and see a vet.", "injury"),
("Caring for an Injured Paw", "Check for foreign objects, clean with saline, and bandage lightly.", "injury"),
("Emergency Care for Poisoning", "Call a vet immediately and do not induce vomiting unless instructed.", "injury");
