# boite-crypto
CREATE DATABASE boite_crypto;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username TEXT,
    password TEXT
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username TEXT,
    password TEXT
);

In hide.py create you should put the path to the repository where you want to save your image: 
update:    output_path = "YOUR_PATHS/secret_{}.png".format(timestamp) in line 54.