CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
    name_category CHAR(64),
    symbol_code CHAR(64)   
);

CREATE TABLE lots (
 	id INT AUTO_INCREMENT PRIMARY KEY,
    creat_date CHAR (64),
    lot_name CHAR (255),
    description CHAR (255),
    picture CHAR (255),
    first_price CHAR (64),
    date_end CHAR (64),
    price_step CHAR (64),
    user_id INT,
    winner_id INT,
    category_id INT
);

CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
	bet_date CHAR (64),
    price_bet CHAR (64),
    user_id INT,
    lot_id INT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regist_date CHAR (64),
    email CHAR(128),
    name CHAR (64),
    password CHAR (64),
    avatar CHAR(128),
    contact CHAR (255),
    lot_id INT,
    bet_id INT
);

CREATE UNIQUE INDEX email ON users (email);
CREATE UNIQUE INDEX contact ON users (contact);
CREATE INDEX  description ON lots(description);
CREATE INDEX  lot_name ON lots(lot_name);