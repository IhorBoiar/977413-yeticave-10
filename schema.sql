CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8 
    DEFAULT COLLATE utf8_general_ci;    

USE yeticave;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128) NOT NULL,
    email CHAR(128) NOT NULL UNIQUE,
    password CHAR(128) NOT NULL,
    contacts CHAR(128),
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP
  );

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    sim_code CHAR(128) NOT NULL
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    description TEXT,
    price INT,
    img CHAR(128),
    category_id INT,
    time_exit DATETIME,
    user_id INT,
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    winner_id INT,
    round_of_bet INT
);

CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    price INT,
    user_id INT,
    lot_id INT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX email_user ON users(email);
CREATE INDEX lot_name ON lots(name);
CREATE INDEX beter ON bets(user_id); 
CREATE FULLTEXT INDEX lot_search ON lots(name, description);