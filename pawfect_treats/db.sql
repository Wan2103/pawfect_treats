
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin', 'vet', 'fosterer') NOT NULL
);

CREATE TABLE cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    age INT NOT NULL,
    neutered ENUM('Yes', 'No') NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    fosterer_name VARCHAR(100) NOT NULL,
    fosterer_image VARCHAR(255) NOT NULL
);

INSERT INTO cats (name, gender, age, neutered, description, image, fosterer_name, fosterer_image)
VALUES
('Snowball', 'Male', 3, 'No', 'A playful and energetic kitten who loves to chase toys and snuggle up for naps.', 'IMAGES/munchkin 1.jpeg', 'Izzah', 'IMAGES/fosterer 1.jpeg'),
('Milo', 'Female', 2, 'Yes', 'A calm ag gentle head rubs.', 'IMAGES/bsh 1.jpeg', 'Aiman', 'IMAGES/fosterer 3.jpeg');


CREATE TABLE fosterers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fosterer_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    race VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    number_of_listings INT DEFAULT 0,
    cats_fostered INT DEFAULT 0,
    review FLOAT DEFAULT 0.0 CHECK (review >= 0 AND review <= 5),
    images TEXT NOT NULL
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    race VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    number_of_listings INT DEFAULT 0,
    toys_sold INT DEFAULT 0,
    review FLOAT DEFAULT 0.0 CHECK (review >= 0 AND review <= 5),
    images TEXT NOT NULL
);

CREATE TABLE vets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vet_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    race VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    number_of_listings INT DEFAULT 0,
    review FLOAT DEFAULT 0.0 CHECK (review >= 0 AND review <= 5),
    images TEXT NOT NULL
);

CREATE TABLE guides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    steps TEXT NOT NULL,
    images TEXT NOT NULL, 
    review FLOAT DEFAULT 0.0 CHECK (review >= 0 AND review <= 5),
    verified_by VARCHAR(100) NOT NULL
);

CREATE TABLE merchandises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    stock INT NOT NULL CHECK (stock >= 0),
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    review FLOAT DEFAULT 0.0 CHECK (review >= 0 AND review <= 5),
    images TEXT NOT NULL
);
