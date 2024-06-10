create database bz2;

use bz2;

create table sito(
    id int primary key,
    url varchar(255),
    nome varchar(255)
);

create table item(
    id int primary key auto_increment,
    link varchar(255),
    nome varchar(255),
    prezzo float,
    linkImg varchar(255),
    tipologia enum('1', '2', '3'),
    idSito int,
    FOREIGN KEY (idSito) REFERENCES sito(id)
    ON DELETE set null
    ON UPDATE CASCADE
);

insert into sito(id, url, nome) 
values (1, 'https://hypeboost.com/it', 'Hyperboost'),
(2, 'https://droplist.store/', 'Drop List'),
(3, 'https://nakedcph.com/', 'Naked');

