use my_petacchidiego;
-- Per Hypeboost
CREATE TEMPORARY TABLE temp_item (
    id int primary key auto_increment,
    link VARCHAR(255),
    nome VARCHAR(255),
    prezzo int,
    linkImg VARCHAR(255),
    tipologia enum('1', '2', '3')
);

LOAD DATA INFILE '/SNKRS_BZ/dati.csv'
INTO TABLE temp_item
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
(link, nome, prezzo, linkImg, tipologia);

-- Elimina solo i record di temp_item dal sito specificato
DELETE FROM item WHERE idSito = 1;

-- Inserisci e sostituisci dati nel sito specificato
REPLACE INTO item (idSito, id, link, nome, prezzo, linkImg, tipologia)
SELECT 1, id, link, nome, prezzo, linkImg, tipologia FROM temp_item;

DROP TEMPORARY TABLE temp_item;

-- Per Naked
CREATE TEMPORARY TABLE temp_item (
    id int primary key auto_increment,
    link VARCHAR(255),
    nome VARCHAR(255),
    prezzo int,
    linkImg VARCHAR(255),
    color varchar(255),
    tipologia enum('1', '2', '3')
);

LOAD DATA INFILE '/SNKRS_BZ/datiNaked.csv'
INTO TABLE temp_item
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
(link, nome, prezzo, linkImg, color, tipologia);

DELETE FROM item WHERE idSito = 3;

REPLACE INTO item (idSito, id, link, nome, prezzo, linkImg, color, tipologia)
SELECT 3, id, link, nome, prezzo, linkImg, color, tipologia FROM temp_item;

DROP TEMPORARY TABLE temp_item;


-- Per Drop List
CREATE TEMPORARY TABLE temp_item (
    id int primary key auto_increment,
    link VARCHAR(255),
    nome VARCHAR(255),
    prezzo int,
    linkImg VARCHAR(255),
    tipologia enum('1', '2', '3')
);

LOAD DATA INFILE '/SNKRS_BZ/datiDropList.csv'
INTO TABLE temp_item
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
(link, nome, prezzo, linkImg, tipologia);

DELETE FROM item WHERE idSito = 2;

REPLACE INTO item (id, link, nome, prezzo, linkImg, tipologia, idSito)
SELECT id, link, nome, prezzo, linkImg, tipologia, 2 FROM temp_item;

DROP TEMPORARY TABLE temp_item;
