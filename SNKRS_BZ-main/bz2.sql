create database bz2;

use bz2;

create table hyperboost(
    id int primary key auto_increment,
    link varchar(255),
    nome varchar(255),
    prezzo float,
    linkImg varchar(255)
);



LOAD DATA INFILE 'C:\\xampp\\mysql\\data\\bz2\\dati.csv'
REPLACE INTO TABLE hyperboost
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
(link, nome, prezzo, linkImg);

