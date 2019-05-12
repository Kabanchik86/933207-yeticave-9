INSERT INTO categories
    (name_category, symbol_code)
VALUES
    ('Доски и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Ботинки', 'boots'),
    ('Одежда', 'clothing'),
    ('Инструменты', 'tools'),
    ('Разное', 'other');

INSERT INTO users
    (regist_date, email, name, password, contact)
VALUES
    ('25.04.2019', 'anton66656@yandex.ru','Anton', 'user', 'Moscow'),
    ('21.04.2019', 'Nastia@gmail.com','Nastia', 'user', 'Volocolamsk');

INSERT INTO lots
    (creat_date, lot_name, picture, first_price, user_id, category_id)
VALUES
    ('26.04.2019', '2014 Rossignol District Snowboard','img/lot-1.jpg', '10999', 1, 2 ),
    ('25.04.2019', 'DC Ply Mens 2016/2017 Snowboard','img/lot-2.jpg', '159999', 1, 2 ),
    ('26.04.2019', 'Крепления Union Contact Pro 2015 года размер L/XL','img/lot-3.jpg', '8000', 1, 3 ),
    ('27.04.2019', 'Ботинки для сноуборда DC Mutiny Charocal','img/lot-4.jpg', '10999', 1, 4 ),
    ('26.04.2019', 'Куртка для сноуборда DC Mutiny Charocal','img/lot-5.jpg', '7500', 2, 7 ),
    ('26.04.2019', 'Маска Oakley Canopy','img/lot-6.jpg', '5400', 2, 6 );

INSERT INTO bets
    (bet_date, price_bet, user_id, lot_id)
VALUES
    ('27.04.2019', '12000', 1 , 1 ),
    ('27.04.2019', '10000', 1, 3 );

SELECT name_category FROM categories;

SELECT creat_date, lot_name, picture, first_price, name_category FROM lots l
JOIN categories c ON l.category_id = c.id;

SELECT lot_name, name_category FROM lots l
JOIN categories c ON l.category_id = c.id
WHERE l.id = 2

UPDATE lots SET lot_name = 'DC Ply Mens 2016/2017 Snowboard Expert_level'
WHERE lot_name = 'DC Ply Mens 2016/2017 Snowboard';

SELECT bet_date, price_bet, lot_name FROM bets b
JOIN lots l ON b.lot_id = l.id
WHERE l.lot_name = '2014 Rossignol District Snowboard';